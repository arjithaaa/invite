<?php include ("server.php");
if (!isset($_SESSION['username']))
{
    header("location: login.php");
    exit();
} ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sent invite</title>
    <link rel="stylesheet" href="style/main.css">
  </head>
  <body>
    <!-- navigation -->
    <div class="navbar">
      <a href="index.php"><h2 class="welcome">Welcome, <?php echo $_SESSION['username']; ?></h2></a>
      <a href="create.php">
        <div class="option">Create new</div>
      </a>
      <a href="view.php?view=1">
        <div class="option">Your Invites</div>
      </a>
      <a href="inbox.php?inbox=1">
        <div class="option">Inbox</div>
      </a>
      <a href="dynamic.php?logout=1"><div class="option">Logout</div></a>
    </div>

    <!-- View invite -->
    <div class="invite-box">
      <div>
        <?php echo "<h3 class='invite-heading'>Date:</h3> {$sent['date']}"; ?>
      </div>
      <br>
      <?php if (!empty($sent['day'])): ?>
      <div>
        <?php echo "<h3 class='invite-heading'>Day:</h3> {$sent['day']}"; ?>
      </div>
      <br>
      <?php
endif; ?>
      <div>
        <?php echo "<h3 class='invite-heading'>Time:</h3> {$sent['time']}"; ?>
      </div>
      <br>
      <div>
        <?php echo "<h3 class='invite-heading'>Venue:</h3> {$sent['venue']}"; ?>
      </div>
      <br>
      <div>
        <?php echo "<h3 class='invite-heading'>Header:</h3> {$sent['head']}"; ?>
      </div>
      <br>
      <div>
        <?php echo "<h3 class='invite-heading'>Body:</h3> {$sent['body']}"; ?>
      </div>
      <br>
      <?php if (!empty($sent['foot'])): ?>
      <div>
        <?php echo "<h3 class='invite-heading'>Footer:</h3> {$sent['foot']}"; ?>
      </div>
      <br>
    <?php
endif; ?>
    </div>
    <br>
    <div class="choice-box">
      <?php if (!isset($_SESSION['view'])): ?>
        <a class="choice" href="dynamic.php?response=yes">Accept</a>
        <a class="choice" href="dynamic.php?response=no">Deny</a>
        <br>
    <?php
endif; ?>
    </div>

  </body>
</html>
