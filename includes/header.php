<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Call of Duty League Stats</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <div class="header-inner">
      <a href="index.php" class="site-title">CDL <span>STATS</span></a>
      <nav>
        <a href="index.php">Home</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a href="dashboard.php">Dashboard</a>
          <a href="stats.php">My Stats</a>
          <a href="compare.php">Compare</a>
          <a href="settings.php">Settings</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="register.php">Register</a>
          <a href="login.php">Login</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <main>
