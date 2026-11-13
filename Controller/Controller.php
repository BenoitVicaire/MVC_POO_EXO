<?php
//Classe parente de tous les controllers : contient ce qu'ils ont en commun
abstract class Controller
{
	//Redirige vers l'accueil si personne n'est connecté
	protected function requireLogin(): void
	{
		if (!isset($_SESSION["id"])) {
			header('Location:index.php');
			exit;
		}
	}

	//Affiche une vue entre le header et le footer
	//$data : tableau des variables que la vue doit pouvoir utiliser (ex: ['title' => 'Accueil'])
	protected function render(string $view, array $data = []): void
	{
		//Transforme chaque clé du tableau en variable ($data['title'] devient $title)
		extract($data);

		require __DIR__ . '/../View/Layout/header.php';
		require __DIR__ . '/../View/' . $view . '.php';
		require __DIR__ . '/../View/Layout/footer.php';
	}
}
