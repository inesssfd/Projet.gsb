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
                    alert("Erreur lors de la suppression de l'appartement.");
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



    // Fonction pour rediriger vers un formulaire de location
    function louerLocataire(numAppt) {
    window.location.href = "formulaire_location.php?num_appt=" + numAppt;
}
        function showVisitForm(num_appt, num_demandeur) {
        var formHTML = `
        <h2>Formulaire de Visite</h2>
        <form action="../controleur/controleur_visite.php" method="post">
            <!-- Champ caché pour spécifier l'action -->
            <input type="hidden" name="action" value="traiterVisite">
        
            <!-- Reste du formulaire -->
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
            xhr.open("POST", "../controleur/controleur_demandeurs.php?action=modifierDemandeur", true);
    
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
            // Envoi de la requête avec la chaîne de requête
            xhr.send(queryString);
        } else {
            console.error("Aucune nouvelle valeur fournie.");
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
    function supprimerProprietaireAdmin(numero_prop) {
        // Demander confirmation avant de supprimer le propriétaire
        if (confirm("Êtes-vous sûr de vouloir supprimer ce propriétaire ?")) {
            // Rediriger vers la page de suppression du propriétaire avec le numéro du propriétaire
            window.location.href = "../controleur/controleur_admin.php?action=supprimer_proprietaire&num_proprietaire=" + numero_prop;
        }
    }
    

    
    
//modifier locattaire
   
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
function supprimerVisite(id_visite) {
    // Envoyer la demande de suppression au serveur en utilisant AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // La suppression a réussi côté serveur, supprimez l'élément côté client
            var visiteElement = document.getElementById('visite_' + id_visite);
            visiteElement.parentNode.removeChild(visiteElement);
        }
    };

    // Envoyer la requête POST vers le fichier PHP côté serveur (class_visite.php dans ce cas)
    xhr.open('POST', '../controleur/controleur_visite.php?action=deleteVisit"', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('id_visite=' + id_visite + '&action=deleteVisit');
}


function modifierDate(id_visite, date_visite) {
var nouvelleDate = prompt("Entrez la nouvelle date de visite (YYYY-MM-DD) :", date_visite);
if (nouvelleDate !== null) {
    // Envoyer la demande de modification au serveur en utilisant AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // La modification a réussi côté serveur
                // Mettre à jour la date de visite affichée côté client
                var visiteElement = document.getElementById('date_visite_' + id_visite);
                visiteElement.textContent = " Date de visite : " + nouvelleDate;
            } else {
                // La modification a échoué côté serveur
                alert("Erreur lors de la modification de la date de visite.");
            }
        }
    };

    // Envoyer la requête POST vers le fichier PHP côté serveur (controleur_visite.php dans ce cas)
    xhr.open('POST', '../controleur/modif_visite.php?action=updateVisitDate', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('id_visite=' + id_visite + '&date_visite=' + encodeURIComponent(nouvelleDate));
}
}


function modifierEtatDemande(id_demandes_location, nouvelEtat) {
    // Vérifiez si l'ID de demande est valide
    if (id_demandes_location !== null && id_demandes_location !== undefined) {
        // Envoyer une requête AJAX au serveur pour modifier l'état de la demande
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controleur/modifier_etat_demande.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // La requête a été traitée avec succès
                    // Vous pouvez ajouter ici des actions supplémentaires si nécessaire
                    console.log("L'état de la demande a été modifié avec succès.");
                } else {
                    // Il y a eu une erreur lors du traitement de la requête
                    console.error("Une erreur s'est produite lors de la modification de l'état de la demande.");
                }
            }
        };
        // Envoyer les données de la demande à modifier
        xhr.send("id_demande=" + id_demandes_location + "&nouvel_etat=" + nouvelEtat);
    } else {
        // Afficher un message d'erreur si l'ID de demande n'est pas valide
        console.error("ID de demande invalide.");
    }
}

function afficherInfoDemandeur(numDemandeur) {
var xhr = new XMLHttpRequest();
xhr.open("GET", "../controleur/controleur_demandeurs.php?action=afficher_infos_demandeur&num_demandeur=" + numDemandeur, true);
xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            // Traitement réussi, affichez les informations du demandeur
            alert(xhr.responseText); // Vous pouvez remplacer cette alerte par l'affichage des données dans une boîte de dialogue ou une autre section de la page
        } else {
            // Erreur lors du traitement de la requête
            console.error("Erreur lors de la récupération des informations du demandeur.");
        }
    }
};
xhr.send();
}


function modifierDemandeurAdmin(index) {
    console.log("fonction appelée");

    // Utilisation de innerHTML pour récupérer les nouvelles valeurs éditées
    var nouveauNom = document.getElementById('nom_demandeur' + index).innerHTML;
    var nouveauPrenom = document.getElementById('prenom_demandeur' + index).innerHTML;
    var nouvelleAdresse = document.getElementById('adresse_demandeur' + index).innerHTML;
    var nouveauCodePostal = document.getElementById('cp_demandeur' + index).innerHTML;
    var nouveauTelephone = document.getElementById('tel_demandeur' + index).innerHTML;
    var nouveauLogin = document.getElementById('login_demandeur' + index).innerHTML;
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

function supprimerDemandeur(num_demandeur) {
    // Demander confirmation avant de supprimer le demandeur
    if (confirm("Êtes-vous sûr de vouloir supprimer ce demandeur ?")) {
        // Rediriger vers la page de suppression du demandeur avec le numéro du demandeur
        window.location.href = "../controleur/controleur_admin.php?action=supprimer_demandeur&num_demandeur=" + num_demandeur;

    }
}
function supprimerVisiteAdmin(id_visite) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette visite ?")) {
        // Créer une instance de l'objet XMLHttpRequest
        var xhr = new XMLHttpRequest();
        
        // Définir le type de requête et l'URL
        xhr.open('GET', '../controleur/controleur_admin.php?action=supprimer_visite&id_visite=' + id_visite, true);
        
        // Définir le type de contenu à envoyer
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        // Gérer la réponse de la requête
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.error(' suppresion de la visite.');
            } else {
                // Gérer les erreurs en cas de problème avec la requête
                console.error('Erreur lors de la suppression de la visite.');
            }
        };
        
        // Envoyer la requête avec l'ID de la visite à supprimer
        xhr.send('id_visite=' + id_visite);
    }
}


