
CREATE DATABASE IF NOT EXISTS `db_tarjetas_aliados`;
USE `db_tarjetas_aliados`;

CREATE TABLE `fabricante` (
  `id_fabricante` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo_url` VARCHAR(255) NOT NULL,
  
  PRIMARY KEY (`id_fabricante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aliados` (
  `id_aliado` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(15),
  `babull_url` VARCHAR(100),
  `logo_url` VARCHAR(255),
  
  PRIMARY KEY (`id_aliado`),
  UNIQUE KEY `idx_aliado_telefono` (`telefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tarjetas` (
  `id_registro` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tarjeta_tipo` VARCHAR(10) NOT NULL,
  `monto` DECIMAL(10, 2) NOT NULL,
  `codigo` VARCHAR(20) NOT NULL,
  `aliado_id` VARCHAR(10) NOT NULL,
  
  PRIMARY KEY (`id_registro`),
  UNIQUE KEY `idx_codigo_unico` (`codigo`),
  
  CONSTRAINT `fk_tarjeta_aliado`
    FOREIGN KEY (`aliado_id`) 
    REFERENCES `aliados` (`id_aliado`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
