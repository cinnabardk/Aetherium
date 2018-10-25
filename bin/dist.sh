#!/usr/bin/env bash

set -e

if [[ "false" != "$TRAVIS_PULL_REQUEST" ]]; then
	echo "Not deploying pull requests."
	exit
fi

if [[ "master" != "$TRAVIS_BRANCH" ]]; then
	echo "Not on the 'master' branch."
	exit
fi

git clone -b distribution "https://github.com/${TRAVIS_REPO_SLUG}.git" distribution

rm -rf distribution/*.*
rm -rf distribution/dist
rm -rf distribution/inc

npm run production
npm run dist
cd distribution

git add -A
git commit -m "Update from travis $TRAVIS_COMMIT"
git push "https://${GH_TOKEN}@github.com/${TRAVIS_REPO_SLUG}.git" distribution 2> /dev/null

#git diff --quiet; nochanges=$?
#if [ $nochanges -eq 1 ]; then
#	git add -A
#	git commit -m "Update from travis $TRAVIS_COMMIT"
#	git push "https://${GH_TOKEN}@github.com/${TRAVIS_REPO_SLUG}.git" distribution 2> /dev/null
#fi


