<?php ob_start(); ?> <!-- Pour lancer l'enregistrement du contenu de cette page-->

<?php
require_once('connexion.php');
global $conn;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription'])) {
    if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['passwd'])){
        // Assurez-vous que les données ont été envoyées via le formulaire d'inscription

    // Récupérez les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['passwd'];

    // Utilisation de requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO admn (nom, email, passwd) VALUES (?, ?, ?)");

    // Vérifie la préparation de la requête
    if ($stmt === false) {
        die('Erreur de préparation de la requête : ' . $conn->errorInfo()[2]);
    }

    // Exécution de la requête en liant les paramètres
    if ($stmt->execute([$nom, $email, $mot_de_passe])) {
        // La requête a réussi
        echo "Inscription réussie.";

        // Sélection de l'identifiant de l'utilisateur inséré
        $IdUser = $conn->lastInsertId();
        //echo "Identifiant de l'utilisateur inséré : " . $IdUser;

        // Stocker l'ID de l'utilisateur dans une variable de session
        $_SESSION['IdUser'] = $IdUser;
        echo "<a href='gestionQuestion.php' class='button'>Créer des questions</a>";
    } else {
        // La requête a échoué
        echo "Erreur lors de l'inscription : " . $stmt->errorInfo()[2];
    }
    }
    
}
?>


<h1>PASSER AU MODE ADMIN</h1>

<div class="contenu" id="contenu">
<form method ='POST' action="" id="formulaire" class="formulaire">
    <input type="text" name="nom" placeholder="Nom d'utilisateur" id="nom" required> <br>
    <input type="email" name="email" placeholder="E-mail" id="email" required><br>
    <input type="password" name="passwd" placeholder="Mot de passe" id="passwd" required><br>

    <span id="erreur" style="color:red;"></span> <br>
    <button type="submit" id="inscription" name="inscription">Valider</button>
</form>

<script> 
   //validation du formulaire
        document.getElementById("formulaire").addEventListener("submit",function(e){
            let erreur ;
            let inputs = document.getElementsByTagName("input");
            for( let i = 0; i < inputs.length; i++ ){
                if(!inputs[i].value){
                    erreur = "Veuillez renseigner tous les champs";
                }
                if(erreur){
                    e.preventDefault();
                    document.getElementById("erreur").innerHTML = erreur;
                    return false;
                }
                else{
                }
            }
           
        });      
    </script>

</div>

<?php 
    $contenu=ob_get_clean(); //pour mettre le contenu dans la variables $contenu qui se trouve dans main
    require_once "template.php";
?>
