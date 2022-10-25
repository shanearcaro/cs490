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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
    <link rel="Stylesheet" href="../../../style/TeacherPages/createExam.css?<?php echo time();?>"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    
</body>
</html>

<?php
    // Send the accountID with the request
    $data = array('accountID' => $_SESSION['accountID']);
    $backend_url = 'localhost/src/backend/selectQuestions.php';
    array_push($data, $backend_url);
    // Encode the data into JSON format
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
    $questions = json_decode($result);
    curl_close($ch);

    // Render all questions on the screen
    if ($questions == "Empty") {
        echo '<h1 id="title">No questions created</h1>';
    }
    else {
        echo '<div class="questionBank">';
        echo '<h1 id="title">Create an Exam</h1>';
        echo '<div class="questionTable">';
        echo '<div class="tableLabels">';

        echo '<ul>';
        echo '<li class="labels">Question</li>';
        echo '<li class="labels">Test Case 1</li>';
        echo '<li class="labels">Test Case 2</li>';
        echo '<li class="labels">Points</li>';
        echo '</ul>';
        echo '</div>';
        echo '<div class="questionRows">';
        echo '<form name="createExam" method="post" action="../post/sendExam.php">';
        for ($i = 0; $i < count($questions); $i++) {
            $question = $questions[$i];
            $questionID = $question->{'questionID'};
            $questionText = $question->{'question'};
            $testcase1 = $question->{'testcase1'};
            $testcase2 = $question->{'testcase2'};
            echo '<div class="row">';
            echo '<ul>';
            echo '<li class="element-button"><input type="checkbox" class="checkBox" name="checkBox[]" value="'. $questionID .'">';
            echo '<li class="element">' . nl2br($questionText) . '</li>';
            echo '<li class="element">' . $testcase1 . '</li>';
            echo '<li class="element">' . $testcase2 . '</li>';
            echo '<li class="element"><input type="number" class="element-text" name="points[]" value="0" min="0" required pattern="[0-9]"></li>';
            echo '</ul>';
            echo '</div>';
        }
        echo '<input class="button" type="submit" name="submit" value="Submit">';
        echo '</form>';
        include 'teacherBackButton.php';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }
?>