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

    // This is a list of questionIDS->answers
    $questionAnswers = json_decode($result);

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
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName . "";
        $file = fopen($filePath, 'w') or die('Unable to open file!');

        // Write shell shebang
        $shebang = '#!/usr/bin/env python' . "\n";
        fwrite($file, $shebang);
        fwrite($file, $answer);
        fwrite($file, $testcase1);
        fclose($file);

        // $output = fread($filePath, filesize($file));

    }


    // Instead of just echoing the data back this is going to have to run the auto grader logic
    curl_close($ch);
    echo $filePath;
?>