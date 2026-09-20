
Site feito usando php, css e html, linkado a um banco de dados MySql, o site possui uma biblioteca que não exige login para ser usada, com uma aba de carrinho e login para realizar compras, site ficticio feito apenas para aprendizado.
Projeto Escolar ofertado pelos Professores de Programação Web e BD (Banco de Dados).

MODELO FÍSICO DO BANCO DE DADOS:
```
CREATE DATABASE IF NOT EXISTS poubresteam;

USE poubresteam;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE
);


CREATE TABLE endereco (
    id_endereco INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep CHAR(8) NOT NULL,

    CONSTRAINT fk_endereco_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT uq_endereco_usuario
        UNIQUE (id_usuario)
);

CREATE TABLE login (
    id_login INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,

    CONSTRAINT fk_login_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT uq_login_usuario
        UNIQUE (id_usuario)
);


CREATE TABLE produto (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    desenvolvedora VARCHAR(100),
    publicadora VARCHAR(100),
    genero VARCHAR(100),
    plataformas VARCHAR(100),
    tamanho VARCHAR(30),
    versao VARCHAR(20),
    classificacao VARCHAR(30),
    idiomas VARCHAR(100),
    modo VARCHAR(100),
    data_lancamento YEAR,
    licenca VARCHAR(150)
);



CREATE TABLE carrinho (
    id_carrinho INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,

    CONSTRAINT fk_carrinho_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_carrinho_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id_produto)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT uq_carrinho_produto
        UNIQUE (id_usuario, id_produto)
);



CREATE TABLE vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    numero_venda VARCHAR(30) NOT NULL,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    valor_unitario DECIMAL(10,2) NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    data_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_vendas_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_vendas_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id_produto)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);



```
**Modelo Lógico:**

<img width="1092" height="832" alt="Captura de tela 2026-09-20 190013" src="https://github.com/user-attachments/assets/87961295-4c8b-490a-95d4-5215d5f31036" />


**Modelo Conceitual:**

<img width="1162" height="677" alt="Captura de tela 2026-09-19 003838" src="https://github.com/user-attachments/assets/5a3c96b1-54dc-4dc0-9137-8ed68e1171de" />

