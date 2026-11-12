<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Accueil</a>

            <?php
                //Vérifier si un manager est connecté
                if(isset($_SESSION["id"])){
            ?>
                    <a href="index.php?page=profile">Mon Compte</a>
                    <a href="index.php?page=agents">Agents</a>
                    <a href="index.php?page=logout">Se Déconnecter</a>
            <?php
                };
            ?>
        </nav>
    </header>