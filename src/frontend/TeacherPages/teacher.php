<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
        
    }
?>
<!DOCTYPE html>
<HTML lang ="en">
    <head>
        <Title>Teacher Portal</Title>
    </head>
    <link rel="Stylesheet" href="../../../style/default.css?<?php echo time();?>"/>
    <h1>Welcome Teacher! What would you like to do?</h1>
    <body>
        <div class="teacherLanding">
            <!--Move to question creation page -->
            <form action="./questionBank.php" target="_self">
                <input type="submit" name="b1" value="Create Questions">
            </form>
            <!--Move to the exam creation page -->
            <form action="./createExam.php" target="_self">
                <input type="submit" name="b2" value="Create Exam">
            </form>
            <!-- Move to the review exam page --> 
            <form action="./gradeExam.php" target="_self">
                <input type="submit" name="b3" value="Grade Exams">
            </form>
        </div>
    </body>
    
</HTML>