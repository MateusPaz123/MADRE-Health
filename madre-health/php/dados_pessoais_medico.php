<?php
session_start();

// Verifique se os dados pessoais foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Acesse os dados usando os nomes que você definiu no HTML
    $name = $_POST['name'];
    $email = $_POST['email'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];

    // Armazenar os dados na sessão
    $_SESSION['nome'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['crm'] = $crm;
    $_SESSION['especialidade'] = $especialidade;

    // Exibir os dados (opcional para depuração)
    echo "name: " . htmlspecialchars($name) . "<br>";
    echo "email: " . htmlspecialchars($email) . "<br>";
    echo "crm: " . htmlspecialchars($crm) . "<br>";
    echo "especialidade: " . htmlspecialchars($especialidade) . "<br>";

    // Redirecionar para o próximo passo
    header('Location: ../senhaM.html');
    exit();
} else {
    // Redireciona se não houver dados enviados
    header('Location: dados_pessoais_medico.html');
    exit();
}
?>