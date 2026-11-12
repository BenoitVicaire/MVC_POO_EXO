<?php
class User 
{
	public static function emailExists(string $email) : bool
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT u.email FROM users u WHERE u.email = ?");
		$request->bindParam(1, $email, PDO::PARAM_STR);
		$request->execute();

		return !empty($request->fetch(PDO::FETCH_ASSOC));
	}

	public static function create(string $firstname, string $lastname, string $email, string $password): void
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("INSERT INTO users(firstname, lastname, email, `password`, Id_role) VALUES (?,?,?,?,2)");
		$request->bindParam(1, $firstname, PDO::PARAM_STR);
		$request->bindParam(2, $lastname, PDO::PARAM_STR);
		$request->bindParam(3, $email, PDO::PARAM_STR);
		$request->bindParam(4, $password, PDO::PARAM_STR);
		$request->execute();
	}

	public static function findByEmail(string $email): ? array
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.password, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_role = r.Id_Role WHERE u.email = ?");
		$request->bindParam(1,$email,PDO::PARAM_STR);
		$request->execute();
		$data = $request->fetch(PDO::FETCH_ASSOC);

		return $data ?: null;
	}

	public static function getManagers(): array
	{
		$pdo = Database::getConnection();

		$request = $pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_Role = r.Id_Role WHERE r.role = 'Manager'");
		$request->execute();

		return $request->fetchAll(PDO::FETCH_ASSOC);
		
	}
}