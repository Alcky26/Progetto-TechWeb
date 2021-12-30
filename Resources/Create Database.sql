-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Dic 30, 2021 alle 14:10
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
-- RELAZIONI PER TABELLA `ACQUISTO`:
--   `dataOra`
--       `ORDINAZIONE` -> `dataOra`
--   `email`
--       `ORDINAZIONE` -> `email`
--

--
-- Dump dei dati per la tabella `ACQUISTO`
--

INSERT INTO `ACQUISTO` (`quantita`, `nome`, `dataOra`, `email`) VALUES
(2, '4 Formaggi', '2021-12-22 11:31:52', 'mvignaga@unipd.it');

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
-- RELAZIONI PER TABELLA `BEVANDA`:
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Dump dei dati per la tabella `BEVANDA`
--

INSERT INTO `BEVANDA` (`nome`, `categoria`, `gradiAlcolici`) VALUES
('Acqua naturale 0.5l', 'bevande analcoliche', 0),
('Acqua frizzante 0.5l', 'bevande analcoliche', 0),
('Acqua naturale 1l', 'bevande analcoliche', 0),
('Acqua frizzante 1l', 'bevande analcoliche', 0),
('Coca Cola 0.5l', 'bevande analcoliche', 0),
('Fanta 0.5l', 'bevande analcoliche', 0),
('The al limone', 'bevande analcoliche', 0),
('The alla pesca', 'bevande analcoliche', 0),
('Glossner Gold', 'birre', 5),
('La Chouffe', 'birre', 8),
('Namur Blache', 'birre', 4.5),
('Pilsner Urquell', 'birre', 4.4),
('Tennent\'s Super', 'birre', 9);

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
-- Dump dei dati per la tabella `COMPOSIZIONE`
--

INSERT INTO `COMPOSIZIONE` (`nome`, `nome_ingr`) VALUES
('4 formaggi', 'pomodoro'),
('4 formaggi', 'mozzarella'),
('4 formaggi', 'asiago'),
('4 formaggi', 'emmenthal'),
('4 formaggi', 'gorgonzola'),
('4 formaggi', 'grana'),
('4 stagioni', 'pomodoro'),
('4 stagioni', 'mozzarella'),
('4 stagioni', 'prosciutto cotto'),
('4 stagioni', 'funghi'),
('4 stagioni', 'salamino piccante'),
('4 stagioni', 'carciofi'),
('Capricciosa', 'pomodoro'),
('Capricciosa', 'mozzarella'),
('Capricciosa', 'prosciutto cotto'),
('Capricciosa', 'funghi'),
('Capricciosa', 'carciofi'),
('Carbonara', 'pomodoro'),
('Carbonara', 'mozzarella'),
('Carbonara', 'pancetta'),
('Carbonara', 'uova'),
('Carbonara', 'grana'),
('Diavola', 'pomodoro'),
('Diavola', 'mozzarella'),
('Diavola', 'salamino piccante'),
('Margherita', 'pomodoro'),
('Margherita', 'mozzarella'),
('Marinara', 'pomodoro'),
('Marinara', 'aglio'),
('Parigina', 'pomodoro'),
('Parigina', 'mozzarella'),
('Parigina', 'prosciutto crudo'),
('Parmigiana', 'pomodoro'),
('Parmigiana', 'mozzarella'),
('Parmigiana', 'melanzane grigliate'),
('Parmigiana', 'grana'),
('Patatosa', 'pomodoro'),
('Patatosa', 'mozzarella'),
('Patatosa', 'patatine fritte'),
('Prosciutto e funghi', 'pomodoro'),
('Prosciutto e funghi', 'mozzarella'),
('Prosciutto e funghi', 'prosciutto cotto'),
('Prosciutto e funghi', 'funghi'),
('Romana', 'pomodoro'),
('Romana', 'mozzarella'),
('Romana', 'acciughe'),
('Romana', 'capperi'),
('Romana', 'origano'),
('Tedesca', 'pomodoro'),
('Tedesca', 'mozzarella'),
('Tedesca', 'wurstel'),
('Tedesca', 'patatine fritte'),
('Tonno e cipolla', 'pomodoro'),
('Tonno e cipolla', 'mozzarella'),
('Tonno e cipolla', 'tonno'),
('Tonno e cipolla', 'cipolla'),
('Vegetariana', 'pomodoro'),
('Vegetariana', 'mozzarella'),
('Vegetariana', 'melanzane grigliate'),
('Vegetariana', 'peperoni grigliati'),
('Vegetariana', 'zucchine grigliate'),
('Viennese', 'pomodoro'),
('Viennese', 'mozzarella'),
('Viennese', 'wurstel');

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
-- Dump dei dati per la tabella `DOLCE`
--

INSERT INTO `DOLCE` (`nome`) VALUES
('Panna cotta al caramello'),
('Panna cotta al cioccolato'),
('Panna cotta ai frutti di bosco'),
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
  `descrizione` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `ELEMENTO_LISTINO`:
--

--
-- Dump dei dati per la tabella `ELEMENTO_LISTINO`
--
INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`) VALUES
('4 formaggi', 6.5),
('4 stagioni', 7),
('Capricciosa', 7),
('Carbonara', 6),
('Diavola', 5),
('Margherita', 4.5),
('Marinara', 3.5),
('Parigina', 6),
('Parmigiana', 6),
('Patatosa', 5.5),
('Prosciutto e funghi', 6.5),
('Romana', 5.5),
('Tedesca', 6),
('Tonno e cipolla', 6),
('Vegetariana', 7.5),
('Viennese', 5),
('Acqua naturale 0.5l', 1.5),
('Acqua frizzante 0.5l', 1.5),
('Acqua naturale 1l', 2),
('Acqua frizzante 1l', 2),
('Coca Cola 0.5l', 3),
('Fanta 0.5l', 3),
('The al limone', 2.5),
('The alla pesca', 2.5),
('Panna cotta al caramello', 4),
('Panna cotta al cioccolato', 4),
('Panna cotta ai frutti di bosco', 4),
('Propfiterole', 4.5),
('Sorbetto al limone', 3.5),
('Sorbetto alla liquirizia', 3.5),
('Tiramisù', 4.5),
('Torta della nonna', 4);

 INSERT INTO `ELEMENTO_LISTINO` (`nome`, `prezzo`, `descrizione`) VALUES
('Pilsner Urquell', 3.5, 'Pilsner dal colore dorato, ha un bouquet di grano tostato e un bilanciato gusto. Sapore intensamente luppolato con un equilibrio di dolcezza sottile e di amaro vellutato dalla combinazione di sapori di miele, diacetile e note caramellate insieme ad un altro estratto residuo. Chiude con una cremosità pulita, che fa perfetto contraltare al luppolo.'),
('Glossner Gold', 4, 'La Neumark Glossnerbrau, la storia di uno dei più antichi Braufamilien. Da semplici inizi come Kommunbrauer è nato un birrificio altamente tecnico e versatile. La gold ha un sapore rinfrescante e sapido con una piacevole amarezza.'),
('Tennent\'s Super', 4.5, 'Una delle strong lager più forti del Regno Unito. Decisa e ad alto grado di piacere, ben equilibrata nelle sue componenti, è una birra pensata per un momento serale. Ha bisogno di calore e di colore, di spazi dove il tempo non ha fretta, ha bisogno di tranquillità.'),
('Namur Blache', 4, 'Al primo assaggio la Blanche de Namur si presenta poco corposa e dagli odori freschi ma delicati. La rifermentazione in bottiglia le dona sentori speziati che rimangono dolci e ben bilanciati ai sapori amarognoli di agrumi.'),
('La Chouffe', 4.5, 'Schiuma cremosa e molto abbondante a proteggere una birra elegante, dal color ambrato carico ed impenetrabile. Emergono piacevoli note floreali e di lievito fragrante, seguite dai classici sentori belgi di spezie, agrumi e coriandolo. Il gusto ed il corpo sono forti ma piacevoli e mantengono il giusto equilibrio.');

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
-- Dump dei dati per la tabella `INGREDIENTE`
--

INSERT INTO `INGREDIENTE` (`nome`, `allergene`) VALUES
('acciughe', 4),
('aglio', 0),
('asiago', 7),
('capperi', 0),
('carciofi', 0),
('cipolla', 0),
('emmenthal', 7),
('funghi', 0),
('gorgonzola', 7),
('grana', 7),
('melanzane grigliate', 0),
('mozzarella', 7),
('origano', 0),
('pancetta', 0),
('patatine fritte', 0),
('peperoni grigliati', 0),
('philadelpia', 7),
('pomodoro', 0),
('prosciutto cotto', 0),
('prosciutto crudo', 0),
('salamino piccante', 0),
('salsiccia', 0),
('tonno', 4),
('uova', 3),
('wurstel', 0),
('zucchine grigliate', 0);

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
-- RELAZIONI PER TABELLA `PIZZA`:
--   `nome`
--       `ELEMENTO_LISTINO` -> `nome`
--

--
-- Dump dei dati per la tabella `PIZZA`
--

INSERT INTO `PIZZA` (`nome`, `categoria`) VALUES
('4 formaggi', 'classiche'),
('4 stagioni', 'classiche'),
('Capricciosa', 'classiche'),
('Carbonara', 'classiche'),
('Diavola', 'classiche'),
('Margherita', 'classiche'),
('Marinara', 'classiche'),
('Parigina', 'classiche'),
('Parmigiana', 'classiche'),
('Patatosa', 'classiche'),
('Prosciutto e funghi', 'classiche'),
('Romana', 'classiche'),
('Tedesca', 'classiche'),
('Tonno e cipolla', 'classiche'),
('Vegetariana', 'classiche'),
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
-- RELAZIONI PER TABELLA `POSSESSO_BONUS`:
--   `email`
--       `UTENTE` -> `email`
--   `username`
--       `UTENTE` -> `username`
--

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
-- RELAZIONI PER TABELLA `PRENOTAZIONE`:
--   `numero`
--       `TAVOLO` -> `numero`
--

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
-- RELAZIONI PER TABELLA `TAVOLO`:
--

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
  `punti` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `UTENTE`:
--

--
-- Dump dei dati per la tabella `UTENTE`
--

INSERT INTO `UTENTE` (`email`, `username`, `birthday`, `password`, `punti`) VALUES
('gorlandi@unipd.it', 'gorlandi', '0000-00-00 00:00:00', 'password', 10),
('mmasetto@unipd.it', 'mmasetto', '0000-00-00 00:00:00', 'password', 55),
('mvignaga@unipd.it', 'mvignaga', '0000-00-00 00:00:00', 'password', 0),
('zzhenwei@unipd.it', 'zzhenwei', '0000-00-00 00:00:00', 'password', 100);

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
  ADD PRIMARY KEY (`codiceBonus`,`email`,`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `email_2` (`email`,`username`);

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
  ADD CONSTRAINT `POSSESSO_BONUS_ibfk_1` FOREIGN KEY (`email`,`username`) REFERENCES `UTENTE` (`email`, `username`);

--
-- Limiti per la tabella `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_1` FOREIGN KEY (`numero`) REFERENCES `TAVOLO` (`numero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
