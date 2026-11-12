<?php
class Archetype 
{
	public static function getAll():array
	{
		$pdo = Database::getConnection();
		$request = $pdo->prepare("SELECT a.Id_Archetype, a.archetype FROM archetypes a");
		$request->execute();

		return $request->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function ArchetypeExists(int $id) : bool
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT a.archetype FROM archetype a WHERE a.Id_archetype = ?");
		$request->bindParam(1, $id, PDO::PARAM_INT);
		$request->execute();
		
		return !empty($request->fetch(PDO::FETCH_ASSOC));
	}
}