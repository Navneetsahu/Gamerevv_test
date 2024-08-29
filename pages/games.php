<?php
include '../includes/header.php'; // Assuming you have a header.php for the navbar and common header elements
include '../includes/db.php'; // Include your database connection

// Fetch all games from the database
$sql = "SELECT id, name, description, thumbnail FROM games";
$result = $conn->query($sql);
$games = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

// Check if a specific game is selected
$selected_game = null;
if (isset($_GET['id'])) {
    $game_id = $_GET['id'];
    $sql = "SELECT * FROM games WHERE id = '$game_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $selected_game = $result->fetch_assoc();
    }
}
?>

<link rel="stylesheet" href="/Game_web/css/games.css">

<div class="games-container">
    <!-- List of Games -->
    <div class="games-list">
        <h2>All Games</h2>
        <ul>
            <?php foreach ($games as $game): ?>
                <li>
                    <a href="games.php?id=<?php echo $game['id']; ?>">
                        <img src="/Game_web/uploads/<?php echo $game['thumbnail']; ?>" alt="<?php echo $game['name']; ?>">
                        <span><?php echo $game['name']; ?></span>
                    </a>
                    <!-- Link to Review the Game -->
                    <a href="review.php?game_id=<?php echo $game['id']; ?>">Review this game</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Game Details -->
    <div class="game-details">
        <?php if ($selected_game): ?>
            <h2><?php echo $selected_game['name']; ?></h2>
            <img src="../uploads/<?php echo $selected_game['thumbnail']; ?>" alt="<?php echo $selected_game['name']; ?>">
            <p><?php echo $selected_game['description']; ?></p>
            <!-- Link to Review the Selected Game -->
            <a href="review.php?game_id=<?php echo $selected_game['id']; ?>" class="review-link">Submit a Review for this Game</a>
        <?php else: ?>
            <p>Please select a game to view its details.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>





