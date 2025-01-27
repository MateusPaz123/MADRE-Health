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
    // Define as variáveis para uso no HTML
    $nome = $row['nome'];
    $email = $row['email'];
    $data_de_nascimento = $row['data_de_nascimento'];
    $sexo = $row['sexo'];
} else {
    echo "<p>Paciente não encontrado.</p>";
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do Paciente</title>
  <link rel="stylesheet" href="CSS/profile.css">
</head>

<body>
  <div class="container">
    <header>
      <h1>Meu Perfil</h1>
    </header>

    <!-- Menu Lateral -->
    <div class="menu">
      <button class="menu-btn" onclick="window.location.href='index.html'">
        <img src="fotos/logo.jpg" alt="Home" class="icon">
        <span class="label">Madre Health</span>
      </button>

      <button class="menu-btn" onclick="window.location.href='historico.html'">
        <span class="emoji">📝</span>
        <span class="label">Histórico</span>
      </button>

      <button class="menu-btn" onclick="window.location.href='perfil_paciente.php'">
        <span class="emoji">😷</span>
        <span class="label">Meu Perfil</span>
      </button>

      <button class="menu-btn" onclick="window.location.href='agendar.html'">
        <span class="emoji">🖊️</span>
        <span class="label">Agende sua consulta</span>
      </button>
    </div>

    <!-- Informações Pessoais -->
    <section class="personal-info">
      <h2>Informações Pessoais</h2>

      <form id="personalInfoForm">
        <label for="nome-completo">Nome Completo:</label>
        <div class="input-box">
          <input type="text" name="name" id="name" placeholder="Nome Completo" value="<?php echo htmlspecialchars($nome); ?>" readonly>
        </div>

        <label for="cpf">CPF:</label>
        <div class="input-box">
          <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" oninput="mascaraCPF(this)" value="<?php echo htmlspecialchars($cpf); ?>" readonly>
        </div>

        <label for="email">E-mail:</label>
        <div class="input-box">
          <input type="email" id="email" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars($email); ?>" readonly>
        </div>

        <label for="birthdate">Data de Nascimento:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($data_de_nascimento); ?>" readonly><br>

        <label for="sexo">Sexo:</label>
        <input type="text" id="sexo" name="sexo" value="<?php echo htmlspecialchars($sexo); ?>" readonly><br>
      </form>
    </section>
  </div>
  </form>


<script>
    function mascaraCPF(cpf) {
        let valor = cpf.value;

        valor = valor.replace(/\D/g, "");

        if (valor.length > 3) {
            valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
        }

        if (valor.length > 6) {
            valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
        }

        if (valor.length > 9) {
            valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }

        cpf.value = valor;
    }
</script>
</body>
</html>
