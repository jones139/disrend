#!/bin/sh
# user ncftpput to ftp the directory structure recursively to the host
# specified in .ftpsettings.  -m flag creates the destination directory
# if necessary.

allFiles="1.htaccess assets/* bonfire/* docs/* index.php license.txt README README.markdown setFolderPerms.sh"


if [ $1 = "all" ]; then
    echo "Deploying entire system..."
    for fname in $allFiles; do
	echo $fname
	ncftpput -v -R -t 600 -m -f .ftpsettings public_html/maps3/$fname $fname	
    done
elif [ $1 = "app" ]; then
    echo "Deploying application directory only..."
    ncftpput -v -R -t 600 -m -f .ftpsettings public_html/maps3/application application/*
elif [ $1 = "media" ]; then
    echo "Deploying media directory only..."
    ncftpput -v -R -t 600 -m -f .ftpsettings public_html/maps3/media media/*
else
    echo "Error - usage: deploy.sh target"
    echo "target is [all|app|media]."

fi

    