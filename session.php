<?php

include "config.php";
	// Permet de charger les classes utilisées automatiquement
	function chargerClasse($classe)
	{
	  require "classes/" . $classe . '.class.php';
	}
	// Indication à PHP que la fonction 'chargerClasse'
	// doit être utiliser pour charger une classe non déclarée
	spl_autoload_register('chargerClasse');
	session_start();

	// Si la connexion n'est pas encore faite avec la bdd
	if (!isset($_SESSION['connexion']))
	{
	  $connexion = new ConnexionBDD($BDD_host, $BDD_base, $BDD_user, $BDD_password);
	  $_SESSION['connexion'] = $connexion;
	}
	// Si elle est déjà faite
	else
		$connexion = $_SESSION['connexion'];

	$bdd = $connexion->pdo();

	// Création des managers
	$UsersManager = new UsersManager($bdd);
	$GroupesManager = new GroupesManager($bdd);
	$HTTPRequest = new HTTPRequest($bdd);

	if(isset($_GET['action']) && $_GET['action'] != "")
		$action = $_GET['action'];
	else
		$action = "";

	// Si la session perso existe, on restaure l'objet.
	if (isset($_SESSION['user']))
	{
	  $user = $_SESSION['user'];
	}

	// Si la session groupes existe, on restaure l'objet.
	if (isset($_SESSION['groupes']))
	{
	  $groupes = $_SESSION['groupes'];
	}
	else
		$groupes = array();

	// Si l'utilisateur n'est pas connecté
	if(!$HTTPRequest->IsConnected())
	{
		if($action == "Connexion" && isset($_GET['login']) && isset($_GET['mdp'])
			&& $_GET['login']!="" && $_GET['mdp']!="")
		{
			$user = $UsersManager->Connexion(new Users(null, $_GET['login'], $_GET['mdp'], null, null, null));
		}
		else if($action == "Inscription")
		{
			if(isset($_GET['login']) && isset($_GET['mdp']) && isset($_GET['mail'])
					&& $_GET['login']!="" && $_GET['mdp']!="" && $_GET['mail']!="")
				{
					$user = new Users(null, $_GET['login'], $_GET['mdp'],
						$_GET['mail'], null, null);
					$UsersManager->add($user);
				}
				else
				{
					$HTTPRequest->Wrong("wrongData");
				}
		}
		else
		{
			$HTTPRequest->Wrong("NotConnected");
		}
	}
	// Si l'utilisateur est connecté
	else
	{
                switch($action)
		{
                        case "SelectGroupes" :
					$groupes = $GroupesManager->SelectGroupes($user);
			break;
			case...
			default :
				$HTTPRequest->Wrong("WrongAction");
			break;
		}
	}

	// Si on a créé un user, on le stocke dans une variable session
	if (isset($user))
	{
		$_SESSION['user'] = $user;
	}
?>
