<?php
include 'includes/db.php';

$games = [];
$search = '';
$reviews = [];

// Fetch games based on search input or fetch all games
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM games WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

// Fetch all games from the database
$sql = "SELECT id, name, description, thumbnail FROM games";
$result = $conn->query($sql);
$games = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

// Fetch all reviews for display
$sql = "SELECT reviews.*, users.username, games.name as game_name
        FROM reviews
        JOIN users ON reviews.user_id = users.id
        JOIN games ON reviews.game_id = games.id
        ORDER BY reviews.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEREVV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="/Game_web/index.php">GAMEREVV</a>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="/Game_web/index.php">HOME</a></li>
                <li><a href="/Game_web/pages/games.php">GAMES</a></li>
                <li><a href="/Game_web/pages/review.php">REVIEWS</a></li>
                <li><a href="/Game_web/pages/about.php">ABOUT</a></li>
            </ul>
        </div>
        <div class="auth-links">
            <a href="/Game_web/pages/login.php">Login</a>
            <a href="/Game_web/pages/signup.php">Signup</a>
        </div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- PHP for dynamic content can go here -->


    <?php
include 'includes/db.php';

$games = [];
$search = '';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM games WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games[] = $row;
        }
    }
} else {
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games[] = $row;
        }
    }
}
?>

 
    <div class="search-container">
        <form method="post" action="/Game_web/index.php">
            <input type="text" name="search" placeholder="Search for a game..." value="<?php echo $search; ?>" class="search-bar">
            <button type="submit">Search</button>
        </form>
    </div>

       <!-- Game Cards Section -->
       <div class="game-grid">
        <?php foreach ($games as $game): ?>
            <div class="game-card">
                <img src="uploads/<?php echo $game['thumbnail']; ?>" alt="<?php echo $game['name']; ?>">
                <h2><?php echo $game['name']; ?></h2>
                <p><?php echo $game['description']; ?></p>
                <p><strong>Type:</strong> <?php echo $game['type']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- User Reviews Section -->
    <div class="reviews-section">
        <h2>User Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <h3><?php echo $review['username']; ?> reviewed <strong><?php echo $review['game_name']; ?></strong></h3>
                    <p><?php echo $review['review_text']; ?></p>
                    <small><?php echo $review['created_at']; ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>
    <?php include 'includes/footer.php';
    ?>
 
      
    <script src="Game_web/js/Script.js"></script>
        </body>
        </html>  
    

 
