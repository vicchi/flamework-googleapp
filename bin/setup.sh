#!/bin/sh

if test $OSTYPE = "FreeBSD"; then
	WHOAMI=`realpath $0`
elif test $OSTYPE = "darwin" -o $OSTYPE = "darwin11"; then
	WHOAMI=`python -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`
else
	WHOAMI=`readlink -f $0`
fi

WHEREAMI=`dirname $WHOAMI`
GOOGLEAPP=`dirname $WHEREAMI`

if test -z "$1"; then
	echo "Oops: usage: setup.sh flamework-install-root"
	exit
fi

PROJECT=$1

echo "Copying application files to ${PROJECT} ..."
cp ${GOOGLEAPP}/www/*.php ${PROJECT}/www/

echo "Copying templates to ${PROJECT} ..."
cp ${GOOGLEAPP}/www/templates/*.txt ${PROJECT}/www/templates/

echo "Copying library code to ${PROJECT} ..."
cp ${GOOGLEAPP}/www/include/*.php ${PROJECT}/www/include/

echo "Copying database schemas to ${PROJECT}; you will still need to run database alters manually ..."

YMD=`date "+%Y%m%d"`
mkdir ${PROJECT}/schema/alters

cat ${GOOGLEAPP}/schema/db_main.schema >> ${PROJECT}/schema/db_main.schema
cat ${GOOGLEAPP}/schema/db_main.schema >> ${PROJECT}/schema/alters/${YMD}.db_main.schema

echo "Setup is (mostly) complete"
echo "You will still need to update your config file manually ..."
echo ""

# TO DO: generate oauth cookie secret

cat ${GOOGLEAPP}/www/include/config.php.example

# TO DO: .htaccess configs