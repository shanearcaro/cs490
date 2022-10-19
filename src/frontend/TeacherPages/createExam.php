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
        echo '<div class="questionBank">';

        echo '<h1 id="title">Create an Exam</h1>';
        echo '<div class="questionTable">';

        echo '<div class="tableLabels">';

        echo '<ul><li>Question</li><li>Test Case 1</li><li>Test Case 2</li></ul>';
        echo '<div class="questionRows">';
        $counter = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo '<ul><li class="element">' . nl2br($row['question']) . '</li><li class="element">' . $row['testcase1'] . '</li><li class="element">' . $row['testcase2'] . '</li></ul>';
            $counter++;
        }
        echo '</div>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
        // echo "<div class=container>";
        // echo '<h1 id="title">Create an Exam</h1>';
        // echo "<table id='database_table'>";
        // echo '<tr><th class="label">' . 'Question' .
        //     '</td><th class="label">' . 'Test Case 1' .
        //     '</td><th class="label">' . 'Test Case 2' . '</td></tr>';
        // $counter = 1;
        // while ($row = mysqli_fetch_array($result)) {
        //     echo '<tr class="questionRow" id="row' . $counter . '"><input type="checkbox" id="button' . $counter . '"><td class="questionCol">' . $row['question'] . 
        //         '</td><td class="questionCol">' . $row["testcase1"] . 
        //         '</td><td class="questionCol">' . $row["testcase2"] . "</td></tr>";
        //     $counter++;    
        // }
        // echo "</table>";
        // echo '</div>';
    }

    $connection->close();
?>