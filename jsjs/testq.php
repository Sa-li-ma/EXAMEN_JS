<?php ob_start(); ?> <!-- Pour lancer l'enregistrement du contenu de cette page -->

<h1>Gestion</h1>
<span id="erreur"></span>
<form id="questionForm" action="">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <h2>Question <?php echo $i; ?></h2>
        <textarea class="question" autofocus="autofocus" required></textarea><br>
        <textarea class="reponse1" required></textarea><br>
        <textarea class="reponse2" required></textarea><br>
        <textarea class="reponse3" required></textarea><br>

        <p>Spécifiez la bonne réponse</p> <br>
        <label for="<?php echo $i; ?>_1">1</label>
        <input type="radio" name="bonne_reponse_<?php echo $i; ?>" value="1"> <br>
        <label for="<?php echo $i; ?>_2">2</label>
        <input type="radio" name="bonne_reponse_<?php echo $i; ?>" value="2"> <br>
        <label for="<?php echo $i; ?>_3">3</label>
        <input type="radio" name="bonne_reponse_<?php echo $i; ?>" value="3"> <br>
    <?php endfor; ?>

    <input type="submit" id="valider" value="Valider">
</form>

<script>
     // Définition de la classe Question
     class Question {
        constructor(question, reponse1, reponse2, reponse3, bonneReponse) {
            this.question = question;
            this.reponse1 = reponse1;
            this.reponse2 = reponse2;
            this.reponse3 = reponse3;
            this.bonneReponse = bonneReponse;
        }
    }
    document.getElementById("questionForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let questions = [];

    for (let i = 1; i <= 2; i++) {
        let question = document.querySelector('.question:nth-of-type(' + i + ')').value;
        let reponse1 = document.querySelector('.reponse1:nth-of-type(' + i + ')').value;
        let reponse2 = document.querySelector('.reponse2:nth-of-type(' + i + ')').value;
        let reponse3 = document.querySelector('.reponse3:nth-of-type(' + i + ')').value;
        let radios = document.getElementsByName(`bonne_reponse_${i}`);
        let bonneReponse;
        for (let j = 0; j < radios.length; j++) {
            if (radios[j].checked) {
                bonneReponse = radios[j].value;
                break;
            }
        }

        if (!question || !reponse1 || !reponse2 || !reponse3 || !bonneReponse) {
            document.getElementById("erreur").innerHTML = "Veuillez renseigner tous les champs et spécifier la bonne réponse";
            return false;
        }

        questions.push(new Question(question, reponse1, reponse2, reponse3, bonneReponse));
    }

    // Utilisez maintenant l'array 'questions' qui contient toutes les instances de la classe Question.
    console.log(questions);
});


   
</script>

<?php 
    $contenu = ob_get_clean(); //pour mettre le contenu dans la variable $contenu qui se trouve dans main
    require_once "template.php";
?>
