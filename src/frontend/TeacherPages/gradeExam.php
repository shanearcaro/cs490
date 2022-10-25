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
        <Title>Grade Exams</Title>
        <link rel="Stylesheet" href="../../../style/TeacherPages/gradeExam.css?<?php echo time();?>"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
    </head>

    <!-- Script makes it so the user can't use the browser back button which
    prevents the loss of the seesion data -->
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { 
                window.history.forward(); 
            }
        </script>
        <div class="left">
            <div class="header">
                <h2 id="title">CS 490</h2>
                <h3 id="semester">Fall 2022</h3>
                <img src="../../../assets/njit.png" alt="NJIT LOGO">
                <h4>Shane Arcaro, Malcolm Shuler, Ege Atay</h4>
            </div>
        </div>
    </body>
</HTML>

<?php
    // Send the accountID with the request
    $data = array('accountID' => $_SESSION['accountID']);
    // Encode the data into JSON format

    $backend_url = 'localhost/src/backend/selectExamsTeacher.php';
    array_push($data, $backend_url);
    $encoded = json_encode($data);

    // Connection for the middle end
    $url = 'localhost/src/middle/middle.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $exams = json_decode($result);
    curl_close($ch);

    // Render all questions on the screen
    echo '
        <div class="right">
            <div class="examBank">
                <div class="examHeader">';
                    if ($exams == "Empty") 
                        echo '
                        <h2 id="examsTitle">No exams available</h2>
                        <div class="examButtons2">
                            <input id="backButton2" form="backButtonForm" type="submit" name="submit" value="Back">
                        </div>
                        <form action="http://localhost:8000/src/frontend/TeacherPages/teacher.php" id="backButtonForm"></form>
                        ';
                    else {
                        echo '
                            <h2 id="examsTitle">Auto Grade Exams</h2>
                            <div class="labels">
                                <ul>
                                    <li id="teacherName">Exam ID</li>
                                    <li id="examID">Student</li>
                                </ul>
                            </div>
                            <div class="examRows">
                                <form name="createExam" id="pickExam" method="POST" action="./examReview.php">';
                                    // Loop  through all available exams 
                                    for ($i = 0; $i < count($exams); $i++) {
                                            $exam = $exams[$i];
                                            // Get all variables needed for display
                                            $exam           = $exams[$i];
                                            $examID         = $exam->{'examID'};
                                            $studentID      = $exam->{'studentID'};
                                            $studentName    = $exam->{'username'};
                                            $username       = $exam->{'username'};

                                            echo '
                                                <div class="examRow">
                                                    <div class="checkBoxElement listElement">
                                                        <input type="radio" required class="checkBox" name="index[]" value="'. $i .'">
                                                    </div>
                                                    <div class="teacherNameElement listElement"
                                                        <p>' . $examID . '</p>
                                                    </div>

                                                    <div class="examIDElement listElement"
                                                        <p>' . nl2br($username) . '</p>
                                                    </div>
                                                </div>
                                            ';
                                    }
                                echo '                      
                                <div class="examButtons">
                                    <input id="submitButton" form="pickExam" type="submit" name="submit" value="Select">
                                    <input id="backButton" form="backButtonForm" type="submit" name="submit" value="Back">
                                </div>
                                </form>
                                <form action="http://localhost:8000/src/frontend/TeacherPages/teacher.php" id="backButtonForm"></form>
                            </div>
                        ';
                    }
                echo ' 
                </div>
            </div>
        </div>
    ';
?>