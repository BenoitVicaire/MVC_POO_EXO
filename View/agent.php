<main>
	<h1>Agents of Shield</h1>
	<section>
		<h2>Enregistrement d'un agent</h2>
		<form action="" method="post">
			<label for="name">Nom : <input id="name" type="text" name="name"></label>
			<label for="dob">Date de naissance : <input id="dob" type="text" name="dob"></label>
			<label for="tier">Tier : <select name="tier" id="tier">
				<?php
					//Affichage des options pour le Tier
					foreach($tiers as $tier){
				?>
						<option value="<?php echo(htmlspecialchars($tier['Id_Tier'])) ?>"><?php echo(htmlspecialchars($tier['tier'])) ?></option>
				<?php
					}
				?>
				</select>
			</label>
			<label for="archetype">Archetype : <select name="archetype" id="archetype">
				<?php
					//Affichage des options pour le Tier
					foreach($archetypes as $archetype){
				?>
						<option value="<?php echo(htmlspecialchars($archetype['Id_Archetype'])) ?>"><?php echo(htmlspecialchars($archetype['archetype'])) ?></option>
				<?php
					}
				?>
				</select>
			</label>
			<input type="submit" name="submit">
		</form>
		<p><?php echo($message) ?></p>
	</section>
	<section>
		<h2>Liste des agents</h2>
		<ul>
			<?php
				foreach($listAgents as $agent){
			?>
					<li><?php 
					//Affichage des données avec nettoyage du code malveillant
					echo(htmlspecialchars($agent['name'])." - ".htmlspecialchars($agent['archetype'])." - ".htmlspecialchars($agent['dob'])." - ".htmlspecialchars($agent['created_at'])." - ".htmlspecialchars($agent['tier'])) ?></li>
			<?php
				}
			?>
		</ul>
	</section>
</main>
