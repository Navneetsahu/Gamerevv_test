<?php
include '../includes/db.php';
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: Game_web/index.php");
    exit();
}

// Add a new game
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_game'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];

    $target_dir = "../uploads/";
    $thumbnail = basename($_FILES["thumbnail"]["name"]);
    $target_file = $target_dir . $thumbnail;
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);

    $sql = "INSERT INTO games (name, description, type, thumbnail) VALUES ('$name', '$description', '$type', '$thumbnail')";
    if ($conn->query($sql) === TRUE) {
        echo "Game added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete a game
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM games WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Game deleted successfully!";
    } else {
        echo "Error deleting game: " . $conn->error;
    }
}

// Fetch all games for display
$games = [];
$sql = "SELECT * FROM games";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - GAMEREVV</title>
    <link rel="stylesheet" href="/Game_web/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel</h1>
        <h2>Add New Game</h2>
        <form method="post" action="/Game_web/pages/admin.php" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Game Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="type" placeholder="Game Type (e.g., RPG, Action)" required>
            <input type="file" name="thumbnail" required>
            <button type="submit" name="add_game">Add Game</button>
        </form>

        <h2>Existing Games</h2>
        <div class="game-grid">
            <?php foreach ($games as $game): ?>
                <div class="game-card">
                    <img src="../uploads/<?php echo $game['thumbnail']; ?>" alt="<?php echo $game['name']; ?>">
                    <h2><?php echo $game['name']; ?></h2>
                    <p><?php echo $game['description']; ?></p>
                    <p><strong>Type:</strong> <?php echo $game['type']; ?></p>
                    <a href="admin.php?delete=<?php echo $game['id']; ?>" class="delete-button">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

