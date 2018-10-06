.PHONY: all test tests cs codecept pre_codecept post_codecept run_codecept \
	fastcs fast phpcs docs api guide guia install db psql \
	clean permisos perm p requeriments req dbh dbheroku

all: test

test tests: codecept phpcs

codecept: pre_codecept run_codecept post_codecept

pre_codecept:
	tests/run-acceptance.sh

post_codecept:
	tests/run-acceptance.sh -d

run_codecept:
	vendor/bin/codecept run

fastcs: fast phpcs

fast:
	vendor/bin/codecept run unit
	vendor/bin/codecept run functional

phpcs cs:
	vendor/bin/phpcs

docs:
	guia/publish-docs.sh

api:
	guia/publish-docs.sh -a

guide guia:
	guia/publish-docs.sh -g

serve:
	@[ -f .env ] && export $$(cat .env) ; ./yii serve

install: requeriments install db permisos

db:
	db/load.sh

dbfull:
	db/create.sh
	db/load.sh

dbh dbheroku:
	heroku psql < db/torrentlibre.sql
	heroku psql < db/torrentlibre_datos.sql

psql:
	db/psql.sh

clean:
	find 'runtime' -not -path 'runtime' -not -name ".gitignore" -exec rm -Rf {} \; || echo ''
	find 'web/assets' -not -path 'web/assets' -not -name ".gitignore" -exec rm -Rf {} \; || echo ''
	find 'web/tmp' -not -path 'web/tmp' -not -name ".gitignore" -exec rm -Rf {} \; || echo ''

permisos perm p:
	echo 'Aplicando permisos'
	sudo chmod -R 770 .
	sudo chmod -R 777 runtime
	sudo chmod -R 755 web
	sudo chmod -R 777 web/assets
	sudo chmod -R 775 web/css
	sudo chmod -R 775 web/images
	sudo chmod -R 775 web/js
	sudo chmod -R 500 web/.htaccess
	sudo chmod -R 500 yii
	bash -c 'yo=$(shell whoami) && sudo chown -R $${yo}:www-data . && echo $${yo}'

requeriments req:
	composer install
	composer run-script post-create-project-cmd
