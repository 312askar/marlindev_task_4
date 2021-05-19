<?php

	function get_user_by_email($email){

		$pdo = new PDO("mysql:host=localhost; dbname=marlin_lessons_part2_local; charset=utf8;", "root", "root");

		$sql = "SELECT * FROM register_form WHERE email=:email";

		$statement = $pdo->prepare($sql);
		$statement->execute(['email' => $email]);

		$registerArray = $statement->fetch(PDO::FETCH_ASSOC);

		return $registerArray;

	}

	function add_user($email, $password){

		$pdo = new PDO("mysql:host=localhost; dbname=marlin_lessons_part2_local; charset=utf8;", "root", "root");

		$sql = "INSERT INTO register_form (email, password, admin) VALUES (:email, :password, :admin)";

		$statement = $pdo->prepare($sql);
		$statement->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'admin' => 0]);

		//$_SESSION['message'] = "<strong>Уведомление!</strong> Вы успешно зарегестрированы.";

	}

	function set_flash_message($name, $message){

		$_SESSION[$name] = $message;
	}

	function display_flash_message($name) {

		echo $_SESSION[$name];

		unset($_SESSION[$name]);

	}

	function redirect_to($path){

		header("Location: $path");

		exit;

	}

	function login($email, $password){

		$pdo = new PDO("mysql:host=localhost; dbname=marlin_lessons_part2_local; charset=utf8", "root", "root");

		$sql = "SELECT * FROM register_form WHERE email=:email";

		$statement = $pdo->prepare($sql);
		$statement->execute(['email' => $email]);

		$user = $statement->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) {

			set_flash_message('key', 'Пользователь с таким email не существует');

			redirect_to('/page_login.php');

		} else {

			if (password_verify($password, $user['password'])) {

				$_SESSION['logged-in'] = $email;

				return true;

			}else return false;

		}
	}

	function is_not_logged_in($name){

		if (isset($_SESSION[$name])) {

			return false;

		}else return true;
	}

	function logout(){

		unset($_SESSION['logged-in']);

	}

	function is_admin($name){

		$pdo = new PDO("mysql:host=localhost; dbname=marlin_lessons_part2_local; charset=utf8", "root", "root");

		$sql = "SELECT * FROM register_form WHERE email=:email";

		$statement = $pdo->prepare($sql);
		$statement->execute(['email' => $name]);

		$admin = $statement->fetch(PDO::FETCH_ASSOC);

		return $admin['admin'];

	}

function get_all_users(){

	$pdo = new PDO("mysql:host=localhost; dbname=marlin_lessons_part2_local; charset=utf8;", "root", "root");

	$sql = "SELECT * FROM register_form";

	$statement = $pdo->prepare($sql);
	$statement->execute();

	$all_users = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $all_users;

}