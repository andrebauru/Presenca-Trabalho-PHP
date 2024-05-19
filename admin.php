<?php
session_start();

// Verificar senha
if (isset($_POST['senha'])) {
    if ($_POST['senha'] == '2000000004') {
        $_SESSION['autenticado'] = true;
    } else {
        $erro = "Senha incorreta.";
    }
}

// Redirecionar se autenticado
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado']) {
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "usuario", "senha", "NomeTabela");

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Adicionar novo nome
    if (isset($_POST['novo_nome'])) {
        $nome = $_POST['novo_nome'];
        $coluna = $_POST['coluna'];
        $sql = "INSERT INTO nomes (nome, coluna) VALUES ('$nome', $coluna)";
        $conn->query($sql);
    }

    // Remover nome
    if (isset($_POST['remover_id'])) {
        $id = $_POST['remover_id'];
        $sql = "DELETE FROM nomes WHERE id = $id";
        $conn->query($sql);
    }

    // Adicionar nova coluna
    if (isset($_POST['nova_coluna'])) {
        $nome_coluna = $_POST['nome_coluna'];
        $sql = "INSERT INTO colunas (nome) VALUES ('$nome_coluna')";
        $conn->query($sql);
    }

    // Remover coluna
    if (isset($_POST['remover_coluna_id'])) {
        $id = $_POST['remover_coluna_id'];
        $sql = "DELETE FROM colunas WHERE id = $id";
        $conn->query($sql);
    }

    // Renomear coluna
    if (isset($_POST['renomear_coluna_id'])) {
        $id = $_POST['renomear_coluna_id'];
        $novo_nome = $_POST['novo_nome_coluna'];
        $sql = "UPDATE colunas SET nome = '$novo_nome' WHERE id = $id";
        $conn->query($sql);
    }

    // Obter os nomes
    $sql = "SELECT * FROM nomes ORDER BY coluna";
    $result = $conn->query($sql);

    $nomes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nomes[] = $row;
        }
    }

    // Obter as colunas
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
    <title>Administração de Nomes</title>
</head>
<body class="container">
    <h1 class="text-center my-4">Administração de Nomes</h1>
    <form method="post" class="mb-4">
        <div class="form-row align-items-end">
            <div class="col-md-4">
                <label for="novo_nome">Adicionar Nome:</label>
                <input type="text" name="novo_nome" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="coluna">Coluna:</label>
                <select name="coluna" class="form-control">
                    <?php foreach ($colunas as $coluna): ?>
                        <option value="<?= $coluna['id'] ?>"><?= htmlspecialchars($coluna['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
    </form>

    <form method="post" class="mb-4">
        <div class="form-row align-items-end">
            <div class="col-md-6">
                <label for="nome_coluna">Adicionar Coluna:</label>
                <input type="text" name="nome_coluna" class="form-control" required>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Adicionar Coluna</button>
            </div>
        </div>
    </form>

    <h2 class="mb-4">Colunas Existentes</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($colunas as $coluna): ?>
            <tr>
                <td><?= $coluna['id'] ?></td>
                <td><?= htmlspecialchars($coluna['nome']) ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="remover_coluna_id" value="<?= $coluna['id'] ?>">
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="renomear_coluna_id" value="<?= $coluna['id'] ?>">
                        <input type="text" name="novo_nome_coluna" placeholder="Novo Nome" class="form-control d-inline-block" style="width:auto;" required>
                        <button type="submit" class="btn btn-warning">Renomear</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mb-4">Nomes Existentes</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nome</th>
                <th>Coluna</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nomes as $nome): ?>
            <tr>
                <td><?= htmlspecialchars($nome['nome']) ?></td>
                <td><?= $nome['coluna'] ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="remover_id" value="<?= $nome['id'] ?>">
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login Administrativo</title>
</head>
<body class="container">
    <h1 class="text-center my-4">Login Administrativo</h1>
    <form method="post">
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</body>
</html>
<?php
}
?>
