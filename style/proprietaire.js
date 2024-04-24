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

