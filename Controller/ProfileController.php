<?php
class ProfileController extends Controller
{
	public function index(): void
	{
		//Accessible uniquement si connecté
		$this->requireLogin();

		$title = "Mon Compte";

		$this->render('profile', compact('title'));
	}
}
