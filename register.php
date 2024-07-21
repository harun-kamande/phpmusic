<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMA - Registration</title>
    <style>
        .nav {
            text-align: center;
            padding-right: 20px;
        }
        .bar:hover {
            color: aqua;
            transition: 0.9s;
            font-family: 'Times New Roman', Times, serif;
            font-size: 25px;
        }
        body {
            background-image: url('uploads/background.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        } 
        .Login {
            width: 500px;
            height: 550px;
            margin: 60px auto 0;
            background-color: rgb(59, 2, 57);
            text-align: center;
            padding: 35px;
            border: 3px solid #fff;
            border-radius: 70px 0 70px;
            color: beige;
        }
        .Login h2 {
            margin-bottom: 30px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .Login p {
            text-align: left;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }
        .btn {
            display: block;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: rgba(179, 141, 91, 0.651);
            border-radius: 25px;
            color: #fff;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 20px;
            text-decoration: none;
            letter-spacing: 5px;
        }
        input {
            background: transparent;
            border-top: none;
            width: 100%;
            color: whitesmoke;
            height: 50px;
            border-radius: 30px;
            border-color: white;
        }
        input:hover {
            border-color: blueviolet;
            transition: 1s;
            height: 70px;
        }
        a {
            color: rgb(67, 114, 216);
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1 align="center">NGOMA</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- <div class="nav">
            <a class="bar" href="about us.html" target="about us.html">about us</a>
            <a class="bar" href="Services.html" target="Services.html">Services</a>
            <a class="bar" href="Contact us.html" target="Contact us.html">Contact us.</a>
        </div> -->
        <div class="Login">
            <h2>REGISTER</h2>
            <label for="username">Username</label></br>
            <input type="text" name="username" id="username" required></br>
            <label for="email">Email</label></br>
            <input type="email" name="email" id="email" required></br>
            <label for="password">Password</label></br>
            <input type="password" name="password" id="password" required></br>
            <input type="submit" value="Register">
            <br>
            ALREADY HAVE AN ACCOUNT,
            <a href="login.php" class="reg">Login</a>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user_name = $_POST['username'];
                    $email = $_POST['email'];
                    $user_password = $_POST['password'];

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

                    // Prepare and bind SQL query to insert user details
                    $stmt = $conn->prepare("INSERT INTO users (user_name, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $user_name, $email, $user_password);

                    // Execute and check
                    if ($stmt->execute()) {
                        echo "<p class='message'>Successfully Registered!</p>";
                    } else {
                        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
                    }

                    // Close the statement and the database connection
                    $stmt->close();
                    $conn->close();
                }
            ?>
        </div>
    </form>
</body>
</html>
