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

Una vez dentro de heroku creamos una aplicación

### Instalar cliente de heroku
wget -qO- https://cli-assets.heroku.com/install-ubuntu.sh | sh

### Loguear en el equipo con el cliente instalado

Desde el directorio del repositorio

```bash
heroku login
```

### Vincular aplicación

Hay dos opciones:
- Crear aplicación desde consola
- Crear aplicación desde la web y vincularla con un directorio

Desde la web:
- Elegir un nombre que será parte del dominio de la aplicación como por 
ejemplo: https://miaplicación.heroku.com
- Elegir región Europa
- Añadir Recursos: En Resources, nos vamos a addons y añadimos la base de 
datos llamada Heroku PostgreSQL y seleccionamos el plan.
- Métodos de despliegue
- En la pestaña deploy seleccionamos uno de los tres métodos. Por defecto al 
crear desde la terminal se crea una rama remota heroku pero es más interesante
utilizar el método GitHub.

Desde este momento al conectar con GitHub cada vez que hagamos un push se
puede desplegar automáticamente si debajo elegimos la rama y y pulsamos 
sobre: Enable automatics deploy 

Asociar aplicación con heroku, le decimos a Heroku cual es la aplicación que 
tenemos.

Listamos las aplicaciones:

```bash
heroku apps
```

Asignamos el remoto para la aplicación:

```bash
heroku git:remote --app nombreaplicación
heroku psql
```

Conecta al psql con heroku y podemos ejecutar comandos o añadir extensiones:
create extension pgcrypto;

También podemos inyectar

```bash
heroku psql < db/nombredv.sql
heroku config
```

También podemos inyectar la base de datos con:

```bash
make dbheroku
```

### Configurar YII

Para que funcione tenemos que crear una variable de entorno llamada YII_ENV 
y asignarle valor de producción:

```bash
heroku config:set YII_ENV=prod
```

Además se necesitar setear las variables establecidas en el archivo 
.env.example configurando cada parámetro adecuado a nuestras necesidades.
