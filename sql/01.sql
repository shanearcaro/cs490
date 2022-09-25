-- Active: 1663965004966@@sql2.njit.edu@3306@ea353
CREATE TABLE `test` (  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    
    create_time DATETIME COMMENT 'Create Time',
    name VARCHAR(255)
) COMMENT '';


CREATE TABLE `Users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` varchar(32) NOT NULL,
    `password` VARCHAR(99) NOT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

INSERT INTO Users(id, username, password) VALUES(0, "testin", "123456");


ALTER table Users2 
ADD COLUMN username varchar(15) NOT NULL;

DROP TABLE `Users2`;
DROP TABLE `test`;


SELECT * FROM `Users` LIMIT 100;