<?php
session_start();
ob_start();  // Inicia o buffer de saída

// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

// Verifique se o CRM está na sessão
if (!isset($_SESSION['crm'])) {
    echo "Erro: CRM não encontrado na sessão.";
    exit;
}

// Recupera o CRM do profissional
$crm = $_SESSION['crm'];

// Consulta para verificar se o CRM existe na tabela perfil_profissional
$query = "SELECT COUNT(*) FROM perfil_profissional WHERE crm = :crm";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':crm', $crm, PDO::PARAM_STR);
$stmt->execute();

// Verificar se o CRM já preencheu os dados na tabela perfil_profissional
$result = $stmt->fetchColumn();

if ($result > 0) {
    // Redireciona para a página principal ou de dashboard
    header('Location: home.html');
    exit();
} else {
    // Redireciona para a página de cadastro
    header('Location: perfil.html');
    exit();
}
