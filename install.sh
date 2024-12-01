#!/bin/bash -x

rm -rf temp/cache/*
composer install
vendor/bin/phinx migrate
chmod -R 0777 temp/