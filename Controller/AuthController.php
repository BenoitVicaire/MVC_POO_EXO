<?php 
//INSCRIPTION MANAGER
//1. Vérifier la réception du formulaire d'inscription
if(isset($_POST['submit'])){

    //2. Normaliser les données avec trim : firstname, lastname, email
    // On enlève les espaces avantr de vérifier les champs vide. Ainsi, si un champ obligatoire est constitué uniquement d'espace, alors il ne passera pas la vérification des champs vide. Par contre, on ne trim jamais le mot de passe, car espace peut en faire légitimement partie
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);

    //3. Vérifier les champs vide
    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($_POST["password"])){

        //4. Vérifier le format des données
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            if(mb_strlen($_POST["password"]) >= 12){
                //5. Hasher le mot de passe
                $password = password_hash($_POST["password"],PASSWORD_DEFAULT);

                //6. Vérifier si l'email est disponible
                try{
                    
                    if(!User::emailExists($email)){
                       User::create($firstname, $lastname, $email, $password);

                        //D. Affichage en nettoyant le code
                        $message = htmlspecialchars($firstname)." ".htmlspecialchars($lastname)." est correctement enregistré.";
                    }else{
                        $message = "Email indisponible.";
                    }

                }catch(Exception $error){
                    http_response_code(500);
                    $message = $error->getMessage();

                    //Erreur 500 : Serveur indisponible
                }

            }else{
                $message = "le mot de passe doit faire au moins 12 caractères.";
            }
        }else{
            $message = "l'email n'est pas au bon format.";
        }

        
    }else{
        $message = "Veuillez remplir tous les champs.";
    }
}

//CONNEXION MANAGER
//1. Vérifier la réception du formulaire d'inscription
if(isset($_POST["submitConnection"])){
    //2. Normaliser les données avec trim : email
    $email = trim($_POST["emailConnection"]);

    //3. Vérifier les champs vide
    if(!empty($email) && !empty($_POST["passwordConnection"])){
        //4. Vérifier le format des données
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            
            if(mb_strlen($_POST["passwordConnection"]) >= 12){
                
                try{
                    //5. Vérifier si le compte existe 
                    //Créer l'objet de connexion PDO
                    $pdo = new PDO("mysql:host=localhost;dbname=agent_manager","root","root",[
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);

                    //A.Préparer la requête
                    $request = $pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.password, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_Role = r.Id_Role WHERE u.email = ?");

                    //B.BindParam
                    $request->bindParam(1,$email, PDO::PARAM_STR);

                    //C.Exécuter la requête
                    $request->execute();

                    //D.Récupérer les données
                    $data = $request->fetch(PDO::FETCH_ASSOC);

                    //E. Vérifier si $data est rempli -> le compte existe
                    if(!empty($data)){
                        //6. Vérifier les mots de passe
                        if(password_verify($_POST["passwordConnection"], $data["password"])){
                            //7. Connecter le manager
                            $_SESSION["id"] = $data["Id_User"];
                            $_SESSION["firstname"] = $data["firstname"];
                            $_SESSION["lastname"] = $data["lastname"];
                            $_SESSION["email"] = $data["email"];
                            $_SESSION["createdAt"] = $data["created_at"];
                            $_SESSION["role"] = $data["role"];

                            $messageConnection = htmlspecialchars($_SESSION["firstname"])." est connecté";

                        }else{
                        $messageConnection = "L'email et/ou le mot de passe est invalide.";
                    }
                        
                    }else{
                        $messageConnection = "L'email et/ou le mot de passe est invalide.";
                    }

                    
                }catch(Exception $error){
                    http_response_code(500);
                    $message = $error->getMessage();

                    //Erreur 500 : Serveur indisponible
                }
                
            }else{
                $messageConnection = "Mot de passe doit faire au moins 12 caractères";
            }
            
        }else{
            $messageConnection = "Format d'email invalide";
        }
        

    }else{
        $messageConnection = "Tous les champs sont obligatoires.";
    }
    
}

