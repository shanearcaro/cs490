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
    curl_close($ch);

    $autoGrade = array();

    function executePythonScript($case, $answer) {
        $fileName = 'question.py';
        $file = fopen($fileName, 'w') or die('Unable to open file!');
        $execResult = "";

        // Write shell shebang
        $shebang = '#!/usr/bin/python3.9' . "\n";
        $testcaseOuput = "print(" . $case . ")";
        fwrite($file, $shebang);
        fwrite($file, $answer);
        fwrite($file, $testcaseOuput);
        fclose($file);

        $command = escapeshellcmd("/usr/bin/python3.9 question.py");
        exec($command, $execResult);
        return $execResult;
    }

    // This is a list of questionIDS->answers
    $questionAnswers = json_decode($result);
    $question1 = json_encode($questionAnswers[0]);
    $question2 = json_encode($questionAnswers[1]);

    // Loop through every question from the exam
    for ($i = 0; $i < count($questionAnswers); $i++) {
        $questionIndex = $questionAnswers[$i];
        $questionID = $questionIndex->{'questionID'};
        $question = $questionIndex->{'question'};
        $answer = $questionIndex->{'answer'} . "\n";
        $points = $questionIndex->{'points'};
        $testcase1 = $questionIndex->{'testcase1'};
        $testcase2 = $questionIndex->{'testcase2'} . "\n";
        $caseAnswer1 = $questionIndex->{'caseAnswer1'};
        $caseAnswer2 = $questionIndex->{'caseAnswer2'};

        // This is where the auto grader should run its logic
        $tc1 = executePythonScript($testcase1, $answer);
        $tc2 = executePythonScript($testcase2, $answer);
        $testcaseAnswer1 = array('question'=>$question, 'answer'=>$answer, 'case'=>$testcase1, 'points'=>$points, 
            'newPoints'=>$points, 'result'=>$tc1[0], 'expected'=>$caseAnswer1, 'questionID'=>$questionID);
        $testcaseAnswer2 = array('question'=>$question, 'answer'=>$answer, 'case'=>$testcase2, 'points'=>$points, 
            'newPoints'=>$points, 'result'=>$tc2[0], 'expected'=>$caseAnswer2, 'questionID'=>$questionID);

        array_push($autoGrade, $testcaseAnswer1);
        array_push($autoGrade, $testcaseAnswer2);
    }

    // Have all the information needed at this point to calculate point deductions
    for ($i = 0; $i < count($autoGrade); $i += 2) {
        $first = $autoGrade[$i];
        $second = $autoGrade[$i + 1];
        $points = $first['points'];
        $testcasePointDeduction = $points / 4;
        
        $expected1 = $first['expected'];
        $expected2 = $second['expected'];

        $result1 = $first['result'];
        $result2 = $second['result'];

        // Deduct points if the expected result doesn't equal the actual value
        if ($expected1 != $result1) $points -= $testcasePointDeduction;
        if ($expected2 != $result2) $points -= $testcasePointDeduction;
        $autoGrade[$i]['newPoints'] = $points;
        $autoGrade[$i + 1]['newPoints'] = $points;
    }

    // Instead of just echoing the data back this is going to have to run the auto grader logic
    $result = json_encode($autoGrade);
    echo $result;
?>