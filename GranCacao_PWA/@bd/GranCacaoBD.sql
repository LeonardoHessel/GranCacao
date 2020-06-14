CREATE SCHEMA `grancacao` DEFAULT CHARACTER SET utf8mb4 ;

USE `grancacao`;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(250) NOT NULL UNIQUE,
  `senha` VARCHAR(250) NOT NULL,
  `nome` VARCHAR(45),
  `token` VARCHAR(250),
  `status` SET('Confirmado', 'Aguradando confirmação'),
  `del` BOOL
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `enderecousuario`;
CREATE TABLE IF NOT EXISTS `enderecousuario` (
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
    `del` BOOL,
    CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (usuario) REFERENCES `usuario`(id)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `telefoneusuario`;
CREATE TABLE IF NOT EXISTS `telefoneusuario` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `usuario` INT NOT NULL,
    `ddd` varchar(3),
    `numero` VARCHAR(9),
    `del` BOOL,
    CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (usuario) REFERENCES `usuario`(id)
)ENGINE = InnoDB;








/*
DROP TABLE IF EXISTS ``;
CREATE TABLE IF NOT EXISTS `` (
	
)ENGINE = InnoDB;
*/
