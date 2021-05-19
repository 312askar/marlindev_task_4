<?php

	session_start();
	include "function.php";

	$email = $_POST['email'];
	$password = $_POST['password'];

		if ($email != "" && $password != "") {

				login($email, $password);

				if (login($email, $password)) {

					redirect_to('/users.php');

				}else{

					set_flash_message('key', 'Неверный пароль для - '. $email);

					redirect_to('/page_login.php');
				}

		}elseif(empty($email) && !empty($password)){

			set_flash_message('key', 'Введите ваш Логин!');

			redirect_to('/page_login.php');

		}elseif(!empty($email) && empty($password)){

			set_flash_message('key', 'Введите ваш Пароль!');

			redirect_to('/page_login.php');

		}elseif(empty($email) && empty($password)){

			set_flash_message('key', 'Введите ваш Логин Пароль!');

			redirect_to('/page_login.php');

		}