<?php
include '../includes/db.php'; // Include your database connection
session_start();

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to write a review.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the game_id from the form
    if (isset($_POST['game_id'])) {
        $game_id = $_POST['game_id'];

        // Check if the game_id exists in the games table
        $check_game = "SELECT id FROM games WHERE id = '$game_id'";
        $game_result = $conn->query($check_game);

        if ($game_result->num_rows > 0) {
            // The game exists, proceed with inserting the review
            $user_id = $_SESSION['user_id']; // Ensure this is set correctly
            $review_text = $conn->real_escape_string($_POST['review_text']); // Sanitize input

            $sql = "INSERT INTO reviews (user_id, game_id, review_text) VALUES ('$user_id', '$game_id', '$review_text')";
            if ($conn->query($sql) === TRUE) {
                echo "Review added successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // The game_id does not exist in the games table
            echo "Error: The game does not exist.";
        }
    } else {
        echo "Error: Game ID is missing.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Review - GAMEREVV</title>
    <link rel="stylesheet" href="../css/review.css">
</head>
<body>
    <div class="review-container">
        <h1>Submit a Review</h1>
        <!-- Your HTML Form -->
<form method="post" action="review.php">
    <input type="hidden" name="game_id" value="<?php echo $selected_game_id; ?>"> <!-- Ensure this is correctly set -->
    <textarea name="review_text" required></textarea>
    <button type="submit">Submit Review</button>
</form>
         
    </div>
</body>
</html>



 
