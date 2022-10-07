<?php
namespace Tests\Post;
use PHPUnit\Framework\TestCase;

class Database extends TestCase {

    public function account($username, $password): string {
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

        if (strpos($result, "Student"))
            return "student";
        else if (strpos($result, "Teacher"))
            return "teacher";
        else 
            return "invalid";
    }

    public function test_student(): void {
        $result = $this->account("student", "password");
        $actual = "student";
        $this->assertEquals($result, $actual);
        printf("Result = " . $result . " Actual = " . $actual . "\n");
    }

    public function test_teacher(): void {
        $result = $this->account("teacher", "password");
        $actual = "teacher";
        $this->assertEquals($result, $actual);
        printf("Result = " . $result . " Actual = " . $actual . "\n");
    }

    public function test_invalid_login(): void {
        $result = $this->account("invalid", "password");
        $actual = "invalid";
        $this->assertEquals($result, $actual);
        printf("Result = " . $result . " Actual = " . $actual . "\n");
    }

    public function test_no_input(): void {
        $result = $this->account("", "");
        $actual = "invalid";
        $this->assertEquals($result, $actual);
        printf("Result = " . $result . " Actual = " . $actual . "\n");
    }
}
?>