# Here is my little tools ;)
## 1. distiller.php tool replaces tests from uploaded git diff file - it designed to work on web-server
## 2. parseCommits.php tool will find out all commits by comment phrase and return its diffs; I put it to ~/Sites/ so I can execute it from subfolders by ../parseCommits.php
### Installing:

```sh
 cd ~/Sites
 git clone git@github.com:ydenyshchenk/magePortTools.git
 cd magePortTools
 chmod +x parseCommits.php
 ln -s ~/Sites/magePortTools/parseCommits.php ~/Sites/parseCommits
```
### Usage:
```sh
 cd ~/Sites/ee217.lo/
 ../parseCommits MDVA-0 > mdva0.patch
 ../parseCommits MDVA-0 --commits > mdva0.commits.log
```