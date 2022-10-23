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
        <Title>Student Portal</Title>
    </head>
    <link rel="Stylesheet" href="../../../style/default.css?<?php echo time();?>"/>
    <h1>Welcome Student! What would you like to do?</h1>
    <body>
        <div class="teacherLanding">
            <!--Move to take exam page -->
            <form action="takeExam.php">
                <input type="submit" name="b1" value="Take Exam">
            </form>
            <!--Move to the exam review page -->
            <form action="reviewExam.php">
                <input type="submit" name="b2" value="Review Exam">
            </form>
        </div>
    </body>
    
</HTML>

<?php
    // If session is restarted or session data is unavailable log the user out
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session expired, logging out.');";
        /**
         * JUST NEED TO MAKE IT SO THAT THE PAGE DIRECTS AND LOGS OUT
         * 
         * Once this is set up the auto grade can start to be worked on. I just want a
         * reliable version of the project before I start working on the auto grader.
         * I don't want to have to program this entire thing for a lot of minor changes
         * to take place to just break it.
         */
        $url = '/page.php';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
        exit();
    }
    else {
        echo $_SESSION['accountID'];
    }
?>