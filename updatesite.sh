#!/bin/bash
date >> ../isogen.txt
git reset fetch --all
git reset --hard origin/master >> ../isogen.txt
echo "--------------------" >> ../isogen.txt
