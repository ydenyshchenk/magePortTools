#!/usr/bin/env php
<?php

define("DS", DIRECTORY_SEPARATOR);

if (empty($argv[1])) {
    exit("Please clarify branch name for search\n");
}

$mode = (!empty($argv[2]) && preg_match('/commit/', $argv[2])) ? 'commits' : 'patch';
$options = '';

if (!in_array('not-all', $argv)) {
    $options .= ' --all ';
}

$diffFileDir = '_DIFFS' . DS . time();
if (!file_exists($diffFileDir)) {
    mkdir($diffFileDir, 0777, true);
}

$branchesRaw = $argv[1];
$branches = explode(',', $branchesRaw);
sort($branches);

foreach ($branches as $branch) {
    $gitLog = shell_exec("git log $options --grep='$branch'");
    preg_match_all('/commit\s([^\s\n]*)\n([^\n]*\n){1}Date\:\s+([^\n]*)/', $gitLog, $matches);

    $commits = [];
    foreach ($matches[1] as $i => $commit) {
        $unixTime = strtotime($matches[3][$i]);
        $commits[$unixTime] = $commit;
    }

    ksort($commits);
    $patch = '';
    $patchArr = [];

    foreach ($commits as $c) {
        $patchArr[] = shell_exec("git diff $c~1 $c");
    }

    $diffContent = implode('', $patchArr);
    $commitsContent = implode("\n", $commits) . "\n";

    $branchFile = $diffFileDir . DS . trim($branch, " \t\n\r\0\x0B:");
    $branchFileDiff = $branchFile . '.diff';
    $branchFileCommits = $branchFile . '.commits.log';
    if (is_writeable($diffFileDir)) {
        file_put_contents($branchFileDiff, $diffContent);
        file_put_contents($branchFileCommits, $commitsContent);
    } else {
        error_log("=== $branch: diff ===", 0);
        error_log($diffContent, 0);
        error_log("=== $branch: commits ===", 0);
        error_log($commitsContent, 0);
    }

    error_log($branch . ' OK', 0);
}

file_put_contents("BRANCHES:\n" . implode("\n", $branches), $diffFileDir . DS . 'branches.log');