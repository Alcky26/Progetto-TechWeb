-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Dic 16, 2021 alle 13:36
-- Versione del server: 10.3.32-MariaDB-0ubuntu0.20.04.1
-- Versione PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvignaga`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ACQUISTO`
--

CREATE TABLE `ACQUISTO` (
  `quantita` tinyint(1) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `dataOra` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `ACQUISTO`:
--   `dataOra`
--       `ORDINAZIONE` -> `dataOra`
--   `email`
--       `ORDINAZIONE` -> `email`
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Svuota la tabella prima dell'inserimento `ACQUISTO`
--

TRUNCATE TABLE `ACQUISTO`;
--
-- Dump dei dati per la tabella `ACQUISTO`
--

INSERT INTO `ACQUISTO` (`quantita`, `nome`, `dataOra`, `email`) VALUES
(2, '4 Formaggi', '2021-12-22 12:31:52', 'mvignaga@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `BEVANDA`
--

CREATE TABLE `BEVANDA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `gradiAlcolici` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `BEVANDA`:
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Svuota la tabella prima dell'inserimento `BEVANDA`
--

TRUNCATE TABLE `BEVANDA`;
--
-- Dump dei dati per la tabella `BEVANDA`
--

INSERT INTO `BEVANDA` (`nome`, `gradiAlcolici`) VALUES
('CocaCola', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `BONUS`
--

CREATE TABLE `BONUS` (
  `codiceBonus` int(11) NOT NULL,
  `dataScadenza` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valore` int(4) NOT NULL,
  `dataRiscatto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `BONUS`:
--

--
-- Svuota la tabella prima dell'inserimento `BONUS`
--

TRUNCATE TABLE `BONUS`;
--
-- Dump dei dati per la tabella `BONUS`
--

INSERT INTO `BONUS` (`codiceBonus`, `dataScadenza`, `valore`, `dataRiscatto`) VALUES
(1, '2021-10-13 18:36:37', 4, '2021-12-16 12:21:31'),
(2, '2021-04-05 10:45:11', 4, '2021-12-16 12:21:31'),
(3, '2021-10-17 05:56:00', 3, '2021-12-16 12:21:31'),
(4, '2021-12-07 23:59:54', 5, '2021-12-16 12:21:31'),
(5, '2021-12-18 19:26:17', 9, '2021-12-16 12:21:31'),
(6, '2021-05-31 22:32:17', 10, '2021-12-16 12:21:31'),
(7, '2021-06-18 08:01:52', 5, '2021-12-16 12:21:31'),
(8, '2022-01-20 12:23:22', 10, '2021-12-16 12:21:31'),
(9, '2021-10-19 05:34:33', 4, '2021-12-16 12:21:31'),
(10, '2021-04-02 06:00:47', 5, '2021-12-16 12:21:31'),
(11, '2022-02-18 17:38:53', 10, '2021-12-16 12:21:31'),
(12, '2021-10-24 04:34:39', 10, '2021-12-16 12:21:31'),
(13, '2021-08-07 14:03:34', 8, '2021-12-16 12:21:31'),
(14, '2021-12-16 14:11:36', 10, '2021-12-16 12:21:31'),
(15, '2021-05-23 06:25:41', 10, '2021-12-16 12:21:31');

-- --------------------------------------------------------

--
-- Struttura della tabella `COMPOSIZIONE`
--

CREATE TABLE `COMPOSIZIONE` (
  `nome_ingr` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `COMPOSIZIONE`:
--   `nome`
--       `PIZZA` -> `nome`
--   `nome_ingr`
--       `INGREDIENTE` -> `nome`
--

--
-- Svuota la tabella prima dell'inserimento `COMPOSIZIONE`
--

TRUNCATE TABLE `COMPOSIZIONE`;
--
-- Dump dei dati per la tabella `COMPOSIZIONE`
--

INSERT INTO `COMPOSIZIONE` (`nome_ingr`, `nome`) VALUES
('Farina 00', 'Tedesca'),
('Mozzarella', 'Tedesca'),
('Passata Pomodoro', 'Tedesca'),
('Patatine Fritte', 'Tedesca'),
('Wurstel', 'Tedesca');

-- --------------------------------------------------------

--
-- Struttura della tabella `DOLCE`
--

CREATE TABLE `DOLCE` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `DOLCE`:
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Svuota la tabella prima dell'inserimento `DOLCE`
--

TRUNCATE TABLE `DOLCE`;
--
-- Dump dei dati per la tabella `DOLCE`
--

INSERT INTO `DOLCE` (`nome`) VALUES
('Tiramisù');

-- --------------------------------------------------------

--
-- Struttura della tabella `ELEMENTO_LISTINO`
--

CREATE TABLE `ELEMENTO_LISTINO` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` float NOT NULL,
  `descrizione` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `ELEMENTO_LISTINO`:
--

--
-- Svuota la tabella prima dell'inserimento `ELEMENTO_LISTINO`
--

TRUNCATE TABLE `ELEMENTO_LISTINO`;
--
-- Dump dei dati per la tabella `ELEMENTO_LISTINO`
--

INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES
('4 Formaggi', 30, ''),
('CocaCola', 3, ''),
('Prosciutto Funghi', 75.1, ''),
('Tedesca', 98.5, ''),
('Tiramisù', 10, ''),
('Vegetariana', 85.6, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `INGREDIENTE`
--

CREATE TABLE `INGREDIENTE` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `allergene` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `INGREDIENTE`:
--

--
-- Svuota la tabella prima dell'inserimento `INGREDIENTE`
--

TRUNCATE TABLE `INGREDIENTE`;
--
-- Dump dei dati per la tabella `INGREDIENTE`
--

INSERT INTO `INGREDIENTE` (`nome`, `allergene`) VALUES
('Farina 00', 1),
('Funghi', 0),
('Gorgonzola', 1),
('Mozzarella', 1),
('Passata Pomodoro', 0),
('Patatine Fritte', 0),
('Peperoni Grigliati', 0),
('Philadelpia', 1),
('Prosciutto', 0),
('Prosciutto Crudo', 0),
('Salamino', 0),
('Salsiccia', 0),
('Uova', 1),
('Wurstel', 0),
('Zucchine Grigliate', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ORDINAZIONE`
--

CREATE TABLE `ORDINAZIONE` (
  `dataOra` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `ORDINAZIONE`:
--   `email`
--       `UTENTE` -> `email`
--

--
-- Svuota la tabella prima dell'inserimento `ORDINAZIONE`
--

TRUNCATE TABLE `ORDINAZIONE`;
--
-- Dump dei dati per la tabella `ORDINAZIONE`
--

INSERT INTO `ORDINAZIONE` (`dataOra`, `email`) VALUES
('2021-12-22 12:31:52', 'mvignaga@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `PIZZA`
--

CREATE TABLE `PIZZA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `PIZZA`:
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Svuota la tabella prima dell'inserimento `PIZZA`
--

TRUNCATE TABLE `PIZZA`;
--
-- Dump dei dati per la tabella `PIZZA`
--

INSERT INTO `PIZZA` (`nome`) VALUES
('4 Formaggi'),
('Prosciutto Funghi'),
('Tedesca'),
('Vegetariana');

-- --------------------------------------------------------

--
-- Struttura della tabella `POSSESSO_BONUS`
--

CREATE TABLE `POSSESSO_BONUS` (
  `codiceBonus` int(11) NOT NULL,
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `POSSESSO_BONUS`:
--   `codiceBonus`
--       `BONUS` -> `codiceBonus`
--   `email`
--       `UTENTE` -> `email`
--

--
-- Svuota la tabella prima dell'inserimento `POSSESSO_BONUS`
--

TRUNCATE TABLE `POSSESSO_BONUS`;
--
-- Dump dei dati per la tabella `POSSESSO_BONUS`
--

INSERT INTO `POSSESSO_BONUS` (`codiceBonus`, `email`) VALUES
(4, 'mvignaga@unipd.it'),
(8, 'mmasetto@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `PRENOTAZIONE`
--

CREATE TABLE `PRENOTAZIONE` (
  `persone` tinyint(1) NOT NULL,
  `dataOra` timestamp NOT NULL DEFAULT current_timestamp(),
  `numero` tinyint(1) NOT NULL,
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `PRENOTAZIONE`:
--   `email`
--       `UTENTE` -> `email`
--   `numero`
--       `TAVOLO` -> `numero`
--

--
-- Svuota la tabella prima dell'inserimento `PRENOTAZIONE`
--

TRUNCATE TABLE `PRENOTAZIONE`;
--
-- Dump dei dati per la tabella `PRENOTAZIONE`
--

INSERT INTO `PRENOTAZIONE` (`persone`, `dataOra`, `numero`, `email`) VALUES
(5, '2021-12-16 12:27:02', 4, 'gorlandi@unipd.it'),
(4, '2021-12-16 12:27:02', 4, 'zzhenwei@unipd.it'),
(10, '2021-12-16 12:27:02', 12, 'mmasetto@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `TAVOLO`
--

CREATE TABLE `TAVOLO` (
  `numero` tinyint(1) NOT NULL,
  `posti` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `TAVOLO`:
--

--
-- Svuota la tabella prima dell'inserimento `TAVOLO`
--

TRUNCATE TABLE `TAVOLO`;
--
-- Dump dei dati per la tabella `TAVOLO`
--

INSERT INTO `TAVOLO` (`numero`, `posti`) VALUES
(1, 6),
(2, 10),
(3, 5),
(4, 2),
(5, 5),
(6, 4),
(7, 6),
(8, 1),
(9, 2),
(10, 4),
(11, 2),
(12, 10),
(13, 5),
(14, 6),
(15, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `UTENTE`
--

CREATE TABLE `UTENTE` (
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `punti` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `UTENTE`:
--

--
-- Svuota la tabella prima dell'inserimento `UTENTE`
--

TRUNCATE TABLE `UTENTE`;
--
-- Dump dei dati per la tabella `UTENTE`
--

INSERT INTO `UTENTE` (`email`, `password`, `punti`) VALUES
('gorlandi@unipd.it', 'password', 10),
('mmasetto@unipd.it', 'password', 55),
('mvignaga@unipd.it', 'password', 0),
('zzhenwei@unipd.it', 'password', 100);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ACQUISTO`
--
ALTER TABLE `ACQUISTO`
  ADD PRIMARY KEY (`nome`,`dataOra`,`email`),
  ADD KEY `dataOra` (`dataOra`,`email`);

--
-- Indici per le tabelle `BEVANDA`
--
ALTER TABLE `BEVANDA`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `BONUS`
--
ALTER TABLE `BONUS`
  ADD PRIMARY KEY (`codiceBonus`);

--
-- Indici per le tabelle `COMPOSIZIONE`
--
ALTER TABLE `COMPOSIZIONE`
  ADD PRIMARY KEY (`nome`,`nome_ingr`),
  ADD KEY `nome_ingr` (`nome_ingr`);

--
-- Indici per le tabelle `DOLCE`
--
ALTER TABLE `DOLCE`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `ELEMENTO_LISTINO`
--
ALTER TABLE `ELEMENTO_LISTINO`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `INGREDIENTE`
--
ALTER TABLE `INGREDIENTE`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `ORDINAZIONE`
--
ALTER TABLE `ORDINAZIONE`
  ADD PRIMARY KEY (`dataOra`,`email`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `PIZZA`
--
ALTER TABLE `PIZZA`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `POSSESSO_BONUS`
--
ALTER TABLE `POSSESSO_BONUS`
  ADD PRIMARY KEY (`codiceBonus`,`email`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD PRIMARY KEY (`numero`,`email`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `TAVOLO`
--
ALTER TABLE `TAVOLO`
  ADD PRIMARY KEY (`numero`);

--
-- Indici per le tabelle `UTENTE`
--
ALTER TABLE `UTENTE`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `BONUS`
--
ALTER TABLE `BONUS`
  MODIFY `codiceBonus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ACQUISTO`
--
ALTER TABLE `ACQUISTO`
  ADD CONSTRAINT `ACQUISTO_ibfk_1` FOREIGN KEY (`dataOra`,`email`) REFERENCES `ORDINAZIONE` (`dataOra`, `email`),
  ADD CONSTRAINT `ACQUISTO_ibfk_2` FOREIGN KEY (`nome`) REFERENCES `ELEMENTO_LISTINO` (`nome`);

--
-- Limiti per la tabella `BEVANDA`
--
ALTER TABLE `BEVANDA`
  ADD CONSTRAINT `BEVANDA_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `ELEMENTO_LISTINO` (`nome`);

--
-- Limiti per la tabella `COMPOSIZIONE`
--
ALTER TABLE `COMPOSIZIONE`
  ADD CONSTRAINT `COMPOSIZIONE_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `PIZZA` (`nome`),
  ADD CONSTRAINT `COMPOSIZIONE_ibfk_2` FOREIGN KEY (`nome_ingr`) REFERENCES `INGREDIENTE` (`nome`);

--
-- Limiti per la tabella `DOLCE`
--
ALTER TABLE `DOLCE`
  ADD CONSTRAINT `DOLCE_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `ELEMENTO_LISTINO` (`nome`);

--
-- Limiti per la tabella `ORDINAZIONE`
--
ALTER TABLE `ORDINAZIONE`
  ADD CONSTRAINT `ORDINAZIONE_ibfk_1` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`);

--
-- Limiti per la tabella `PIZZA`
--
ALTER TABLE `PIZZA`
  ADD CONSTRAINT `PIZZA_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `ELEMENTO_LISTINO` (`nome`);

--
-- Limiti per la tabella `POSSESSO_BONUS`
--
ALTER TABLE `POSSESSO_BONUS`
  ADD CONSTRAINT `POSSESSO_BONUS_ibfk_1` FOREIGN KEY (`codiceBonus`) REFERENCES `BONUS` (`codiceBonus`),
  ADD CONSTRAINT `POSSESSO_BONUS_ibfk_2` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`);

--
-- Limiti per la tabella `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_1` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`),
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_2` FOREIGN KEY (`numero`) REFERENCES `TAVOLO` (`numero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
