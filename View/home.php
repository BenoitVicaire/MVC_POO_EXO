<main>
	<h1>Accueil</h1>
	<?php
		//Vérifier si personne n'est connecté
		if(!isset($_SESSION["id"])){
	?>
	<section>
		<h2>Inscription</h2>
		<form action="index.php?page=register" method="post">
			<label for="firstname">Prenom :<input id="firstname" type="text" name="firstname"></label>
			<label for="lastname">Nom :<input id="lastname" type="text" name="lastname"></label>
			<label for="email">Email :<input id="email" type="text" name="email"></label>
			<label for="password">Motde Passe :<input id="password" type="password" name="password"></label>
			<input type="submit" name="submit">
		</form>
		<p><?php echo htmlspecialchars($message) ?></p>
	</section>
	<section>
		<h2>Connexion</h2>
		<form action="index.php?page=login" method="post">
			<label for="emailConnection">Email :<input id="emailConnection" type="text" name="emailConnection"></label>
			<label for="passwordConnection">Motde Passe :<input id="passwordConnection" type="password" name="passwordConnection"></label>
			<input type="submit" name="submitConnection">
		</form>
		<p><?php echo htmlspecialchars($messageConnection) ?></p>
	</section>
	<?php
		}
		
		//Vérifier si un manager est connecté
		if(isset($_SESSION["id"])){
	?>
			<section>
				<h2>Liste des Managers</h2>
				<ul>
					<?php
						foreach($listManagers as $manager){
					?>
							<li><?php 
							//Affichage des données avec nettoyage du code malveillant
							echo(htmlspecialchars($manager['firstname'])." ".htmlspecialchars($manager['lastname'])." - ".htmlspecialchars($manager['email'])) ?></li>
					<?php
						}
					?>
				</ul>
			</section>
	<?php
		}
	?>
</main>
