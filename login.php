<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url("backgrounddesigns/backgroundimage.png");
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-form {
      background-color: grey;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      text-align: center;
    }
    .login-form h5 {
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
    }
    .form-group input[type="email"], 
    .form-group input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .form-group input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .form-group input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="login-form" style="background-color:red;">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" name="login" value="Login">
      </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get email and password from POST request
        $email = $_POST['email'];
        $user_password = $_POST['password'];

        // Database connection details
        $host = "localhost";
        $username = "root";
        $password_db = "harunkamande";
        $dbname = "music_hitts";

        // Create db connection
        $conn = new mysqli($host, $username, $password_db, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        // Prepare SQL query to retrieve user details
        $sql = "SELECT email FROM users WHERE email='$email' and password='$user_password'";
        $result = $conn->query($sql);

        // Check if the query returned any results
        if ($result->num_rows > 0) {
            // Set a cookie with the user's email, valid for 30 days
            setcookie("user", $email, time() + (60 * 60 * 24 * 30), "/");

            // User found, redirect to home page
            header("location: home.html");
            exit();
        } else {
            // User not found, display an error message
            echo "<p>Invalid credentials, please try again</p>";
        }

        // Close the database connection
        $conn->close();
    }
    ?>
    You don't have an account? <a href="register.php">Create now!</a>
  </div>
</body>
</html>
