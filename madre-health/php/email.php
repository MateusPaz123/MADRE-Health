<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['email'] = $_POST['email'];
    header('Location: ../dados_pessoais.html');
    exit();
} else {
    header('Location: ../email.html');
    exit();
}
?>