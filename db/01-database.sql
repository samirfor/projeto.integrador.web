SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `pilpw` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pilpw` ;

-- -----------------------------------------------------
-- Table `pilpw`.`aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pilpw`.`aluno` (
  `numero_matricula` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_aluno` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`numero_matricula`),
  UNIQUE INDEX `nome_UNIQUE` (`nome_aluno` ASC),
  UNIQUE INDEX `matricula_UNIQUE` (`numero_matricula` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pilpw`.`curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pilpw`.`curso` (
  `idcurso` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`idcurso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pilpw`.`periodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pilpw`.`periodo` (
  `idperiodo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `periodo_descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idperiodo`),
  UNIQUE INDEX `periodo_descricao_UNIQUE` (`periodo_descricao` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pilpw`.`matricula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pilpw`.`matricula` (
  `idmatricula` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_matricula` INT UNSIGNED NOT NULL,
  `curso_id` INT UNSIGNED NOT NULL,
  `periodo_id` INT UNSIGNED NOT NULL,
  `semestre` INT NOT NULL,
  PRIMARY KEY (`idmatricula`),
  INDEX `fk_matricula_1_idx` (`numero_matricula` ASC),
  INDEX `fk_matricula_2_idx` (`curso_id` ASC),
  INDEX `fk_matricula_3_idx` (`periodo_id` ASC),
  CONSTRAINT `fk_matricula_1`
    FOREIGN KEY (`numero_matricula`)
    REFERENCES `pilpw`.`aluno` (`numero_matricula`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_matricula_2`
    FOREIGN KEY (`curso_id`)
    REFERENCES `pilpw`.`curso` (`idcurso`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_matricula_3`
    FOREIGN KEY (`periodo_id`)
    REFERENCES `pilpw`.`periodo` (`idperiodo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `pilpw`.`curso`
-- -----------------------------------------------------
START TRANSACTION;
USE `pilpw`;
INSERT INTO `pilpw`.`curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Inglês');
INSERT INTO `pilpw`.`curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Administração');
INSERT INTO `pilpw`.`curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Informática');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pilpw`.`periodo`
-- -----------------------------------------------------
START TRANSACTION;
USE `pilpw`;
INSERT INTO `pilpw`.`periodo` (`idperiodo`, `periodo_descricao`) VALUES (NULL, 'Manhã');
INSERT INTO `pilpw`.`periodo` (`idperiodo`, `periodo_descricao`) VALUES (NULL, 'Tarde');
INSERT INTO `pilpw`.`periodo` (`idperiodo`, `periodo_descricao`) VALUES (NULL, 'Noite');

COMMIT;

