function supprimerAppartement(num_appt) {
    if(confirm("Êtes-vous sûr de vouloir supprimer cet appartement ?")) {
        // Création d'une requête AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../controleur/supprimer_appartement.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        // Envoi des données au serveur
        xhr.onreadystatechange = function() {
            if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if(xhr.responseText == "success") {
                    // Rafraîchissement de la page si la suppression est réussie
                    window.location.reload();
                } else {
                    alert("Succées de la supression");
                }
            }
        };
        // Envoi des données POST avec le numéro de l'appartement à supprimer
        xhr.send('num_appt=' + num_appt);
    }
}




function modifierAppartement(num_appt, num_prop) {
    console.log("Fonction appelée avec le numéro d'appartement : " + num_appt);
    console.log("Fonction appelée avec le numéro prop : " + num_prop);

    // Récupérer les nouvelles valeurs des champs éditables
    var nouveauType = document.getElementById('type_appt_' + num_appt).innerText;
    var nouveauPrix = document.getElementById('prix_loc_' + num_appt).innerText;
    var nouvelleCharge = document.getElementById('prix_charge_' + num_appt).innerText;
    var nouvelleRue = document.getElementById('rue_' + num_appt).innerText;

    // Envoi des nouvelles valeurs au serveur via une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            console.log("Réponse complète du serveur : " + xhr.responseText);
            // Gérer la réponse du serveur ici
            if (xhr.status == 200) {
                // Si la réponse est 200 (OK), afficher un message d'alerte
                alert(xhr.responseText);
            } else {
                // Sinon, afficher un message d'alerte indiquant qu'il y a eu une erreur
                alert("Erreur lors de la modification de l'appartement.");
            }
        }
    };
    var params = "num_prop=" + num_prop +
    "&num_appt=" + num_appt +
    "&nouveauType=" + encodeURIComponent(nouveauType) +
    "&nouveauPrix=" + encodeURIComponent(nouveauPrix) +
    "&nouvelleCharge=" + encodeURIComponent(nouvelleCharge) +
    "&nouvelleRue=" + encodeURIComponent(nouvelleRue) +
    "&action=modifierAppartement"; // Assurez-vous d'ajouter l'action

    // Ouverture de la requête AJAX et envoi avec la chaîne de requête
    xhr.open("POST", "../controleur/controleur_app.php", true); // Utilisez le bon chemin vers votre script PHP
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

