<?php
header('Content-Type: application/json');

// Habilitar a exibição de erros para debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'users');

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    echo json_encode(['error' => 'Erro de conexão com o banco de dados: ' . $conn->connect_error]);
    exit();
}

// Consulta ajustada para buscar os eventos da tabela 'consulta'
$sql = "SELECT 
            paciente AS patientName, 
            CONCAT(data_de_agendamento, 'T', startTime) AS start, 
            CONCAT(data_de_agendamento, 'T', endTime) AS end,
            medicoNome AS doctorName, 
            cpf_paciente AS cpf
        FROM consulta";

$result = $conn->query($sql);

// Verifica se a consulta foi bem-sucedida
if (!$result) {
    echo json_encode(['error' => 'Erro ao executar a consulta: ' . $conn->error]);
    exit();
}

$agendamentos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = [
            'patientName' => $row['patientName'], // Nome do paciente
            'start' => $row['start'],           // Data e hora de início
            'end' => $row['end'],               // Data e hora de fim
            'doctorName' => $row['doctorName'], // Nome do médico
            'cpf' => $row['cpf'],               // CPF do paciente
            'backgroundColor' => '#8BC34A',     // Cor personalizada
            'textColor' => '#ffffff'            // Cor do texto
        ];
    }
}

// Retorna os agendamentos em formato JSON
echo json_encode($agendamentos);

$conn->close();
?>
