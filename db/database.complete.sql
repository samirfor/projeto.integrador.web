CREATE DATABASE pilpw;

CREATE USER 'pilpw_user'@'mysql' IDENTIFIED BY 'ahrei4eiYiesho3eezie';
GRANT ALL PRIVILEGES ON *.* TO 'pilpw_user'@'mysql';

FLUSH PRIVILEGES;

USE pilpw;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aluno` (
  `numero_matricula` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_aluno` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`numero_matricula`),
  UNIQUE INDEX `nome_UNIQUE` (`nome_aluno` ASC),
  UNIQUE INDEX `matricula_UNIQUE` (`numero_matricula` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `curso` (
  `idcurso` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`idcurso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `turno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `turno` (
  `idturno` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `turno_descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idturno`),
  UNIQUE INDEX `periodo_descricao_UNIQUE` (`turno_descricao` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matricula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matricula` (
  `idmatricula` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_matricula` INT UNSIGNED NOT NULL,
  `curso_id` INT UNSIGNED NOT NULL,
  `turno_id` INT UNSIGNED NOT NULL,
  `semestre` INT NOT NULL,
  PRIMARY KEY (`idmatricula`),
  INDEX `fk_matricula_1_idx` (`numero_matricula` ASC),
  INDEX `fk_matricula_2_idx` (`curso_id` ASC),
  INDEX `fk_matricula_3_idx` (`turno_id` ASC),
  CONSTRAINT `fk_matricula_1`
    FOREIGN KEY (`numero_matricula`)
    REFERENCES `aluno` (`numero_matricula`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_matricula_2`
    FOREIGN KEY (`curso_id`)
    REFERENCES `curso` (`idcurso`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_matricula_3`
    FOREIGN KEY (`turno_id`)
    REFERENCES `turno` (`idturno`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `curso`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Inglês');
INSERT INTO `curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Administração');
INSERT INTO `curso` (`idcurso`, `curso_descricao`) VALUES (NULL, 'Informática');

COMMIT;


-- -----------------------------------------------------
-- Data for table `turno`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `turno` (`idturno`, `turno_descricao`) VALUES (NULL, 'Manhã');
INSERT INTO `turno` (`idturno`, `turno_descricao`) VALUES (NULL, 'Tarde');
INSERT INTO `turno` (`idturno`, `turno_descricao`) VALUES (NULL, 'Noite');

COMMIT;
