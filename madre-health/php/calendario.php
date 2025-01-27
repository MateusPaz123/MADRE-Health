<?php
// Iniciar a sessão (se necessário)
session_start();

// Conectar ao banco de dados MariaDB
$conn = new mysqli('localhost', 'root', '', 'users');

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $paciente = $_POST['patientName'];
    $medicoNome = $_POST['doctor']; // Médico selecionado
    $dataDeAgendamento = $_POST['appointmentDate'];
    $horario = $_POST['time'];
    $cpf_paciente = $_POST['cpf'];

    // Dividir o horário em startTime e endTime
    list($startTime, $endTime) = explode('-', $horario);

    // Preparar a consulta SQL para inserir os dados na tabela consulta
    $sql = "INSERT INTO consulta (paciente, medicoNome, startTime, endTime, data_de_agendamento, cpf_paciente) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar a declaração
    if ($stmt = $conn->prepare($sql)) {
        // Vincular os parâmetros (s = string, t = time, d = date)
        $stmt->bind_param("ssssss", $paciente, $medicoNome, $startTime, $endTime, $dataDeAgendamento, $cpf_paciente);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "Consulta agendada com sucesso!";
            header('Location: ../historico.html');
            exit();
        } else {
            echo "Erro ao agendar consulta: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>
