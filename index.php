<?php
session_start();
require_once('mysqli_connect.php');

// Aggregate stats for the hero stat bar
$agg = mysqli_fetch_assoc(mysqli_query($dbc,
  "SELECT COUNT(*) AS total_players,
          MAX(k_d) AS top_kd,
          MAX(bp_rating) AS top_bp
   FROM cdl_overall_stats"
));

// Top 3 players by BP rating for the featured section
$top_players = mysqli_query($dbc,
  "SELECT p.player_name, t.team_name, o.k_d, o.bp_rating, o.slayer_rating
   FROM cdl_overall_stats o
   JOIN cdl_players p ON p.player_id = o.player_id
   JOIN cdl_teams t ON t.team_id = p.team_id
   ORDER BY o.bp_rating DESC
   LIMIT 3"
);

include('includes/header.php');
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <p class="hero-eyebrow">Call of Duty League &mdash; Player Analytics</p>
    <h1>DOMINATE.<br><em>TRACK.</em><br>IMPROVE.</h1>
    <p class="hero-sub">
      Log your match stats, get personalized recommendations based on your KD and slayer rating,
      and see how you stack up against the best players in the league.
    </p>
    <div class="hero-actions">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
      <?php else: ?>
        <a href="register.php" class="btn btn-primary">Get Started</a>
        <a href="login.php" class="btn btn-secondary">Login</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Live stats pulled from the database -->
  <div class="hero-statbar">
    <div class="hero-statbar-inner">
      <div class="hero-stat">
        <div class="hero-stat-label">Players Tracked</div>
        <div class="hero-stat-value"><?= $agg['total_players'] ?></div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-label">Top KD Ratio</div>
        <div class="hero-stat-value"><?= number_format($agg['top_kd'], 2) ?></div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-label">Top BP Rating</div>
        <div class="hero-stat-value"><?= number_format($agg['top_bp'], 2) ?></div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-label">Game Modes</div>
        <div class="hero-stat-value">HP &amp; SND</div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-section">
  <div class="features-section-inner">
    <p class="section-label">What You Can Do</p>
    <h2 class="section-title">Built for Competitors</h2>
    <div class="features">
      <div class="feature-card">
        <div class="feature-num">01</div>
        <h2>Log Match Stats</h2>
        <p>Record kills, deaths, and scores for Hardpoint and Search &amp; Destroy after every series.</p>
      </div>
      <div class="feature-card">
        <div class="feature-num">02</div>
        <h2>Get Recommendations</h2>
        <p>Receive personalized tips based on your KD ratio, slayer rating, and BP rating to sharpen your game.</p>
      </div>
      <div class="feature-card">
        <div class="feature-num">03</div>
        <h2>Compare Players</h2>
        <p>Pull up any player's stats and go head-to-head &mdash; find the edge before the match starts.</p>
      </div>
    </div>
  </div>
</section>

<!-- TOP PLAYERS (dynamic from DB) -->
<section class="players-section">
  <div class="players-section-inner">
    <p class="section-label">Leaderboard</p>
    <h2 class="section-title">Top Rated Players</h2>
    <div class="players-grid">
      <?php $rank = 1; while ($player = mysqli_fetch_assoc($top_players)): ?>
      <div class="player-card">
        <div class="player-rank"># <?= $rank++ ?> BP Rating</div>
        <div class="player-name"><?= htmlspecialchars($player['player_name']) ?></div>
        <div class="player-team"><?= htmlspecialchars($player['team_name']) ?></div>
        <div class="player-stats">
          <div>
            <div class="player-stat-label">BP Rating</div>
            <div class="player-stat-val"><?= number_format($player['bp_rating'], 2) ?></div>
          </div>
          <div>
            <div class="player-stat-label">K/D</div>
            <div class="player-stat-val"><?= number_format($player['k_d'], 2) ?></div>
          </div>
          <div>
            <div class="player-stat-label">Slayer</div>
            <div class="player-stat-val"><?= number_format($player['slayer_rating'], 1) ?></div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php
mysqli_close($dbc);
include('includes/footer.php');
?>
