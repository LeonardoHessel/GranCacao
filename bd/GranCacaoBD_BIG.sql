CREATE DATABASE `grancacao` DEFAULT CHARACTER SET utf8mb4 ;
USE `grancacao` ;

CREATE TABLE `usuario` (
	`idusuario` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`pnome` VARCHAR(20),
	`unome` VARCHAR(20),
	`email` VARCHAR(45) NOT NULL,
	`senha` VARCHAR(45) NOT NULL,
	`cpf` VARCHAR(11),
	`priend` INT,
	`pritel` INT,
	`status` SET("Ativo", "Excluído") NOT NULL DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `usuarioend` (
	`idendereco` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`idusuario` INT NOT NULL,
	`cep` CHAR(8),
	`rua` VARCHAR(45),
	`numero` VARCHAR(6),
	`compl` VARCHAR(45),
	`bairro` VARCHAR(45),
	`cidade` VARCHAR(45),
	`uf` VARCHAR(20),
	`vfrete` DECIMAL(6,2),
	`status` SET("Ativo", "Excluído") NOT NULL DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `usuariotel` (
	`idtel` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`idusuario` INT NOT NULL,
	`ddd` CHAR(2),
	`numero` CHAR(9),
	`status` SET("Ativo", "Excluído") NOT NULL DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `funcionario` (
	`idfunc` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(20),
	`email` VARCHAR(255) NOT NULL,
	`senha` VARCHAR(45) NOT NULL,
	`status` SET("Ativo", "Excluído") NOT NULL DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `pedido` (
	`idpedido` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`idstatusped` INT,
	`idusuario` INT,
	`qtditens` INT,
	`valoritens` DECIMAL(6,2),
	`entrega` SET("Retirada", "Delivery"),
	`iddelivery` INT DEFAULT 0,
	`valorfrete` DECIMAL(6,2),
	`valortotal` DECIMAL(6,2),
	`valorpago` DECIMAL(6,2),
	`troco` DECIMAL(6,2) DEFAULT 0,
	`datahora` DATETIME NOT NULL
)ENGINE = InnoDB;

CREATE TABLE `statusped` (
	`idstatusped` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(20) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE `item` (
	`iditem` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`idpedido` INT NOT NULL,
	`idproduto` INT NOT NULL,
	`qtd` DOUBLE,
	`valorunitario` DECIMAL(6,2),
	`valoradicional` DECIMAL(6,2),
	`valorsubtotal` DECIMAL(6,2),
	`status` SET("Ativo", "Excluído") DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `produto` (
	`idproduto` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(45) NOT NULL,
	`valor` DECIMAL(6,2) NOT NULL,
	`aceitaingred` TINYINT,
	`fracionavel` TINYINT,
	`status` SET("Ativo", "Excluído") DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `ingred` (
	`idingred` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(45) NOT NULL,
	`valor` DECIMAL(6,2) NOT NULL,
	`addrem` TINYINT NOT NULL,
	`vaddrem` DECIMAL(6,2) NOT NULL,
	`status` SET("Ativo", "Excluído") DEFAULT 'Ativo'
)ENGINE = InnoDB;

CREATE TABLE `listaingred` (
	`idprod` INT PRIMARY KEY NOT NULL,
	`idingred` INT NOT NULL,
	`status` SET("Ativo", "Excluído") NOT NULL DEFAULT 'Ativo'
)ENGINE = InnoDB;



