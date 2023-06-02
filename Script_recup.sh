#!/bin/bash

# paramètre de connexion à la base de données
db_user="admin"
db_pass="sae23"
db_host="localhost"
db_base="sae23"

> data.txt

result=$(/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -sN -e "SELECT ID_sensor,Type_sensor, Room FROM sensor" | jq -R . | jq -s .)

for data in $(echo "$result" | jq -r '.[]')
do
	echo $data >> data.txt
done

nbr_ligne=$(wc -l < ./data.txt)
nbr_sensor=$(($nbr_ligne / 3))


for ((i=1; i<=$nbr_sensor; i++))
do

ID_sensor=$(sed '1q;d' ./data.txt)
Type_sensor=$(sed '2q;d' ./data.txt)
Room=$(sed '3q;d' ./data.txt)

# paramètre de connexion mqtt
mqtt_nom_domaine="localhost"
mqtt_port="1883"
mqtt_topic=$(echo -e "Student/by-room/$Room/data")

# récupération des données en mqtt
all_data=$(mosquitto_sub -h $mqtt_nom_domaine -p $mqtt_port -t "$mqtt_topic" -C 1)
quote=\'
# traitement des données de la salle
data=$(echo "$all_data" | jq '.[0].'"$Type_sensor"'')

date=$(date +"%Y-%m-%d %H:%M:%S")

echo $data

# Requête SQL d'insertion de données
insert_data="INSERT INTO measure (ID_Sensor, Date, Value) VALUES ('$ID_sensor','$date', '$data');"

# Exécution de la requête SQL
/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "$insert_data"

sed -i '1,3d' data.txt

done

