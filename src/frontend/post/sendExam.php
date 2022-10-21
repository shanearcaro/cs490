<?php
    session_start();
    $questionBank = array();
    if (isset($_POST['checkBox'])) {
        for ($i = 0; $i < count($_POST['checkBox']); $i++) {
            $questionBank[$_POST['checkBox'][$i]] = $_POST['points'][$i];
        }
    }
    array_push($questionBank, $_SESSION['accountID']);

    // Encode the data into JSON format
    $encoded = json_encode($questionBank);

    // Connection for the middle end
    $url = 'localhost/src/middle/validateExam.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

    print_r($questionBank);
    echo "[ " . $result . " ]";

    /**
     * Need to look at sendExam.php, validateExam.php, and insertExam.php, and find the error
     * that's stoping the curl session from working properly. The exam and the exam questions
     * should all be created and the result should either be "Blank" meaning that no questions
     * were added, or "x number of questions were added" indicating the number of questions that
     * were added to the database.
     */
?>