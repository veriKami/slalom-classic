#!/bin/bash

place="/var/www/"
minets="1"

res=$(find $place -maxdepth 1 -name index.html -mmin -$minets -type f)
#res1=$(ls /var/www/admin/copy)
if [ -n "$res" ]; then
 #echo $res
# if [ -n "$res1" ]; then
 if [ -f /var/www/admin/copy ]; then
  path=$(cat /var/www/admin/copy)
  wput -quA /var/www/i*.html $path
 fi
fi
