<?php
    session_start();
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
    </head>
    <h1>Create Question</h1>
    <body>
        <form name = "question" method = "post" action = "../post/sendQuestion.php">
            <label for="questionBox">Enter a Question:</label><br>
            <textarea type="textarea" id="questionBox" name="questionBox" class="questionBox" required></textarea><br>
            <label for="testCase1">Enter your first test case:</label><br>
            <input type="text" id="testCase1" name="testCase1" required><br>
            <label for="testCase2">Enter your second test case:</label><br>
            <input type="text" id="testCase2" name="testCase2" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>

    <form action="teacher.php">
        <input type="submit" name="b1" value="Back">
    </form>
</HTML>