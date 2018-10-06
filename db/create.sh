#!/usr/bin/env bash
# -*- ENCODING: UTF-8 -*-

if [[ "$1" = "travis" ]]; then
    psql -U postgres -c "CREATE DATABASE torrentlibre_test;"
    psql -U postgres -c "CREATE USER torrentlibre PASSWORD 'torrentlibre' SUPERUSER;"
else
    if [[ "$1" != "test" ]]; then
        sudo -u postgres dropdb --if-exists torrentlibre
        sudo -u postgres dropdb --if-exists torrentlibre_test
        sudo -u postgres dropuser --if-exists torrentlibre
    fi

    sudo -u postgres psql -c "CREATE USER torrentlibre PASSWORD 'torrentlibre' SUPERUSER;"

    if [[ "$1" != "test" ]]; then
        sudo -u postgres createdb -O torrentlibre torrentlibre
    fi

    sudo -u postgres createdb -O torrentlibre torrentlibre_test

    LINE="localhost:5432:*:torrentlibre:torrentlibre"
    FILE="$HOME/.pgpass"

    if [[ ! -f "$FILE" ]]; then
        touch "$FILE"
        chmod 600 "$FILE"
    fi

    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> "$FILE"
    fi
fi
