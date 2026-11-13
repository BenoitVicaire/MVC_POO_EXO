<?php
class AuthController extends Controller
{
	//Les messages sont stockés bruts dans la session (messages flash) : l'échappement se fait dans la vue
	public function register(): void
	{
		//INSCRIPTION MANAGER
		//1. Vérifier la réception du formulaire d'inscription
		if (isset($_POST['submit'])) {

			//2. Normaliser les données avec trim : firstname, lastname, email
			// On ne trim jamais le mot de passe, car un espace peut en faire légitimement partie
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST["lastname"]);
			$email = trim($_POST["email"]);

			//3. Vérifier les champs vides
			if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($_POST["password"])) {

				//4. Vérifier le format des données
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					if (mb_strlen($_POST["password"]) >= 12) {
						//5. Hasher le mot de passe
						$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

						try {
							//6. Vérifier si l'email est disponible
							if (!User::emailExists($email)) {
								//7. Enregistrer le manager
								User::create($firstname, $lastname, $email, $password);

								$_SESSION['flash_register'] = $firstname . " " . $lastname . " est correctement enregistré.";
							} else {
								$_SESSION['flash_register'] = "Email indisponible.";
							}
						} catch (Exception $error) {
							//Erreur 500 : Serveur indisponible
							http_response_code(500);
							$_SESSION['flash_register'] = $error->getMessage();
						}
					} else {
						$_SESSION['flash_register'] = "Le mot de passe doit faire au moins 12 caractères.";
					}
				} else {
					$_SESSION['flash_register'] = "L'email n'est pas au bon format.";
				}
			} else {
				$_SESSION['flash_register'] = "Veuillez remplir tous les champs.";
			}
		}

		//Dans tous les cas, retour à l'accueil
		header('Location:index.php');
		exit;
	}

	public function login(): void
	{
		//CONNEXION MANAGER
		//1. Vérifier la réception du formulaire de connexion
		if (isset($_POST["submitConnection"])) {
			//2. Normaliser les données avec trim : email
			$email = trim($_POST["emailConnection"]);

			//3. Vérifier les champs vides
			if (!empty($email) && !empty($_POST["passwordConnection"])) {
				//4. Vérifier le format des données
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					if (mb_strlen($_POST["passwordConnection"]) >= 12) {

						try {
							//5. Récupérer le compte
							$data = User::findByEmail($email);

							//6. Vérifier si $data est rempli -> le compte existe
							if (!empty($data)) {
								//7. Vérifier les mots de passe
								if (password_verify($_POST["passwordConnection"], $data["password"])) {
									//8. Connecter le manager
									//Nouvel identifiant de session après connexion (protection contre le vol de session)
									session_regenerate_id(true);

									$_SESSION["id"] = $data["Id_User"];
									$_SESSION["firstname"] = $data["firstname"];
									$_SESSION["lastname"] = $data["lastname"];
									$_SESSION["email"] = $data["email"];
									$_SESSION["createdAt"] = $data["created_at"];
									$_SESSION["role"] = $data["role"];
								} else {
									$_SESSION['flash_login'] = "L'email et/ou le mot de passe est invalide.";
								}
							} else {
								$_SESSION['flash_login'] = "L'email et/ou le mot de passe est invalide.";
							}
						} catch (Exception $error) {
							//Erreur 500 : Serveur indisponible
							http_response_code(500);
							$_SESSION['flash_login'] = $error->getMessage();
						}
					} else {
						$_SESSION['flash_login'] = "Mot de passe doit faire au moins 12 caractères";
					}
				} else {
					$_SESSION['flash_login'] = "Format d'email invalide";
				}
			} else {
				$_SESSION['flash_login'] = "Tous les champs sont obligatoires.";
			}
		}

		//Dans tous les cas, retour à l'accueil
		header('Location:index.php');
		exit;
	}

	public function logout(): void
	{
		//Détruire la session
		session_destroy();

		//Rediriger vers l'accueil
		header('Location:index.php');
		exit;
	}
}
