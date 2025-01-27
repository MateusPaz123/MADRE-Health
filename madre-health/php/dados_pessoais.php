<?php
session_start();

// Verifique se os dados pessoais foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Acesse os dados usando os nomes que você definiu no HTML
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_de_nascimento'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];

    // Armazenar os dados na sessão
    $_SESSION['nome'] = $name;
    $_SESSION['cpf'] = $cpf;
    $_SESSION['data_de_nascimento'] = $data_nascimento;
    $_SESSION['sexo'] = $sexo;
    $_SESSION['email'] = $email;

    // Exibir os dados (opcional para depuração)
    echo "name: " . htmlspecialchars($name) . "<br>";
    echo "cpf: " . htmlspecialchars($cpf) . "<br>";
    echo "data de nascimento: " . htmlspecialchars($data_nascimento) . "<br>";
    echo "sexo: " . htmlspecialchars($sexo) . "<br>";
    echo "email: " . htmlspecialchars($email) . "<br>";

    // Redirecionar para o próximo passo
    header('Location: ../senha.html');
    exit();
} else {
    // Redireciona se não houver dados enviados
    header('Location: dados_pessoais.html');
    exit();
}
?>