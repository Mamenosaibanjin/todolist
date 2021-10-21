CREATE TABLE `todo`.`todo_list` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(255) NOT NULL , 
  `description` LONGTEXT NOT NULL , 
  `processing_date` DATE NOT NULL , 
  `created_at` DATETIME NOT NULL , 
  `updated_at` DATETIME NOT NULL , 
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB;
