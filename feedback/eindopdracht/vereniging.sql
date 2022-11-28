-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 28 nov 2022 om 13:34
-- Serverversie: 8.0.30
-- PHP-versie: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vereniging`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `email`
--

CREATE TABLE `email` (
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `email`
--

INSERT INTO `email` (`email`, `lidnummer`) VALUES
('bramvander@outlook.com', 1),
('test@test.com', 1),
('culpa@nesciunt.com', 2),
('lorem@ipsum.com', 3),
('dolor@sit.com', 4),
('amet@consectetur.com', 5),
('incidunt@placeat.com', 6),
('officia@aperiam.com', 7),
('eum@nemo.com', 8),
('asperiores@distinctio.com', 9),
('suscipit@repellendus.com', 10),
('arem@quae.com', 11),
('ration@sapiente.com', 12);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leden`
--

CREATE TABLE `leden` (
  `lidnummer` int UNSIGNED NOT NULL,
  `voornaam` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `achternaam` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `postcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `huisnummer` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leden`
--

INSERT INTO `leden` (`lidnummer`, `voornaam`, `achternaam`, `postcode`, `huisnummer`) VALUES
(1, 'Bram', 'Vander', '5616CE', '1'),
(2, 'Culpa', 'Nesciunt', '1234AB', '2'),
(3, 'Lorem', 'Ipsum', '5678CD', '3'),
(4, 'Dolor', 'Sit', '9012EF', '4'),
(5, 'Amet', 'Consectetur', '3456GH', '5'),
(6, 'Incidunt', 'Placeat', '7890IJ', '6'),
(7, 'Officia', 'Aperiam', '1234KL', '7'),
(8, 'Eum', 'Nemo', '5678MN', '8'),
(9, 'Asperiores', 'Distinctio', '9012OP', '9'),
(10, 'Suscipit', 'Repellendus', '3456QR', '10'),
(11, 'Arem', 'Quae', '7890ST', '11'),
(12, 'Ration', 'Sapiente', '1234UV', '12'),
(42, 'aaaa', 'aaaa', '1111AA', '0011'),
(43, 'Brock', 'Steen', '1111AA', '1'),
(44, 'Misty', 'Water', '1111AA', '2'),
(45, 'Surge', 'Electrisch', '1111AA', '3'),
(46, 'Link', 'Heroe', '1111AA', '90'),
(47, 'Zelda', 'Prinses', '1111AA', '91'),
(48, 'teamlid', 'pokemon', '1111AA', '1234'),
(50, 'zelda', 'delete', '1111AA', '1'),
(51, 'zeldaaa', 'deleteeee', '1111AA', '1111'),
(52, 'edit', 'tide', '1111AA', '2b'),
(53, 'Ganondorf', 'Evil', '1111AA', '2121');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `postcode`
--

CREATE TABLE `postcode` (
  `postcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adres` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `woonplaats` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `postcode`
--

INSERT INTO `postcode` (`postcode`, `adres`, `woonplaats`) VALUES
('1111AA', 'teststraat 00', 'Timboekto'),
('1234AB', 'Papierstraat 2', 'Lorem'),
('1234KL', 'Quo Architecto 7', 'Laundantium'),
('1234UV', 'Debitis 12', 'Delectus'),
('3456GH', 'Ipsum 5', 'Animi'),
('3456QR', 'Nisi 10', 'Iure'),
('5616CE', 'Clovislaan 1', 'Eindhoven'),
('5678CD', 'Magnam 3', 'Aliquam'),
('5678MN', 'Labore 8', 'Voluptatem'),
('7890IJ', 'Labore 6', 'Culpa'),
('7890ST', 'Provident 11', 'Placeat'),
('9012EF', 'Corrupti 4', 'Veniam'),
('9012OP', 'Dicta 9', 'Tenetur');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teamlid`
--

CREATE TABLE `teamlid` (
  `tl_id` int NOT NULL,
  `teamnaam` char(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `teamlid`
--

INSERT INTO `teamlid` (`tl_id`, `teamnaam`, `lidnummer`) VALUES
(3, 'Pokemon', 1),
(4, 'Pokemon', 43),
(5, 'Pokemon', 44),
(6, 'Pokemon', 45),
(7, 'Zelda', 46),
(9, 'LoremIpsum', 3),
(10, 'LoremIpsum', 4),
(11, 'LoremIpsum', 5),
(12, 'LoremIpsum', 6),
(17, 'Zelda', 47),
(18, 'Zelda', 53);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `teamnaam` char(255) COLLATE utf8mb4_general_ci NOT NULL,
  `omschrijving` char(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`teamnaam`, `omschrijving`) VALUES
('LoremIpsum', 'fillers'),
('Pokemon', 'vrienden van Ashe'),
('Zelda', 'Main characters');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `telefoon`
--

CREATE TABLE `telefoon` (
  `telefoonnummer` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `telefoon`
--

INSERT INTO `telefoon` (`telefoonnummer`, `lidnummer`) VALUES
('0615909094', 1),
('0649090951', 1),
('0623456789', 2),
('0634567890', 3),
('0645678901', 4),
('0656789012', 5),
('0667890123', 6),
('0678901234', 7),
('0689012345', 8),
('0690123456', 9),
('0601012345', 10),
('0601123456', 11),
('0601234567', 12);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `forename` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`forename`, `surname`, `username`, `password`) VALUES
('Henk', 'de Ridder', 'LOIDocent', '$2y$10$YfaIWEslaxofo.ab/yyeMuJAGvjMxbMPS9IWYxGf9kISAtwgM7EGG');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`email`),
  ADD KEY `email_ibfk_1` (`lidnummer`);

--
-- Indexen voor tabel `leden`
--
ALTER TABLE `leden`
  ADD PRIMARY KEY (`lidnummer`),
  ADD KEY `leden_ibfk_1` (`postcode`);

--
-- Indexen voor tabel `postcode`
--
ALTER TABLE `postcode`
  ADD PRIMARY KEY (`postcode`);

--
-- Indexen voor tabel `teamlid`
--
ALTER TABLE `teamlid`
  ADD PRIMARY KEY (`tl_id`),
  ADD KEY `teamlid_ibfk_1` (`teamnaam`),
  ADD KEY `teamlid_ibfk_2` (`lidnummer`);

--
-- Indexen voor tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`teamnaam`);

--
-- Indexen voor tabel `telefoon`
--
ALTER TABLE `telefoon`
  ADD PRIMARY KEY (`telefoonnummer`),
  ADD KEY `telefoon_ibfk_1` (`lidnummer`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `leden`
--
ALTER TABLE `leden`
  MODIFY `lidnummer` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT voor een tabel `teamlid`
--
ALTER TABLE `teamlid`
  MODIFY `tl_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`lidnummer`) REFERENCES `leden` (`lidnummer`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `leden`
--
ALTER TABLE `leden`
  ADD CONSTRAINT `leden_ibfk_1` FOREIGN KEY (`postcode`) REFERENCES `postcode` (`postcode`);

--
-- Beperkingen voor tabel `telefoon`
--
ALTER TABLE `telefoon`
  ADD CONSTRAINT `telefoon_ibfk_1` FOREIGN KEY (`lidnummer`) REFERENCES `leden` (`lidnummer`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
