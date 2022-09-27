<?php

function getDB(){
    global $db;
    if(!isset($db)) {
        try{
            require_once(__DIR__. "/config.php"); 
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            var_export($e);
            $db = null;
        }
    }
    return $db;
}



$db = getDB();
$stmt = $db->prepare("SELECT username, password from Users 
where username = :username");
try {
    $r = $stmt->execute([":username" => $username]);
    if ($r) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $hash = $user["password"];
            unset($user["password"]);
            if (password_verify($password, $hash)) {

                $_SESSION["user"] = $user; 
                try {

                    $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                    JOIN UserRoles on Roles.id = UserRoles.role_id 
                    where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                    $stmt->execute([":user_id" => $user["id"]]);
                    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all since we'll want multiple
                } catch (Exception $e) {
                    error_log(var_export($e, true));
                }
                //save roles or empty array
                if (isset($roles)) {
                    $_SESSION["user"]["roles"] = $roles; //at least 1 role
                } else {
                    $_SESSION["user"]["roles"] = []; //no roles
                }
                flash("Welcome, " . get_username());
                die(header("Location: shop.php"));
            } else {
                flash("Invalid password");
            }
        } else {
            flash("U not found");
        }
    }
} catch (Exception $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}


?>