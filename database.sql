CREATE DATABASE IF NOT EXISTS `fullstack`;
USE `fullstack`;

--
-- Table structure for table `mahasiswa`
--
CREATE TABLE `mahasiswa` (
  `nrp` char(9) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `angkatan` year(4) NOT NULL,
  `foto_extention` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`nrp`)
);

--
-- Table structure for table `dosen`
--
CREATE TABLE `dosen` (
  `npk` char(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `foto_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`npk`)
);

--
-- Table structure for table `akun`
--
CREATE TABLE `akun` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nrp_mahasiswa` char(9) DEFAULT NULL,
  `npk_dosen` char(6) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`),
  FOREIGN KEY (`nrp_mahasiswa`) REFERENCES `mahasiswa`(`nrp`) 
      ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`npk_dosen`) REFERENCES `dosen`(`npk`) 
      ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `grup`
-- UPDATED: Simplified 'jenis' to only 'Publik' and 'Private'
--
CREATE TABLE `grup` (
  `idgrup` int(11) NOT NULL AUTO_INCREMENT,
  `username_pembuat` varchar(20) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `deskripsi` varchar(45) NOT NULL,
  `tanggal_pembentukan` datetime NOT NULL,
  `jenis` enum('Publik','Private') NOT NULL,
  `kode_pendaftaran` varchar(45) NOT NULL,
  PRIMARY KEY (`idgrup`),
  FOREIGN KEY (`username_pembuat`) REFERENCES `akun`(`username`) 
      ON DELETE RESTRICT ON UPDATE CASCADE
);

--
-- Table structure for table `member_grup`
--
CREATE TABLE `member_grup` (
  `idgrup` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idgrup`, `username`),
  FOREIGN KEY (`idgrup`) REFERENCES `grup`(`idgrup`) 
      ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`username`) REFERENCES `akun`(`username`) 
      ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `event`
--
CREATE TABLE `event` (
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `idgrup` int(11) NOT NULL,
  `judul` varchar(45) NOT NULL,
  `judul_slug` varchar(45) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `jenis` enum('Rapat','Tugas','Acara') NOT NULL,
  `poster_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`idevent`),
  FOREIGN KEY (`idgrup`) REFERENCES `grup`(`idgrup`) 
      ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `thread`
--
CREATE TABLE `thread` (
  `idthread` int(11) NOT NULL AUTO_INCREMENT,
  `username_pembuat` varchar(20) NOT NULL,
  `idgrup` int(11) NOT NULL,
  `tanggal_pembuatan` datetime NOT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  PRIMARY KEY (`idthread`),
  FOREIGN KEY (`username_pembuat`) REFERENCES `akun`(`username`) 
      ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`idgrup`) REFERENCES `grup`(`idgrup`) 
      ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `chat`
--
CREATE TABLE `chat` (
  `idchat` int(11) NOT NULL AUTO_INCREMENT,
  `idthread` int(11) NOT NULL,
  `username_pembuat` varchar(20) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_pembuatan` datetime NOT NULL,
  PRIMARY KEY (`idchat`),
  FOREIGN KEY (`idthread`) REFERENCES `thread`(`idthread`) 
      ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`username_pembuat`) REFERENCES `akun`(`username`) 
      ON DELETE RESTRICT ON UPDATE CASCADE
);

--
-- Seeding the default admin user
--
INSERT INTO `akun` (`username`, `password`, `nrp_mahasiswa`, `npk_dosen`, `isadmin`) 
VALUES ('admin', '$2y$10$YCiqg/RKu.9YzZhZSXINDODjFI.OZQvPM0h3UxG/iLTYlMw0rsgWG', NULL, NULL, 1);