-- running this will empty your old database and create a new one

DROP SCHEMA IF EXISTS `axif` ;
CREATE SCHEMA IF NOT EXISTS `axif` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `axif` ;

CREATE TABLE IF NOT EXISTS `axif`.`activities` (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
) ENGINE = INNODB;