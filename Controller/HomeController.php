<?php 
//Déclaration des variables d'affichage
$title = "Accueil";
$message = "";
$messageConnection = "";
$listManagers = [];
//LISTE DES MANAGERS
//Vérifier si un manager est connecté
if(isset($_SESSION["id"])){
    try{
        //Créer l'objet de connexion PDO
        $pdo = new PDO("mysql:host=localhost;dbname=agent_manager","root","root",[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

        //A.Préparer la requête
        $request = $pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.password, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_Role = r.Id_Role WHERE r.role = 'Manager'");

        //B.Exécuter la requête
        $request->execute();

        //C.Récupérer les données
        $listManagers = $request->fetchAll(PDO::FETCH_ASSOC);
                        
    }catch(Exception $error){
        http_response_code(500);
        $message = $error->getMessage();

        //Erreur 500 : Serveur indisponible
    }
}