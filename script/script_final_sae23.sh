#!/bin/bash

#variable for database connection
DB_USER=cailleaud
DB_PASS=rt
DB_NAME=sae23

# Get the list of sensors and their types from the database
CAPTEUR=$(/opt/lampp/bin/mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -N -e "SELECT NOM_SALLE, Type FROM Capteur;")

# Loop through each sensor and listen for data
echo "$CAPTEUR" | while IFS=$'\t' read -r salle type

do
    # Start a background process for each sensor
    mosquitto_sub -h mqtt.iut-blagnac.fr -u student -P student -t sensors/AM107/by-room/$salle/data -p 8883 -C 1 | while read payload
    do
        # Get the current date and time, and the sensor name from the payload
        DATE=$(date "+%Y-%m-%d")
        HORAIRE=$(date "+%H:%M:%S")
        nom_capteur=$(echo $payload | jq -r '.[1].deviceName')

        bat=$(echo $payload | jq -r '.[1].Building')

        # Create directories and files for storing logs if they don't exist
        if [ ! -d "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat" ];then
        echo "====Création du dossier BATIMENT_$bat ===="
        mkdir "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat"
        echo "Opération réussi avec succès !"
        fi
        if [ ! -d "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle" ];then
        echo "====Création du dossier BATIMENT_$bat/$salle ===="
        mkdir "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle"
        echo "Opération réussi avec succès !"
        fi
        if [ ! -f "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat$bat.txt" ];then
        echo "====Création du fichier où les dernières valeurs seront stockées ===="
        touch "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat$bat.txt"
        echo "Opération réussi avec succès !"
        fi
        if [ ! -f "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat${bat}_public.txt" ];then
        echo "====Création du fichier où toutes les valeurs seront stockées ===="
        touch "/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat${bat}_public.txt"
        echo "Opération réussi avec succès !"
        fi

        # Create files for min, max, and average values if they don't exist
        logs="/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat$bat.txt"
        logs_public="/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_bat${bat}_public.txt"
		logs_min="/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_min_bat$bat.txt"
		logs_max="/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_max_bat$bat.txt"
		logs_moy="/home/lcailleaud/Documents/SAE23/BATIMENT_$bat/$salle/${type}_logs_moy_bat$bat.txt"

        # Store the value based on the type of sensor and calculate min, max, and average
        if [ "$type" == "Temperature" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].temperature')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(float(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY_V1=$(python3 -c "print($SOMME / $NB_LIGNE)")
            VALEUR_MOY_V2="${VALEUR_MOY_V1//./,}"
            printf "%.1f\n" "$VALEUR_MOY_V2" > $logs_moy
        elif [ "$type" == "Humidity" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].humidity')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(float(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY_V1=$(python3 -c "print($SOMME / $NB_LIGNE)")
            VALEUR_MOY_V2="${VALEUR_MOY_V1//./,}"
            printf "%.1f\n" "$VALEUR_MOY_V2" > $logs_moy
        elif [ "$type" == "Activity" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].activity')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "CO2" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].co2')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "Tvoc" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].tvoc')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "Illumination" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].illumination')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "Infrared" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].infrared')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "Infrared_and_visible" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].infrared_and_visible')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(int(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY=$(($SOMME / $NB_LIGNE))
            echo "$VALEUR_MOY" > $logs_moy
        elif [ "$type" == "Pressure" ]; then
            VALEUR=$(echo $payload | jq -r '.[0].pressure')
            echo "${VALEUR}" >> $logs
            echo "${VALEUR}" > $logs_public
            VALEUR_MIN=$(sort -n $logs | head -n 1)
			echo "${VALEUR_MIN}" > $logs_min
            VALEUR_MAX=$(sort -n $logs | tail -n 1)
			echo "${VALEUR_MAX}" > $logs_max
            SOMME=$(python3 -c "print(sum(float(ligne) for ligne in open('$logs') if ligne.strip()))")
            NB_LIGNE=$(grep -c '.' $logs)
            VALEUR_MOY_V1=$(python3 -c "print($SOMME / $NB_LIGNE)")
            VALEUR_MOY_V2="${VALEUR_MOY_V1//./,}"
            printf "%.1f\n" "$VALEUR_MOY_V2" > $logs_moy
        
        # Handle unknown sensor types
        else
            echo "Type inconnu pour $salle : $type"
            continue
        fi

        # Insert the values into the database in the "Mesure" table
        /opt/lampp/bin/mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "INSERT INTO Mesure (Date, Horaire, Valeur, NOM_CAPTEUR) VALUES ('$DATE', '$HORAIRE', $VALEUR, '$nom_capteur');"
        echo "Mesure insérée pour $nom_capteur : $VALEUR"
    # Allow the background process to continue running for each sensor
    done &
done

echo 'Terminé !'
