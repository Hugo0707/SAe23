#!/bin/bash

# paramètre de connexion mqtt
mqtt_nom_domaine="localhost"
mqtt_port="1883"
mqtt_topic="Student/by-room/E101/data"

# récupération des données en mqtt
data_E101=$(mosquitto_sub -h $mqtt_nom_domaine -p $mqtt_port -t $mqtt_topic -C 1)

# traitement des données de la salle
temp_E101=$(echo $data_E101 | jq '.[0].temperature')
co2_E101=$(echo $data_E101 | jq '.[0].co2')

date=$(date +"%Y-%m-%d %H:%M:%S")

ID_sensor="2"

# paramètre de connexion à la base de données
db_user="admin"
db_pass="sae23"
db_host="localhost"
db_base="sae23"
db_table_name="measure"

# Requête SQL d'insertion de données
insert_temp="INSERT INTO $db_table_name (ID_Sensor, Date, Value) VALUES ('$ID_sensor','$date', '$temp_E101');"
insert_co2="INSERT INTO $db_table_name (ID_Sensor, Date, Value) VALUES ('$ID_sensor','$date', '$co2_E101');"

# Exécution de la requête SQL
/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "$insert_temp"
/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "$insert_co2"

