<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "NomeTabela");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os nomes do banco de dados
$sql = "SELECT * FROM nomes ORDER BY coluna";
$result = $conn->query($sql);

$nomes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nomes[] = $row;
    }
}

// Obter as colunas do banco de dados
$sql = "SELECT * FROM colunas ORDER BY id";
$result = $conn->query($sql);

$colunas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colunas[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .nome {
            cursor: pointer;
            background-color: white;
            color: black;
            text-align: center;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        .ativado {
            background-color: blue;
            color: black;
        }
    </style>
    <script>
        function mudaCor(element, id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "atualiza_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (element.classList.contains('ativado')) {
                        element.classList.remove('ativado');
                    } else {
                        element.classList.add('ativado');
                    }
                }
            };
            xhr.send("id=" + id);
        }

        // Atualiza a página a cada 5 minutos
        setInterval(function() {
            location.reload();
        }, 300000); // 300000ms = 5 minutos
    </script>
</head>
<body class="container">
    <h1 class="text-center my-4">Tabela de Nomes</h1>
    <div class="row">
        <?php foreach ($colunas as $coluna): ?>
            <div class="col-md-3">
                <h3><?= htmlspecialchars($coluna['nome']) ?></h3>
                <?php foreach ($nomes as $nome): ?>
                    <?php if ($nome['coluna'] == $coluna['id']): ?>
                        <div class="nome <?= $nome['status'] ?>" onclick="mudaCor(this, <?= $nome['id'] ?>)">
                            <?= htmlspecialchars($nome['nome']) ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
