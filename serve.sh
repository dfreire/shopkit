#!/bin/bash
HERE=`cd -P $(dirname $0) && pwd`
mkdir -p $HERE/site/cache/
mkdir -p $HERE/thumbs/
php -S localhost:3030
