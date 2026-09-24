
Site feito usando php, css e html, linkado a um banco de dados MySql, o site possui uma biblioteca que não exige login para ser usada, com uma aba de carrinho e login para realizar compras, site ficticio feito apenas para aprendizado.
Projeto Escolar ofertado pelos Professores de Programação Web e BD (Banco de Dados).

MODELO FÍSICO DO BANCO DE DADOS:
```
-- ============================================================
-- POUBRE STEAM
-- MODELO FÍSICO COMPLETO
-- BANCO + TABELAS + PRODUTOS
-- ============================================================


-- ============================================================
-- 1. CRIAR BANCO
-- ============================================================

CREATE DATABASE IF NOT EXISTS poubresteam
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE poubresteam;


-- ============================================================
-- 2. TABELA USUARIO
-- ============================================================

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE
) ENGINE=InnoDB;


-- ============================================================
-- 3. TABELA ENDERECO
-- ============================================================

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
) ENGINE=InnoDB;


-- ============================================================
-- 4. TABELA LOGIN
-- ============================================================

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
) ENGINE=InnoDB;


-- ============================================================
-- 5. TABELA PRODUTO
-- ============================================================

CREATE TABLE produto (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL,
    descricao TEXT NOT NULL,
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
    licenca VARCHAR(150),

    CONSTRAINT chk_produto_preco
        CHECK (preco >= 0)
) ENGINE=InnoDB;


-- ============================================================
-- 6. TABELA CARRINHO
-- ============================================================

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
        UNIQUE (id_usuario, id_produto),

    CONSTRAINT chk_carrinho_quantidade
        CHECK (quantidade > 0)
) ENGINE=InnoDB;


-- ============================================================
-- 7. TABELA VENDAS
-- ============================================================

CREATE TABLE vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,

    numero_venda VARCHAR(30) NOT NULL UNIQUE,

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
        ON UPDATE CASCADE,

    CONSTRAINT chk_vendas_quantidade
        CHECK (quantidade > 0),

    CONSTRAINT chk_vendas_valor_unitario
        CHECK (valor_unitario >= 0),

    CONSTRAINT chk_vendas_valor_total
        CHECK (valor_total >= 0)
) ENGINE=InnoDB;


-- ============================================================
-- 8. ÍNDICES
-- ============================================================

CREATE INDEX idx_endereco_usuario
    ON endereco(id_usuario);

CREATE INDEX idx_login_usuario
    ON login(id_usuario);

CREATE INDEX idx_carrinho_usuario
    ON carrinho(id_usuario);

CREATE INDEX idx_carrinho_produto
    ON carrinho(id_produto);

CREATE INDEX idx_vendas_usuario
    ON vendas(id_usuario);

CREATE INDEX idx_vendas_produto
    ON vendas(id_produto);

CREATE INDEX idx_vendas_numero
    ON vendas(numero_venda);


-- ============================================================
-- 9. PRODUTOS
-- ============================================================

INSERT INTO produto
(
    id_produto,
    nome,
    preco,
    descricao,
    imagem,
    desenvolvedora,
    publicadora,
    genero,
    plataformas,
    tamanho,
    versao,
    classificacao,
    idiomas,
    modo,
    data_lancamento,
    licenca
)
VALUES

(
    1,
    'CyberPunk 2099',
    3.99,
    'Uma experiência futurista em uma grande cidade dominada por tecnologia, escolhas difíceis e ação intensa.',
    'img/cyberpunk.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Ação / RPG',
    'PC',
    '70 GB',
    '1.0',
    '16 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    2,
    'Eldacio Ringue',
    4.99,
    'Aventura sombria em mundo aberto, com chefes marcantes, exploração ampla e combates desafiadores.',
    'img/elder-ring.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'RPG / Ação',
    'PC',
    '60 GB',
    '1.0',
    '16 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    3,
    'Hollow Shadow',
    3.99,
    'Metroidvania subterrâneo com visual sombrio, exploração profunda, combates rápidos e mistérios antigos.',
    'img/hollow-knight.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Metroidvania / Ação',
    'PC',
    '9 GB',
    '1.0',
    '10 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    4,
    'Vale da Tarde',
    3.99,
    'Construa sua fazenda, explore cavernas, conheça moradores e desenvolva uma rotina tranquila no campo.',
    'img/stardew-valley.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Simulação / RPG',
    'PC',
    '2 GB',
    '1.0',
    'Livre',
    'Português e Inglês',
    'Um jogador / Multiplayer',
    2026,
    'Revenda digital PoubreSteam'
),

(
    5,
    'Aguária',
    2.99,
    'Explore, construa, enfrente chefes e sobreviva em um mundo cheio de recursos, criaturas e possibilidades.',
    'img/terraria.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Sandbox / Aventura',
    'PC',
    '500 MB',
    '1.0',
    '10 anos',
    'Português e Inglês',
    'Um jogador / Multiplayer',
    2026,
    'Revenda digital PoubreSteam'
),

(
    6,
    'Infernal',
    1.99,
    'Um jogo de plataforma preciso e desafiador sobre escalar uma montanha e superar seus próprios limites.',
    'img/celeste.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Plataforma',
    'PC',
    '1,2 GB',
    '1.0',
    '10 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    7,
    'Live Ceus',
    1.99,
    'Ação rápida, progressão constante e combates intensos em cenários cheios de inimigos, armas e melhorias.',
    'img/dead-cells.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Roguelike / Ação',
    'PC',
    '2 GB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    8,
    'Irmão Mais Velho do Zeus',
    2.99,
    'Enfrente o submundo em combates rápidos, com poderes divinos, narrativa envolvente e chefes memoráveis.',
    'img/hades.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Roguelike / RPG',
    'PC',
    '15 GB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    9,
    'Light Souls',
    3.99,
    'RPG de ação com atmosfera sombria, combates exigentes, exploração cuidadosa e inimigos implacáveis.',
    'img/darksouls.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'RPG / Ação',
    'PC',
    '8 GB',
    '1.0',
    '16 anos',
    'Português e Inglês',
    'Um jogador / Multiplayer',
    2026,
    'Revenda digital PoubreSteam'
),

(
    10,
    'Não Assista os Dogs',
    1.99,
    'Ação em mundo aberto com perseguições, tecnologia, invasões digitais e missões urbanas estratégicas.',
    'img/watch-dogs.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Ação / Mundo Aberto',
    'PC',
    '25 GB',
    '1.0',
    '16 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    11,
    'Humano: Caindo Duro',
    2.99,
    'Puzzle de física com personagens atrapalhados, fases criativas e desafios divertidos para jogar sozinho ou em grupo.',
    'img/human.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Puzzle / Plataforma',
    'PC',
    '1 GB',
    '1.0',
    'Livre',
    'Português e Inglês',
    'Um jogador / Multiplayer',
    2026,
    'Revenda digital PoubreSteam'
),

(
    12,
    'Bendy and the Coisa Machine',
    2.99,
    'Aventura de terror em um estúdio abandonado, com estética de animação antiga, mistério e exploração.',
    'img/bendy.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Terror / Aventura',
    'PC',
    '5 GB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    13,
    'Doki Doki The Bizarre Club',
    1.50,
    'Visual novel com aparência leve, narrativa psicológica, escolhas marcantes e uma experiência cheia de tensão.',
    'img/doki.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Visual Novel / Terror',
    'PC',
    '500 MB',
    '1.0',
    '14 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    14,
    'Demonologia 100% Seria',
    1.99,
    'Puzzle curto e estilizado, com humor direto, desafios rápidos e personagens marcantes em uma jornada pelo inferno.',
    'img/helltaker.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Puzzle / Aventura',
    'PC',
    '300 MB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    15,
    'Cano e Fanstasma',
    1.99,
    'Ação e estratégia em túneis assombrados, com manutenção de equipamentos, perigos constantes e ritmo acelerado.',
    'img/awaria.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Ação / Terror',
    'PC',
    '2 GB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    16,
    'Baldi''s Complexo',
    1.50,
    'Terror com humor estranho e estética de jogo educativo antigo, misturando perseguição, coleta e sobrevivência.',
    'img/baldis.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Terror / Sobrevivência',
    'PC',
    '800 MB',
    '1.0',
    '10 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    17,
    'Rato Azul 2',
    1.99,
    'Clássico jogo de plataforma em alta velocidade, com fases coloridas, anéis, chefes e muita ação lateral.',
    'img/sonic.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Plataforma / Ação',
    'PC',
    '3 GB',
    '1.0',
    'Livre',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    18,
    'Poppy Paytime',
    1.99,
    'Terror em uma fábrica de brinquedos abandonada, com puzzles, exploração e criaturas ameaçadoras.',
    'img/poppy.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Terror / Puzzle',
    'PC',
    '12 GB',
    '1.0',
    '12 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    19,
    'Maravilha',
    1.99,
    'Jogo de tiro intenso, com ação rápida, armas pesadas e combates agressivos contra criaturas demoníacas.',
    'img/doom.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'FPS / Ação',
    'PC',
    '18 GB',
    '1.0',
    '18 anos',
    'Português e Inglês',
    'Um jogador',
    2026,
    'Revenda digital PoubreSteam'
),

(
    20,
    'GTA VI',
    3.99,
    'Ação em mundo aberto com missões, veículos, exploração urbana e diferentes formas de avançar pela cidade.',
    'img/gta.jpg',
    'Poubre Interactive',
    'PoubreSteam',
    'Ação / Mundo Aberto',
    'PC',
    '150 GB',
    '1.0',
    '18 anos',
    'Português e Inglês',
    'Um jogador / Multiplayer',
    2026,
    'Revenda digital PoubreSteam'
);


-- ============================================================
-- 10. CONFERÊNCIA FINAL
-- ============================================================

SELECT
    id_produto,
    nome,
    preco,
    imagem
FROM produto
ORDER BY id_produto;



