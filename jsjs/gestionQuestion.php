
<?php
require_once('connexion.php');
global $conn;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si tous les champs sont définis dans $_POST
    if (isset($_POST['question'], $_POST['reponse1'], $_POST['reponse2'], $_POST['reponse3'], $_POST['bonne_reponse'])) {
        $question = $_POST['question'];
        $reponse1 = $_POST['reponse1'];
        $reponse2 = $_POST['reponse2'];
        $reponse3 = $_POST['reponse3'];
        $bonne_reponse_index = $_POST['bonne_reponse'];
        
        // Vérification si les valeurs ne sont pas vides
        if (!empty($question) && !empty($reponse1) && !empty($reponse2) && !empty($reponse3) && !empty($bonne_reponse_index)) {
            $reponses = [$reponse1, $reponse2, $reponse3];
            $bonne_reponse = $reponses[$bonne_reponse_index - 1];
            
            // Utilisation de requête préparée pour éviter les injections SQL
            $stmt = $conn->prepare("INSERT INTO question (question, reponse1, reponse2, reponse3, bonneReponse) VALUES (?, ?, ?, ?, ?)");
            
            // Vérification de la préparation de la requête
            if ($stmt === false) {
                die('Erreur de préparation de la requête : ' . $conn->error);
            }
            
            // Liaison des paramètres
            $stmt->bindParam(1, $question);
            $stmt->bindParam(2, $reponse1);
            $stmt->bindParam(3, $reponse2);
            $stmt->bindParam(4, $reponse3);
            $stmt->bindParam(5, $bonne_reponse);
            //$stmt->bindParam(6, $IdAdmin);
            
            // Exécution de la requête
            if ($stmt->execute()) {
                // La requête a réussi
                echo "La question a été ajoutée avec succès.";
            } else {
                // La requête a échoué
                echo "Erreur lors de l'ajout de la question : " . $stmt->errorInfo()[2];
            }
            
            // Fermeture du statement
            $stmt->closeCursor();
        } else {
            echo "Tous les champs du formulaire doivent être remplis.";
        }
    } else {
        echo "Tous les champs du formulaire doivent être définis.";
    }
}
?>

<h1>Gestion</h1>
<span id="erreur"></span>
<form id="questionForm" action="" method="post" class="formulaire"> <!-- Ajout de la méthode POST -->
    <h2>Question </h2>
    <textarea name="question" id="question" autofocus="autofocus" placeholder="Question" required></textarea><br>
    <textarea name="reponse1" id="reponse1" placeholder="Reponse 1" required></textarea><br>
    <textarea name="reponse2" id="reponse2" placeholder="Reponse 2" required></textarea><br>
    <textarea name="reponse3" id="reponse3" placeholder="Reponse 3" required></textarea><br>
    <p>Spécifiez la bonne réponse</p> <br>
    <label for="1">1</label>
    <input type="radio" name="bonne_reponse" id="1" value="1"> <br>
    <label for="2">2</label> <!-- Correction du label -->
    <input type="radio" name="bonne_reponse" id="2" value="2"> <br>
    <label for="3">3</label>
    <input type="radio" name="bonne_reponse" id="3" value="3"> <br>
    <input type="submit" id="valider" value="Valider">
</form>


<?php 
    $contenu = ob_get_clean(); //pour mettre le contenu dans la variable $contenu qui se trouve dans main
    require_once "template.php";
?>
