// Documented in English - Cascading select dynamic updates using custom database schema fields
document.addEventListener("DOMContentLoaded", function () {
    const selectBatiment = document.getElementById("select-batiment");
    const selectCapteur = document.getElementById("select-capteur");

    if (selectBatiment && selectCapteur) {
        selectBatiment.addEventListener("change", function () {
            const batimentId = this.value;

            if (batimentId === "") {
                selectCapteur.innerHTML = '<option value="">-- Choisissez d'abord un bâtiment --</option>';
                selectCapteur.disabled = true;
                return;
            }

            // Fetch sensors dynamically from the selected building ID
            fetch(`get_dropdown_data.php?batiment_id=${batimentId}`)
                .then(response => response.json())
                .then(sensors => {
                    selectCapteur.innerHTML = '<option value="">-- Sélectionner un capteur --</option>';
                    
                    if (sensors.length > 0) {
                        selectCapteur.disabled = false;
                        sensors.forEach(sensor => {
                            const option = document.createElement("option");
                            option.value = sensor.NOM_CAPTEUR;
                            option.textContent = `Salle ${sensor.NOM_SALLE} - ${sensor.NOM_CAPTEUR} (${sensor.Type})`;
                            selectCapteur.appendChild(option);
                        });
                    } else {
                        selectCapteur.innerHTML = '<option value="">Aucun capteur trouvé</option>';
                        selectCapteur.disabled = true;
                    }
                })
                .catch(error => console.error("Error updates logging data via Fetch API:", error));
        });
    }
});
