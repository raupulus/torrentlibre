# Instrucciones de instalación y despliegue

## En local

### Requisitos

- Versión de php 7.1 o superior
- Servidor Apache2
- Composer
- PostgreSQL 9.6
- Sistema Operativo GNU/Linux

### Obtener código 

Para desplegar en local primero obtenemos el código fuente desde github
hacia nuestro sitio virtual apache previamente configurado.

### Instalar dependencias de composer.

```bash
composer install
```

### Desplegar base de datos.

Para generar la base de datos o recrearla de forma limpia:

```bash
make dbfull
```

Para solo reinsertar tablas en la bd existente:
```bash
make db
```

### Variables de la aplicación

Configurar/setear las variables de la aplicación como por ejemplo el
almacenamiento de amazon, correo, nombre etc etc.

Se puede tomar como ejemplo el archivo .env.example localizado en la raíz del
proyecto.

## Configurar host virtual apache con nombre de dominio

Configurar el servidor apache con un nombre de dominio resolviendo al
directorio **web** del proyecto.

## En la nube

El despliegue en la nube se ha planteado utilizando heroku por lo que será 
necesario disponer de cuenta en esta plataforma.

Para la instalación de la aplicación en la nube usaremos Heroku, por lo que una cuénta en dicha plataforma será necesaria para continuar.

Con nuestra cuenta de Heroku, realizaremos los siguientes pasos:

- Con nuestra cuenta de Heroku deberemos crear una aplicación. Además, necesitaremos el comando `heroku` para consola y poder así con la consola.

- Añadir la extensión para postgres y cargar la base de datos.

Comandos:
```
heroku login
heroku apps:create nombreAplicacion --region eu
heroku addons:create heroku-postgresql
heroku pg:psql < db/load.sql
heroku pg:psql
create extension pgcrypto;
heroku config:set SMTP_PASS=clave
git push -u heroku master
```
