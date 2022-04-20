-- database
CREATE SCHEMA IF NOT EXISTS `bi` DEFAULT CHARACTER SET utf8 ;
USE `bi` ;

-- tb_group
CREATE TABLE `bi`.`tb_group`(
  `grp_id` INT NOT NULL,
  `grp_name` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`grp_id`)
) ENGINE = InnoDB;

-- tb_company
CREATE TABLE `bi`.`tb_company`(
  `com_id` INT NOT NULL,
  `com_name` VARCHAR(400) NOT NULL,
  `grp_id` INT NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE = InnoDB;

ALTER TABLE `tb_company` ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`grp_id`) REFERENCES `tb_group`(`grp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;