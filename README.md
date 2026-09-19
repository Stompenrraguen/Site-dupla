
Site feito usando php e css e html, linkado a um banco de dados MySql, o site possui uma biblioteca que não exige login para ser usada, com uma aba de carrinho e login para realizar compras, site ficticio feito apenas para aprendizado

MODELO FÍSICO DO BANCO DE DADOS:

CREATE DATABASE IF NOT EXISTS poubresteam;
USE poubresteam;

//TABELA: USUARIOS

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(8) NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY cpf (cpf)
);



//TABELA: LOGIN


CREATE TABLE login (
    id INT NOT NULL AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY login (login),
    UNIQUE KEY cpf (cpf),

    CONSTRAINT fk_login_usuario
        FOREIGN KEY (cpf)
        REFERENCES usuarios(cpf)
);



//TABELA: CARRINHO


CREATE TABLE carrinho (
    id INT NOT NULL AUTO_INCREMENT,
    cpf_usuario VARCHAR(11) NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,

    PRIMARY KEY (id),

    UNIQUE KEY usuario_produto (cpf_usuario, produto_id),

    CONSTRAINT fk_carrinho_usuario
        FOREIGN KEY (cpf_usuario)
        REFERENCES usuarios(cpf)
);

//TABELA: VENDAS
CREATE TABLE vendas (
    id INT NOT NULL AUTO_INCREMENT,
    numero_venda VARCHAR(30) NOT NULL,
    nome_usuario VARCHAR(100) NOT NULL,
    cpf_usuario VARCHAR(11) NOT NULL,
    produto VARCHAR(200) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    data_hora DATETIME NOT NULL,

    PRIMARY KEY (id),

    UNIQUE KEY numero_venda (numero_venda),

    CONSTRAINT fk_vendas_usuario
        FOREIGN KEY (cpf_usuario)
        REFERENCES usuarios(cpf)
);

<img width="1281" height="822" alt="Captura de tela 2026-09-18 233941" src="https://github.com/user-attachments/assets/5d43101c-2b14-455a-bf2e-875d232f51f7" />
