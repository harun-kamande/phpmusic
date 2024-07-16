<?php
$host = "localhost";
$username = "root";
$password_db = "harunkamande";
$dbname = "music_hitts";

// Create database connection
$conn = new mysqli($host, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user email from the cookie
if (isset($_COOKIE['user'])) {
    $email = $_COOKIE['user'];

    // Fetch the user ID based on the email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
} else {
    die("User not logged in.");
}

if (isset($_POST['upload'])) {
    $music_title = $_POST['music_title'];

    // File upload logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["music_file"]["name"]);
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["music_file"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["music_file"]["name"])). " has been uploaded.";

            // Save file path in the database
            $stmt = $conn->prepare("INSERT INTO music (music_title, music_filepath, user_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $music_title, $target_file, $user_id);

            if ($stmt->execute()) {
                echo "Music file path saved in the database successfully.";
                header("Location: listen.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
