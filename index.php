<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Page</title>
        <link rel="Stylesheet" href="./style/login.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
    </head>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script>
        <div class="login">
            <!-- Need to use send.php to cURL the information instead of standards post -->
            <form name = "loginForm" method = "post" action = "./src/frontend/post/sendLogin.php">
                <h1>Login</h1>
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" placeholder="Type your username"><br>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Type your password"><br>
                <input type="submit" id="submit" name="submit" value="Submit">
            </form>
        </div>
    </body>
    
</html>
