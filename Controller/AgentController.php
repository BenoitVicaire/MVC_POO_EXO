<?php
class AgentController extends Controller
{
	public function index(): void
	{
		//Accessible uniquement si connecté
		$this->requireLogin();

		//Variables d'affichage
		$title = "Agents of Shield";
		$listAgents = [];
		$tiers = [];
		$archetypes = [];

		//ENREGISTREMENT D'UN AGENT (en premier : le nouvel agent apparaît ensuite dans la liste)
		$message = $this->registerAgent();

		//RECUPERATION DES LISTES : tiers, archetypes et agents
		try {
			$tiers = Tier::getAll();
			$archetypes = Archetype::getAll();
			$listAgents = Agent::getAll();
		} catch (Exception $error) {
			//Erreur 500 : Serveur indisponible
			http_response_code(500);
			$message = $error->getMessage();
		}

		$this->render('agent', compact('title', 'message', 'tiers', 'archetypes', 'listAgents'));
	}

	//Traite le formulaire d'enregistrement et renvoie le message à afficher
	private function registerAgent(): string
	{
		$message = "";

		//1. Vérifier si on reçoit le formulaire
		if (isset($_POST["submit"])) {
			//2. Normaliser les données
			$name = trim($_POST["name"]);
			$dob = trim($_POST["dob"]);
			$tier = trim($_POST["tier"]);
			$archetype = trim($_POST["archetype"]);

			//3. Vérifier les champs vides
			if (!empty($name) && !empty($dob) && !empty($tier) && !empty($archetype)) {
				//4. Vérifier le format des données
				if (!filter_var($tier, FILTER_VALIDATE_INT)) {
					$message = "Le Tier est invalide";
				} elseif (!filter_var($archetype, FILTER_VALIDATE_INT)) {
					$message = "Archetype est invalide";
				} elseif (!$this->isValidDate($dob)) {
					$message = "La date de naissance est invalide.";
				} else {
					try {
						if (Agent::nameExists($name)) {
							$message = "Ce nom n'est pas disponible.";
						} elseif (!Archetype::ArchetypeExists((int)$archetype)) {
							$message = "Cet Archetype n'existe pas";
						} elseif (!Tier::TierExists((int)$tier)) {
							$message = "Ce Tier n'existe pas";
						} else {
							Agent::create($name, $dob, (int)$tier, (int)$archetype);
							$message = $name . " a été enregistré.";
						}
					} catch (Exception $error) {
						http_response_code(500);
						$message = $error->getMessage();
					}
				}
			} else {
				$message = "Remplissez tous les champs.";
			}
		}

		return $message;
	}

	//Vrai si la date est au format AAAA-MM-JJ et existe réellement
	private function isValidDate(string $date): bool
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d !== false && $d->format('Y-m-d') === $date;
	}
}
