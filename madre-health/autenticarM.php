<?php
session_start(); // Inicia a sessão
ob_start();      // Inicia o buffer de saída

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='../CSS/style_autenticar.css'> 
    <title>Autenticação</title>
</head>
<body>";

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $crm = $_POST['crm'];
    $senha = $_POST['senha'];

    try {
        // Conecta ao banco de dados usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para verificar o CRM e obter a senha do usuário
        $query = "SELECT senha FROM profissionais WHERE crm = :crm";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':crm', $crm, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Se o CRM foi encontrado, verifica a senha
            $hash = $stmt->fetchColumn();

            if (password_verify($senha, $hash)) {
                echo "<div class='message success'>Login bem-sucedido!</div>";

                // Armazena o CRM na sessão para futuras verificações
                $_SESSION['crm'] = $crm;

                // Verifica se o CRM já completou o perfil na tabela perfil_profissional
                $query = "SELECT COUNT(*) FROM perfil_profissional WHERE crm_profissional = :crm";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':crm', $crm, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchColumn();

                if ($result > 0) {
                    // Redireciona para a página principal (perfil completo)
                    header('Location: /madre-health/agendamento.html');
                    exit();
                } else {
                    // Redireciona para a página de cadastro (perfil incompleto)
                    header('Location: /madre-health/perfil.html');
                    exit();
                }
            } else {
                echo "<div class='message error'>Senha incorreta.</div>";
            }
        } else {
            echo "<div class='message error'>CRM não encontrado.</div>";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
        exit;
    }
} else {
    header('Location: /madre-health/loginM.html');
    exit();
}

echo "</body></html>";
?>
