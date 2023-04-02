-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Ápr 02. 21:31
-- Kiszolgáló verziója: 10.4.25-MariaDB
-- PHP verzió: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `2123szft_munkaido`
--
CREATE DATABASE IF NOT EXISTS `2123szft_munkaido` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `2123szft_munkaido`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `position`
--

CREATE TABLE `position` (
  `ID` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `wage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `position`
--

INSERT INTO `position` (`ID`, `name`, `wage`) VALUES
(1, 'Takarító', 990);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `shifts`
--

CREATE TABLE `shifts` (
  `ID` int(11) NOT NULL,
  `workerID` int(11) NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `day` varchar(10) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `shifts`
--

INSERT INTO `shifts` (`ID`, `workerID`, `starttime`, `endtime`, `day`) VALUES
(2, 1, '06:15:00', '15:30:00', '1');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `workers`
--

CREATE TABLE `workers` (
  `ID` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `positionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `workers`
--

INSERT INTO `workers` (`ID`, `name`, `positionID`) VALUES
(1, 'Kovács János', 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`ID`);

--
-- A tábla indexei `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `workerID` (`workerID`);

--
-- A tábla indexei `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `positionID` (`positionID`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `position`
--
ALTER TABLE `position`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `shifts`
--
ALTER TABLE `shifts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `workers`
--
ALTER TABLE `workers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_ibfk_1` FOREIGN KEY (`workerID`) REFERENCES `workers` (`ID`);

--
-- Megkötések a táblához `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_ibfk_1` FOREIGN KEY (`positionID`) REFERENCES `position` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
