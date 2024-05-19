CREATE DATABASE NomeTabela;
USE NomeTabela;

-- Tabela para armazenar os nomes
CREATE TABLE nomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    coluna INT NOT NULL,
    status ENUM('desativado', 'ativado') DEFAULT 'desativado'
);

-- Tabela para armazenar os logs de toque
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_id INT,
    toque TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nome_id) REFERENCES nomes(id)
);

-- Tabela para armazenar as colunas
CREATE TABLE colunas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

-- Inserir colunas iniciais
INSERT INTO colunas (nome) VALUES ('Coluna 1'), ('Coluna 2'), ('Coluna 3'), ('Coluna 4');
