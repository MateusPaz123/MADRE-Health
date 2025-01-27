<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Obtém o CPF enviado pelo formulário
$cpf = $_POST['cpf'];

// Prepara a consulta SQL para buscar as consultas associadas ao CPF
$sql = "SELECT paciente, medicoNome, startTime, endTime, data_de_agendamento 
        FROM consulta 
        WHERE cpf_paciente = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há consultas e exibe os resultados
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        // Formata a data para o formato brasileiro
        $dataFormatada = date("d/m/Y", strtotime($row['data_de_agendamento']));

        echo "<li>
                <b>Paciente:</b> " . htmlspecialchars($row['paciente']) . "<br>
                <b>Médico:</b> " . htmlspecialchars($row['medicoNome']) . "<br>
                <b>Horário:</b> " . htmlspecialchars($row['startTime']) . " - " . htmlspecialchars($row['endTime']) . "<br>
                <b>Data:</b> " . htmlspecialchars($dataFormatada) . "
              </li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhuma consulta encontrada para este CPF.</p>";
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
