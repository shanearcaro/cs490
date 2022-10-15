CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;
CREATE TABLE IF NOT EXISTS `UserAccounts` (
    id INT(10) NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password TEXT(255) NOT NULL,
    isTeacher TINYINT(1) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO `UserAccounts` (`id`, `username`, `password`, `isTeacher`) VALUES (NULL, 'student', 'student', '0');
INSERT INTO `UserAccounts` (`id`, `username`, `password`, `isTeacher`) VALUES (NULL, 'teacher', 'teacher', '1');