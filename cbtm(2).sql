-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2019 a las 10:07:58
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cbtm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arret`
--

CREATE TABLE `arret` (
  `nb_train` int(11) NOT NULL,
  `nom_dep` varchar(30) NOT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time NOT NULL,
  `nom_arr` varchar(30) NOT NULL,
  `date_arr` date NOT NULL,
  `heure_arr` time NOT NULL,
  `temps_arret` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `arret`
--
DELIMITER $$
CREATE TRIGGER `arret_imp` BEFORE INSERT ON `arret` FOR EACH ROW IF (NEW.date_dep = NEW.date_arr AND NEW.heure_dep > NEW.heure_arr) OR (NEW.date_dep > NEW.date_arr) THEN
	SIGNAL SQLSTATE '01000'
    	SET MESSAGE_TEXT = 'Sorry cannot insert', MYSQL_ERRNO = 1000;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `billet`
--

CREATE TABLE `billet` (
  `numero` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nb_train` int(11) NOT NULL,
  `nom_arr` varchar(30) NOT NULL,
  `date_arr` date NOT NULL,
  `heure_arr` time NOT NULL,
  `nom_dep` varchar(30) NOT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `email` varchar(50) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`email`, `nom`, `prenom`, `age`) VALUES
('alejandro_perez@yahoo.com', 'Pérez', 'Alejandro', 12),
('b.egidog@gmail.com', 'del Egido', 'Belén', 25),
('c.garciav@hotmail.com', 'García', 'Camilo', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gare`
--

CREATE TABLE `gare` (
  `nom` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gare`
--

INSERT INTO `gare` (`ville`, `nom`) VALUES
('Paris', 'Austerlitz'),
('Avignon', 'Avignon Centre'),
('Bordeaux', 'Bordeaux-St-Jean'),
('Amiens', 'Gare de Amiens'),
('Angoulême', 'Gare de Angoulême'),
('Dijon', 'Gare de Dijon'),
('Le Mans', 'Gare de Le Mans'),
('Nancy', 'Gare de Nancy'),
('Nantes', 'Gare de Nantes'),
('Nice', 'Gare de Nice'),
('Orléans', 'Gare de Orléans'),
('Poitiers', 'Gare de Poitiers'),
('Rennes', 'Gare de Rennes'),
('Saint Pierre des Corps', 'Gare de Saint-Pierre-des-Corps'),
('Strasbourg', 'Gare de Strasbourg'),
('Tours', 'Gare de Tours'),
('Vierzon', 'Gare de Vierzon'),
('Orléans', 'Les Aubrais'),
('Lille', 'Lille Flandres'),
('Lyon', 'Lyon Part-Dieu'),
('Lyon', 'Lyon Perrache'),
('Marseille', 'Marseille Saint-Charles'),
('Montpellier', 'Montpellier Saint-Roch'),
('Paris', 'Paris Bercy'),
('Paris', 'Paris Est'),
('Paris', 'Paris Montparnasse'),
('Paris', 'Paris Nord'),
('Rouen', 'Rouen Rive Droite'),
('Toulouse', 'Toulouse Matabiau');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `place`
--

CREATE TABLE `place` (
  `nb_place` int(11) NOT NULL,
  `nb_voiture` int(11) NOT NULL,
  `situation` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `possede`
--

CREATE TABLE `possede` (
  `email` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reduction`
--

CREATE TABLE `reduction` (
  `type` varchar(15) NOT NULL,
  `pourcentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `train`
--

CREATE TABLE `train` (
  `nb_train` int(11) NOT NULL,
  `max_voitures` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `train`
--

INSERT INTO `train` (`nb_train`, `max_voitures`) VALUES
(63699, 6),
(24675, 4),
(39714, 3),
(38751, 5),
(87158, 3),
(51334, 3),
(88716, 5),
(69511, 3),
(24155, 5),
(70533, 3),
(45734, 4),
(92111, 4),
(37104, 6),
(42048, 5),
(61927, 4),
(41605, 4),
(40187, 4),
(54114, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voiture`
--

CREATE TABLE `voiture` (
  `nb_train` int(11) NOT NULL,
  `nb_voiture` int(11) NOT NULL,
  `quant_places` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into voiture (nb_train, nb_voiture, quant_places) values
(87158, 838682, 50),
(87158, 312946, 50),
(87158, 984043, 50),
(63699, 996895, 50),
(63699, 475723, 50),
(63699, 913801, 50),
(63699, 557064, 50),
(63699, 737148, 50),
(63699, 129045, 50),
(24675, 929888, 50),
(24675, 950081, 50),
(24675, 704698, 50),
(24675, 852617, 50),
(39714, 543055, 50),
(39714, 883749, 50),
(39714, 618251, 50);


--
-- Disparadores `voiture`
--
DELIMITER $$
create trigger limit_train 
before insert on voiture for each row
begin
declare nb_max_voitures INT;
declare current_voitures INT;
select COUNT(*) + 1 into current_voitures FROM voiture AS V WHERE V.nb_train = new.nb_train;
SELECT max_voitures into nb_max_voitures FROM train as T WHERE T.nb_train = new.nb_train;
if current_voitures > nb_max_voitures then
SIGNAL SQLSTATE '45000';
end if;
end; $$
DELIMITER ;

-- --------------------------------------------------------

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arret`
--
ALTER TABLE `arret`
  ADD PRIMARY KEY (`nb_train`,`date_dep`,`heure_dep`);

--
-- Indices de la tabla `billet`
--
ALTER TABLE `billet`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `nom_arr` (`nom_arr`),
  ADD KEY `email` (`email`),
  ADD KEY `nb_train` (`nb_train`),
  ADD KEY `nom_dep` (`nom_dep`),
  ADD KEY `date_arr` (`date_arr`),
  ADD KEY `date_dep` (`date_dep`),
  ADD KEY `heure_arr` (`heure_arr`),
  ADD KEY `heure_dep` (`heure_dep`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `gare`
--
ALTER TABLE `gare`
  ADD PRIMARY KEY (`nom`);

--
-- Indices de la tabla `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`nb_place`,`nb_voiture`),
  ADD KEY `nb_voiture` (`nb_voiture`);

--
-- Indices de la tabla `possede`
--
ALTER TABLE `possede`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `train`
--
ALTER TABLE `train`
  ADD PRIMARY KEY (`nb_train`);

--
-- Indices de la tabla `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`nb_voiture`),
  ADD KEY `nb_train` (`nb_train`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arret`
--
ALTER TABLE `arret`
  ADD CONSTRAINT `arret_ibfk_1` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`);

--
-- Filtros para la tabla `billet`
--
ALTER TABLE `billet`
  ADD CONSTRAINT `billet_ibfk_1` FOREIGN KEY (`nom_arr`) REFERENCES `gare` (`nom`),
  ADD CONSTRAINT `billet_ibfk_2` FOREIGN KEY (`email`) REFERENCES `client` (`email`),
  ADD CONSTRAINT `billet_ibfk_3` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`),
  ADD CONSTRAINT `billet_ibfk_4` FOREIGN KEY (`nom_dep`) REFERENCES `gare` (`nom`);

--
-- Filtros para la tabla `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`nb_voiture`) REFERENCES `voiture` (`nb_voiture`);

--
-- Filtros para la tabla `possede`
--
ALTER TABLE `possede`
  ADD CONSTRAINT `possede_ibfk_1` FOREIGN KEY (`email`) REFERENCES `client` (`email`);

--
-- Filtros para la tabla `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
