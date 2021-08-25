<?php

$errors = [];
$data = [];
$correctInput = true;
$dataUsers = [
	[
		'id' => 0,
		'name' => 'Ivan',
		'email' => 'ivan@mail.ru',
	],
	[
		'id' => 1,
		'name' => 'Bob',
		'email' => 'bob@mail.ru',
	],
	[
		'id' => 2,
		'name' => 'John',
		'email' => 'john@mail.ru',
	],
	[
		'id' => 3,
		'name' => 'Maga',
		'email' => 'maga@mail.ru',
	],
];

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$errors['email'] = 'Please enter a valid email';
	$correctInput = false;
}

if (empty($_POST['password']) || empty($_POST['confirm_password']) || ($_POST['password'] !== $_POST['confirm_password'])) {
	$errors['password'] = 'Passwords are not the same';
	$correctInput = false;
}

if ($correctInput) {
	foreach ($dataUsers as $user) {
		if (in_array($_POST['email'], $user)) {
			$data['success'] = true;
			$data['message'] = 'Registration success!';
			break;
		}
	}

	if(! isset($data['success'])) {
		$data['success'] = false;
		$data['message'] = 'Not such user!';
	} 
} else {
	$data['success'] = false;
	$data['message'] = $errors;
}

echo json_encode($data);
if (empty($errors)) {
	$logMessage = '[' . date('Y-m-d H:i:s') . '] - ' . $data['message'] . PHP_EOL;
} else {
	$logMessage = '[' . date('Y-m-d H:i:s') . '] - ' . implode(', ', $data['message']) . PHP_EOL;
}
file_put_contents('my-errors.log', $logMessage, FILE_APPEND);