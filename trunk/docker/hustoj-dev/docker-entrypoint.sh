#!/bin/bash

DIRECTORY="/data/data/"
if [ ! -d $DIRECTORY ]; then
	cp -R /home/judge/data/ /data/
fi
mount --bind $DIRECTORY /home/judge/data

DIRECTORY="/data/etc/"
if [ ! -d $DIRECTORY ]; then
	cp -R  /home/judge/etc/ /data/
fi
mount --bind $DIRECTORY /home/judge/etc

DIRECTORY="/data/upload"
if [ ! -d $DIRECTORY ]; then
	cp -R  /home/judge/src/web/upload /data
fi
mount --bind $DIRECTORY /home/judge/src/web/upload

DIRECTORY="/data/config"
if [ ! -d $DIRECTORY ]; then
	cp -R  /home/judge/src/web/config /data
fi
#if [ ! -f "/data/config/system.conf" ]; then
	cp /home/judge/src/web/config/system.conf /data/config
#fi
mount --bind $DIRECTORY /home/judge/src/web/config

DIRECTORY="/data/mysql"
if [ ! -d $DIRECTORY ]; then
	cp -R /var/lib/mysql /data
fi
mount --bind $DIRECTORY /var/lib/mysql

if [  -f "/data/judge.conf" ]; then
	mv /data/judge.conf /data/etc
fi

#if [  -f "/data/db_info.inc.php" ]; then
#	mv /data/db_info.inc.php /data/config
#fi
#if [  -f "/data/config/db_info.inc.php" ]; then
#	cp /data/config/db_info.inc.php /home/judge/src/web/include/db_info.inc.php
#else
#	cp /home/judge/src/web/include/db_info.inc.php /data/config/db_info.inc.php
#fi

cp /data/etc/judge.conf /data/config

chmod 775 -R /data/data 
chgrp -R www-data /data/data
chmod 770 -R 		/data/upload /data/config #/data/judge.conf /data/db_info.inc.php
chgrp -R www-data 	/data/upload /data/config #/data/judge.conf /data/db_info.inc.php
#/home/judge/src/web/config 
#/home/judge/src/web/config
#chown -R mysql:mysql /var/lib/mysql 
chown -R mysql:mysql /data/mysql/

service mysql start
/usr/bin/judged
php5-fpm
service nginx start

/bin/bash  
exit 0 


