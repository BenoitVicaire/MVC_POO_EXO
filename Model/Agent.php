<?php
class Agent
{
	//Liste de tous les agents avec leur tier, archetype et équipe
	public static function getAll(): array
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT a.Id_Agent, a.name, a.dob, a.created_at, t.tier, ac.archetype, te.team_name FROM agents a INNER JOIN tiers t ON t.Id_Tier = a.Id_Tier INNER JOIN archetypes ac ON ac.Id_Archetype = a.Id_Archetype LEFT JOIN Teams te ON te.Id_Team = a.Id_Team");
		$request->execute();

		return $request->fetchAll(PDO::FETCH_ASSOC);
	}

	//Vrai si un agent porte déjà ce nom
	public static function nameExists(string $name): bool
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT a.name FROM agents a WHERE a.name = ?");
		$request->bindParam(1, $name, PDO::PARAM_STR);
		$request->execute();

		return !empty($request->fetch(PDO::FETCH_ASSOC));
	}

	//Enregistre un nouvel agent 
	public static function create(string $name, string $dob, int $tier, int $archetype): void
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("INSERT INTO agents (`name`, dob, Id_Tier, Id_Archetype) VALUES (?,?,?,?)");
		$request->bindParam(1, $name, PDO::PARAM_STR);
		$request->bindParam(2, $dob, PDO::PARAM_STR);
		$request->bindParam(3, $tier, PDO::PARAM_INT);
		$request->bindParam(4, $archetype, PDO::PARAM_INT);
		$request->execute();
	}
}
