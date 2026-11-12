<?php
class Tier
{
	public static function getAll(): array
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT t.Id_Tier, t.tier FROM tiers t");
		$request -> execute();

		return $request->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function TierExists(int $id) : bool
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT t.tier FROM tiers t WHERE t.Id_Tier = ?");
		$request->bindParam(1, $id, PDO::PARAM_INT);
		$request -> execute();
		return !empty($request->fetch(PDO::FETCH_ASSOC));
	} 
}