<?php
namespace Tests\Post;
use PHPUnit\Framework\TestCase;

class Database extends TestCase {
    public function test_connection(): void {
        // Get username and password from Malcolm's login screen and create a data array
        $username = "student";
        $password = "password";

        $data = array('username' => $username, 'password' => $password);

        // Encode the data into JSON format
        $encoded = json_encode($data);

        // Connection for the middle end
        $url = 'https://afsaccess4.njit.edu/~sma237/CS490/middle/validate.php';

        // Initialized a cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

        // Decode the results of sending the data
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
    }
}
?>