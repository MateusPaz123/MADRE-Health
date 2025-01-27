<?php
$host = 'localhost'; // Geralmente é 'localhost' no XAMPP
$db = 'users'; // Nome do seu banco de dados
$user = 'root'; // Usuário do banco de dados, normalmente 'root' no XAMPP
$pass = ''; // Senha do banco de dados, geralmente vazia no XAMPP

try {
    // Cria uma nova conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Define o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Caso ocorra um erro na conexão, exibe uma mensagem
    echo "Erro de conexão: " . $e->getMessage();
}
?>