<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na conexão: ' . $e->getMessage()]);
    exit;
}

// Consulta ajustada
$query = "
    SELECT 
        p.id, 
        p.nome, 
        p.especialidade, 
        COALESCE(pp.dias_trabalho, '') AS dias_trabalho 
    FROM 
        profissionais p
    LEFT JOIN 
        perfil_profissional pp 
    ON 
        p.crm = pp.crm_profissional";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na consulta: ' . $e->getMessage()]);
    exit;
}

// Mapeamento de dias da semana
$daysOfWeek = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
$medicos = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Verifica se o campo dias_trabalho não está vazio e realiza o explode
    $dias_trabalho = !empty($row['dias_trabalho']) ? explode(",", $row['dias_trabalho']) : [];

    // Mapeia os números para os nomes dos dias, com fallback para 'Inválido' se o índice não for válido
    $dias_formatados = array_map(function ($dia) use ($daysOfWeek) {
        // Garante que o valor de $dia seja um número inteiro
        $dia = (int)$dia;
        return isset($daysOfWeek[$dia]) ? $daysOfWeek[$dia] : 'Inválido';
    }, $dias_trabalho);

    $medicos[] = [
        'id' => $row['id'],
        'nome' => $row['nome'],
        'especialidade' => $row['especialidade'],
        'dias_trabalho' => $dias_formatados
    ];
}

// Retorna o array de médicos como JSON
echo json_encode($medicos);
?>
