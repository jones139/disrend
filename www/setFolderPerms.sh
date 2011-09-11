#!/bin/sh

writeableFiles="cache logs config archives db/backups db/migrations config/development config/production config/testing config/application.php"
cd bonfire/application

for fname in $writeableFiles; do
    echo $fname
    chgrp -R www-data $fname
    chmod g+w $fname
done