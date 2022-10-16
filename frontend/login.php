<!DOCTYPE html>
<html lang="en">
    <head>
         <title>Login Page</title>
    </head>
    <body>
        <form name = "loginForm" method = "post" action = "verifyLogin.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>
