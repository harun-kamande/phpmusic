<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('backgrounddesigns/backgroundimage.png');
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .registration-form {
      background-color: grey;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      text-align: center;
    }
    .registration-form h5 {
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
    }
    .form-group input[type="text"], 
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
    .message {
      margin-bottom: 20px;
      font-size: 16px;
      color: green;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="registration-form" style="background-color:red;">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" name="register" value="Register">
      </div>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD']=='POST') {
        $user_name = $_POST['username'];
        $email = $_POST['email'];
        $user_password = $_POST['password'];

        $host = "localhost";
        $username = "root";
        $password = "harunkamande";
        $dbname = "music_hitts";

        // Create db connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check db connection
        if($conn) {
            // Prepare SQL query to insert user details
            $sql = "INSERT INTO users(user_name, email, password) VALUES('$user_name', '$email', '$user_password')";
            $results = mysqli_query($conn, $sql);

            if($results) {
                echo "<p class='message'>Successfully Registered!</p>";
            } else {
                echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
            }

            // Close the connection
            $conn->close();
        } else {
            die("<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>");
        }
    }
    ?>

		You have an account? <a href="login.php">login!</a>
  </div>
</body>
</html>
