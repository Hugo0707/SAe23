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

echo "temp : "$temp_E101 ",co2 :" $co2_E101 ",date : "$date >> ./data.txt

