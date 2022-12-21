CREATE TABLE `leden` (
  `lidnummer` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `voornaam` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `achternaam` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postcode` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `huisnummer` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `email` (
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `postcode` (
  `postcode` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `adres` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `woonplaats` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `telefoon` (
  `telefoonnummer` char(25) COLLATE utf8mb4_general_ci NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `teams` (
  `teamnaam` char(255) NOT NULL,
  `omschrijving` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `teamlid` (
  `tl_id` INT NOT NULL,
  `teamnaam` char(255) NOT NULL,
  `lidnummer` int UNSIGNED NOT NULL
);


INSERT INTO `postcode` (`postcode`, `adres`, `woonplaats`) VALUES
('5616CE', 'Clovislaan 1', 'Eindhoven'),
('1234AB', 'Papierstraat 2', 'Lorem'),
('5678CD', 'Magnam 3', 'Aliquam'),
('9012EF', 'Corrupti 4', 'Veniam'),
('3456GH', 'Ipsum 5', 'Animi'),
('7890IJ', 'Labore 6', 'Culpa'),
('1234KL', 'Quo Architecto 7', 'Laundantium'),
('5678MN', 'Labore 8', 'Voluptatem'),
('9012OP', 'Dicta 9', 'Tenetur'),
('3456QR', 'Nisi 10', 'Iure'),
('7890ST', 'Provident 11', 'Placeat'),
('1234UV', 'Debitis 12', 'Delectus');

INSERT INTO `leden` (`lidnummer`, `voornaam`, `achternaam`, `postcode`, `huisnummer`) VALUES
(1, 'Bram', 'Vander', '5616CE', '1'),
(2, 'Culpa', 'Nesciunt', '1234AB', '2'),
(3, 'Lorem', ' Ipsum', '5678CD', '3'),
(4, 'Dolor', 'Sit', '9012EF', '4'),
(5, 'Amet', 'Consectetur', '3456GH', '5'),
(6, 'Incidunt', 'Placeat', '7890IJ', '6'),
(7, 'Officia', 'Aperiam', '1234KL', '7'),
(8, 'Eum', 'Nemo', '5678MN', '8'),
(9, 'Asperiores', 'Distinctio', '9012OP', '9'),
(10, 'Suscipit', 'Repellendus', '3456QR', '10'),
(11, 'Arem', 'Quae', '7890ST', '11'),
(12, 'Ration', 'Sapiente', '1234UV', '12');

INSERT INTO `email` (`email`, `lidnummer`) VALUES
('bramvander@outlook.com', 1),
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

INSERT INTO `telefoon` (`telefoonnummer`, `lidnummer`) VALUES
('0615909094', 1),
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


ALTER TABLE `email`
  ADD PRIMARY KEY (`email`),
  ADD KEY `email_ibfk_1` (`lidnummer`);

ALTER TABLE `leden`
  ADD PRIMARY KEY (`lidnummer`),
  ADD KEY `leden_ibfk_1` (`postcode`);

ALTER TABLE `postcode`
  ADD PRIMARY KEY (`postcode`);

ALTER TABLE `telefoon`
  ADD PRIMARY KEY (`telefoonnummer`),
  ADD KEY `telefoon_ibfk_1` (`lidnummer`);

ALTER TABLE `teams`
  ADD PRIMARY KEY (`teamnaam`);

ALTER TABLE `teamlid`
  ADD PRIMARY KEY (`tl_id`),
  ADD KEY `teamlid_ibfk_1` (`teamnaam`),
  ADD KEY `teamlid_ibfk_2` (`lidnummer`);


ALTER TABLE `leden`
  ADD CONSTRAINT `leden_ibfk_1` FOREIGN KEY (`postcode`) REFERENCES `postcode` (`postcode`);

ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`lidnummer`) REFERENCES `leden` (`lidnummer`) ON DELETE CASCADE;

ALTER TABLE `telefoon`
  ADD CONSTRAINT `telefoon_ibfk_1` FOREIGN KEY (`lidnummer`) REFERENCES `leden` (`lidnummer`) ON DELETE CASCADE;