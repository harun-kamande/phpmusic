<?php
$host = "localhost";
$username = "root";
$password_db = "harunkamande";
$dbname = "music_hitts";

// Create database connection
$conn = new mysqli($host, $username, $password_db, $dbname);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in (using cookies)
if (!isset($_COOKIE['user'])) {
    die("User not logged in.");
}

// Retrieve user ID based on the email stored in cookie
$email = $_COOKIE['user'];
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

// Fetch all music files with artist names from the database
$sql = "
    SELECT m.id, m.music_title, u.user_name, m.music_filepath, m.user_id
    FROM music m
    INNER JOIN users u ON m.user_id = u.id
";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listen to Music</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card video,
        .card audio {
            width: 100%;
            margin-top: 10px;
        }

        .delete-form {
            margin-top: 10px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            height: 45px;
            width: 100%;
            background-color: grey;
            padding: 20px 0;
            text-align: center;
            z-index: 1;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            display: inline-block;
            margin-right: 20px;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<header style="background-color:red;">
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="post.html">Upload</a></li>
        <li><a href="listen.php">Libraries</a></li>
    </ul>
</header>
<body>
    <h2>Listen to Music</h2>
    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            $file_path = htmlspecialchars($row['music_filepath']);
            $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            echo "<div class='card'>";
            echo "<h3> Song: " . htmlspecialchars($row['music_title']) . "\n by " . htmlspecialchars($row['user_name']) . "</h3>";
            
            if ($file_type == 'mp3') {
                echo "<audio controls loop>";
                echo "<source src='$file_path' type='audio/mp3'>";
                echo "Your browser does not support the audio element.";
                echo "</audio>";
            } elseif ($file_type == 'mp4') {
                echo "<video controls>";
                echo "<source src='$file_path' type='video/mp4'>";
                echo "Your browser does not support the video element.";
                echo "</video>";
            }

            // Display delete button only if the logged-in user is the owner of the song
            if ($row['user_id'] == $user_id) {
                echo "<form action='delete_music.php' method='post' class='delete-form'>";
                echo "<input type='hidden' name='music_id' value='" . $row['id'] . "'>";
                echo "<input type='submit' name='delete' value='Delete'>";
                echo "</form>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No music files found.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
