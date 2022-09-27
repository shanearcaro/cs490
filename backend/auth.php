<?php
include("credentials.php");
$conn = new mysqli('sql2.njit.edu', 'ea353', 'Password1', 'ea353');

$user_data = file_get_contents('php://input');

$username = $userdata['middle_user'];
$password = $userdata['middle_pass'];

$sql = "SELECT id, username, password, isteacher FROM Users where username = \"". $username . "\"";

$result = $conn->query($sql);

$size = count(mysqli_fetch_array($result));
$out = json_encode($result);
if ($size == 0){
  $out == json_encode(404);
}
echo $out;
$conn->close();
?>