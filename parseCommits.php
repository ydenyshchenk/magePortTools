#!/usr/bin/env php
<?php

if (empty($argv[1])) {
    exit("Please clarify branch name for search\n");
}

$branch = $argv[1];

$mode = (!empty($argv[2]) && preg_match('/commit/', $argv[2])) ? 'commits' : 'patch';

$gitLog = shell_exec("git log --all --grep='$branch'");

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

//    $b = 1;
//    echo "$c\n";
}

if ($mode == 'commits') {
    echo implode("\n", $commits) . "\n";
} else {
    echo implode('', $patchArr);
}
