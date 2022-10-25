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
        </style>
        <link rel="Stylesheet" href="../../../style/TeacherPages/questionBank.css?<?php echo time();?>"/>
    </head>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script>
            <div class="left">
            <div class="header">
                <h2 id="title">CS 490</h2>
                <h3 id="semester">Fall 2022</h3>
                <img src="../../../assets/njit.png" alt="NJIT LOGO">
                <h4>Shane Arcaro, Malcolm Shuler, Ege Atay</h4>
            </div>
    </div>
    <div class="right">
        <div class="examBank">
            <h2 id="examsTitle">Create Question </h2>
            <div class="labels">
                <ul>
                    <li id="question">Question</li>
                    <li id="testcase1">Test Case</li>
                    <li id="answer1">Answer</li>
                    <li id="testcase2">Test Case</li>
                    <li id="answer2">Answer</li>
                </ul>
            </div>
            <div class="examRows">
                <form name="createExam" id="pickExam" method="POST" autocomplete="off" action="../post/sendQuestion.php">
                    <div class="elements">
                        <textarea type="textarea" class="question" name="questionBox" class="questionBox" required></textarea>
                        <input type="text" class="normalElement" name="testCase1" required>
                        <input type="text" class="normalElement" name="caseAnswer1" required>
                        <input type="text" class="normalElement" name="testCase2" required>
                        <input type="text" class="normalElement" name="caseAnswer2" required>
                    </div>
                    <div class="examButtons">
                        <input id="submitButton" form="pickExam" type="submit" name="submit" value="Create">
                        <input id="backButton" form="backButtonForm" type="submit" name="submit" value="Back">
                    </div>
                </form>
                <form action="http://localhost:8000/src/frontend/TeacherPages/teacher.php" id="backButtonForm"></form>
            </div>
        </div>
    </div>
            <!-- <div class="form-buttons">
                <form name = "question" method = "post" action = "../post/sendQuestion.php">
                    <div class="element">
                        <label for="questionBox">Enter a Question:</label>
                        
                    </div>
                    <div class="element">
                        <label for="testCase1">Test case 1:</label>
                        <input type="text" id="testCase1" name="testCase1" required>
                    </div>
                    <div class="element">
                        <label for="caseAnswer1">Expected Answer:</label>
                        <input type="text" id="caseAnswer1" name="caseAnswer1" required>
                    </div>
                    <div class="element">
                        <label for="testCase2">Test case 2:</label>
                        <input type="text" id="testCase2" name="testCase2" required>
                    </div>
                    <div class="element">
                        <label for="caseAnswer2">Expected Answer:</label>
                        <input type="text" id="caseAnswer2" name="caseAnswer2" required>
                    </div>
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div> -->
        </div>
    </div>
    </body>
    <?php
        include 'teacherBackButton.php';
    ?>
</HTML>