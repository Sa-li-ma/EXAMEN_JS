<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHYSIQUE</title>
</head>
<body>
    <header>         <!--Cette balise contient les informations de l'en-tête de toutes les pages-->
        <nav class="menu">
            <ul>
                <li id="logo">BIG2 QUIZ</li>
                <li> <a href="index.php">ACCUEIL</a></li>
                <li><a href="admin.php">Mode admin</a></li>
                <li><a href="jeux.php">JOUER</a></li>
            </ul>
        </nav>
    </header>
    <main class = "contenu">
        <?= $contenu; ?>
    </main>
 
    <footer class="pied_de_page">
    <div id="texte_defilant"> *** 220786 Salimata Mamadou N'DIAYE *** 220836 Rokhaya Seck *** 220797 Aminata DIAW *** </div>
    </footer>
   
    
</body>
</html>