<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia a sessão
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'users');

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT senha FROM usuarios WHERE cpf = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();

            if (password_verify($senha, $hash)) {
                // Armazena o CPF na sessão
                $_SESSION['cpf'] = $cpf;
                header("Location: perfil_paciente.php");
                exit();
            } else {
                // Redireciona com erro de senha
                header("Location: login.html?erro=senha_incorreta");
                exit();
            }
        } else {
            // Redireciona com erro de CPF não encontrado
            header("Location: login.html?erro=cpf_nao_encontrado");
            exit();
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }

    $conn->close();
} else {
    header('Location: login.html');
    exit();
}
?>
