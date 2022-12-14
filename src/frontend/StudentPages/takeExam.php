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
        <Title>Student Portal</Title>
        <link rel="Stylesheet" href="../../../style/takeExam.css?<?php echo time();?>"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
    </head>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { 
                window.history.forward(); 
            }
        </script>
    </body>
</HTML>

<?php
    // Send the accountID with the request
    $data = array('accountID' => $_SESSION['accountID']);
    // Encode the data into JSON format

    $backend_url = 'localhost/src/backend/selectExamsStudent.php';
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
    if ($exams == "Empty") {
        echo '<h1 id="title">No exams available</h1>';
        echo '<body>';
        include 'studentBackButton.php';
        echo '</body>';
    }
    else {
        echo '<div class="questionBank">';
        echo '<h1 id="title">Take Exam</h1>';
        echo '<div class="questionTable">';
        echo '<div class="tableLabels">';

        echo '<ul>';
        echo '<li class="labels">Professor</li>';
        echo '<li class="labels">Exam ID</li>';
        echo '<li class="labels">Points</li>';
        echo '<li class="labels">Questions</li>';
        echo '</ul>';
        echo '</div>';
        echo '<div class="questionRows">';
        echo '<form name="createExam" method="post" action="./exam.php">';
        for ($i = 0; $i < count($exams); $i++) {
            $exam = $exams[$i];
            $examID = $exam->{'examID'};
            $examPoints = $exam->{'examPoints'};
            $numberOfQuestions = $exam->{'numberOfQuestions'};
            $teacherID = $exam->{'teacherID'};
            $username = $exam->{'username'};
            echo '<div class="row">';
            echo '<ul>';
            echo '<li class="element-button"><input type="radio" class="checkBox" name="checkBox[]" value="'. $examID .'">';
            echo '<li class="element">' . nl2br($username) . '</li>';
            echo '<li class="element">' . $examID . '</li>';
            echo '<li class="element">' . $examPoints . '</li>';
            echo '<li class="element">' . $numberOfQuestions . '</li>';
            echo '</ul>';
            echo '</div>';
        }
        echo '<input class="button" type="submit" name="submit" value="Take Exam">';
        echo '</form>';
        include 'studentBackButton.php';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
?>