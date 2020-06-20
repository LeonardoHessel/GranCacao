DROP DATABASE IF EXISTS `grancacao`;
CREATE DATABASE `grancacao` DEFAULT CHARACTER SET utf8mb4 ;
USE `grancacao`;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(250) NOT NULL UNIQUE,
  `senha` CHAR(64) NOT NULL,
  `nome` VARCHAR(45),
  `token` CHAR(64),
  `status` SET('Confirmado', 'Não confirmado') DEFAULT 'Não confirmado',
  `del` BOOL DEFAULT FALSE
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `usuario_endereco`;
CREATE TABLE IF NOT EXISTS `usuario_endereco` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `usuario` INT NOT NULL,
    `cep` CHAR(8),
    `logradouro` VARCHAR(60) NOT NULL,
    `numero` INT NOT NULL,
    `complemento` VARCHAR(45),
    `localidade` VARCHAR(45) NOT NULL,
    `uf` CHAR(2) NOT NULL,
    `ibge` CHAR(7) NOT NULL,
    `totalentregas` INT,
    `del` BOOL DEFAULT FALSE,
    CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `usuario_telefone`;
CREATE TABLE IF NOT EXISTS `usuario_telefone` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `usuario` INT NOT NULL,
    `ddd` varchar(3),
    `numero` VARCHAR(9),
    `del` BOOL DEFAULT FALSE,
    CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `usuario_dispositivo`;
CREATE TABLE IF NOT EXISTS `usuario_dispositivo` (
	`usuario` INT NOT NULL,
    `token` CHAR(64) NOT NULL,
    `validade` DATE NOT NULL,
    PRIMARY KEY (`usuario`,`token`),
    CONSTRAINT `fk_usuario_dispositivo` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nome`VARCHAR(250) NOT NULL,
    `valor` DECIMAL(5,2) NOT NULL,
    `descricao` VARCHAR(250),    
    `categoria` INT,
    `del` BOOL DEFAULT FALSE
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
    `usuario` INT,
    `qtdItens` INT,
    `valorTotal` DECIMAL(5,2),
    `situacao` SET('Concluído','Aberto'),
    `del` BOOL DEFAULT FALSE,
    CONSTRAINT `fk_usuario_pedido` FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `item_pedido`;
CREATE TABLE IF NOT EXISTS `item_pedido` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
    `pedido` INT NOT NULL,
    `produto` INT NOT NULL,
    `qtdProd` INT NOT NULL,
    `valorUn` DECIMAL(5,2),
    `subToatal` DECIMAL(5,2),
    `del` BOOL DEFAULT FALSE,
    CONSTRAINT `fk_pedido_item` FOREIGN KEY (`pedido`) REFERENCES `pedido`(`id`),
    CONSTRAINT `fk_produto_item` FOREIGN KEY (`produto`) REFERENCES `produto`(`id`)
)ENGINE = InnoDB;



/*select DATE(DATE_ADD(NOW(), INTERVAL 15 DAY));*/


/*
DROP TABLE IF EXISTS ``;
CREATE TABLE IF NOT EXISTS `` (
	
)ENGINE = InnoDB;
*/
