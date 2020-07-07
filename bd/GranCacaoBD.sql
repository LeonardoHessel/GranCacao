DROP DATABASE IF EXISTS `grancacao`;
CREATE DATABASE `grancacao` DEFAULT CHARACTER SET utf8mb4 ;
USE `grancacao`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
	`id_user` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(250) NOT NULL UNIQUE,
    `pass` CHAR(64) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `token` CHAR(64),
    `active` BOOL DEFAULT TRUE,
    PRIMARY KEY (`id_user`)
)ENGINE = InnoDB;

INSERT INTO `user` (`email`,`pass`,`name`) VALUES ("leonardo.hessel@hotmail.com","68dd8aea6fbb95d0617a16298d944bffa066d5df3d687797d5077dcc43e6e635","Leonardo Hessel");

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
	`id_client` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(250) NOT NULL UNIQUE,
    `pass` CHAR(64) NOT NULL,
    `name` VARCHAR(45),
    `active` BOOL DEFAULT TRUE,
    PRIMARY KEY (`id_client`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `client_fone`;
CREATE TABLE IF NOT EXISTS `client_fone` (
	`id_fone` INT NOT NULL AUTO_INCREMENT,
    `id_client` INT NOT NULL,
    `description` VARCHAR(100),
    `ddd` CHAR(3),
    `fone` CHAR(64),
    PRIMARY KEY (`id_fone`),
    CONSTRAINT `fk_ClientToFone` FOREIGN KEY (`id_client`) REFERENCES `client`(`id_client`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `client_address`;
CREATE TABLE IF NOT EXISTS `client_address` (
	`id_address` INT NOT NULL AUTO_INCREMENT,
    `id_client` INT NOT NULL,
    `description` VARCHAR(100),
    `cep` CHAR(8),
    `logradouro` VARCHAR(100),
    `complemento` VARCHAR(50),
    `bairro` VARCHAR(100),
    `localidade` VARCHAR(50),
    `uf` CHAR(2),
    PRIMARY KEY (`id_address`),
    CONSTRAINT `fk_ClientToAddress` FOREIGN KEY (`id_client`) REFERENCES `client`(`id_client`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `client_device`;
CREATE TABLE IF NOT EXISTS `client_device` (
	`id_client` INT NOT NULL,
    `token` CHAR(64) NOT NULL,
    `expiration` DATETIME NOT NULL,
    PRIMARY KEY (`id_client`,`token`),
    CONSTRAINT `fk_ClientToDevice` FOREIGN KEY (`id_client`) REFERENCES `client`(`id_client`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_group`;
CREATE TABLE IF NOT EXISTS `product_group` (
	`id_group` INT NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(250),
    PRIMARY KEY (`id_group`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
	`id_product` INT NOT NULL AUTO_INCREMENT,
    `name`VARCHAR(250) NOT NULL,
    `value` DECIMAL(5,2) NOT NULL,
    `description` VARCHAR(250),
    `id_group` INT,
    `active` BOOL DEFAULT FALSE,
    PRIMARY KEY (`id_product`),
    CONSTRAINT `fk_GroupToProduct` FOREIGN KEY (`id_group`) REFERENCES `product_group`(`id_group`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
	`id_image` INT NOT NULL AUTO_INCREMENT,
    `id_product` INT NOT NULL,
    `address` VARCHAR(250),
    PRIMARY KEY(`id_image`,`id_product`)
    -- CONSTRAINT `fk_ProductToImage` FOREIGN KEY (`id_product`) REFERENCES `product`(`id_product`)
)ENGINE = InnoDB;

