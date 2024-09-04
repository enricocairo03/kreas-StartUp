-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 04, 2024 alle 11:42
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kréas`
--
CREATE DATABASE IF NOT EXISTS `kréas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kréas`;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

DROP TABLE IF EXISTS `ordine`;
CREATE TABLE IF NOT EXISTS `ordine` (
  `id_ordine` int(11) NOT NULL AUTO_INCREMENT,
  `data_vendita` date NOT NULL,
  `dest_paese` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ordine`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`id_ordine`, `data_vendita`, `dest_paese`) VALUES
(1, '2024-07-17', 'Italia'),
(2, '2024-08-01', 'Francia'),
(3, '2024-05-02', 'Olanda'),
(4, '2024-06-11', 'Inghilterra'),
(5, '2024-07-15', 'Germania');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine_items`
--

DROP TABLE IF EXISTS `ordine_items`;
CREATE TABLE IF NOT EXISTS `ordine_items` (
  `id_ordine_prodotti` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordini` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantità` int(11) NOT NULL,
  PRIMARY KEY (`id_ordine_prodotti`),
  KEY `Ordini` (`id_ordini`),
  KEY `Prodotti` (`id_prodotto`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine_items`
--

INSERT INTO `ordine_items` (`id_ordine_prodotti`, `id_ordini`, `id_prodotto`, `quantità`) VALUES
(201, 1, 4, 50),
(202, 5, 6, 80),
(203, 3, 5, 200),
(204, 4, 1, 180),
(205, 2, 3, 60),
(206, 1, 2, 265),
(207, 1, 5, 55);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

DROP TABLE IF EXISTS `prodotti`;
CREATE TABLE IF NOT EXISTS `prodotti` (
  `id_prodotto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `co2_salvata` float NOT NULL,
  PRIMARY KEY (`id_prodotto`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id_prodotto`, `nome`, `co2_salvata`) VALUES
(1, 'Carne di Pollo', 2.5),
(2, 'Carne di Maile', 3.2),
(3, 'Bistecca Sintetica', 4.5),
(4, 'Carne di Manzo', 6.5),
(5, 'Salsicce di maiale sintetiche', 7.8),
(6, 'Carne di Alce', 10.5),
(7, 'Carne di Cervo', 12.4);



-- Query per il calcolo della CO2 salvata
-- Questo è solo un esempio, in un contesto reale dovrebbe essere eseguito tramite applicazione.
SELECT
    SUM(prodotti.co2_salvata * ordine_items.quantità) AS totale_co2
FROM
    ordine
JOIN
    ordine_items ON ordine.id_ordine = ordine_items.id_ordini
JOIN
    prodotti ON ordine_items.id_prodotto = prodotti.id_prodotto
WHERE
    ordine.data_vendita BETWEEN '2024-01-01' AND '2024-12-31'
    AND ordine.dest_paese = 'Italia'
    AND prodotti.nome = 'Prodotto Esempio';


--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ordine_items`
--
ALTER TABLE `ordine_items`
  ADD CONSTRAINT `Ordini` FOREIGN KEY (`id_ordini`) REFERENCES `ordine` (`id_ordine`) ON DELETE CASCADE,
  ADD CONSTRAINT `Prodotti` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id_prodotto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
