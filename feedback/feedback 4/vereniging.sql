-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 25 okt 2022 om 13:06
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
-- Tabelstructuur voor tabel `contactinfo`
--

CREATE TABLE `contactinfo` (
  `lidnummer` int UNSIGNED DEFAULT NULL,
  `email` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefoon` char(25) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contactinfo`
--

INSERT INTO `contactinfo` (`lidnummer`, `email`, `telefoon`) VALUES
(1, 'bram@vander.nl', '0612345678'),
(1, NULL, '0401234567'),
(1, 'vander@bram.net', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `members`
--

CREATE TABLE `members` (
  `lidnummer` int UNSIGNED NOT NULL,
  `lidnaam` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adres` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postcode` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `members`
--

INSERT INTO `members` (`lidnummer`, `lidnaam`, `adres`, `postcode`) VALUES
(1, 'Bram Vander', 'Clovislaan 87', '5616');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `postcode`
--

CREATE TABLE `postcode` (
  `postcode` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stadscode` char(3) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `postcode`
--

INSERT INTO `postcode` (`postcode`, `stadscode`) VALUES
('5616', '040');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `woonplaats`
--

CREATE TABLE `woonplaats` (
  `stadscode` char(3) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `woonplaats` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `woonplaats`
--

INSERT INTO `woonplaats` (`stadscode`, `woonplaats`) VALUES
('040', 'Eindhoven');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `contactinfo`
--
ALTER TABLE `contactinfo`
  ADD KEY `lidnummer` (`lidnummer`);

--
-- Indexen voor tabel `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`lidnummer`),
  ADD KEY `postcode` (`postcode`);

--
-- Indexen voor tabel `postcode`
--
ALTER TABLE `postcode`
  ADD KEY `stadscode` (`stadscode`),
  ADD KEY `postcode` (`postcode`);

--
-- Indexen voor tabel `woonplaats`
--
ALTER TABLE `woonplaats`
  ADD KEY `woonplaats` (`woonplaats`),
  ADD KEY `stadscode` (`stadscode`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `members`
--
ALTER TABLE `members`
  MODIFY `lidnummer` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `contactinfo`
--
ALTER TABLE `contactinfo`
  ADD CONSTRAINT `contactinfo_ibfk_1` FOREIGN KEY (`lidnummer`) REFERENCES `members` (`lidnummer`);

--
-- Beperkingen voor tabel `postcode`
--
ALTER TABLE `postcode`
  ADD CONSTRAINT `postcode_ibfk_1` FOREIGN KEY (`postcode`) REFERENCES `members` (`postcode`);

--
-- Beperkingen voor tabel `woonplaats`
--
ALTER TABLE `woonplaats`
  ADD CONSTRAINT `woonplaats_ibfk_1` FOREIGN KEY (`stadscode`) REFERENCES `postcode` (`stadscode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
