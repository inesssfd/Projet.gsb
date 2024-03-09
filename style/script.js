function supprimerAppartement(num_appt) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet appartement?")) {
        var xhr = new XMLHttpRequest();
        var appartementElement = document.getElementById('type_appt_' + num_appt);

        console.log("Tentative de suppression de l'élément avec l'ID : " + 'type_appt_' + num_appt);

        if (appartementElement) {
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log("Réponse du serveur : " + xhr.responseText);
                        if (xhr.responseText === 'success') {
                            alert("Appartement supprimé avec succès!");
                            appartementElement.parentNode.removeChild(appartementElement);
                        } else {
                            console.error("Erreur de suppression côté serveur. Réponse du serveur : " + xhr.responseText);
                        }
                    } else {
                        console.error("Erreur de suppression côté serveur. Statut HTTP : " + xhr.status);
                    }
                }
            };

            xhr.open('GET', '../modele/modele_app.php?action=supprimerAppartement&num_appt=' + num_appt, true);
            xhr.send();
        } else {
            console.error("L'élément n'existe pas dans le DOM.");
        }
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




    // Fonction pour rediriger vers un formulaire de location
    function louerLocataire(numAppt) {
    window.location.href = "formulaire_location.php?num_appt=" + numAppt;
}
function supprimerVisite(id_visite) {
        // Envoyer la demande de suppression au serveur en utilisant AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // La suppression a réussi côté serveur, supprimez l'élément côté client
                var visiteElement = document.getElementById('date_visite_' + id_visite).closest('.visite');
                visiteElement.parentNode.removeChild(visiteElement);
            }
        };

        // Envoyer la requête POST vers le fichier PHP côté serveur (class_visite.php dans ce cas)
        xhr.open('POST', '../modele/modele_visite.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('id_visite=' + id_visite + '&action=deleteVisit');
    }
        function showVisitForm(num_appt, num_demandeur) {
        var formHTML = `
            <h2>Formulaire de Visite</h2>
            <form action="../controleur/controleur_visite.php" method="post">
                <input type="hidden" name="num_demandeur" value="${num_demandeur}">
                
                <label for="num_appt">Numéro de l'appartement :</label>
                <input type="text" name="num_appt" id="num_appt" value="${num_appt}" required class="form-input" readonly>
                
                <label for="date_visite">Date de visite :</label>
                <input type="date" name="date_visite" id="date_visite" required class="form-input"><br>
                
                <input type="submit" class="visit-button" value="Planifier la visite">
            </form>
        `;
    
        // Obtenez le conteneur modal
        var modalContainer = document.getElementById("visitFormContainer");
    
        // Définissez le contenu HTML de la modalité
        modalContainer.innerHTML = formHTML;
    
        // Obtenez la modalité et affichez-la
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }
    
    
    
    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

  function modifierDemandeur() {
    console.log("fonction appelée");
    
        // Utilisation de prompt pour saisir de nouvelles valeurs
        var nouveauNom = document.getElementById('nom_demandeur').innerText;
        var nouveauPrenom = document.getElementById('prenom_demandeur').innerText;
        var nouvelleAdresse = document.getElementById('adresse_demandeur').innerText;
        var nouveauCodePostal = document.getElementById('cp_demandeur').innerText;
        var nouveauTelephone = document.getElementById('tel_demandeur').innerText;
        // Création d'un objet pour stocker les paramètres à envoyer
        var params = {};
    
        // Vérification des valeurs et ajout aux paramètres non nuls
        if (nouveauNom !== null && nouveauNom !== "") {
            params.nouveauNom = nouveauNom;
        }
        if (nouveauPrenom !== null && nouveauPrenom !== "") {
            params.nouveauPrenom = nouveauPrenom;
        }
        if (nouvelleAdresse !== null && nouvelleAdresse !== "") {
            params.nouvelleAdresse = nouvelleAdresse;
        }
        if (nouveauCodePostal !== null && nouveauCodePostal !== "") {
            params.nouveauCodePostal = nouveauCodePostal;
        }
        if (nouveauTelephone !== null && nouveauTelephone !== "") {
            params.nouveauTelephone = nouveauTelephone;
        }
    
        // Vérifier si des paramètres ont été ajoutés avant d'envoyer la requête AJAX
        if (Object.keys(params).length > 0) {
            // Envoi des nouvelles valeurs au serveur (par exemple, via une requête AJAX)
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    console.log("Réponse complète du serveur : " + xhr.responseText);
    
                    if (xhr.status == 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
    
                            if (response.status === 'success') {
                                alert("Données du demandeur modifiées avec succès!");
                                // Actualisez la page ou effectuez d'autres actions après la modification
                            } else if (response.status === 'error') {
                                console.error("Erreur de modification côté serveur. Message du serveur : " + response.message);
                            } else {
                                console.error("Réponse inattendue du serveur.");
                            }
                        } catch (error) {
                            console.error("Erreur lors de l'analyse de la réponse JSON : " + error);
                        }
                    } else {
                        console.error("Erreur de modification côté serveur. Statut HTTP : " + xhr.status);
                    }
                }
            };
    
            // Construction de la chaîne de requête avec les nouvelles valeurs
            var queryString = Object.keys(params).map(function (key) {
                return key + '=' + encodeURIComponent(params[key]);
            }).join('&');
    
            // Ouverture de la requête AJAX (assurez-vous d'ajuster l'URL du script serveur)
            xhr.open("POST", "../controleur/controleur_modif_demandeur.php?action=modifierDemandeur", true);
    
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
            // Envoi de la requête avec la chaîne de requête
            xhr.send(queryString);
        } else {
            console.error("Aucune nouvelle valeur fournie.");
        }
    }



    
    
    

    function modifierDate(idVisite) {
        var dateVisiteElement = document.getElementById('date_visite_' + idVisite);
        var nouvelleDate = prompt('Nouvelle date de visite :', dateVisiteElement.innerText);
    
        if (nouvelleDate !== null) {
            // Envoyer la nouvelle date au serveur en utilisant AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // La mise à jour a réussi côté serveur, mettez à jour l'élément côté client
                    dateVisiteElement.innerText = nouvelleDate;
                }
            };
    
            // Envoyer la requête POST vers le même fichier PHP
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('action=updateDate&id_visite=' + idVisite + '&nouvelle_date=' + nouvelleDate);
        }
    }
    // supprimer un proprietaire 
    // script.js
    function supprimerProprietaire() {
        console.log("fonction appelée");
        
        // Créez un objet XMLHttpRequest
        var xhr = new XMLHttpRequest();
        
        // Configurez la requête
        xhr.open('POST', '../controleur/controleur_proprietaire.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        // Définissez la fonction de rappel
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Vérifiez la réponse du serveur
                    var response = xhr.responseText;
                    if (response === 'success') {
                        // Suppression réussie côté serveur
                        console.log('Propriétaire supprimé avec succès.');
                        // Redirigez ou effectuez d'autres actions nécessaires
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
        xhr.send('action=supprimerProprietaireConnecte');
    }

//modifier locattaire
   
function supprimerLocataire() {
    console.log("fonction appelée");
    
    // Créez un objet XMLHttpRequest
    var xhr = new XMLHttpRequest();
    
    // Configurez la requête
    xhr.open('POST', '../controleur/c_supp_loc.php', true);
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
                    window.location.href = 'index.php';
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
   function modifierloccataire() {
    console.log("fonction appelée");
       
   // Récupérer les nouvelles données du formulaire
   var nom_loc = document.getElementById('nom_loc').textContent ;
   var prenom_loc = document.getElementById('prenom_loc').textContent ;
   var date_nais = document.getElementById('date_nais').textContent ;
   var tel_loc = document.getElementById('tel_loc').textContent ;
   // Créer un objet XMLHttpRequest
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


   // Envoyer la requête avec les données du formulaire
   xhr.send('nom_loc=' + encodeURIComponent(nom_loc) +
            '&prenom_loc=' + encodeURIComponent(prenom_loc) +
            '&date_nais=' + encodeURIComponent(date_nais)+
            '&tel_loc=' + encodeURIComponent(tel_loc));
}