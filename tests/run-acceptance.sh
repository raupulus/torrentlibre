#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
PORT=8088

if [ -f $BASE_DIR/acceptance.suite.yml ]
then
    if fuser -n tcp $PORT > /dev/null 2>&1
    then
        echo "Matando los procesos en los puertos $PORT y 9515..."
        fuser -k -n tcp $PORT
        fuser -k -n tcp 9515
    fi
    if [ "$1" != "-d" ]
    then
        echo "Ejecutando chromedriver --url-base=/wd/hub ..."
        $BASE_DIR/chromedriver --url-base=/wd/hub > /dev/null 2>&1 &
        echo "Ejecutando tests/bin/yii serve ..."
        if [ "$1" = "-v" ]
        then
            $BASE_DIR/bin/yii serve --port=$PORT &
        else
            $BASE_DIR/bin/yii serve --port=$PORT > /dev/null 2>&1 &
        fi
    fi
fi
