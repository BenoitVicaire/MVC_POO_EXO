<?php


//Variable d'affichage
$title = "Agents of Shield";
$listAgents = [];
$tiers = [];
$archetypes = [];
$message = "";

//Accessible uniquement si connecté
if(!isset($_SESSION["id"])){
    //non connecté -> redirection vers accueil
    header('Location:index.php');
    exit;
}

//RECUPERATION DE LA LISTE DES TIERS ET DES ARCHETYPES
try{
    $tiers = Tier::getAll();
	$archetypes = Archetype::getAll();
}catch(Exception $error){
    http_response_code(500);
    $message = $error->getMessage();
}

//ENREGISTREMENT D'UN AGENT
//1. Vérifier si on reçoit le formulaire
if(isset($_POST["submit"])){
    //2. Normaliser les données
    $name = trim($_POST["name"]);
    $dob = trim($_POST["dob"]);
    $tier = trim($_POST["tier"]);
    $archetype = trim($_POST["archetype"]);

    //3. Vérifier les champs vides
    if(!empty($name) && !empty($dob) && !empty($tier) && !empty($archetype)){
        //4. Vérifier le format de donnée
        if(filter_var($tier,FILTER_VALIDATE_INT)){
            if(filter_var($archetype,FILTER_VALIDATE_INT)){
                try{
                    if(!Agent::nameExists($name)){
                        if(Archetype::ArchetypeExists((int)$archetype)){   
                            if(Tier::TierExists((int)$tier)){
                               Agent::create($name, $dob, $tier, $archetype);

                                //8.4 Message
                                $message = htmlspecialchars($name)." a été enregistré.";

                            }else{
                                $message = "Ce Tier n'existe pas";
                            }
                            //8. Lancer l'enregistrement

                        }else{
                            $message = "Cet Archetype n'existe pas";
                        }
                        
                    }else{
                        $message = "Ce nom n'est pas disponible.";
                    }

                    
                }catch(Exception $error){
                    http_response_code(500);
                    $message = $error->getMessage();
                }
                
            }else{
                $message = "Archetype est invalide";
            }
        }else{
            $message = "Le Tier est invalide";
        }
        
    }else{
        $message = "Remplissez tous les champs.";
    }
}

//LISTES DES AGENTS
try{
    //Récupère
    $listAgents = Agent::getAll();
}catch(Exception $error){
   http_response_code(500);
   $message = $error->getMessage();
}
//Inscription d'un nouvel agent (attention : ne pas oublie le tier et l'archetype)
//Affichage de la liste des agents

include './View/Layout/header.php';
include './View/Layout/agent.php';
?>

    