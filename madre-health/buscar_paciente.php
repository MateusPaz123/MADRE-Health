<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['cpf'])) {
    header("Location: login.html");
    exit();
}

$cpf = $_SESSION['cpf']; // Recupera o CPF da sessão

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'users');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta no banco de dados
$sql = "SELECT id, email, nome, cpf, data_de_nascimento, sexo FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Paciente não encontrado.</p>";
}

$stmt->close();
$conn->close();
?>
