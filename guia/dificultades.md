# Dificultades encontradas

## Convertir información de torrent formato bittorrent

Para convertir a formato bitorrent codificando/decodificando encontré ciertos
inconvenientes al obtener resultados mal formados usando librerías que en un
principio debería facilitar esta acción.

Finalmente opté por utilizar la librería oficial de bittorrent llamada 
**Bencode** estudiando su algoritmo y funcionamiento.

Mediante el uso de esta librería oficial consigo obtener toda la información a 
partir de un torrent como por ejemplo su tamaño, los archivos contenidos, 
calcular el hash general **hash info** del torrent, las partes que lo componen
e incluso los servidores/trackers dónde se comparten sus partes en la red. 

## Elemento de innovación

