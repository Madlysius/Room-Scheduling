-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema COECSA_Room_Scheduling
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema COECSA_Room_Scheduling
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `COECSA_Room_Scheduling` DEFAULT CHARACTER SET utf8 ;
USE `COECSA_Room_Scheduling` ;
-- -----------------------------------------------------
-- TABLE `COECSA_Room_Scheduling`.`User_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`User_types` (
  `user_type_id` INT NOT NULL AUTO_INCREMENT,
  `user_type` ENUM('Room Manager', 'Coordinator') NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`User` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `userpass` VARCHAR(45) NOT NULL,
  `user_type_id` INT NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_User_User_Types1_idx` (`user_type_id` ASC),
  CONSTRAINT `fk_User_User_Types1`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `COECSA_Room_Scheduling`.`user_types` (`user_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Course` (
  `course_id` INT NOT NULL AUTO_INCREMENT,
  `course_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`course_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Semester`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Semester` (
  `semester_id` INT NOT NULL AUTO_INCREMENT,
  `semester` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`semester_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Subject`
-- -----------------------------------------------------
  CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Subject` (
    `subject_id` INT NOT NULL AUTO_INCREMENT,
    `course_id` INT NOT NULL,
    `semester_id` INT NOT NULL,
    `subject_code` VARCHAR(10) NOT NULL,
    `subject_name` VARCHAR(45) NOT NULL,
    `lecture_hr` VARCHAR(45) NOT NULL,
    `laboratory_hr` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`subject_id`),
    INDEX `fk_Subject_Courses1_idx` (`course_id` ASC),
    INDEX `fk_Subject_Semester1_idx` (`semester_id` ASC),
    CONSTRAINT `fk_Subject_Courses1`
      FOREIGN KEY (`course_id`)
      REFERENCES `COECSA_Room_Scheduling`.`Course` (`course_id`)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
    CONSTRAINT `fk_Subject_Semester1_idx`
      FOREIGN KEY (`semester_id`)
      REFERENCES `COECSA_Room_Scheduling`.`Semester` (`semester_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Room` (
  `room_id` INT NOT NULL AUTO_INCREMENT,
  `room_code` VARCHAR(45) NOT NULL,
  `room_name` VARCHAR(45) NOT NULL,
  `room_category` VARCHAR(45) NOT NULL,
  `room_location` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`room_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Section` (
  `section_id` INT NOT NULL AUTO_INCREMENT,
  `section_name` VARCHAR(7) NOT NULL,
  `section_year` VARCHAR(45) NOT NULL,
  `course_id` INT NOT NULL,
  PRIMARY KEY (`section_id`),
  INDEX `fk_Section_Courses1_idx` (`course_id` ASC),
  CONSTRAINT `fk_Section_Courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Course` (`course_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Day`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Day` (
  `day_id` INT NOT NULL AUTO_INCREMENT,
  `day` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`day_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `COECSA_Room_Scheduling`.`Scheduling Table`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COECSA_Room_Scheduling`.`Scheduling Table` (
  `schedule_id` INT NOT NULL AUTO_INCREMENT,
  `subject_id` INT NOT NULL,
  `room_id` INT NOT NULL,
  `section_id` INT NOT NULL,
  `day_id` INT NOT NULL,
  `semester_id` INT NOT NULL,
  `schedule_start_time` VARCHAR(45) NOT NULL,
  `schedule_end_time` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`schedule_id`, `subject_id`, `room_id`, `section_id`, `day_id`, `semester_id`),
  INDEX `fk_Scheduling Table_Subjects1_idx` (`subject_id` ASC),
  INDEX `fk_Scheduling Table_Rooms1_idx` (`room_id` ASC),
  INDEX `fk_Scheduling Table_Section1_idx` (`section_id` ASC),
  INDEX `fk_Scheduling Table_Days1_idx` (`day_id` ASC),
  INDEX `fk_Scheduling Table_Semester1_idx` (`semester_id` ASC),
  CONSTRAINT `fk_Scheduling Table_Subjects1`
    FOREIGN KEY (`subject_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Subject` (`subject_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Scheduling Table_Rooms1`
    FOREIGN KEY (`room_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Room` (`room_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Scheduling Table_Section1`
    FOREIGN KEY (`section_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Section` (`section_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Scheduling Table_Days1`
    FOREIGN KEY (`day_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Day` (`day_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Scheduling Table_Semester1`
    FOREIGN KEY (`semester_id`)
    REFERENCES `COECSA_Room_Scheduling`.`Semester` (`semester_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('1', 'Monday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('2', 'Tuesday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('3', 'Wednesday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('4', 'Thursday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('5', 'Friday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('6', 'Saturday');
INSERT INTO `COECSA_Room_Scheduling`.`Day` (`day_id`, `day`) VALUES ('7', 'Sunday');

INSERT INTO `COECSA_Room_scheduling`.`Semester` (`semester_id`, `semester`) VALUES ('1', '1st Semester');
INSERT INTO `COECSA_Room_scheduling`.`Semester` (`semester_id`, `semester`) VALUES ('2', '2nd Semester');


INSERT INTO `COECSA_Room_Scheduling`.`User_Types` (`user_type_id`, `user_type`) VALUES ('1', 'Room Manager');
INSERT INTO `COECSA_Room_Scheduling`.`User_Types` (`user_type_id`, `user_type`) VALUES ('2', 'Coordinator');
INSERT INTO `COECSA_Room_Scheduling`.`User` (`user_id`, `username`, `userpass`, `user_type_id`) VALUES ('2', 'admin2', 'admin2', '2');
INSERT INTO `COECSA_Room_Scheduling`.`User` (`user_id`, `username`, `userpass`, `user_type_id`) VALUES ('1', 'admin', 'admin', '1');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
