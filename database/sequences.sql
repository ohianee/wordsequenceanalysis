-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2024 a las 11:20:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sequences`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anolis_carolinensis`
--

CREATE TABLE `anolis_carolinensis` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `anolis_carolinensis`
--

INSERT INTO `anolis_carolinensis` (`id`, `nombre`) VALUES
(1, 'Anolis_carolinensis.AnoCar2.0v2.dna.nonchromosomal.fa.gz'),
(2, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.1.fa.gz'),
(3, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.2.fa.gz'),
(4, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.3.fa.gz'),
(5, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.4.fa.gz'),
(6, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.5.fa.gz'),
(7, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.6.fa.gz'),
(8, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.a.fa.gz'),
(9, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.b.fa.gz'),
(10, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.c.fa.gz'),
(11, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.d.fa.gz'),
(12, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.f.fa.gz'),
(13, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.g.fa.gz'),
(14, 'Anolis_carolinensis.AnoCar2.0v2.dna.primary_assembly.h.fa.gz'),
(15, 'Anolis_carolinensis.AnoCar2.0v2.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anopheles_gambiae`
--

CREATE TABLE `anopheles_gambiae` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `anopheles_gambiae`
--

INSERT INTO `anopheles_gambiae` (`id`, `nombre`) VALUES
(1, 'Anopheles_gambiae.AgamP4.dna.alt.fa.gz'),
(2, 'Anopheles_gambiae.AgamP4.dna.chromosome.2L.fa.gz'),
(3, 'Anopheles_gambiae.AgamP4.dna.chromosome.2R.fa.gz'),
(4, 'Anopheles_gambiae.AgamP4.dna.chromosome.3L.fa.gz'),
(5, 'Anopheles_gambiae.AgamP4.dna.chromosome.3R.fa.gz'),
(6, 'Anopheles_gambiae.AgamP4.dna.chromosome.Mt.fa.gz'),
(7, 'Anopheles_gambiae.AgamP4.dna.chromosome.X.fa.gz'),
(8, 'Anopheles_gambiae.AgamP4.dna.nonchromosomal.fa.gz'),
(9, 'Anopheles_gambiae.AgamP4.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apis_mellifera`
--

CREATE TABLE `apis_mellifera` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `apis_mellifera`
--

INSERT INTO `apis_mellifera` (`id`, `nombre`) VALUES
(1, 'Apis_mellifera.Amel_HAv3.1.dna.nonchromosomal.fa.gz'),
(2, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009931.2.fa.gz'),
(3, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009932.2.fa.gz'),
(4, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009933.2.fa.gz'),
(5, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009934.2.fa.gz'),
(6, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009935.2.fa.gz'),
(7, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009936.2.fa.gz'),
(8, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009937.2.fa.gz'),
(9, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009938.2.fa.gz'),
(10, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009939.2.fa.gz'),
(11, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009940.2.fa.gz'),
(12, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009941.2.fa.gz'),
(13, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009942.2.fa.gz'),
(14, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009943.2.fa.gz'),
(15, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009944.2.fa.gz'),
(16, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009945.2.fa.gz'),
(17, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009946.2.fa.gz'),
(18, 'Apis_mellifera.Amel_HAv3.1.dna.primary_assembly.CM009947.2.fa.gz'),
(19, 'Apis_mellifera.Amel_HAv3.1.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arabidopsis_thaliana`
--

CREATE TABLE `arabidopsis_thaliana` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `arabidopsis_thaliana`
--

INSERT INTO `arabidopsis_thaliana` (`id`, `nombre`) VALUES
(1, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.1.fa.gz'),
(2, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.2.fa.gz'),
(3, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.3.fa.gz'),
(4, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.4.fa.gz'),
(5, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.5.fa.gz'),
(6, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.Mt.fa.gz'),
(7, 'Arabidopsis_thaliana.TAIR10.dna.chromosome.Pt.fa.gz'),
(8, 'Arabidopsis_thaliana.TAIR10.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caenorhabditis_elegans`
--

CREATE TABLE `caenorhabditis_elegans` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `caenorhabditis_elegans`
--

INSERT INTO `caenorhabditis_elegans` (`id`, `nombre`) VALUES
(1, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.I.fa.gz'),
(2, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.II.fa.gz'),
(3, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.III.fa.gz'),
(4, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.IV.fa.gz'),
(5, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.MtDNA.fa.gz'),
(6, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.V.fa.gz'),
(7, 'Caenorhabditis_elegans.WBcel235.dna.chromosome.X.fa.gz'),
(8, 'Caenorhabditis_elegans.WBcel235.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caulobacter_vibrioides_cb15_gca_000006905`
--

CREATE TABLE `caulobacter_vibrioides_cb15_gca_000006905` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `caulobacter_vibrioides_cb15_gca_000006905`
--

INSERT INTO `caulobacter_vibrioides_cb15_gca_000006905` (`id`, `nombre`) VALUES
(1, 'Caulobacter_vibrioides_cb15_gca_000006905.ASM690v1.dna.chromosome.Chromosome.fa.gz'),
(2, 'Caulobacter_vibrioides_cb15_gca_000006905.ASM690v1.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `danio_rerio`
--

CREATE TABLE `danio_rerio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `danio_rerio`
--

INSERT INTO `danio_rerio` (`id`, `nombre`) VALUES
(1, 'Danio_rerio.GRCz11.dna.alt.fa.gz'),
(2, 'Danio_rerio.GRCz11.dna.chromosome.1.fa.gz'),
(3, 'Danio_rerio.GRCz11.dna.chromosome.2.fa.gz'),
(4, 'Danio_rerio.GRCz11.dna.chromosome.3.fa.gz'),
(5, 'Danio_rerio.GRCz11.dna.chromosome.4.fa.gz'),
(6, 'Danio_rerio.GRCz11.dna.chromosome.5.fa.gz'),
(7, 'Danio_rerio.GRCz11.dna.chromosome.6.fa.gz'),
(8, 'Danio_rerio.GRCz11.dna.chromosome.7.fa.gz'),
(9, 'Danio_rerio.GRCz11.dna.chromosome.8.fa.gz'),
(10, 'Danio_rerio.GRCz11.dna.chromosome.9.fa.gz'),
(11, 'Danio_rerio.GRCz11.dna.chromosome.10.fa.gz'),
(12, 'Danio_rerio.GRCz11.dna.chromosome.11.fa.gz'),
(13, 'Danio_rerio.GRCz11.dna.chromosome.12.fa.gz'),
(14, 'Danio_rerio.GRCz11.dna.chromosome.13.fa.gz'),
(15, 'Danio_rerio.GRCz11.dna.chromosome.14.fa.gz'),
(16, 'Danio_rerio.GRCz11.dna.chromosome.15.fa.gz'),
(17, 'Danio_rerio.GRCz11.dna.chromosome.16.fa.gz'),
(18, 'Danio_rerio.GRCz11.dna.chromosome.17.fa.gz'),
(19, 'Danio_rerio.GRCz11.dna.chromosome.18.fa.gz'),
(20, 'Danio_rerio.GRCz11.dna.chromosome.19.fa.gz'),
(21, 'Danio_rerio.GRCz11.dna.chromosome.20.fa.gz'),
(22, 'Danio_rerio.GRCz11.dna.chromosome.21.fa.gz'),
(23, 'Danio_rerio.GRCz11.dna.chromosome.22.fa.gz'),
(24, 'Danio_rerio.GRCz11.dna.chromosome.23.fa.gz'),
(25, 'Danio_rerio.GRCz11.dna.chromosome.24.fa.gz'),
(26, 'Danio_rerio.GRCz11.dna.chromosome.25.fa.gz'),
(27, 'Danio_rerio.GRCz11.dna.chromosome.MT.fa.gz'),
(28, 'Danio_rerio.GRCz11.dna.nonchromosomal.fa.gz'),
(29, 'Danio_rerio.GRCz11.dna.primary_assembly.fa.gz'),
(30, 'Danio_rerio.GRCz11.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drosophila_melanogaster`
--

CREATE TABLE `drosophila_melanogaster` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `drosophila_melanogaster`
--

INSERT INTO `drosophila_melanogaster` (`id`, `nombre`) VALUES
(1, 'Drosophila_melanogaster.BDGP6.46.dna.nonchromosomal.fa.gz'),
(2, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.2L.fa.gz'),
(3, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.2R.fa.gz'),
(4, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.3L.fa.gz'),
(5, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.3R.fa.gz'),
(6, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.4.fa.gz'),
(7, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.X.fa.gz'),
(8, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.Y.fa.gz'),
(9, 'Drosophila_melanogaster.BDGP6.46.dna.primary_assembly.mitochondrion_genome.fa.gz'),
(10, 'Drosophila_melanogaster.BDGP6.46.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fundulus_heteroclitus`
--

CREATE TABLE `fundulus_heteroclitus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `fundulus_heteroclitus`
--

INSERT INTO `fundulus_heteroclitus` (`id`, `nombre`) VALUES
(1, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna.nonchromosomal.fa.gz'),
(2, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna.toplevel.fa.gz'),
(3, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna_rm.nonchromosomal.fa.gz'),
(4, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna_rm.toplevel.fa.gz'),
(5, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna_sm.nonchromosomal.fa.gz'),
(6, 'Fundulus_heteroclitus.Fundulus_heteroclitus-3.0.2.dna_sm.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallus_gallus`
--

CREATE TABLE `gallus_gallus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `gallus_gallus`
--

INSERT INTO `gallus_gallus` (`id`, `nombre`) VALUES
(1, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.nonchromosomal.fa.gz'),
(2, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.1.fa.gz'),
(3, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.2.fa.gz'),
(4, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.3.fa.gz'),
(5, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.4.fa.gz'),
(6, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.5.fa.gz'),
(7, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.6.fa.gz'),
(8, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.7.fa.gz'),
(9, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.8.fa.gz'),
(10, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.9.fa.gz'),
(11, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.10.fa.gz'),
(12, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.11.fa.gz'),
(13, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.12.fa.gz'),
(14, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.13.fa.gz'),
(15, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.14.fa.gz'),
(16, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.15.fa.gz'),
(17, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.16.fa.gz'),
(18, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.17.fa.gz'),
(19, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.18.fa.gz'),
(20, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.19.fa.gz'),
(21, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.20.fa.gz'),
(22, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.21.fa.gz'),
(23, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.22.fa.gz'),
(24, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.23.fa.gz'),
(25, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.24.fa.gz'),
(26, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.25.fa.gz'),
(27, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.26.fa.gz'),
(28, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.27.fa.gz'),
(29, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.28.fa.gz'),
(30, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.29.fa.gz'),
(31, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.30.fa.gz'),
(32, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.31.fa.gz'),
(33, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.32.fa.gz'),
(34, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.33.fa.gz'),
(35, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.34.fa.gz'),
(36, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.35.fa.gz'),
(37, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.36.fa.gz'),
(38, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.37.fa.gz'),
(39, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.38.fa.gz'),
(40, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.39.fa.gz'),
(41, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.MT.fa.gz'),
(42, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.W.fa.gz'),
(43, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.primary_assembly.Z.fa.gz'),
(44, 'Gallus_gallus.bGalGal1.mat.broiler.GRCg7b.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `homo_sapiens`
--

CREATE TABLE `homo_sapiens` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `homo_sapiens`
--

INSERT INTO `homo_sapiens` (`id`, `nombre`) VALUES
(1, 'Homo_sapiens.GRCh38.dna.alt.fa.gz'),
(2, 'Homo_sapiens.GRCh38.dna.chromosome.1.fa.gz'),
(3, 'Homo_sapiens.GRCh38.dna.chromosome.2.fa.gz'),
(4, 'Homo_sapiens.GRCh38.dna.chromosome.3.fa.gz'),
(5, 'Homo_sapiens.GRCh38.dna.chromosome.4.fa.gz'),
(6, 'Homo_sapiens.GRCh38.dna.chromosome.5.fa.gz'),
(7, 'Homo_sapiens.GRCh38.dna.chromosome.6.fa.gz'),
(8, 'Homo_sapiens.GRCh38.dna.chromosome.7.fa.gz'),
(9, 'Homo_sapiens.GRCh38.dna.chromosome.8.fa.gz'),
(10, 'Homo_sapiens.GRCh38.dna.chromosome.9.fa.gz'),
(11, 'Homo_sapiens.GRCh38.dna.chromosome.10.fa.gz'),
(12, 'Homo_sapiens.GRCh38.dna.chromosome.11.fa.gz'),
(13, 'Homo_sapiens.GRCh38.dna.chromosome.12.fa.gz'),
(14, 'Homo_sapiens.GRCh38.dna.chromosome.13.fa.gz'),
(15, 'Homo_sapiens.GRCh38.dna.chromosome.14.fa.gz'),
(16, 'Homo_sapiens.GRCh38.dna.chromosome.15.fa.gz'),
(17, 'Homo_sapiens.GRCh38.dna.chromosome.16.fa.gz'),
(18, 'Homo_sapiens.GRCh38.dna.chromosome.17.fa.gz'),
(19, 'Homo_sapiens.GRCh38.dna.chromosome.18.fa.gz'),
(20, 'Homo_sapiens.GRCh38.dna.chromosome.19.fa.gz'),
(21, 'Homo_sapiens.GRCh38.dna.chromosome.20.fa.gz'),
(22, 'Homo_sapiens.GRCh38.dna.chromosome.21.fa.gz'),
(23, 'Homo_sapiens.GRCh38.dna.chromosome.22.fa.gz'),
(24, 'Homo_sapiens.GRCh38.dna.chromosome.MT.fa.gz'),
(25, 'Homo_sapiens.GRCh38.dna.chromosome.X.fa.gz'),
(26, 'Homo_sapiens.GRCh38.dna.chromosome.Y.fa.gz'),
(27, 'Homo_sapiens.GRCh38.dna.nonchromosomal.fa.gz'),
(28, 'Homo_sapiens.GRCh38.dna.primary_assembly.fa.gz'),
(29, 'Homo_sapiens.GRCh38.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hydra_vulgaris_gca022113875v1rs`
--

CREATE TABLE `hydra_vulgaris_gca022113875v1rs` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `hydra_vulgaris_gca022113875v1rs`
--

INSERT INTO `hydra_vulgaris_gca022113875v1rs` (`id`, `nombre`) VALUES
(1, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.nonchromosomal.fa.gz'),
(2, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039212.1.fa.gz'),
(3, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039213.1.fa.gz'),
(4, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039214.1.fa.gz'),
(5, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039215.1.fa.gz'),
(6, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039216.1.fa.gz'),
(7, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039217.1.fa.gz'),
(8, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039218.1.fa.gz'),
(9, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039219.1.fa.gz'),
(10, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039220.1.fa.gz'),
(11, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039221.1.fa.gz'),
(12, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039222.1.fa.gz'),
(13, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039223.1.fa.gz'),
(14, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039224.1.fa.gz'),
(15, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039225.1.fa.gz'),
(16, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.CM039226.1.fa.gz'),
(17, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.NC_011220.1.fa.gz'),
(18, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.primary_assembly.NC_011221.1.fa.gz'),
(19, 'Hydra_vulgaris_gca022113875v1rs.Hydra_105_v3.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mus_musculus`
--

CREATE TABLE `mus_musculus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `mus_musculus`
--

INSERT INTO `mus_musculus` (`id`, `nombre`) VALUES
(1, 'Mus_musculus.GRCm39.dna.chromosome.1.fa.gz'),
(2, 'Mus_musculus.GRCm39.dna.chromosome.2.fa.gz'),
(3, 'Mus_musculus.GRCm39.dna.chromosome.3.fa.gz'),
(4, 'Mus_musculus.GRCm39.dna.chromosome.4.fa.gz'),
(5, 'Mus_musculus.GRCm39.dna.chromosome.5.fa.gz'),
(6, 'Mus_musculus.GRCm39.dna.chromosome.6.fa.gz'),
(7, 'Mus_musculus.GRCm39.dna.chromosome.7.fa.gz'),
(8, 'Mus_musculus.GRCm39.dna.chromosome.8.fa.gz'),
(9, 'Mus_musculus.GRCm39.dna.chromosome.9.fa.gz'),
(10, 'Mus_musculus.GRCm39.dna.chromosome.10.fa.gz'),
(11, 'Mus_musculus.GRCm39.dna.chromosome.11.fa.gz'),
(12, 'Mus_musculus.GRCm39.dna.chromosome.12.fa.gz'),
(13, 'Mus_musculus.GRCm39.dna.chromosome.13.fa.gz'),
(14, 'Mus_musculus.GRCm39.dna.chromosome.14.fa.gz'),
(15, 'Mus_musculus.GRCm39.dna.chromosome.15.fa.gz'),
(16, 'Mus_musculus.GRCm39.dna.chromosome.16.fa.gz'),
(17, 'Mus_musculus.GRCm39.dna.chromosome.17.fa.gz'),
(18, 'Mus_musculus.GRCm39.dna.chromosome.18.fa.gz'),
(19, 'Mus_musculus.GRCm39.dna.chromosome.19.fa.gz'),
(20, 'Mus_musculus.GRCm39.dna.chromosome.MT.fa.gz'),
(21, 'Mus_musculus.GRCm39.dna.chromosome.X.fa.gz'),
(22, 'Mus_musculus.GRCm39.dna.chromosome.Y.fa.gz'),
(23, 'Mus_musculus.GRCm39.dna.nonchromosomal.fa.gz'),
(24, 'Mus_musculus.GRCm39.dna.primary_assembly.fa.gz'),
(25, 'Mus_musculus.GRCm39.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pan_troglodytes`
--

CREATE TABLE `pan_troglodytes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pan_troglodytes`
--

INSERT INTO `pan_troglodytes` (`id`, `nombre`) VALUES
(1, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.1.fa.gz'),
(2, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.2A.fa.gz'),
(3, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.2B.fa.gz'),
(4, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.3.fa.gz'),
(5, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.4.fa.gz'),
(6, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.5.fa.gz'),
(7, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.6.fa.gz'),
(8, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.7.fa.gz'),
(9, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.8.fa.gz'),
(10, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.9.fa.gz'),
(11, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.10.fa.gz'),
(12, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.11.fa.gz'),
(13, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.12.fa.gz'),
(14, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.13.fa.gz'),
(15, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.14.fa.gz'),
(16, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.15.fa.gz'),
(17, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.16.fa.gz'),
(18, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.17.fa.gz'),
(19, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.18.fa.gz'),
(20, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.19.fa.gz'),
(21, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.20.fa.gz'),
(22, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.21.fa.gz'),
(23, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.22.fa.gz'),
(24, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.MT.fa.gz'),
(25, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.X.fa.gz'),
(26, 'Pan_troglodytes.Pan_tro_3.0.dna.chromosome.Y.fa.gz'),
(27, 'Pan_troglodytes.Pan_tro_3.0.dna.nonchromosomal.fa.gz'),
(28, 'Pan_troglodytes.Pan_tro_3.0.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rattus_norvegicus`
--

CREATE TABLE `rattus_norvegicus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rattus_norvegicus`
--

INSERT INTO `rattus_norvegicus` (`id`, `nombre`) VALUES
(1, 'Rattus_norvegicus.mRatBN7.2.dna.nonchromosomal.fa.gz'),
(2, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.1.fa.gz'),
(3, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.2.fa.gz'),
(4, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.3.fa.gz'),
(5, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.4.fa.gz'),
(6, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.5.fa.gz'),
(7, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.6.fa.gz'),
(8, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.7.fa.gz'),
(9, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.8.fa.gz'),
(10, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.9.fa.gz'),
(11, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.10.fa.gz'),
(12, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.11.fa.gz'),
(13, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.12.fa.gz'),
(14, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.13.fa.gz'),
(15, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.14.fa.gz'),
(16, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.15.fa.gz'),
(17, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.16.fa.gz'),
(18, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.17.fa.gz'),
(19, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.18.fa.gz'),
(20, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.19.fa.gz'),
(21, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.20.fa.gz'),
(22, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.MT.fa.gz'),
(23, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.X.fa.gz'),
(24, 'Rattus_norvegicus.mRatBN7.2.dna.primary_assembly.Y.fa.gz'),
(25, 'Rattus_norvegicus.mRatBN7.2.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saccharomyces_cerevisiae`
--

CREATE TABLE `saccharomyces_cerevisiae` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `saccharomyces_cerevisiae`
--

INSERT INTO `saccharomyces_cerevisiae` (`id`, `nombre`) VALUES
(1, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.I.fa.gz'),
(2, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.II.fa.gz'),
(3, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.III.fa.gz'),
(4, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.IV.fa.gz'),
(5, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.IX.fa.gz'),
(6, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.Mito.fa.gz'),
(7, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.V.fa.gz'),
(8, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.VI.fa.gz'),
(9, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.VII.fa.gz'),
(10, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.VIII.fa.gz'),
(11, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.X.fa.gz'),
(12, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XI.fa.gz'),
(13, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XII.fa.gz'),
(14, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XIII.fa.gz'),
(15, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XIV.fa.gz'),
(16, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XV.fa.gz'),
(17, 'Saccharomyces_cerevisiae.R64-1-1.dna.chromosome.XVI.fa.gz'),
(18, 'Saccharomyces_cerevisiae.R64-1-1.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schizosaccharomyces_pombe`
--

CREATE TABLE `schizosaccharomyces_pombe` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `schizosaccharomyces_pombe`
--

INSERT INTO `schizosaccharomyces_pombe` (`id`, `nombre`) VALUES
(1, 'Schizosaccharomyces_pombe.ASM294v2.dna.chromosome.I.fa.gz'),
(2, 'Schizosaccharomyces_pombe.ASM294v2.dna.chromosome.II.fa.gz'),
(3, 'Schizosaccharomyces_pombe.ASM294v2.dna.chromosome.III.fa.gz'),
(4, 'Schizosaccharomyces_pombe.ASM294v2.dna.chromosome.MT.fa.gz'),
(5, 'Schizosaccharomyces_pombe.ASM294v2.dna.nonchromosomal.fa.gz'),
(6, 'Schizosaccharomyces_pombe.ASM294v2.dna.toplevel.fa.gz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_url`
--

CREATE TABLE `tabla_url` (
  `id` int(11) NOT NULL,
  `tabla` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tabla_url`
--

INSERT INTO `tabla_url` (`id`, `tabla`, `url`) VALUES
(1, 'anolis_carolinensis', 'https://ftp.ensembl.org/pub/current_fasta/'),
(2, 'anopheles_gambiae', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/metazoa/fasta/'),
(3, 'apis_mellifera', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/metazoa/fasta/'),
(4, 'arabidopsis_thaliana', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/plants/fasta/'),
(5, 'caenorhabditis_elegans', 'https://ftp.ensembl.org/pub/current_fasta/'),
(6, 'caulobacter_vibrioides_cb15_gca_000006905', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/bacteria/fasta/bacteria_0_collection/'),
(7, 'danio_rerio', 'https://ftp.ensembl.org/pub/current_fasta/'),
(8, 'drosophila_melanogaster', 'https://ftp.ensembl.org/pub/current_fasta/'),
(9, 'fundulus_heteroclitus', 'https://ftp.ensembl.org/pub/current_fasta/'),
(10, 'gallus_gallus', 'https://ftp.ensembl.org/pub/current_fasta/'),
(11, 'homo_sapiens', 'https://ftp.ensembl.org/pub/current_fasta/'),
(12, 'hydra_vulgaris_gca022113875v1rs', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/metazoa/fasta/'),
(13, 'mus_musculus', 'https://ftp.ensembl.org/pub/current_fasta/'),
(14, 'pan_troglodytes', 'https://ftp.ensembl.org/pub/current_fasta/'),
(15, 'rattus_norvegicus', 'https://ftp.ensembl.org/pub/current_fasta/'),
(16, 'saccharomyces_cerevisiae', 'https://ftp.ensembl.org/pub/current_fasta/'),
(17, 'schizosaccharomyces_pombe', 'https://ftp.ebi.ac.uk/ensemblgenomes/pub/current/fungi/fasta/');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anolis_carolinensis`
--
ALTER TABLE `anolis_carolinensis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anopheles_gambiae`
--
ALTER TABLE `anopheles_gambiae`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `apis_mellifera`
--
ALTER TABLE `apis_mellifera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `arabidopsis_thaliana`
--
ALTER TABLE `arabidopsis_thaliana`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caenorhabditis_elegans`
--
ALTER TABLE `caenorhabditis_elegans`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caulobacter_vibrioides_cb15_gca_000006905`
--
ALTER TABLE `caulobacter_vibrioides_cb15_gca_000006905`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `danio_rerio`
--
ALTER TABLE `danio_rerio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `drosophila_melanogaster`
--
ALTER TABLE `drosophila_melanogaster`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fundulus_heteroclitus`
--
ALTER TABLE `fundulus_heteroclitus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gallus_gallus`
--
ALTER TABLE `gallus_gallus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `homo_sapiens`
--
ALTER TABLE `homo_sapiens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hydra_vulgaris_gca022113875v1rs`
--
ALTER TABLE `hydra_vulgaris_gca022113875v1rs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mus_musculus`
--
ALTER TABLE `mus_musculus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pan_troglodytes`
--
ALTER TABLE `pan_troglodytes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rattus_norvegicus`
--
ALTER TABLE `rattus_norvegicus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `saccharomyces_cerevisiae`
--
ALTER TABLE `saccharomyces_cerevisiae`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `schizosaccharomyces_pombe`
--
ALTER TABLE `schizosaccharomyces_pombe`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_url`
--
ALTER TABLE `tabla_url`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anolis_carolinensis`
--
ALTER TABLE `anolis_carolinensis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `anopheles_gambiae`
--
ALTER TABLE `anopheles_gambiae`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `apis_mellifera`
--
ALTER TABLE `apis_mellifera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `arabidopsis_thaliana`
--
ALTER TABLE `arabidopsis_thaliana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `caenorhabditis_elegans`
--
ALTER TABLE `caenorhabditis_elegans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `caulobacter_vibrioides_cb15_gca_000006905`
--
ALTER TABLE `caulobacter_vibrioides_cb15_gca_000006905`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `danio_rerio`
--
ALTER TABLE `danio_rerio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `drosophila_melanogaster`
--
ALTER TABLE `drosophila_melanogaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `fundulus_heteroclitus`
--
ALTER TABLE `fundulus_heteroclitus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `gallus_gallus`
--
ALTER TABLE `gallus_gallus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `homo_sapiens`
--
ALTER TABLE `homo_sapiens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `hydra_vulgaris_gca022113875v1rs`
--
ALTER TABLE `hydra_vulgaris_gca022113875v1rs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `mus_musculus`
--
ALTER TABLE `mus_musculus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pan_troglodytes`
--
ALTER TABLE `pan_troglodytes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `rattus_norvegicus`
--
ALTER TABLE `rattus_norvegicus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `saccharomyces_cerevisiae`
--
ALTER TABLE `saccharomyces_cerevisiae`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `schizosaccharomyces_pombe`
--
ALTER TABLE `schizosaccharomyces_pombe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tabla_url`
--
ALTER TABLE `tabla_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
