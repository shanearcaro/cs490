<!DOCTYPE html>
<html lang="en">
    <head>
         <title>Login Page</title>
    </head>
    <body>
        <!-- Need to use send.php to cURL the information instead of standards post -->
        <form name = "loginForm" method = "post" action = "send.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
    
</html>
