<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $nome = $_SESSION['nome'];
    $crm = $_SESSION['crm'];
    $especialidade = $_SESSION['especialidade'];
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

    $sql = "INSERT INTO profissionais (email, nome, crm, especialidade, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email, $nome, $crm, $especialidade, $senha_hash);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        header("Location: ../index.html");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
        header("location: ../senhaM.html");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>