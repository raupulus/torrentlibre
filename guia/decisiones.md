# Decisiones adoptadas

## Almacenar hash torrents

Para identificar los torrents como únicos se almacena principalmente el hash 
de cada uno, así es posible identificarlos como únicos además de preguntarles
a un tracker por su información o comenzar su descarga. 

## Uso de Amazon S3

Decido usar amazon S3 para almacenar las portadas de los torrents y así 
solucionar el disponer de almacenamiento volatil en heroku.
