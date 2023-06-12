#!/bin/bash

# database connection parameter
db_user="c1998364c_admin"
db_pass="?&([RSeh;]SQ"
db_host="91.234.195.40"
db_base="c1998364c_sae23"

# Reset of the file which will contain the information of the sensors
> data.txt

# retrieve information from the measure table
result=$(/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -sN -e "SELECT ID_sensor, Type_sensor, Room FROM sensor" | jq -R . | jq -s .)

# send table information to a file
for data in $(echo "$result" | jq -r '.[]')
do
	echo $data >> data.txt
done

# Close the database connetion
/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "EXIT"

# calculate the number of sensors to process
nbr_line=$(wc -l < ./data.txt)
nbr_sensor=$(($nbr_line / 3))

# creation of the recovery function and sends data
fonction()
{

	# mqtt connection parameter
	mqtt_domain_name="mqtt.iut-blagnac.fr"
	mqtt_port="1883"
	mqtt_topic=$(echo "Student/by-room/$3/data")

	# mqtt data recovery
	all_data=$(mosquitto_sub -h $mqtt_domain_name -p $mqtt_port -t "$mqtt_topic" -C 1)

	# room data processing
	data=$(echo "$all_data" | jq '.[0].'$2)

	# date and time retrieval
	date=$(date +"%Y-%m-%d %H:%M:%S")

	# Data Insertion SQL Query
	insert_data="INSERT INTO measure (ID_Sensor, Date, Value) VALUES ('$1','$date', '$data');"

	# SQL query execution
	/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "$insert_data"
	
	# Close the database connetion
	/opt/lampp/bin/mysql -h $db_host -D $db_base -u $db_user -p$db_pass -e "EXIT"

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

