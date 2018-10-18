-- -*- encoding: utf-8 -*-
-------------------------------------------------------------------------------
--
-- Author:       Raúl Caro Pastorino
-- Email Author: dev@fryntiz.es
-- Web Author:   https://fryntiz.es
-- gitlab:       https://gitlab.com/fryntiz
-- github:       https://github.com/fryntiz
-- twitter:      https://twitter.com/fryntiz
--
-- Create Date: 2018
-- Project Name: TorrentLibre
-- Description: Sitio web para compartir torrents con licencias libres
--
-- Dependencies: Extensión "pgcrypto" para postgresql
--
-- Revision 0.01 - File Created
-- Additional Comments: Archivo principal con estructura de tablas
--
-- Código fuente: https://github.com/fryntiz/torrentlibre
-------------------------------------------------------------------------------
--
-- Copyright (C) 2018  Raúl Caro Pastorino
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>
-------------------------------------------------------------------------------


---------------------------------------------------
--                     Roles                     --
---------------------------------------------------
DROP TABLE IF EXISTS roles CASCADE;

/*
 * Roles a los que pertenecen los usuarios
 * Existen: admin, editor, basic
 */
CREATE TABLE roles (
    id               BIGSERIAL     PRIMARY KEY
  , tipo             VARCHAR(255)  NOT NULL UNIQUE
  , descripcion      VARCHAR(255)
);

---------------------------------------------------
--                     TEMAS                     --
---------------------------------------------------
DROP TABLE IF EXISTS temas CASCADE;

/*
 * Contiene el nombre del tema (será el nombre de la hoja de estilos CSS) y la * descripción a mostrar
 */
CREATE TABLE temas (
    id               BIGSERIAL     PRIMARY KEY
  , nombre           VARCHAR(255)  NOT NULL UNIQUE
  , descripcion      VARCHAR(500)
);

---------------------------------------------------
--                  PREFERENCIAS                 --
---------------------------------------------------
DROP TABLE IF EXISTS preferencias CASCADE;

/*
 * Contiene las preferencias del usuario
 *
 * Los booleanos "promociones, noticias y resumen" son para el envio de
 * publicidad o contenido de forma automatizada.
 *
 * El booleano "tour" indica si mostrar una guía dinámica de como usar la
 * aplicación, por defecto se activa para la primera vez que se entra.
 */
CREATE TABLE preferencias (
    id               BIGSERIAL     PRIMARY KEY
  , tema_id          BIGINT        NOT NULL REFERENCES temas (id) DEFAULT 1
  , promociones      BOOLEAN       DEFAULT true
  , noticias         BOOLEAN       DEFAULT true
  , resumen          BOOLEAN       DEFAULT true
  , tour             BOOLEAN       DEFAULT true  -- Realizar tour inicial
);

---------------------------------------------------
--                    Usuarios                   --
---------------------------------------------------
/*
 * Datos sensibles de usuario, se puede borrar ya que se relacionará
 * sobre usuarios
 */
DROP TABLE IF EXISTS usuarios_datos CASCADE;
CREATE TABLE usuarios_datos (
    id               BIGSERIAL     PRIMARY KEY
  , nombre           VARCHAR(255)
  , nick             VARCHAR(255)  NOT NULL UNIQUE
  , web              VARCHAR(255)
  , biografia        VARCHAR(255)
  , email            VARCHAR(255)  NOT NULL UNIQUE
  , twitter          VARCHAR(255)
  , facebook         VARCHAR(255)
  , googleplus       VARCHAR(255)
  , avatar           VARCHAR(255)
  , password         VARCHAR(255)  NOT NULL
  , auth_key         VARCHAR(255)
  , token            VARCHAR(255)  UNIQUE
  , lastlogin_at     TIMESTAMP     -- Última fecha de login
  , preferencias_id  BIGINT        REFERENCES preferencias (id)
  --, localidad        VARCHAR(255)
  --, provincia        VARCHAR(255)
  --, direccion        VARCHAR(255)
  --, telefono         VARCHAR(255)

  --, fecha_nacimiento DATE
  --, geoloc           VARCHAR(255)
  --, sexo             CHAR          --CONSTRAINT ck_sexo_f_o_m
  --CHECK (sexo = 'F'OR sexo = 'M')
);

DROP TABLE IF EXISTS usuarios CASCADE;

/*
 * Usuarios y datos del programa (no sensible), nunca se eliminará.
 * Este identificador relaciona 1:1 a un usuario de la tabla "usuarios_datos"
 */
CREATE TABLE usuarios (
    id               BIGSERIAL     PRIMARY KEY
  , datos_id         BIGINT        REFERENCES usuarios_datos (id)
  , created_at       TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , updated_at       TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , rol_id           BIGINT        DEFAULT 1
  NOT NULL REFERENCES roles (id)
  ON DELETE NO ACTION
  ON UPDATE CASCADE
);

---------------------------------------------------
--                  Licencias                    --
---------------------------------------------------
DROP TABLE IF EXISTS licencias CASCADE;
/*
 * Licencias para asignar a los torrents.
 * Las licencias (tipo) tienen un enlace hacia la web oficial (url) y
 * el nombre de la imagen para esta.
 */
CREATE TABLE licencias (
    id               BIGSERIAL     PRIMARY KEY
  , tipo             VARCHAR(255)  NOT NULL UNIQUE
  , url              VARCHAR(255)  NOT NULL UNIQUE
  , imagen           VARCHAR(255)
);

---------------------------------------------------
--                  CATEGORÍAS                   --
---------------------------------------------------
DROP TABLE IF EXISTS categorias CASCADE;

/*
 * Categorías a la que puede pertenecer un torrent
 */
CREATE TABLE categorias (
    id              BIGSERIAL     PRIMARY KEY
  , nombre          VARCHAR(255)  NOT NULL UNIQUE
  , descripcion     VARCHAR(500)
);


---------------------------------------------------
--                   TORRENTS                    --
---------------------------------------------------
DROP TABLE IF EXISTS torrents CASCADE;

/*
 * Información sobre los torrents
 */
CREATE TABLE torrents (
    id                BIGSERIAL     PRIMARY KEY
  , licencia_id       BIGINT        NOT NULL REFERENCES licencias (id)
  , categoria_id      BIGINT        NOT NULL REFERENCES categorias (id)
  , usuario_id        BIGINT        NOT NULL REFERENCES usuarios (id)
  , titulo            VARCHAR(255)  NOT NULL
  , resumen           VARCHAR(255)  NOT NULL
  , descripcion       VARCHAR(500)
  , imagen            VARCHAR(255)
  , hash              VARCHAR(255)  -- Hashinfo codificada para generar torrent
  , size              BIGINT        -- Tamaño ocupado
  , n_piezas          NUMERIC
  , size_piezas       NUMERIC
  , archivos          VARCHAR
  , password          VARCHAR(255)  -- Contraseña para descomprimir el torrent
  , created_at        TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , torrentcreate_at  TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , updated_at        TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP  --, magnet
  --   VARCHAR(255)  -- Enlace magnet al torrent
  --, file            VARCHAR(255)  -- Archivo .torrent
  --, md5             VARCHAR(255)  -- Verificación del .torrent
  --, n_descargas     BIGINT        DEFAULT 0  -- Cantidad de veces descargado
  --, n_visitas       BIGINT        DEFAULT 0  -- Cantidad de visitas
  --, online          BOOLEAN       DEFAULT TRUE -- Indica si es válido
  --, modificar       BOOLEAN  -- Indica si han solicitado modificación
);

-- Este indexado no vale para buscar por ilike
--CREATE INDEX idx_torrents_titulo ON torrents (titulo);
--CREATE INDEX idx_torrents_resumen ON torrents (resumen);
CREATE INDEX idx_torrents_categoria_id ON torrents (categoria_id);
-- Falta indexar por categoria+titulo

---------------------------------------------------
--              REPORTES TORRENTS                --
---------------------------------------------------
DROP TABLE IF EXISTS reportes_torrents CASCADE;

/*
 * Listado de reportes realizados a torrents (Mal uso o caído)
 */
CREATE TABLE reportes_torrents (
    id              BIGSERIAL     PRIMARY KEY
  , usuario_id      BIGINT        NOT NULL
                                  REFERENCES usuarios (id)
                                  ON DELETE NO ACTION
                                  ON UPDATE CASCADE
  , torrent_id      BIGINT        NOT NULL
                                  REFERENCES torrents (id)
                                  ON DELETE NO ACTION
                                  ON UPDATE CASCADE
  , ip              VARCHAR(15)
  , titulo          VARCHAR(120)  NOT NULL
  , resumen         VARCHAR(300)  NOT NULL
  , comunicado      BOOLEAN       DEFAULT FALSE -- Indica si se avisó por email
  , created_at      TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , UNIQUE (usuario_id, torrent_id)
);

CREATE INDEX idx_reportes_torrents_torrent_id ON reportes_torrents (torrent_id);


---------------------------------------------------
--                 COMENTARIOS                   --
---------------------------------------------------
DROP TABLE IF EXISTS comentarios CASCADE;

/**
 * Tabla comentarios
 *
 * Todos los comentarios se asocian a un usuario y un torrent.
 * Un comentario puede ser hijo de otro (ser una respuesta a otro comentario)
 * en ese caso tendrá "comentario_id" que es precisamente el padre de este.
 */
CREATE TABLE comentarios (
    id              BIGSERIAL  PRIMARY KEY
  , usuario_id      BIGINT     NOT NULL REFERENCES "usuarios" (id)
                               ON DELETE NO ACTION
                               ON UPDATE CASCADE
  , torrent_id      BIGINT     NOT NULL REFERENCES torrents (id)
                               ON DELETE CASCADE
                               ON UPDATE CASCADE
  , contenido       VARCHAR(500)  NOT NULL
  , comentario_id   BIGINT     REFERENCES comentarios (id)
                               ON DELETE NO ACTION
                               ON UPDATE CASCADE
  , created_at      TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , updated_at      TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , deleted         BOOLEAN    DEFAULT FALSE
);

CREATE INDEX idx_comentarios_usuario_id ON comentarios (usuario_id);
CREATE INDEX idx_comentarios_torrent_id ON comentarios (torrent_id);
CREATE INDEX idx_comentarios_comentario_id ON comentarios (comentario_id);


---------------------------------------------------
--             REPORTES COMENTARIOS              --
---------------------------------------------------
DROP TABLE IF EXISTS reportes_comentarios CASCADE;

/*
 * Listado de reportes realizados a comentarios (Mal uso o inapropiados)
 */
CREATE TABLE reportes_comentarios (
    id              BIGSERIAL     PRIMARY KEY
  , usuario_id      BIGINT        NOT NULL
                                  REFERENCES usuarios (id)
                                  ON DELETE NO ACTION
                                  ON UPDATE CASCADE
  , comentario_id   BIGINT        NOT NULL
                                  REFERENCES comentarios (id)
                                  ON DELETE NO ACTION
                                  ON UPDATE CASCADE
  , ip              VARCHAR(15)
  , titulo          VARCHAR(120)  NOT NULL
  , resumen         VARCHAR(300)  NOT NULL
  , comunicado      BOOLEAN       DEFAULT FALSE -- Indica si se avisó por email
  , created_at      TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , UNIQUE (usuario_id, comentario_id)
);

CREATE INDEX idx_reportes_comentarios_comentario_id
  ON reportes_comentarios (comentario_id);


---------------------------------------------------
--                    BANEADOS                   --
---------------------------------------------------
DROP TABLE IF EXISTS usuarios_bloqueados CASCADE;

/**
 * Usuarios que han sido bloqueados
 */
CREATE TABLE usuarios_bloqueados (
    id            BIGSERIAL    PRIMARY KEY
  , usuario_id    BIGINT       NOT NULL UNIQUE REFERENCES "usuarios_datos" (id)
  , created_at    TIMESTAMP(0) DEFAULT  LOCALTIMESTAMP
);


DROP TABLE IF EXISTS ip_bloqueadas CASCADE;

/**
 * IP que han sido bloqueados
 */
CREATE TABLE ip_bloqueadas (
    id            BIGSERIAL    PRIMARY KEY
  , ip            VARCHAR(15)  NOT NULL
  , created_at    TIMESTAMP(0) DEFAULT  LOCALTIMESTAMP
);

---------------------------------------------------
--                    DEMANDAS                   --
---------------------------------------------------
DROP TABLE IF EXISTS demandas CASCADE;

/*
 * Torrents que han solicitado la comunidad
 */
CREATE TABLE demandas (
    id            BIGSERIAL    PRIMARY KEY
  , usuario_id    BIGINT       NOT NULL REFERENCES "usuarios" (id)
  , titulo        VARCHAR(255) NOT NULL UNIQUE
  , descripcion   VARCHAR(255) NOT NULL
  , atendido      BOOLEAN      NOT NULL DEFAULT FALSE
);


---------------------------------------------------
--                  PUNTUACIONES                 --
---------------------------------------------------
DROP TABLE IF EXISTS puntuacion_torrents CASCADE;
CREATE TABLE puntuacion_torrents (
    id               BIGSERIAL    PRIMARY KEY
  , usuario_id       BIGINT       REFERENCES "usuarios" (id)
  , torrent_id       BIGINT       REFERENCES "torrents" (id)
  , puntuacion       BIGINT       NOT NULL --Valor del 0 al 10
  , created_at       TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , UNIQUE (usuario_id, torrent_id)
);

CREATE INDEX idx_puntuacion_torrents_torrent_id
  ON puntuacion_torrents (torrent_id);


DROP TABLE IF EXISTS puntuacion_comentarios CASCADE;
CREATE TABLE puntuacion_comentarios (
    id               BIGSERIAL    PRIMARY KEY
  , usuario_id       BIGINT       REFERENCES "usuarios" (id)
  , comentario_id    BIGINT    REFERENCES "comentarios" (id)
  , puntuacion       BIGINT       NOT NULL --Valor del 0 al 10
  , created_at       TIMESTAMP(0)  DEFAULT LOCALTIMESTAMP
  , UNIQUE (usuario_id, comentario_id)
);

CREATE INDEX idx_puntuacion_comentarios_comentario_id
  ON puntuacion_comentarios (comentario_id);


---------------------------------------------------
--                   REGISTROS                   --
---------------------------------------------------
DROP TABLE IF EXISTS accesos CASCADE;
CREATE TABLE accesos (
      id            BIGSERIAL    PRIMARY KEY
    , usuario_id    BIGINT       NOT NULL REFERENCES "usuarios" (id)
    , registered_at TIMESTAMP(0) DEFAULT LOCALTIMESTAMP
);

DROP TABLE IF EXISTS descargas CASCADE;
CREATE TABLE descargas (
      id            BIGSERIAL    PRIMARY KEY
    , ip            VARCHAR(15)  -- IP DE ACCESO
    , torrent_id    BIGINT       NOT NULL REFERENCES "torrents" (id)
    , registered_at TIMESTAMP(0) DEFAULT LOCALTIMESTAMP
);

CREATE INDEX idx_descargas_torrent_id
  ON descargas (torrent_id);

---------------------------------------------------
--                     VISTAS                    --
---------------------------------------------------
