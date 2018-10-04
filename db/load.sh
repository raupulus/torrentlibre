#!/usr/bin/env bash
# -*- ENCODING: UTF-8 -*-

BASE_DIR=$(dirname $(readlink -f "$0"))

if [[ "$1" != "test" ]]; then
    psql -h localhost -U torrentlibre -d torrentlibre < $BASE_DIR/torrentlibre.sql
    psql -h localhost -U torrentlibre -d torrentlibre < $BASE_DIR/torrentlibre_datos.sql
fi

psql -h localhost -U torrentlibre -d torrentlibre_test < $BASE_DIR/torrentlibre.sql
psql -h localhost -U torrentlibre -d torrentlibre_test < $BASE_DIR/torrentlibre_datos.sql
