CREATE DATABASE IF NOT EXISTS fullstack;
USE `fullstack`;

CREATE TABLE `mahasiswa` (
  `nrp` char(9) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `angkatan` year(4) NOT NULL,
  `foto_extention` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`nrp`)
);

CREATE TABLE `dosen` (
  `npk` char(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `foto_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`npk`)
);

CREATE TABLE `akun` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nrp_mahasiswa` char(9) DEFAULT NULL,
  `npk_dosen` char(6) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`),
  FOREIGN KEY (`nrp_mahasiswa`) REFERENCES `mahasiswa`(`nrp`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`npk_dosen`) REFERENCES `dosen`(`npk`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `grup` (
  `idgrup` int(11) NOT NULL AUTO_INCREMENT,
  `username_pembuat` varchar(20) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `deskripsi` varchar(45) NOT NULL,
  `tanggal_pembentukan` datetime NOT NULL,
  `jenis` enum('Akademik','Minat Bakat','Organisasi') NOT NULL,
  `kode_pendaftaran` varchar(45) NOT NULL,
  PRIMARY KEY (`idgrup`),
  FOREIGN KEY (`username_pembuat`) REFERENCES `akun`(`username`) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE `member_grup` (
  `idgrup` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idgrup`, `username`),
  FOREIGN KEY (`idgrup`) REFERENCES `grup`(`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`username`) REFERENCES `akun`(`username`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `event` (
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `idgrup` int(11) NOT NULL,
  `judul` varchar(45) NOT NULL,
  `judul_slug` varchar(45) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `jenis` enum('Rapat','Tugas','Acara') NOT NULL,
  `poster_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`idevent`),
  FOREIGN KEY (`idgrup`) REFERENCES `grup`(`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Run This Here Or in phpMyAdmin
/* INSERT INTO `akun` (`username`, `password`, `nrp_mahasiswa`, `npk_dosen`, `isadmin`) 
VALUES ('admin', 'YOUR_GENERATED_HASH_HERE', NULL, NULL, 1); */