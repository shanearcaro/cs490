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
<HTML>
    <head>
        <Title>Create Question</Title>
        <style>
            .questionBox{
                height: 150px;
                width: 75%;
                font-size: 16px;
            }
        </style>
        <link rel="Stylesheet" href="../../../style/default.css?<?php echo time();?>"/>
    </head>
    <h1>Create Question</h1>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script>
        <form name = "question" method = "post" action = "../post/sendQuestion.php">
            <label for="questionBox">Enter a Question:</label><br>
            <textarea type="textarea" id="questionBox" name="questionBox" class="questionBox" required></textarea><br>
            <label for="testCase1">Enter your first test case:</label><br>
            <input type="text" id="testCase1" name="testCase1" required><br>
            <label for="caseAnswer1">Enter the expected answer for test case 1:</label><br>
            <input type="text" id="caseAnswer1" name="caseAnswer1" required><br>
            <label for="testCase2">Enter your second test case:</label><br>
            <input type="text" id="testCase2" name="testCase2" required><br>
            <label for="caseAnswer2">Enter the expected answer for test case 2:</label><br>
            <input type="text" id="caseAnswer2" name="caseAnswer2" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>

    <form action="teacher.php">
        <input type="submit" name="b1" value="Back">
    </form>
</HTML>