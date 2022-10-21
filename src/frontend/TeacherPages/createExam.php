<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
    <link rel="Stylesheet" href="../style/exam.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    
</body>
</html>

<?php
    require_once realpath(dirname(__DIR__, 3) . '/vendor/autoload.php');
    
    // Read from credentials file and connect to database
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
    $dotenv->load();

    $connection = new mysqli($_ENV['HOST'], $_ENV['NAME'], $_ENV['PASS'], $_ENV['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if ($connection->connect_error) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    //Insert question data into question table
    $query = "SELECT * FROM Questions";
    $result = mysqli_query($connection, $query);

    $total = mysqli_num_rows($result);

    if ($total == 0) {
        echo '<h1 id="title">No questions created</h1>';
    }
    else {
        echo $_SESSION['accountID'];
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
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="row">';
            echo '<ul>';
            echo '<li class="element-button"><input type="checkbox" class="checkBox" name="checkBox[]" value="'. $row['questionID'] .'">';
            echo '<li class="element">' . nl2br($row['question']) . '</li>';
            echo '<li class="element">' . $row['testcase1'] . '</li>';
            echo '<li class="element">' . $row['testcase2'] . '</li>';
            echo '<li class="element"><input type="text" class="element-text" name="points[]" value="0">';
            echo '</ul>';
            echo '</div>';
        }
        echo '<input class="button" type="submit" name="submit" value="Submit">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    $connection->close();
?>