<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "NomeTabela");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_POST['id'];

// Obter o status atual
$sql = "SELECT status FROM nomes WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$new_status = $row['status'] == 'ativado' ? 'desativado' : 'ativado';

// Atualizar o status
$sql = "UPDATE nomes SET status = '$new_status' WHERE id = $id";
$conn->query($sql);

// Registrar o toque
$sql = "INSERT INTO logs (nome_id) VALUES ($id)";
$conn->query($sql);

$conn->close();
?>
