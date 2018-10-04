#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
ACTUAL=$PWD
cd $BASE_DIR/..
$BASE_DIR/download-chromedriver.sh -q
ACCEPT=tests/acceptance.suite.yml
SN="S"
if [ -f $ACCEPT ]
then
    if [ "$1" = "-q" ]
    then
        SN="N"
    else
        echo -n "El archivo $ACCEPT ya existe. ¿Desea sobreescribirlo? (s/N): "
        read SN
        [ "$SN" = "s" ] && SN="S"
    fi
fi
if [ "$SN" = "S" ]
then
    echo "Copiando $ACCEPT.example sobre $ACCEPT..."
    cp -f $ACCEPT.example $ACCEPT
fi
if ! grep -qs "codeception/codeception" composer.json
then
    echo "Pasando de codeception/base a codeception/codeception..."
    sed -i s%codeception/base%codeception/codeception%g composer.json
    echo "Ejecutando composer update..."
    composer update
else
    echo "Ya se requiere codeception/codeception en composer.json."
fi
cd $ACTUAL
