<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Page</title>
        <link rel="Stylesheet" href="./style/login.css?<?php echo time();?>"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"> 
    </head>
    <body onLoad="noBack();">
        <script type="text/javascript">
            window.history.forward();
            function noBack() { window.history.forward(); }
        </script>
        <div class="left">
            <div class="header">
                <h2 id="title">CS 490</h2>
                <h3 id="semester">Fall 2022</h3>
                <img src="./assets/njit.png" alt="NJIT LOGO">
                <h4>Shane Arcaro, Malcolm Shuler, Ege Atay</h4>
            </div>
        </div>
        <div class="right">
            <div class="loginBox">
                <h2>Log in</h2>
                <form name = "loginForm" autocomplete="off" method = "post" action = "./src/frontend/post/sendLogin.php">
                    <label class="label" for="username">Username</label><br>
                    <input class="input" type="text" id="username" name="username" placeholder="Username" required><br>
                    <label class="label" for="password">Password</label><br>
                    <input class="input"type="password" id="password" name="password" placeholder="Password" required><br>
                    <input type="submit" id="submit" name="submit" value="Login">
                </form>
            </div>
        </div>
    </body>
</html>
