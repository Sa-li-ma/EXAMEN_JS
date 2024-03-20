<?php ob_start(); ?> <!--Pour lancer l'enregitrement du contenu de cette page-->

<?php
require_once('connexion.php');
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription'])) {
    // Assurez-vous que les données ont été envoyées via le formulaire d'inscription

    // Récupérez les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['passwd'];

    // Préparation de la requête SQL avec une requête préparée
    $stmt = $conn->prepare("INSERT INTO joueur (nom, email, passwd) VALUES (:nom, :email, :mot_de_passe)");

    // Liaison des valeurs aux paramètres de la requête préparée
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe);

    // Exécution de la requête préparée
    $stmt->execute();
}
?>


<h1>ACCUEIL</h1>

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
    $contenu=ob_get_clean(); //pour mettre le contenu dans la variables $contenu qui de trouve dans main
    require_once "template.php";
 ?>
