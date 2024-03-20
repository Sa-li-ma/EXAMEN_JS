<?php ob_start(); ?> <!-- Pour lancer l'enregistrement du contenu de cette page -->
<?php
include('connexion.php');
global $conn;
?>
<h1>Espace jeux </h1>
<p id="score"> score : 0/5</p>
<form id="quizForm" action="" method="post" class="formulaire">
<?php
try {
    // Préparez la requête SQL pour récupérer cinq questions aléatoires
    $selectQuery = "SELECT id_q, question, reponse1, reponse2, reponse3, bonneReponse FROM question ORDER BY RAND() LIMIT 5";
    $selectStmt = $conn->prepare($selectQuery);
    
    // Exécutez la requête
    $selectStmt->execute();
    
    // Récupérez les résultats
    $questions = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Vérifiez si des questions ont été récupérées
    if (!empty($questions)) {
        foreach ($questions as $questionData) {
            // Récupérez les données de la question
            $questionId = $questionData['id_q'];
            $question = $questionData['question'];
            $reponse1 = $questionData['reponse1'];
            $reponse2 = $questionData['reponse2'];
            $reponse3 = $questionData['reponse3'];
            $bonneReponse = $questionData['bonneReponse'];
            // Affichez la question
            echo "<h3>Question :</h3>";
            echo "<p>$question</p>";
            // Affichez les réponses sous forme de radio boutons
            echo "<h3>Réponses :</h3>";
            echo "<label for='reponse1'><input type='radio' name='questions[$questionId][reponse]' value='$reponse1'> $reponse1</label><br>";
            echo "<label for='reponse2'><input type='radio' name='questions[$questionId][reponse]' value='$reponse2'> $reponse2</label><br>";
            echo "<label for='reponse3'><input type='radio' name='questions[$questionId][reponse]' value='$reponse3'> $reponse3</label><br>";
            // Stockez la bonne réponse dans une variable JavaScript
            echo "<script>var bonneReponse_$questionId = '$bonneReponse';</script>";
            echo "<br>";
        }
    } else {
        echo "Aucune question trouvée dans la base de données.";
    }
} catch (PDOException $e) {
    die("Erreur lors de l'opération sur les données : " . $e->getMessage());
}
?>
<br>
<p id ="resultat"></p>
<input type="submit" value="Valider">
</form>
<script>
let score = 0;
document.getElementById("quizForm").addEventListener("submit", function (e) {
    e.preventDefault();
    for (let questionId = 1; questionId <= 5; questionId++) {
        // Récupérez l'élément radio cochée pour chaque question
        var selectedOption = document.querySelector('input[name="questions[' + questionId + '][reponse]"]:checked');
        let resultat = document.getElementById("resultat");
        let scoreElement = document.getElementById("score");
        // Vérifiez si une option a été sélectionnée
        if (selectedOption) {
            // Stockez la valeur de l'option cochée dans une variable
            var userResponse = selectedOption.value;
            // Utilisez maintenant la variable 'userResponse' comme nécessaire
            if (userResponse == window['bonneReponse_' + questionId]) {
                score++;

            }
        }
    }
    // Affichez le résultat final
    resultat.innerHTML = "Score final : " + score + "/5";
    scoreElement.innerHTML = "score : " + score + "/5"; // Mettez à jour le score ici
});
</script>
<?php
$contenu = ob_get_clean(); // pour mettre le contenu dans la variable $contenu qui se trouve dans main
require_once "template.php";