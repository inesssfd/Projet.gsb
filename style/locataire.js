function supprimerLocataire() {
    console.log("fonction appelée");
    
    // Créez un objet XMLHttpRequest
    var xhr = new XMLHttpRequest();
    
    // Configurez la requête
    xhr.open('POST', '../controleur/controleur_locc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Définissez la fonction de rappel
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Vérifiez la réponse du serveur
                var response = xhr.responseText;
                if (response === 'success') {
                    // Suppression réussie côté serveur
                    console.log('locc supprimé avec succès.');
                    window.location.href = '../index.php';
                } else {
                    // Gérez d'autres réponses ou erreurs
                    alert('Erreur: ' + response);
                }
            } else {
                // Gérez les erreurs de requête
                console.error('Erreur de requête :', xhr.status, xhr.statusText);
            }
        }
    };
    
    // Envoyez la requête avec les données POST
    xhr.send('action=supprimerLocataire');
}
function modifierLocataire() {
    // Récupérer les nouvelles données du formulaire
    var formData = {
        nom_loc: document.getElementById('nom_loc').textContent,
        prenom_loc: document.getElementById('prenom_loc').textContent,
        date_nais: document.getElementById('date_nais').textContent,
        tel_loc: document.getElementById('tel_loc').textContent
    };
    var xhr = new XMLHttpRequest();

    // Configurer la requête
    xhr.open('POST', '../controleur/controleur_profil_loccataire.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Définir la fonction de rappel lorsque la requête est terminée
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            console.log(xhr.responseText); // Ajoutez cette ligne pour voir la réponse dans la console
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Les informations du locataire ont été modifiées avec succès!');
                    // Mettez à jour les informations affichées sur la page si nécessaire
                } else {
                    alert('Échec de la modification des informations du locataire.');
                }
            }
        }
    };

    // Créer une chaîne de requête avec les données du formulaire
    var params = Object.keys(formData).map(function(key) {
        return encodeURIComponent(key) + '=' + encodeURIComponent(formData[key]);
    }).join('&');

    // Envoyer la requête avec les données du formulaire
    xhr.send(params);
}


function modifierLocataireAdmin(num_loc, index) {
    console.log("Numéro de locataire:", num_loc);
    var nouvellesDonnees = {
        nom_loc: $('#nom_loc' + index).text(),
        prenom_loc: $('#prenom_loc' + index).text(),
        date_nais: $('#date_nais' + index).text(),
        tel_loc: $('#tel_loc' + index).text(),
        num_bancaire: $('#num_bancaire' + index).text(),
        nom_banque: $('#nom_banque' + index).text(),
        cp_banque: $('#cp_banque' + index).text(),
        tel_banque: $('#tel_banque' + index).text(),
        login_loc: $('#login_loc' + index).text()
    };
    // Convertir les nouvelles données en JSON
    var nouvellesDonneesJSON = JSON.stringify(nouvellesDonnees);
    console.log("Nouvelles données:", nouvellesDonnees);
    $.ajax({
        type: "POST",
        url: "../controleur/controleur_admin.php?action=modifier_locataire",
        data: {
            num_loc: num_loc,
            nouvellesDonnees: nouvellesDonneesJSON // Envoyer les données au format JSON
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                // Afficher un message de succès à l'utilisateur ou actualiser la page, etc.
                console.log("Locataire modifié avec succès !");
            } else {
                // Afficher un message d'erreur à l'utilisateur
                console.error("Erreur lors de la modification du locataire :", response.message);
            }
        },
        error: function(xhr, status, error) {
            // Gérer les erreurs de requête Ajax
            console.error("Erreur Ajax lors de la modification du locataire :", error);
        }
    });
}