#!/bin/bash
SCRIPT=$(readlink -f $0)
SCRIPTPATH=`dirname $SCRIPT`

cd SCRIPTPATH

git pull

c:/xamp-php81/php/php.exe artisan migrate
c:/xamp-php81/php/php.exe artisan dusk --filter FacebookBot
