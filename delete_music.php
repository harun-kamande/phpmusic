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

// Check if delete button is clicked and music_id is set
if (isset($_POST['delete']) && isset($_POST['music_id'])) {
    $music_id = $_POST['music_id'];

    // Fetch music file path from database
    $stmt = $conn->prepare("SELECT music_filepath FROM music WHERE id = ?");
    $stmt->bind_param("i", $music_id);
    $stmt->execute();
    $stmt->bind_result($music_filepath);
    $stmt->fetch();
    $stmt->close();

    // Delete record from the database
    $sql = "DELETE FROM music WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $music_id);

    if ($stmt->execute()) {
        echo "Music file deleted successfully.";

        // Delete file from filesystem
        if (unlink($music_filepath)) {
            echo " File deleted from filesystem.";
        } else {
            echo " Failed to delete file from filesystem.";
        }
    } else {
        echo "Error deleting music file.";
    }

    $stmt->close();
}

$conn->close();
?>
