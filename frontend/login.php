<!DOCTYPE html>
<html lang="en">
    <head>
         <title>Login Page</title>
    </head>
<!-- https://web.njit.edu/~sma237/CS490/middle/validate.php -->
    <body>
        <form name = "loginForm" method = "post" action = "../middle/validate.php">
            <label for="user">Username:</label><br>
            <input type="text" id="user" name="user"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
    
</html>