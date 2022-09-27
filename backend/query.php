<?php

    $user_data = file_get_contents('php://input');
    echo $user_data;

    // User data might need to be decoded here
?>