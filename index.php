<?php
//ACCUEIL
//Démarrage de la session
session_start();
require_once __DIR__ . '/Model/Database.php';
require_once __DIR__ . '/Model/Agent.php';
require_once __DIR__ . '/Model/Archetype.php.php';
require_once __DIR__ . '/Model/Tier.php';
require_once __DIR__ . '/Model/User.php';

$page = $_GET['page'] ?? 'home';

$result = match($page) {
  'home' => require_once __DIR__ . '/Controller/HomeController.php',
  'agents' => require_once __DIR__ . '/Controller/AgentController.php',
  'profile' => require_once __DIR__ . '/Controller/ProfileController.php',
  'logout' => require_once __DIR__ . '/Controller/AuthController.php',
  default => require_once __DIR__ . '/Controller/HomeController.php',
}


?>
   