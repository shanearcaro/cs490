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
        <link rel="Stylesheet" href="../../../style/questionSubmission.css?<?php echo time();?>"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet">
        <Title>Create Question</Title> 
    </head>
    <h1 id="title">Create Question</h1>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script>
        <form name = "question" method = "post" action = "../post/sendQuestion.php">
            <label for="questionBox" class="label">Enter a Question:</label><br>
            <textarea type="textarea" id="questionBox" name="questionBox" class="questionBox" required></textarea><br>
            <label for="testCase1" class = "label">Enter your first test case:</label><br>
            <input type="text" id="testCase1" name="testCase1" class="textBox" required><br>
            <label for="caseAnswer1" class = "label">Enter the expected answer for test case 1:</label><br>
            <input type="text" id="caseAnswer1" name="caseAnswer1" class="textBox" required><br>
            <label for="testCase2" class = "label">Enter your second test case:</label><br>
            <input type="text" id="testCase2" name="testCase2" class="textBox" required><br>
            <label for="caseAnswer2" class = "label">Enter the expected answer for test case 2:</label><br>
            <input type="text" id="caseAnswer2" name="caseAnswer2" class="textBox" required><br>
            <input type="submit" name="submit" value="Submit" class="button">
        </form>
    </body>
    <?php
        include 'teacherBackButton.php';
    ?>
</HTML>