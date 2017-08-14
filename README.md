# Here is my little tools ;)
## 1. distiller.php tool replaces tests from uploaded git diff file - it designed to work on web-server
## 2. parseCommit.php tool will find out all commits by comment phrase and return its diffs; I put it to ~/Sites/ so I can execute it from subfolders by ../parseCommit.php
### Installing:

```sh
 cd ~/Sites
 git clone git@github.com:ydenyshchenk/magePortTools.git
 cd magePortTools
 chmod +x parseCommit.php
 ln -s ~/Sites/magePortTools/parseCommits.php ~/Sites/parseCommits
```
### Usage:
```sh
 cd ~/Sites/ee217.lo/
 ../parseCommit MDVA-0 > mdva0.patch
 ../parseCommit MDVA-0 --commits > mdva0.commits.log
```