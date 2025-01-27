<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'users');

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os dados da tabela com os nomes corretos das colunas
$sql = "SELECT title, precedencia, startTime, endTime, data_de_agendamento FROM calendario";
$result = $conn->query($sql);

// Preparar um array para armazenar os dados do agendamento
$agendamentos = [];

if ($result->num_rows > 0) {
    // Coletar os dados em um array para serem exibidos em JSON
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row;
    }
}

// Salvar o array como JSON para o JavaScript do HTML
file_put_contents('agendamentos.json', json_encode($agendamentos));

// Fechar a conexão
$conn->close();
?>
