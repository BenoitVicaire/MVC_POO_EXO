<?php
class HomeController extends Controller
{
	public function index(): void
	{
		//Variables d'affichage
		$title = "Accueil";
		$message = "";
		$messageConnection = "";
		$listManagers = [];

		//MESSAGES FLASH (écrits par AuthController avant la redirection)
		//On les lit puis on les supprime pour qu'ils ne s'affichent qu'une fois
		if (isset($_SESSION['flash_register'])) {
			$message = $_SESSION['flash_register'];
			unset($_SESSION['flash_register']);
		}
		if (isset($_SESSION['flash_login'])) {
			$messageConnection = $_SESSION['flash_login'];
			unset($_SESSION['flash_login']);
		}

		//LISTE DES MANAGERS
		//Vérifier si un manager est connecté
		if (isset($_SESSION["id"])) {
			try {
				$listManagers = User::getManagers();
			} catch (Exception $error) {
				//Erreur 500 : Serveur indisponible
				http_response_code(500);
				$message = $error->getMessage();
			}
		}

		$this->render('home', compact('title', 'message', 'messageConnection', 'listManagers'));
	}
}
