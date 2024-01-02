CREATE DATABASE tarefas;

CREATE TABLE tarefa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio DATE,
    data_fim DATE,
    estado TINYINT(1) DEFAULT 0
);