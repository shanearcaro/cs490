<?php
    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'), true);

    // Pulls the backend url from the array and removes it from the array
    $url = array_pop($user_data);
    $examID = end($user_data);
    $studentID = end($user_data);
    $encoded = json_encode($user_data);

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);

    $autoGrade = array();

    // This is a list of questionIDS->answers
    $questionAnswers = json_decode($result);
    $resultCode = 0;
    // Loop through every question from the exam
    for ($i = 0; $i < count($questionAnswers); $i++) {
        $questionIndex = $questionAnswers[$i];
        $questionID = $questionIndex->{'questionID'};
        $answer = $questionIndex->{'answer'} . "\n";
        $points = $questionIndex->{'points'};
        $testcase1 = $questionIndex->{'testcase1'};
        $testcase2 = $questionIndex->{'testcase2'} . "\n";


        // This is where the auto grader should run its logic
        $fileName = 'question.py';
        $file = fopen($fileName, 'w') or die('Unable to open file!');

        // Write shell shebang
        $shebang = '#!/usr/bin/python3.9' . "\n";
        $testcaseOuput = "print(" . $testcase1 . ")";
        fwrite($file, $shebang);
        fwrite($file, $answer);
        fwrite($file, $testcaseOuput);
        fclose($file);

        $command = escapeshellcmd("/usr/bin/python3.9 question.py");
        exec($command, $result, $resultCode);
        array_push($autoGrade, $result);
        array_push($autoGrade, $resultCode);
    }


    // Instead of just echoing the data back this is going to have to run the auto grader logic
    curl_close($ch);
    $result = json_encode($autoGrade);
    echo $result;
?>