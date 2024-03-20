<?php
require_once('connexion.php');
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questions = $_POST['questions'];

    foreach ($questions as $questionData) {
        $question = $questionData['question'];
        $reponse1 = $questionData['reponse1'];
        $reponse2 = $questionData['reponse2'];
        $reponse3 = $questionData['reponse3'];
        $reponses = [$reponse1, $reponse2, $reponse3];
        $bonne_reponse_index = $questionData['bonne_reponse'];
        $bonne_reponse = $reponses[$bonne_reponse_index - 1];

        // Utilisation de requête préparée pour éviter les injections SQL
        $stmt = $conn->prepare("INSERT INTO questions (question, reponse1, reponse2, reponse3, bonneReponse) VALUES (?, ?, ?, ?, ?)");

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

        // Exécution de la requête
        if ($stmt->execute()) {
            // La requête a réussi
            echo "La question a été ajoutée avec succès.<br>";
        } else {
            // La requête a échoué
            echo "Erreur lors de l'ajout de la question : " . $stmt->errorInfo()[2] . "<br>";
        }

        // Fermeture du statement
        $stmt->closeCursor();
    }
}
?>

<h1>Gestion</h1>
<span id="erreur"></span>
<form id="questionForm" action="" method="post"> <!-- Ajout de la méthode POST -->

    <!-- Exemple de champs pour une question -->
    <div class="question">
        <h2>Question </h2>
        <textarea name="questions[0][question]" autofocus="autofocus" placeholder="Question" required></textarea><br>
        <textarea name="questions[0][reponse1]" placeholder="Reponse 1" required></textarea><br>
        <textarea name="questions[0][reponse2]" placeholder="Reponse 2" required></textarea><br>
        <textarea name="questions[0][reponse3]" placeholder="Reponse 3" required></textarea><br>

        <p>Spécifiez la bonne réponse</p> <br>
        <label for="1">1</label>
        <input type="radio" name="questions[0][bonne_reponse]" id="1" value="1"> <br>
        <label for="2">2</label> <!-- Correction du label -->
        <input type="radio" name="questions[0][bonne_reponse]" id="2" value="2"> <br>
        <label for="3">3</label>
        <input type="radio" name="questions[0][bonne_reponse]" id="3" value="3"> <br>
    </div>

    <!-- Ajouter d'autres questions avec des index différents -->

    <input type="submit" id="valider" value="Valider">
</form>


<script>
    // Ton script JavaScript peut être ajouté ici selon les besoins
</script>

<?php
$contenu = ob_get_clean(); //pour mettre le contenu dans la variable $contenu qui se trouve dans main
require_once "template.php";
?>
