-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Gen 08, 2022 alle 18:57
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
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ACQUISTO`
--

INSERT INTO `ACQUISTO` (`quantita`, `nome`, `dataOra`, `email`, `birthday`) VALUES
(2, '4 Formaggi', '2021-12-22 11:31:52', 'mvignaga@unipd.it', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `BEVANDA`
--

CREATE TABLE `BEVANDA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `gradiAlcolici` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `BEVANDA`
--

INSERT INTO `BEVANDA` (`nome`, `categoria`, `gradiAlcolici`) VALUES
('Acqua frizzante 0.5l', 'bevande analcoliche', 0),
('Acqua frizzante 1l', 'bevande analcoliche', 0),
('Acqua naturale 0.5l', 'bevande analcoliche', 0),
('Acqua naturale 1l', 'bevande analcoliche', 0),
('Coca Cola 0.5l', 'bevande analcoliche', 0),
('Fanta 0.5l', 'bevande analcoliche', 0),
('Glossner Gold', 'birre', 5),
('La Chouffe', 'birre', 8),
('Namur Blache', 'birre', 4.5),
('Pilsner Urquell', 'birre', 4.4),
('Tennents Super', 'birre', 9),
('The al limone', 'bevande analcoliche', 0),
('The alla pesca', 'bevande analcoliche', 0);

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
  `id_ingrediente` int(4) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `COMPOSIZIONE`
--

INSERT INTO `COMPOSIZIONE` (`id_ingrediente`, `nome`) VALUES
(1, '4 formaggi'),
(2, '4 formaggi'),
(5, '4 formaggi'),
(11, '4 formaggi'),
(15, '4 formaggi'),
(16, '4 formaggi'),
(1, '4 stagioni'),
(2, '4 stagioni'),
(9, '4 stagioni'),
(13, '4 stagioni'),
(28, '4 stagioni'),
(33, '4 stagioni'),
(2, 'Alla greppia'),
(16, 'Alla greppia'),
(32, 'Alla greppia'),
(40, 'Alla greppia'),
(2, 'Altopiano'),
(5, 'Altopiano'),
(13, 'Altopiano'),
(27, 'Altopiano'),
(2, 'Calzone'),
(31, 'Calzone'),
(39, 'Calzone'),
(2, 'Calzone 2'),
(13, 'Calzone 2'),
(28, 'Calzone 2'),
(2, 'Calzone vegetariano'),
(17, 'Calzone vegetariano'),
(23, 'Calzone vegetariano'),
(45, 'Calzone vegetariano'),
(1, 'Capricciosa'),
(2, 'Capricciosa'),
(9, 'Capricciosa'),
(13, 'Capricciosa'),
(28, 'Capricciosa'),
(1, 'Carbonara'),
(2, 'Carbonara'),
(16, 'Carbonara'),
(21, 'Carbonara'),
(43, 'Carbonara'),
(1, 'Carmine'),
(2, 'Carmine'),
(13, 'Carmine'),
(16, 'Carmine'),
(30, 'Carmine'),
(32, 'Carmine'),
(1, 'Diavola'),
(2, 'Diavola'),
(33, 'Diavola'),
(2, 'Estate'),
(17, 'Estate'),
(23, 'Estate'),
(45, 'Estate'),
(1, 'frutti di mare'),
(2, 'frutti di mare'),
(12, 'frutti di mare'),
(14, 'frutti di mare'),
(1, 'Margherita'),
(2, 'Margherita'),
(1, 'Marinara'),
(4, 'Marinara'),
(1, 'Mediterranea'),
(2, 'Mediterranea'),
(7, 'Mediterranea'),
(26, 'Mediterranea'),
(30, 'Mediterranea'),
(32, 'Mediterranea'),
(37, 'Mediterranea'),
(1, 'Parigina'),
(2, 'Parigina'),
(29, 'Parigina'),
(1, 'Parmigiana'),
(2, 'Parmigiana'),
(16, 'Parmigiana'),
(17, 'Parmigiana'),
(1, 'Patatosa'),
(2, 'Patatosa'),
(22, 'Patatosa'),
(2, 'Pizza dolce'),
(13, 'Pizza dolce'),
(35, 'Pizza dolce'),
(40, 'Pizza dolce'),
(1, 'Polpa di granchio'),
(2, 'Polpa di granchio'),
(25, 'Polpa di granchio'),
(1, 'Prosciutto e funghi'),
(2, 'Prosciutto e funghi'),
(13, 'Prosciutto e funghi'),
(28, 'Prosciutto e funghi'),
(1, 'Regina'),
(6, 'Regina'),
(18, 'Regina'),
(1, 'Ritrovo'),
(2, 'Ritrovo'),
(13, 'Ritrovo'),
(16, 'Ritrovo'),
(32, 'Ritrovo'),
(35, 'Ritrovo'),
(1, 'Romana'),
(2, 'Romana'),
(3, 'Romana'),
(8, 'Romana'),
(20, 'Romana'),
(1, 'Salmone'),
(2, 'Salmone'),
(32, 'Salmone'),
(34, 'Salmone'),
(1, 'Saporita'),
(2, 'Saporita'),
(10, 'Saporita'),
(15, 'Saporita'),
(23, 'Saporita'),
(33, 'Saporita'),
(18, 'Stromboli'),
(19, 'Stromboli'),
(23, 'Stromboli'),
(33, 'Stromboli'),
(2, 'Svizzera'),
(11, 'Svizzera'),
(17, 'Svizzera'),
(21, 'Svizzera'),
(1, 'Tedesca'),
(2, 'Tedesca'),
(22, 'Tedesca'),
(44, 'Tedesca'),
(1, 'Texana'),
(2, 'Texana'),
(10, 'Texana'),
(19, 'Texana'),
(21, 'Texana'),
(41, 'Texana'),
(42, 'Texana'),
(1, 'Tirolese'),
(2, 'Tirolese'),
(38, 'Tirolese'),
(41, 'Tirolese'),
(44, 'Tirolese'),
(1, 'Tonno e cipolla'),
(2, 'Tonno e cipolla'),
(10, 'Tonno e cipolla'),
(42, 'Tonno e cipolla'),
(1, 'Vegetariana'),
(2, 'Vegetariana'),
(17, 'Vegetariana'),
(23, 'Vegetariana'),
(45, 'Vegetariana'),
(1, 'Vesuviana'),
(2, 'Vesuviana'),
(17, 'Vesuviana'),
(26, 'Vesuviana'),
(29, 'Vesuviana'),
(37, 'Vesuviana'),
(1, 'Viennese'),
(2, 'Viennese'),
(44, 'Viennese');

-- --------------------------------------------------------

--
-- Struttura della tabella `DOLCE`
--

CREATE TABLE `DOLCE` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `DOLCE`
--

INSERT INTO `DOLCE` (`nome`) VALUES
('Panna cotta ai frutti di bosco'),
('Panna cotta al caramello'),
('Panna cotta al cioccolato'),
('Propfiterole'),
('Sorbetto al limone'),
('Sorbetto alla liquirizia'),
('Tiramisù'),
('Torta della nonna');

-- --------------------------------------------------------

--
-- Struttura della tabella `ELEMENTO_LISTINO`
--

CREATE TABLE `ELEMENTO_LISTINO` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` float NOT NULL,
  `descrizione` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ELEMENTO_LISTINO`
--

INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES
('4 formaggi', 6.5, NULL),
('4 stagioni', 7, NULL),
('Acqua frizzante 0.5l', 1.5, NULL),
('Acqua frizzante 1l', 2, NULL),
('Acqua naturale 0.5l', 1.5, NULL),
('Acqua naturale 1l', 2, NULL),
('Alla greppia', 6, NULL),
('Altopiano', 7.5, NULL),
('Calzone', 7, NULL),
('Calzone 2', 7, NULL),
('Calzone vegetariano', 7, NULL),
('Capricciosa', 7, NULL),
('Carbonara', 6, NULL),
('Carmine', 7, NULL),
('Coca Cola 0.5l', 3, NULL),
('Diavola', 5, NULL),
('Estate', 6, NULL),
('Fanta 0.5l', 3, NULL),
('Frutti di mare', 7, NULL),
('Glossner Gold', 3.5, NULL),
('La Chouffe', 3.5, NULL),
('Margherita', 4.5, NULL),
('Marinara', 3.5, NULL),
('Mediterranea', 7, NULL),
('Namur Blache', 3.5, NULL),
('Panna cotta ai frutti di bosco', 4, NULL),
('Panna cotta al caramello', 4, NULL),
('Panna cotta al cioccolato', 4, NULL),
('Parigina', 6, NULL),
('Parmigiana', 6, NULL),
('Patatosa', 5.5, NULL),
('Pilsner Urquell', 3.5, 'Pilsner dal colore dorato, ha un bouquet di grano tostato e un bilanciato gusto. Sapore intensamente luppolato con un equilibrio di dolcezza sottile e di amaro vellutato dalla combinazione di sapori di miele, diacetile e note caramellate insieme ad un altro estratto residuo. Chiude con una cremosità pulita, che fa perfetto contraltare al luppolo.'),
('Pizza dolce', 6, NULL),
('Polpa di granchio', 6.5, NULL),
('Propfiterole', 4.5, NULL),
('Prosciutto e funghi', 6.5, NULL),
('Regina', 8.5, NULL),
('Ritrovo', 7, NULL),
('Romana', 5.5, NULL),
('Salmone', 7, NULL),
('Saporita', 7.5, NULL),
('Sorbetto al limone', 3.5, NULL),
('Sorbetto alla liquirizia', 3.5, NULL),
('Stromboli', 8, NULL),
('Svizzera', 6.5, NULL),
('Tedesca', 6, NULL),
('Tennents Super', 3.5, NULL),
('Texana', 7.5, NULL),
('The al limone', 2.5, NULL),
('The alla pesca', 2.5, NULL),
('Tiramisù', 4.5, NULL),
('Tirolese', 8, NULL),
('Tonno e cipolla', 6, NULL),
('Torta della nonna', 4, NULL),
('Vegetariana', 7.5, NULL),
('Vesuviana', 8, NULL),
('Viennese', 5, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `INGREDIENTE`
--

CREATE TABLE `INGREDIENTE` (
  `id_ingrediente` int(4) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `allergene` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `INGREDIENTE`
--

INSERT INTO `INGREDIENTE` (`id_ingrediente`, `nome`, `allergene`) VALUES
(1, 'pomodoro', 0),
(2, 'mozzarella', 7),
(3, 'acciughe', 4),
(4, 'aglio', 0),
(5, 'asiago', 7),
(6, 'basilico', 0),
(7, 'bresaola', 0),
(8, 'capperi', 0),
(9, 'carciofi', 0),
(10, 'cipolla', 0),
(11, 'emmenthal', 7),
(12, 'frutti di mare', 13),
(13, 'funghi', 0),
(14, 'gamberetti', 2),
(15, 'gorgonzola', 7),
(16, 'grana', 7),
(17, 'melanzane grigliate', 0),
(18, 'mozzarella di bufala', 7),
(19, 'olive', 0),
(20, 'origano', 0),
(21, 'pancetta', 0),
(22, 'patatine fritte', 0),
(23, 'peperoni grigliati', 0),
(24, 'philadelpia', 7),
(25, 'polpa di granchio', 2),
(26, 'pomodorini', 0),
(27, 'porchetta', 0),
(28, 'prosciutto cotto', 0),
(29, 'prosciutto crudo', 0),
(30, 'radicchio', 0),
(31, 'ricotta', 7),
(32, 'rucola', 0),
(33, 'salamino piccante', 0),
(34, 'salmone affumicato', 4),
(35, 'salsiccia', 0),
(36, 'sbrise', 0),
(37, 'scamorza', 7),
(38, 'speck', 0),
(39, 'spinaci', 0),
(40, 'stracchino', 7),
(41, 'taleggio', 7),
(42, 'tonno', 4),
(43, 'uova', 3),
(44, 'wurstel', 0),
(45, 'zucchine grigliate', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ORDINAZIONE`
--

CREATE TABLE `ORDINAZIONE` (
  `dataOra` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ORDINAZIONE`
--

INSERT INTO `ORDINAZIONE` (`dataOra`, `email`) VALUES
('2021-12-22 11:31:52', 'mvignaga@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `PIZZA`
--

CREATE TABLE `PIZZA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `PIZZA`
--

INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES
('4 formaggi', 'classiche'),
('4 stagioni', 'classiche'),
('Alla greppia', 'bianche'),
('Altopiano', 'bianche'),
('Calzone', 'calzoni'),
('Calzone 2', 'calzoni'),
('Calzone vegetariano', 'calzoni'),
('Capricciosa', 'classiche'),
('Carbonara', 'classiche'),
('Carmine', 'speciali'),
('Diavola', 'classiche'),
('Estate', 'bianche'),
('Frutti di mare', 'speciali'),
('Margherita', 'classiche'),
('Marinara', 'classiche'),
('Mediterranea', 'speciali'),
('Parigina', 'classiche'),
('Parmigiana', 'classiche'),
('Patatosa', 'classiche'),
('Pizza dolce', 'bianche'),
('Polpa di granchio', 'speciali'),
('Prosciutto e funghi', 'classiche'),
('Regina', 'speciali'),
('Ritrovo', 'speciali'),
('Romana', 'classiche'),
('Salmone', 'speciali'),
('Saporita', 'speciali'),
('Stromboli', 'bianche'),
('Svizzera', 'bianche'),
('Tedesca', 'classiche'),
('Texana', 'speciali'),
('Tirolese', 'speciali'),
('Tonno e cipolla', 'classiche'),
('Vegetariana', 'classiche'),
('Vesuviana', 'speciali'),
('Viennese', 'classiche');

-- --------------------------------------------------------

--
-- Struttura della tabella `POSSESSO_BONUS`
--

CREATE TABLE `POSSESSO_BONUS` (
  `codiceBonus` int(11) NOT NULL,
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `POSSESSO_BONUS`
--

INSERT INTO `POSSESSO_BONUS` (`codiceBonus`, `email`, `username`) VALUES
(4, 'mvignaga@unipd.it', 'mvignaga'),
(8, 'mmasetto@unipd.it', 'mmasetto');

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
-- Dump dei dati per la tabella `PRENOTAZIONE`
--

INSERT INTO `PRENOTAZIONE` (`persone`, `dataOra`, `numero`, `email`) VALUES
(4, '2021-12-16 11:27:02', 3, 'zzhenwei@unipd.it'),
(5, '2021-12-16 11:27:02', 4, 'gorlandi@unipd.it'),
(10, '2021-12-16 11:27:02', 12, 'mmasetto@unipd.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `TAVOLO`
--

CREATE TABLE `TAVOLO` (
  `numero` tinyint(1) NOT NULL,
  `posti` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `punti` int(15) NOT NULL DEFAULT 0,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `UTENTE`
--

INSERT INTO `UTENTE` (`email`, `username`, `birthday`, `password`, `punti`, `isAdmin`) VALUES
('gorlandi@unipd.it', 'gorlandi', '0000-00-00 00:00:00', 'password', 10, 0),
('mmasetto@unipd.it', 'mmasetto', '0000-00-00 00:00:00', 'password', 55, 0),
('mvignaga@unipd.it', 'mvignaga', '0000-00-00 00:00:00', 'password', 0, 0),
('prova@gmail.com', 'prova', '0000-00-00 00:00:00', 'prova', 0, 0),
('test@gmail.com', 'testuser', '0000-00-00 00:00:00', 'testpw', 0, 1),
('zzhenwei@unipd.it', 'zzhenwei', '0000-00-00 00:00:00', 'password', 100, 0);

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
  ADD PRIMARY KEY (`nome`,`id_ingrediente`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

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
  ADD PRIMARY KEY (`id_ingrediente`);

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
  ADD PRIMARY KEY (`codiceBonus`,`email`,`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_2` (`username`,`email`);

--
-- Indici per le tabelle `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD PRIMARY KEY (`dataOra`,`numero`),
  ADD KEY `numero` (`numero`);

--
-- Indici per le tabelle `TAVOLO`
--
ALTER TABLE `TAVOLO`
  ADD PRIMARY KEY (`numero`);

--
-- Indici per le tabelle `UTENTE`
--
ALTER TABLE `UTENTE`
  ADD PRIMARY KEY (`username`,`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `BONUS`
--
ALTER TABLE `BONUS`
  MODIFY `codiceBonus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT per la tabella `COMPOSIZIONE`
--
ALTER TABLE `COMPOSIZIONE`
  MODIFY `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT per la tabella `INGREDIENTE`
--
ALTER TABLE `INGREDIENTE`
  MODIFY `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

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
  ADD CONSTRAINT `COMPOSIZIONE_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `INGREDIENTE` (`id_ingrediente`);

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
  ADD CONSTRAINT `POSSESSO_BONUS_ibfk_1` FOREIGN KEY (`username`,`email`) REFERENCES `UTENTE` (`username`, `email`),
  ADD CONSTRAINT `POSSESSO_BONUS_ibfk_2` FOREIGN KEY (`codiceBonus`) REFERENCES `BONUS` (`codiceBonus`);

--
-- Limiti per la tabella `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_1` FOREIGN KEY (`numero`) REFERENCES `TAVOLO` (`numero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
