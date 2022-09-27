<?php

    $user_data = file_get_contents('php://input');
    $decoded = json_decode($user_data, true);
    echo $decoded;

    echo "FUCKING ANYTTHING!@";

?>