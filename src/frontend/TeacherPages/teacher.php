<?php
    session_start();
?>
<!DOCTYPE html>
<HTML lang ="en">
    <head>
        <Title>Teacher Portal</Title>
    </head>
    <h1>Welcome Teacher! What would you like to do?</h1>
    <body>
        <!--Move to question creation page -->
        <form action="./questionBank.php">
            <input type="submit" name="b1" value="Create Questions">
        </form>
        <!--Move to the exam creation page -->
        <form action="createExam.php">
            <input type="submit" name="b2" value="Create Exam">
        </form>
        <!-- Move to the review exam page --> 
        <form action="gradeExam.php">
            <input type="submit" name="b3" value="Grade Exams">
        </form>
    </body>
    
</HTML>