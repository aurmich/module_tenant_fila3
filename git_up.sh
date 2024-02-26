
#
path=$(readlink -f -- "$0 ";)
branch=$1
echo 'path:' $path
echo 'branch:' $branch
git submodule foreach "$path" $branch
echo "-------- START[$(pwd) ($path) ($branch)] ----------";
git add --renormalize -A
git add -A && aicommits  || echo '---------------------------empty'
git push origin $branch -u --progress 'origin' || git push --set-upstream origin $branch
echo "-------- END PUSH[$(pwd) ($branch)] ----------";
git checkout $branch --
git branch --set-upstream-to=origin/$branch $branch
git branch -u origin/$branch
git merge $branch
echo "-------- END BRANCH[$(pwd) ($branch)] ----------";
git submodule update --progress --init --recursive --force --merge --rebase --remote
git checkout $branch --
git pull origin $branch --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase
echo "-------- END PULL[$(pwd) ($branch)] ----------";
git status


