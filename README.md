# Sistema de Presença de Trabalho

Este projeto é um sistema de presença de trabalho que permite gerenciar e registrar toques em nomes exibidos em colunas. A aplicação é composta por três páginas principais: `index.php`, `atualiza_status.php`, e `admin.php`.

## Funcionalidades

- **index.php**: Exibe uma tabela de nomes em colunas, onde os usuários podem clicar nos nomes para ativá-los ou desativá-los. A página se atualiza automaticamente a cada 5 minutos.
- **atualiza_status.php**: Atualiza o status (ativado/desativado) de um nome no banco de dados e registra o horário do toque.
- **admin.php**: Página administrativa para gerenciar os nomes e colunas. Inclui autenticação por senha (2000000004), adicionar, remover e renomear colunas, além de adicionar e remover nomes.

## Estrutura do Banco de Dados

### Banco de Dados: `NomeTabela`

#### Tabela: `nomes`

| Coluna   | Tipo        | Descrição                                      |
|----------|-------------|------------------------------------------------|
| id       | INT         | Identificador único do nome (chave primária)   |
| nome     | VARCHAR(255)| Nome do usuário                                |
| coluna   | INT         | Identificador da coluna a que o nome pertence  |
| status   | ENUM        | Status do nome (`desativado`, `ativado`)       |

#### Tabela: `logs`

| Coluna   | Tipo        | Descrição                                       |
|----------|-------------|-------------------------------------------------|
| id       | INT         | Identificador único do log (chave primária)     |
| nome_id  | INT         | Identificador do nome (chave estrangeira)       |
| toque    | TIMESTAMP   | Horário do toque                                |

#### Tabela: `colunas`

| Coluna   | Tipo        | Descrição                                      |
|----------|-------------|------------------------------------------------|
| id       | INT         | Identificador único da coluna (chave primária) |
| nome     | VARCHAR(255)| Nome da coluna                                 |

### Script SQL para Criar as Tabelas

```sql
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
```

## Instruções de Uso

### index.php

1. Exibe uma tabela de nomes organizados por colunas.
2. Permite que o usuário clique em um nome para ativá-lo ou desativá-lo.
3. Atualiza a página automaticamente a cada 5 minutos.

### atualiza_status.php

1. Recebe o ID do nome via POST.
2. Alterna o status do nome entre `ativado` e `desativado`.
3. Registra o horário do toque no banco de dados.

### admin.php

1. Página protegida por senha (2000000004).
2. Permite adicionar e remover nomes.
3. Permite adicionar, remover e renomear colunas.

## Dependências

- PHP 7.x ou superior
- MySQL 5.x ou superior
- Bootstrap 4.5.2 (CDN incluído nas páginas)

## Como Configurar

1. Clone o repositório para o seu ambiente de desenvolvimento.
2. Execute o script SQL fornecido para criar o banco de dados e as tabelas.
3. Configure as credenciais do banco de dados nos arquivos PHP (`index.php`, `atualiza_status.php`, `admin.php`).
4. Acesse `index.php` para visualizar a tabela de nomes.
5. Acesse `admin.php` para gerenciar nomes e colunas.

## Contato

Para mais informações, entre em contato:

**Andretsc**  
Email: [andretsc@gmail.com](mailto:andretsc@gmail.com)

## Direitos Autorais

© 2024 Andretsc. Todos os direitos reservados.