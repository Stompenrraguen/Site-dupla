Um trabalho escolar que simula um confiavel site de revenda de jogos, possuindo integração com o banco, um sistema de implementação e uso de email em desenvolvimento e em sua esmagadora composição MSQLI e PHP
```
--- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2026 às 17:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `poubresteam`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1
) ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `id_usuario`, `endereco`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(10, 10, 'LUGAR', 'TIJUCA', 'LANABARRA', 'BA', '44042022');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `login`
--

INSERT INTO `login` (`id_login`, `id_usuario`, `login`, `senha`) VALUES
(10, 10, 'enzo', '$2y$10$bj0NO.vIlSMmAWkui2ALPOrl.xYFiyLk2lps5aiyqXE84jaNZYlhq');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `desenvolvedora` varchar(100) DEFAULT NULL,
  `publicadora` varchar(100) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `plataformas` varchar(100) DEFAULT NULL,
  `tamanho` varchar(30) DEFAULT NULL,
  `versao` varchar(20) DEFAULT NULL,
  `classificacao` varchar(30) DEFAULT NULL,
  `idiomas` varchar(100) DEFAULT NULL,
  `modo` varchar(100) DEFAULT NULL,
  `data_lancamento` year(4) DEFAULT NULL,
  `licenca` varchar(150) DEFAULT NULL
) ;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome`, `descricao`, `preco`, `imagem`, `desenvolvedora`, `publicadora`, `genero`, `plataformas`, `tamanho`, `versao`, `classificacao`, `idiomas`, `modo`, `data_lancamento`, `licenca`) VALUES
(1, 'CyberPunk 2099', 'Uma experiência futurista em uma grande cidade dominada por tecnologia, escolhas difíceis e ação intensa.', 3.99, 'img/cyberpunk.jpg', 'Poubre Interactive', 'PoubreSteam', 'Ação / RPG', 'PC', '70 GB', '1.0', '16 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(2, 'Eldacio Ringue', 'Aventura sombria em mundo aberto, com chefes marcantes, exploração ampla e combates desafiadores.', 4.99, 'img/elder-ring.jpg', 'Poubre Interactive', 'PoubreSteam', 'RPG / Ação', 'PC', '60 GB', '1.0', '16 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(3, 'Hollow Shadow', 'Metroidvania subterrâneo com visual sombrio, exploração profunda, combates rápidos e mistérios antigos.', 3.99, 'img/hollow-knight.jpg', 'Poubre Interactive', 'PoubreSteam', 'Metroidvania / Ação', 'PC', '9 GB', '1.0', '10 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(4, 'Vale da Tarde', 'Construa sua fazenda, explore cavernas, conheça moradores e desenvolva uma rotina tranquila no campo.', 3.99, 'img/stardew-valley.jpg', 'Poubre Interactive', 'PoubreSteam', 'Simulação / RPG', 'PC', '2 GB', '1.0', 'Livre', 'Português e Inglês', 'Um jogador / Multiplayer', '2026', 'Revenda digital PoubreSteam'),
(5, 'Aguária', 'Explore, construa, enfrente chefes e sobreviva em um mundo cheio de recursos, criaturas e possibilidades.', 2.99, 'img/terraria.jpg', 'Poubre Interactive', 'PoubreSteam', 'Sandbox / Aventura', 'PC', '500 MB', '1.0', '10 anos', 'Português e Inglês', 'Um jogador / Multiplayer', '2026', 'Revenda digital PoubreSteam'),
(6, 'Infernal', 'Um jogo de plataforma preciso e desafiador sobre escalar uma montanha e superar seus próprios limites.', 1.99, 'img/celeste.jpg', 'Poubre Interactive', 'PoubreSteam', 'Plataforma', 'PC', '1,2 GB', '1.0', '10 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(7, 'Live Ceus', 'Ação rápida, progressão constante e combates intensos em cenários cheios de inimigos, armas e melhorias.', 1.99, 'img/dead-cells.jpg', 'Poubre Interactive', 'PoubreSteam', 'Roguelike / Ação', 'PC', '2 GB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(8, 'Irmão Mais Velho do Zeus', 'Enfrente o submundo em combates rápidos, com poderes divinos, narrativa envolvente e chefes memoráveis.', 2.99, 'img/hades.jpg', 'Poubre Interactive', 'PoubreSteam', 'Roguelike / RPG', 'PC', '15 GB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(9, 'Light Souls', 'RPG de ação com atmosfera sombria, combates exigentes, exploração cuidadosa e inimigos implacáveis.', 3.99, 'img/darksouls.jpg', 'Poubre Interactive', 'PoubreSteam', 'RPG / Ação', 'PC', '8 GB', '1.0', '16 anos', 'Português e Inglês', 'Um jogador / Multiplayer', '2026', 'Revenda digital PoubreSteam'),
(10, 'Não Assista os Dogs', 'Ação em mundo aberto com perseguições, tecnologia, invasões digitais e missões urbanas estratégicas.', 1.99, 'img/watch-dogs.jpg', 'Poubre Interactive', 'PoubreSteam', 'Ação / Mundo Aberto', 'PC', '25 GB', '1.0', '16 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(11, 'Humano: Caindo Duro', 'Puzzle de física com personagens atrapalhados, fases criativas e desafios divertidos para jogar sozinho ou em grupo.', 2.99, 'img/human.jpg', 'Poubre Interactive', 'PoubreSteam', 'Puzzle / Plataforma', 'PC', '1 GB', '1.0', 'Livre', 'Português e Inglês', 'Um jogador / Multiplayer', '2026', 'Revenda digital PoubreSteam'),
(12, 'Bendy and the Coisa Machine', 'Aventura de terror em um estúdio abandonado, com estética de animação antiga, mistério e exploração.', 2.99, 'img/bendy.jpg', 'Poubre Interactive', 'PoubreSteam', 'Terror / Aventura', 'PC', '5 GB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(13, 'Doki Doki The Bizarre Club', 'Visual novel com aparência leve, narrativa psicológica, escolhas marcantes e uma experiência cheia de tensão.', 1.50, 'img/doki.jpg', 'Poubre Interactive', 'PoubreSteam', 'Visual Novel / Terror', 'PC', '500 MB', '1.0', '14 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(14, 'Demonologia 100% Seria', 'Puzzle curto e estilizado, com humor direto, desafios rápidos e personagens marcantes em uma jornada pelo inferno.', 1.99, 'img/helltaker.jpg', 'Poubre Interactive', 'PoubreSteam', 'Puzzle / Aventura', 'PC', '300 MB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(15, 'Cano e Fanstasma', 'Ação e estratégia em túneis assombrados, com manutenção de equipamentos, perigos constantes e ritmo acelerado.', 1.99, 'img/awaria.jpg', 'Poubre Interactive', 'PoubreSteam', 'Ação / Terror', 'PC', '2 GB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(16, 'Baldi\'s Complexo', 'Terror com humor estranho e estética de jogo educativo antigo, misturando perseguição, coleta e sobrevivência.', 1.50, 'img/baldis.jpg', 'Poubre Interactive', 'PoubreSteam', 'Terror / Sobrevivência', 'PC', '800 MB', '1.0', '10 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(17, 'Rato Azul 2', 'Clássico jogo de plataforma em alta velocidade, com fases coloridas, anéis, chefes e muita ação lateral.', 1.99, 'img/sonic.jpg', 'Poubre Interactive', 'PoubreSteam', 'Plataforma / Ação', 'PC', '3 GB', '1.0', 'Livre', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(18, 'Poppy Paytime', 'Terror em uma fábrica de brinquedos abandonada, com puzzles, exploração e criaturas ameaçadoras.', 1.99, 'img/poppy.jpg', 'Poubre Interactive', 'PoubreSteam', 'Terror / Puzzle', 'PC', '12 GB', '1.0', '12 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(19, 'Maravilha', 'Jogo de tiro intenso, com ação rápida, armas pesadas e combates agressivos contra criaturas demoníacas.', 1.99, 'img/doom.jpg', 'Poubre Interactive', 'PoubreSteam', 'FPS / Ação', 'PC', '18 GB', '1.0', '18 anos', 'Português e Inglês', 'Um jogador', '2026', 'Revenda digital PoubreSteam'),
(20, 'GTA VI', 'Ação em mundo aberto com missões, veículos, exploração urbana e diferentes formas de avançar pela cidade.', 3.99, 'img/gta.jpg', 'Poubre Interactive', 'PoubreSteam', 'Ação / Mundo Aberto', 'PC', '150 GB', '1.0', '18 anos', 'Português e Inglês', 'Um jogador / Multiplayer', '2026', 'Revenda digital PoubreSteam');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` char(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT 0,
  `token_verificacao` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `cpf`, `email`, `email_verificado`, `token_verificacao`) VALUES
(10, 'enzo daniel oliveira', '06917007534', 'enzodanieloliveiracar@gmail.com', 0, '9bab946af1687ba79d7b83340cd66880fb5ef2fc357225b5a5dbd7a87f0ed02a');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `numero_venda` varchar(30) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `valor_unitario` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `data_hora` datetime NOT NULL DEFAULT current_timestamp()
) ;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `numero_venda`, `id_usuario`, `id_produto`, `quantidade`, `valor_unitario`, `valor_total`, `forma_pagamento`, `data_hora`) VALUES
(1, '202611251007395580', 10, 1, 1, 3.99, 3.99, 'Pix', '2026-11-25 10:07:39'),
(2, '202611251007395581', 10, 2, 1, 4.99, 4.99, 'Pix', '2026-11-25 10:07:39'),
(3, '202611251023116390', 10, 1, 1, 3.99, 3.99, 'Cartão de Crédito', '2026-11-25 10:23:11'),
(4, '202611251023315040', 10, 7, 1, 1.99, 1.99, 'Pix', '2026-11-25 10:23:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id_carrinho`),
  ADD UNIQUE KEY `uq_carrinho_produto` (`id_usuario`,`id_produto`),
  ADD KEY `idx_carrinho_usuario` (`id_usuario`),
  ADD KEY `idx_carrinho_produto` (`id_produto`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD UNIQUE KEY `uq_endereco_usuario` (`id_usuario`),
  ADD KEY `idx_endereco_usuario` (`id_usuario`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `uq_login_usuario` (`id_usuario`),
  ADD KEY `idx_login_usuario` (`id_usuario`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD UNIQUE KEY `numero_venda` (`numero_venda`),
  ADD KEY `idx_vendas_usuario` (`id_usuario`),
  ADD KEY `idx_vendas_produto` (`id_produto`),
  ADD KEY `idx_vendas_numero` (`numero_venda`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id_carrinho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `fk_carrinho_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_carrinho_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `fk_endereco_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vendas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

```


