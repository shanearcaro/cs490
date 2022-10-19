CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

-- Create UserAccounts table
CREATE TABLE IF NOT EXISTS UserAccounts (
    id INT(10) NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password TEXT(255) NOT NULL,
    isTeacher TINYINT(1) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO `UserAccounts` (`id`, `username`, `password`, `isTeacher`) VALUES (NULL, 'student', 'student', '0');
INSERT INTO `UserAccounts` (`id`, `username`, `password`, `isTeacher`) VALUES (NULL, 'teacher', 'teacher', '1');

-- Create Questions table
CREATE TABLE IF NOT EXISTS Questions (
    id int(10) NOT NULL AUTO_INCREMENT,
    question TEXT(255) NOT NULL,
    testcase1 VARCHAR(20) NOT NULL,
    testcase2 VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS Exams (
    id INT NOT NULL, 
    points INT NOT NULL, 
    numberOfQuestions INT NOT NULL, 
    teacherID INT NOT NULL, 
    PRIMARY KEY (id),
    FOREIGN KEY (teacherID) REFERENCES UserAccounts(id)
);

CREATE TABLE IF NOT EXISTS ExamQuestions (
    examID INT NOT NULL,
    questionID INT NOT NULL,
    points INT NOT NULL,
    FOREIGN KEY (examID) REFERENCES Exams(id),
    FOREIGN KEY (questionID) REFERENCES Questions(id)
);
