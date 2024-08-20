-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/08/2024 às 23:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `brunoambev`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `dados_motorista`
--

CREATE TABLE `dados_motorista` (
  `id` int(11) NOT NULL,
  `data1` bigint(20) DEFAULT NULL,
  `mapa` int(11) DEFAULT NULL,
  `cxentreg` float DEFAULT NULL,
  `tempointerno` time DEFAULT NULL,
  `hrjornadaliq` time DEFAULT NULL,
  `qtentregasentreg_rv` int(11) DEFAULT NULL,
  `cpfmotorista` bigint(20) DEFAULT NULL,
  `cpfajudante1` bigint(20) DEFAULT NULL,
  `cpfajudante2` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `motoristas`
--

CREATE TABLE `motoristas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `funcao` varchar(100) NOT NULL,
  `tipo_carro` enum('moto','carro','caminhao') NOT NULL,
  `cpfmotorista` bigint(20) NOT NULL,
  `observacao` text DEFAULT NULL,
  `tipo_usuario` tinyint(4) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `motoristas`
--

INSERT INTO `motoristas` (`id`, `nome`, `funcao`, `tipo_carro`, `cpfmotorista`, `observacao`, `tipo_usuario`, `data_cadastro`) VALUES
(1, 'Bruno', 'Supervisor', 'carro', 0, 'Administrador do sistema', 1, '2024-08-13 02:01:35'),
(2, 'Diogo Castro', 'Motorista ADM', 'carro', 0, 'Teste Admin', 1, '2024-08-13 02:21:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` char(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `tipo`, `date`) VALUES
(1, 'Diogo Castro', 'dcastrocs@gmail.com', 'castro', '123456', '1', '2024-08-11'),
(2, 'BrunoMazzeo', 'email@email.com', 'bruno', '1234', '1', '2024-08-12');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `dados_motorista`
--
ALTER TABLE `dados_motorista`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `motoristas`
--
ALTER TABLE `motoristas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `dados_motorista`
--
ALTER TABLE `dados_motorista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de tabela `motoristas`
--
ALTER TABLE `motoristas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
