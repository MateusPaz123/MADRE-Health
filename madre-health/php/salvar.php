<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $nome = $_SESSION['nome'];
    $cpf = $_SESSION['cpf'];
    $data_nascimento = $_SESSION['data_de_nascimento'];
    $sexo = $_SESSION['sexo'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar-senha'];

    // Verifica se as senhas correspondem
    if ($senha !== $confirmar_senha) {
        die("As senhas não coincidem.");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Conectar ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'users');

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "INSERT INTO usuarios (email, nome, cpf, data_de_nascimento, sexo, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $nome, $cpf, $data_nascimento, $sexo, $senha_hash);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        header("Location: ../index.html");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>