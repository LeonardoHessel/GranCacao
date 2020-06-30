DROP DATABASE IF EXISTS `grancacao`;
CREATE DATABASE `grancacao` DEFAULT CHARACTER SET utf8mb4 ;
USE `grancacao`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(250) NOT NULL UNIQUE,
  `pass` CHAR(64) NOT NULL,
  `name` VARCHAR(45),
  `token` CHAR(64),
  -- `status` SET('Confirmado', 'Não confirmado') DEFAULT 'Não confirmado',
  `active` BOOL DEFAULT TRUE,
  PRIMARY KEY (`id_user`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `user_device`;
CREATE TABLE IF NOT EXISTS `user_device` (
	`id_user` INT NOT NULL,
    `token` CHAR(64) NOT NULL,
    `validade` DATE NOT NULL,
    PRIMARY KEY (`id_user`,`token`),
    CONSTRAINT `fk_UserToDevice` FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_group`;
CREATE TABLE IF NOT EXISTS `product_group` (
	`id_group` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(250),
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
    PRIMARY KEY(`id_image`,`id_product`),
    CONSTRAINT `fk_ProductToImage` FOREIGN KEY (`id_product`) REFERENCES `product`(`id_product`)
)ENGINE = InnoDB;

