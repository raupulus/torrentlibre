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
-- Additional Comments: Archivo complementario para insertar datos
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
-- along with this program.  If not, see <https://www.gnu.org/licenses/>
-------------------------------------------------------------------------------

CREATE EXTENSION pgcrypto;

---------------------------------------------------
--                     Roles                     --
---------------------------------------------------
INSERT INTO roles (tipo, descripcion) VALUES
    ('admin', 'Administrador principal de la aplicación')
  , ('editor', 'Puede moderar, bloquear usuarios y ver estadísticas')
  , ('especial', 'Designado manualmente por el administrador para colaborar ' ||
                 'en la administración o moderación del sitio')
  , ('tmp', 'Cuenta recién creada, solo puede rellenar el perfil y ver ' ||
              'usuarios')

  , ('novato', 'Cuenta recién creada pero ha verificado su perfil')
  , ('geekv1', 'Ha publicado al menos 10 torrents')
  , ('geekv2', 'Ha publicado al menos 50 torrents')
  , ('geekv3', 'Ha publicado al menos 100 torrents')
;

---------------------------------------------------
--                     TEMAS                     --
---------------------------------------------------
INSERT INTO temas (nombre, descripcion) VALUES
    ('default', 'Tema por defecto con colores neutros')
  , ('redmoon', 'Tema donde predomina el color rojo')
  , ('bluesky', 'Tema donde predomina el color azul claro')
;

---------------------------------------------------
--                  PREFERENCIAS                 --
---------------------------------------------------
INSERT INTO preferencias (tema_id) VALUES
  (1), (2), (3)
;

---------------------------------------------------
--                    Usuarios                   --
---------------------------------------------------
INSERT INTO usuarios_id (rol_id,ip)
VALUES
  (
      1
    , '199.199.199.199'
  )

  , (
      2
    , '199.199.199.200'
)

  , (
      5
    , '199.199.199.201'
)
;

INSERT INTO usuarios (
  id, nombre, nick, web, biografia, email,
  twitter, facebook, googleplus, password,
  auth_key, token, preferencias_id
) VALUES
  (
      1
    , 'Administrador'
    , 'admin'
    , 'https://fryntiz.es'
    , 'Administrador en plataforma de pruebas (beta)'
    , 'admin@admin.com'
    , '@admin'
    , '@admin'
    , '@admin'
    , crypt('admin', gen_salt('bf', 13))
    , ''
    , 'temp1'
    , 1
  )

  , (
      2
    , 'Editor'
    , 'editor'
    , 'https://www.fryntiz.es'
    , 'Editor en plataforma de pruebas (beta)'
    , 'user1@domain.com'
    , '@editor'
    , '@editor'
    , '@editor'
    , crypt('1234', gen_salt('bf', 13))
    , ''
    , 'temp2'
    , 2
  )

  , (
      3
    , 'Pepe'
    , 'pepeneitor3000'
    , 'https://www.fryntiz.es'
    , 'Usuario normal en plataforma de pruebas (beta)'
    , 'user2@domain.com'
    , '@pepeitor'
    , '@pepeitor'
    , '@pepeitor'
    , crypt('1234', gen_salt('bf', 13))
    , ''
    , 'temp3'
    , 3
  )
;


---------------------------------------------------
--                  Licencias                    --
---------------------------------------------------
INSERT INTO licencias (tipo, url, imagen) VALUES
    ('GPLv3', 'https://www.gnu.org/licenses/gpl-3.0.html', 'gpl3.png')
  , ('BSD-3', 'https://opensource.org/licenses/BSD-3-Clause', 'bsd3.png')
;


---------------------------------------------------
--                  CATEGORÍAS                   --
---------------------------------------------------
INSERT INTO categorias (nombre, descripcion) VALUES
    ('Máquinas Virtuales', 'Sección de Máquinas Virtuales preparadas')
  , ('Libros', 'Libros digitales')
  , ('Podcasts', 'Audio-Podcasts')
  , ('Apuntes', 'Anotaciones, guías y manuales')
  , ('Vídeos', 'Vídeos de conferencias, tutoriales y ayuda en general')
  , ('PDF', 'Documentos en formato PDF')
  , ('Otros', 'Otro tipo de material no clasificado en secciones anteriores')
  , ('Imágenes', 'Imágenes o Pack de imágenes')
  , ('Cheat Sheet', 'Hojas de chuletas o anotaciones rápidas')
  , ('Scripts', 'Programas o fragmentos de programas')
  , ('Sistemas Operativos', 'Imágenes de sistemas Operativos libres')
  , ('Docker', 'Imagenes Docker preparadas')
;

---------------------------------------------------
--                   TORRENTS                    --
---------------------------------------------------
INSERT INTO torrents (licencia_id, categoria_id, usuario_id, titulo, resumen,
                      descripcion, imagen, file, size, md5, magnet)
VALUES
  (
      1
    , 1
    , 3
    , 'Torrent de prueba 1'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent1.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f0'
    , 'magnet:xxxxxxxxxxxxxxx'
  )

  , (
      1
    , 2
    , 3
    , 'Torrent de prueba 2'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent2.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f1'
    , 'magnet:xxxxxxxxxxxxxxy'
  )

  , (
      1
    , 1
    , 3
    , 'Torrent de prueba 3'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent3.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f2'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 4'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent4.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f3'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 5'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent5.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f4'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 6'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent6.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f5'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 7'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent7.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f6'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 8'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent8.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f7'
    , 'magnet:xxxxxxxxxxxxxxz'
)

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 9'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent1.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f8'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 10'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent1.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c569f9'
    , 'magnet:xxxxxxxxxxxxxxz'
  )

  , (
    1
    , 1
    , 3
    , 'Torrent de prueba 11'
    , 'Descripción corta del torrent de prueba'
    , 'Descripción larga donde se explica a fondo el torrent y su contenido'
    , 'torrent1.jpg'
    , 'torrent1.torrent'
    , 1024
    , '1da569f68f3b3c472caafec432c56910'
    , 'magnet:xxxxxxxxxxxxxxz'
  )
;

---------------------------------------------------
--                 COMENTARIOS                   --
---------------------------------------------------
INSERT INTO comentarios (usuario_id, torrent_id, contenido) VALUES
    (3, 1, 'Este comentario es para decir lo bien que está ese torrent')
  , (3, 1, 'Y sigue subiendo contenido así máquina!')
  , (3, 2, 'Este comentario es para decir lo bien que está ese torrent')
  , (3, 3, 'Este comentario es para decir lo bien que está ese torrent')
  , (3, 3, 'Este comentario está reportado')
;


---------------------------------------------------
--             REPORTES COMENTARIOS              --
---------------------------------------------------

INSERT INTO reportes_comentarios (usuario_id, comentario_id, ip, titulo,
resumen)
VALUES
    (3, 5, '127.0.0.99', 'Título de Prueba de Reporte', 'Resumen test')
;


---------------------------------------------------
--                    DEMANDAS                   --
---------------------------------------------------
INSERT INTO demandas (usuario_id, titulo, descripcion) VALUES
    (3, 'VM Debian stable apache2', 'Máquina Virtual con el sistema operativo apache2 preparado y configurado')
  , (3, 'Chuleta básica para utilizar Docker', 'Una cheatsheet con los comandos básicos para la instalación, configuración y gestión de docker')
;


---------------------------------------------------
--                  PUNTUACIONES                 --
---------------------------------------------------
INSERT INTO puntuacion_torrents (usuario_id, torrent_id, puntuacion) VALUES
    (1, 1, 10)
  , (1, 2, 10)
  , (1, 3, 10)
  , (1, 4, 10)
  , (1, 5, 10)
  , (1, 6, 10)
  , (1, 7, 10)
  , (1, 8, 10)
  , (1, 9, 10)
  , (2, 1, 10)
  , (3, 1, 9)
  , (3, 2, 6)
  , (3, 3, 0)
;

INSERT INTO puntuacion_comentarios (usuario_id, comentario_id, puntuacion) VALUES
    (1, 1, 10)
  , (1, 2, 10)
  , (1, 3, 10)
  , (2, 1, 10)
  , (3, 1, 9)
  , (3, 2, 6)
  , (3, 3, 0)
;


---------------------------------------------------
--                   REGISTROS                   --
---------------------------------------------------
INSERT INTO accesos (usuario_id) VALUES
    (1)
  , (2)
  , (3)
  , (1)
  , (1)
  , (2)
  , (2)
  , (2)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
  , (3)
;


INSERT INTO descargas (ip, torrent_id) VALUES
  ('127.0.0.97', 1)
  , ('127.0.0.98', 1)
  , ('127.0.0.99', 1)
  , ('127.0.0.97', 2)
  , ('127.0.0.98', 2)
  , ('127.0.0.99', 2)
  , ('127.0.0.97', 3)
  , ('127.0.0.98', 3)
  , ('127.0.0.99', 3)
  , ('127.0.0.97', 3)
  , ('127.0.0.98', 3)
  , ('127.0.0.98', 3)
  , ('127.0.0.98', 3)
  , ('127.0.0.98', 3)
;
