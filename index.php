<?php
//POINT D'ENTREE : toutes les pages passent par ce fichier (routeur)

//Démarrage de la session
session_start();

//Chargement des classes
require_once __DIR__ . '/Model/Database.php';
require_once __DIR__ . '/Model/Agent.php';
require_once __DIR__ . '/Model/Archetype.php';
require_once __DIR__ . '/Model/Tier.php';
require_once __DIR__ . '/Model/User.php';
require_once __DIR__ . '/Controller/Controller.php';
require_once __DIR__ . '/Controller/AuthController.php';
require_once __DIR__ . '/Controller/HomeController.php';
require_once __DIR__ . '/Controller/AgentController.php';
require_once __DIR__ . '/Controller/ProfileController.php';

//Page demandée (accueil par défaut)
$page = $_GET['page'] ?? 'home';

//Seules les pages listées ici peuvent être appelées
match ($page) {
	'home'     => (new HomeController())->index(),
	'agents'   => (new AgentController())->index(),
	'profile'  => (new ProfileController())->index(),
	'register' => (new AuthController())->register(),
	'login'    => (new AuthController())->login(),
	'logout'   => (new AuthController())->logout(),
	default    => (new HomeController())->index(),
};
