#!/bin/bash

# database connection parameter
db_user="admin"
db_pass="sae23"
db_host="localhost"
db_base="sae23"

# Reset of the file which will contain the information of the sensors
> data.txt

# retrieve information from the measure table
result=$(/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -sN -e "SELECT ID_sensor, Type_sensor, Room FROM sensor" | jq -R . | jq -s .)

# send table information to a file
for data in $(echo "$result" | jq -r '.[]')
do
	echo $data >> data.txt
done

# calculate the number of sensors to process
nbr_ligne=$(wc -l < ./data.txt)
nbr_sensor=$(($nbr_ligne / 3))

# creation of the recovery function and sends data
fonction(){

# mqtt connection parameter
mqtt_nom_domaine="localhost"
mqtt_port="1883"
mqtt_topic=$(echo "Student/by-room/$3/data")

# mqtt data recovery
all_data=$(mosquitto_sub -h $mqtt_nom_domaine -p $mqtt_port -t "$mqtt_topic" -C 1)

# room data processing
data=$(echo "$all_data" | jq '.[0].'$2)

# date and time retrieval
date=$(date +"%Y-%m-%d %H:%M:%S")

# Data Insertion SQL Query
insert_data="INSERT INTO measure (ID_Sensor, Date, Value) VALUES ('$1','$date', '$data');"

# SQL query execution
/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "$insert_data"

}

# Loop that executes the number of times there are sensors
for ((i=1; i<=$nbr_sensor; i++))
do

# Sensor ID retrieval
ID_sensor=$(sed '1q;d' ./data.txt)

# Sensor type recovery
Type_sensor=$(sed '2q;d' ./data.txt)

# Sensor Room Recovery
Room=$(sed '3q;d' ./data.txt)

# Parallel execution of the function
fonction "$ID_sensor" "$Type_sensor" "$Room" &

# Deletion of the first 3 lines of the file containing the information of the sensors
sed -i '1,3d' data.txt

# End
done

