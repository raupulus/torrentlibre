#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
CHROME="chromedriver"
SN="S"
if [ -f "$BASE_DIR/$CHROME" ]
then
    if [ "$1" = "-q" ]
    then
        SN="N"
    else
        echo -n "El archivo $CHROME ya existe. ¿Desea descargar la última versión? (s/N): "
        read SN
        [ "$SN" = "s" ] && SN="S"
    fi
fi
if [ "$SN" = "S" ]
    then
    echo "Descargando la última versión de ChromeDriver..."
    ZIP=chromedriver_linux64.zip
    VERSION=$(curl -s https://chromedriver.storage.googleapis.com/LATEST_RELEASE)
    curl -s -o $BASE_DIR/$ZIP https://chromedriver.storage.googleapis.com/$VERSION/$ZIP
    unzip -o $BASE_DIR/$ZIP -d $BASE_DIR
    rm $BASE_DIR/$ZIP
fi
