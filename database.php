<?php

$host = "localhost";
$databaseName = "personal-information";
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$databaseName";

$data = $_POST;
$errors = [];

if (!empty($errors)) {
    echo implode('<br />', $errors);
    exit;
}

$email = $data['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email format';
    exit;
}

$options = [
    PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$statement = $pdo->prepare('SELECT * FROM information WHERE email = :email');
$statement->execute(['email' => $data['email']]);

if (!empty($statement->fetch())) {
    echo "User with the same email exists.";
    exit;

}

$statement = $pdo->prepare(
        'INSERT INTO information (name, email, number, birthdate, age, gender) VALUES (:name, :email, :number, :birthdate, :age, :gender)'
);
$statement->execute([
    'name' => $data['name'],
    'email' => $data['email'],
    'number' => $data['number'],
    'birthdate' => $data['birthdate'],
    'age' => $data['age'],
    'gender' => $data['gender']
]);

echo "User has successfully been saved.";
?>