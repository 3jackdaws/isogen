#!/bin/bash
git stash
date >> gitlog.txt
git pull >> gitlog.txt
echo "--------------------" >> gitlog.txt
