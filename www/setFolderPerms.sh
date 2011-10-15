#!/bin/sh

cd bonfire/application
writeableFiles="../modules cache logs config archives db/backups db/migrations config/development config/production config/testing config/*"

for fname in $writeableFiles; do
    echo $fname
    chgrp -R www-data $fname
    chmod g+w $fname
done
