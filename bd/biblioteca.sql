-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 19/08/2026 às 16:33
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
-- Banco de dados: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `biblioteca`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `matricula` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cpf` char(11) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `endereço` text NOT NULL,
  PRIMARY KEY (`matricula`),
  UNIQUE KEY `matricula` (`matricula`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `telefone` (`telefone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`matricula`, `nome`, `email`, `cpf`, `telefone`, `endereço`) VALUES
(1, 'Christian Torres', 'christian.torres@gmail.com', '12345678901', '53999172893', 'Avenida Madrid, 150 - Planeta Vegeta'),
(2, 'Mariana Oliveira', 'mariana.oliveira@gmail.com', '23456789012', '53998123456', 'Rua das Flores, 245 - Centro'),
(3, 'Lucas Pereira', 'lucas.pereira@gmail.com', '34567890123', '53998234567', 'Avenida Brasil, 890 - Cidade Nova'),
(4, 'Fernanda Costa', 'fernanda.costa@gmail.com', '45678901234', '53998345678', 'Rua São José, 412 - Vila Esperança'),
(5, 'Gabriel Almeida', 'gabriel.almeida@gmail.com', '56789012345', '53998456789', 'Travessa das Palmeiras, 78 - Jardim América');

-- --------------------------------------------------------

--
-- Estrutura para tabela `autor`
--

DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cpf` char(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `autor`
--

INSERT INTO `autor` (`id`, `nome`, `cpf`, `email`) VALUES
(0, 'Maquiavel', '12345678923', 'maquiavel@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `autor_livro`
--

DROP TABLE IF EXISTS `autor_livro`;
CREATE TABLE IF NOT EXISTS `autor_livro` (
  `id` bigint(20) NOT NULL,
  `livro_id` bigint(20) UNSIGNED NOT NULL,
  `autor_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `livro_id` (`livro_id`),
  KEY `autor_id` (`autor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `autor_livro`
--

INSERT INTO `autor_livro` (`id`, `livro_id`, `autor_id`) VALUES
(0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `ano_lançamento` int(11) NOT NULL,
  `reserva_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_id` (`reserva_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livro`
--

INSERT INTO `livro` (`id`, `titulo`, `genero`, `ano_lançamento`, `reserva_id`) VALUES
(0, 'Arte da Guerra', 'filosófico', 1521, 1),
(1, 'Senna O Heroi revelado', 'Biografia', 2007, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `data_hora_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_hora_final` timestamp NULL DEFAULT NULL,
  `aluno_matricula` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `aluno_matricula` (`aluno_matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id`, `status`, `data_hora_inicio`, `data_hora_final`, `aluno_matricula`) VALUES
(1, 'RESERVADO', '2026-08-07 00:19:28', NULL, 1),
(2, 'RESERVADO', '2026-08-07 00:19:37', NULL, 1);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `autor_livro`
--
ALTER TABLE `autor_livro`
  ADD CONSTRAINT `autor_livro_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`),
  ADD CONSTRAINT `autor_livro_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`);

--
-- Restrições para tabelas `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `livro_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`aluno_matricula`) REFERENCES `aluno` (`matricula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
