<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $crm = $_POST['crm'];
    $cpf = $_POST['cpf'];
    $celular = $_POST['celular'];
    $dias_trabalho = isset($_POST['dias_trabalho']) ? implode(',', $_POST['dias_trabalho']) : '';

    // Armazena os dados na sessão
    $_SESSION['crm'] = $crm;
    $_SESSION['cpf'] = $cpf;
    $_SESSION['celular'] = $celular;
    $_SESSION['dias_trabalho'] = $dias_trabalho;

    // Conecta ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'users');
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Prepara e executa a query
    $sql = "INSERT INTO perfil_profissional (crm_profissional, cpf, celular, dias_trabalho) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $crm, $cpf, $celular, $dias_trabalho);

    if ($stmt->execute()) {
        // Cadastro realizado com sucesso
        echo "Cadastro realizado com sucesso!";
        header("Location: ../perfil.html");
        exit();
    } else {
        // Exibe o erro em caso de falha
        echo "Erro ao salvar no banco de dados: " . $stmt->error;
        header("Location: ../perfil.html");
        exit();
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
} else {
    // Redireciona caso o acesso seja inválido
    header('Location: ../index.html');
    exit();
}
?>
