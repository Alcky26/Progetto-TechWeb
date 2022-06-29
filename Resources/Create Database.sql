-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Feb 01, 2022 alle 16:32
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
-- Dump dei dati per la tabella `ACQUISTO`
--

INSERT INTO `ACQUISTO` (`quantita`, `nome`, `dataOra`, `email`) VALUES
(2, '4 Formaggi', '2021-12-22 11:31:52', 'mvignaga@unipd.it'),
(1, 'Calzone 2', '2022-01-23 16:58:32', 'mvignaga@unipd.it'),
(2, 'Margherita', '2022-06-12 19:02:11', 'user@user.com'),
(2, 'Coca Cola 0.5l', '2022-06-12 19:02:11', 'user@user.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `BEVANDA`
--

CREATE TABLE `BEVANDA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `gradiAlcolici` float NOT NULL,
  `disponibile` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `BEVANDA`
--

INSERT INTO `BEVANDA` (`nome`, `categoria`, `gradiAlcolici`, `disponibile`) VALUES
('Acqua frizzante 0.5l', 'bevande analcoliche', 0, 1),
('Acqua frizzante 1l', 'bevande analcoliche', 0, 1),
('Acqua naturale 0.5l', 'bevande analcoliche', 0, 1),
('Acqua naturale 1l', 'bevande analcoliche', 0, 1),
('Coca Cola 0.5l', 'bevande analcoliche', 0, 1),
('Fanta 0.5l', 'bevande analcoliche', 0, 1),
('Glossner Gold', 'birre', 5, 1),
('La Chouffe', 'birre', 8, 1),
('Namur Blache', 'birre', 4.5, 1),
('Pilsner Urquell', 'birre', 4.4, 1),
('Tennents Super', 'birre', 9, 1),
('The al limone', 'bevande analcoliche', 0, 1),
('The alla pesca', 'bevande analcoliche', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `BONUS`
--

CREATE TABLE `BONUS` (
  `codiceBonus` int(11) NOT NULL,
  `dataScadenza` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valore` int(4) NOT NULL,
  `dataRiscatto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(319) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `BONUS`
--

INSERT INTO `BONUS` (`codiceBonus`, `dataScadenza`, `valore`, `dataRiscatto`, `email`) VALUES
(1, '2021-10-13 18:36:37', 4, '2021-10-5 12:21:31', 'mvignaga@unipd.it'),
(2, '2021-04-05 10:45:11', 4, '2021-04-04 12:21:31', 'gorlandi@unipd.it'),
(3, '2021-10-17 05:56:00', 3, '2021-10-15 12:21:31', 'gorlandi@unipd.it'),
(4, '2021-12-07 23:59:54', 5, '2021-11-25 12:21:31', 'zzhenwei@unipd.it'),
(5, '2021-12-18 19:26:17', 9, '2021-12-16 12:21:31', 'mmasetto@unipd.it'),
(6, '2021-05-31 22:32:17', 10, '2021-05-12 12:21:31', 'mvignaga@unipd.it'),
(7, '2021-06-18 08:01:52', 5, '2021-05-31 12:21:31', 'mmasetto@unipd.it'),
(8, '2022-01-20 12:23:22', 10, '2021-12-16 12:21:31', 'gorlandi@unipd.it'),
(9, '2021-10-19 05:34:33', 4, '2021-10-02 12:21:31', 'mmasetto@unipd.it'),
(10, '2021-04-02 06:00:47', 5, '2021-03-28 12:21:31', 'mvignaga@unipd.it'),
(11, '2022-02-18 17:38:53', 10, '2021-12-30 12:21:31', 'zzhenwei@unipd.it'),
(12, '2021-10-24 04:34:39', 10, '2021-10-01 12:21:31', 'zzhenwei@unipd.it'),
(13, '2021-08-07 14:03:34', 8, '2021-07-07 12:21:31', 'mvignaga@unipd.it'),
(14, '2021-12-16 14:11:36', 10, '2021-12-16 12:21:31', 'mmasetto@unipd.it'),
(15, '2021-05-23 06:25:41', 10, '2021-05-16 12:21:31', 'mmasetto@unipd.it'),
(16, '2022-10-23 06:25:41', 15, NULL, 'user@user.com'),
(17, '2022-12-12 15:06:30', 5, NULL, 'user@user.com'),
(18, '2022-10-23 06:25:41', 25, NULL, 'admin@admin.com');

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
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `disponibile` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `DOLCE`
--

INSERT INTO `DOLCE` (`nome`, `disponibile`) VALUES
('Panna cotta ai frutti di bosco', 1),
('Panna cotta al caramello', 1),
('Panna cotta al cioccolato', 1),
('Propfiterole', 1),
('Sorbetto al limone', 1),
('Sorbetto alla liquirizia', 1),
('Tiramisù', 1),
('Torta della nonna', 1);

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
('Glossner Gold', 3.5, 'La Neumark Glossnerbrau, la storia di uno dei più antichi Braufamilien. Da semplici inizi come Kommunbrauer è nato un birrificio altamente tecnico e versatile. La gold ha un sapore rinfrescante e sapido con una piacevole amarezza.'),
('La Chouffe', 3.5, 'Schiuma cremosa e molto abbondante a proteggere una birra elegante, dal color ambrato carico ed impenetrabile. Emergono piacevoli note floreali e di lievito fragrante, seguite dai classici sentori belgi di spezie, agrumi e coriandolo. Il gusto ed il corpo sono forti ma piacevoli e mantengono il giusto equilibrio.'),
('Margherita', 4.5, NULL),
('Marinara', 3.5, NULL),
('Mediterranea', 7, NULL),
('Namur Blache', 3.5, 'Al primo assaggio la Blanche de Namur si presenta poco corposa e dagli odori freschi ma delicati. La rifermentazione in bottiglia le dona sentori speziati che rimangono dolci e ben bilanciati ai sapori amarognoli di agrumi.'),
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
('Tennents Super', 3.5, 'Una delle strong lager più forti del Regno Unito. Decisa e ad alto grado di piacere, ben equilibrata nelle sue componenti, è una birra pensata per un momento serale. Ha bisogno di calore e di colore, di spazi dove il tempo non ha fretta, ha bisogno di tranquillità.'),
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
  `allergene` tinyint(1) NOT NULL DEFAULT 0,
  `disponibile` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `INGREDIENTE`
--

INSERT INTO `INGREDIENTE` (`id_ingrediente`, `nome`, `allergene`, `disponibile`) VALUES
(1, 'pomodoro', 0, 1),
(2, 'mozzarella', 7, 1),
(3, 'acciughe', 4, 1),
(4, 'aglio', 0, 1),
(5, 'asiago', 7, 1),
(6, 'basilico', 0, 1),
(7, 'bresaola', 0, 1),
(8, 'capperi', 0, 1),
(9, 'carciofi', 0, 1),
(10, 'cipolla', 0, 1),
(11, 'emmenthal', 7, 1),
(12, 'frutti di mare', 13, 1),
(13, 'funghi', 0, 1),
(14, 'gamberetti', 2, 1),
(15, 'gorgonzola', 7, 1),
(16, 'grana', 7, 1),
(17, 'melanzane grigliate', 0, 1),
(18, 'mozzarella di bufala', 7, 1),
(19, 'olive', 0, 1),
(20, 'origano', 0, 1),
(21, 'pancetta', 0, 1),
(22, 'patatine fritte', 0, 1),
(23, 'peperoni grigliati', 0, 1),
(24, 'philadelpia', 7, 1),
(25, 'polpa di granchio', 2, 1),
(26, 'pomodorini', 0, 1),
(27, 'porchetta', 0, 1),
(28, 'prosciutto cotto', 0, 1),
(29, 'prosciutto crudo', 0, 1),
(30, 'radicchio', 0, 1),
(31, 'ricotta', 7, 1),
(32, 'rucola', 0, 1),
(33, 'salamino piccante', 0, 1),
(34, 'salmone affumicato', 4, 1),
(35, 'salsiccia', 0, 1),
(37, 'scamorza', 7, 1),
(38, 'speck', 0, 1),
(39, 'spinaci', 0, 1),
(40, 'stracchino', 7, 1),
(41, 'taleggio', 7, 1),
(42, 'tonno', 4, 1),
(43, 'uova', 3, 1),
(44, 'wurstel', 0, 1),
(45, 'zucchine grigliate', 0, 1),
(190, 'sbrise', 0, 0);

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
('2021-12-22 11:31:52', 'mvignaga@unipd.it'),
('2022-01-23 16:58:32', 'mvignaga@unipd.it'),
('2022-06-12 19:02:11', 'user@user.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `PIZZA`
--

CREATE TABLE `PIZZA` (
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `disponibile` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `PIZZA`
--

INSERT INTO `PIZZA` (`nome`, `categoria`, `disponibile`) VALUES
('4 formaggi', 'classiche', 1),
('4 stagioni', 'classiche', 1),
('Alla greppia', 'bianche', 1),
('Altopiano', 'bianche', 1),
('Calzone', 'calzoni', 1),
('Calzone 2', 'calzoni', 1),
('Calzone vegetariano', 'calzoni', 1),
('Capricciosa', 'classiche', 1),
('Carbonara', 'classiche', 1),
('Carmine', 'speciali', 1),
('Diavola', 'classiche', 1),
('Estate', 'bianche', 1),
('Frutti di mare', 'speciali', 1),
('Margherita', 'classiche', 1),
('Marinara', 'classiche', 1),
('Mediterranea', 'speciali', 1),
('Parigina', 'classiche', 1),
('Parmigiana', 'classiche', 1),
('Patatosa', 'classiche', 1),
('Pizza dolce', 'bianche', 1),
('Polpa di granchio', 'speciali', 1),
('Prosciutto e funghi', 'classiche', 1),
('Regina', 'speciali', 1),
('Ritrovo', 'speciali', 1),
('Romana', 'classiche', 1),
('Salmone', 'speciali', 1),
('Saporita', 'speciali', 1),
('Stromboli', 'bianche', 1),
('Svizzera', 'bianche', 1),
('Tedesca', 'classiche', 1),
('Texana', 'speciali', 1),
('Tirolese', 'speciali', 1),
('Tonno e cipolla', 'classiche', 1),
('Vegetariana', 'classiche', 1),
('Vesuviana', 'speciali', 1),
('Viennese', 'classiche', 1);

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
(10, '2021-12-16 11:27:02', 12, 'mmasetto@unipd.it'),
(1, '2022-01-23 19:30:00', 1, 'zzhenwei@unipd.it'),
(1, '2022-01-23 20:00:00', 1, 'zzhenwei@unipd.it'),
(2, '2022-01-24 19:45:00', 1, 'zzhenwei@unipd.it'),
(1, '2022-01-24 20:15:00', 1, 'zzhenwei@unipd.it');

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
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `birthdayModified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `UTENTE`
--

INSERT INTO `UTENTE` (`email`, `username`, `birthday`, `password`, `isAdmin`, `birthdayModified`) VALUES
('gorlandi@unipd.it', 'gorlandi', '0000-00-00 00:00:00', 'Password1', 0, 0),
('mmasetto@unipd.it', 'mmasetto', '0000-00-00 00:00:00', 'Password2', 0, 0),
('mvignaga@unipd.it', 'mvignaga', '0000-00-00 00:00:00', 'Password3', 0, 0),
('test@gmail.com', 'testuser', '0000-00-00 00:00:00', 'Password4', 1, 0),
('zzhenwei@unipd.it', 'zzhenwei', '0000-00-00 00:00:00', 'Password5', 0, 0),
('admin@admin.com', 'admin', '0000-00-00 00:00:00', 'admin', 1, 0),
('user@user.com', 'user', '0000-00-00 00:00:00', 'user', 0, 0);

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
  ADD PRIMARY KEY (`codiceBonus`),
  ADD KEY `email` (`email`);

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
-- Indici per le tabelle `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD PRIMARY KEY (`dataOra`,`numero`),
  ADD KEY `numero` (`numero`),
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
  ADD PRIMARY KEY (`email`),
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
  MODIFY `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

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
-- Limiti per la tabella `BONUS`
--
ALTER TABLE `BONUS`
  ADD CONSTRAINT `BONUS_ibfk_1` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `ORDINAZIONE_ibfk_1` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `PIZZA`
--
ALTER TABLE `PIZZA`
  ADD CONSTRAINT `PIZZA_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `ELEMENTO_LISTINO` (`nome`);

--
-- Limiti per la tabella `PRENOTAZIONE`
--
ALTER TABLE `PRENOTAZIONE`
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_1` FOREIGN KEY (`numero`) REFERENCES `TAVOLO` (`numero`),
  ADD CONSTRAINT `PRENOTAZIONE_ibfk_2` FOREIGN KEY (`email`) REFERENCES `UTENTE` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
