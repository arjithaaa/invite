<?php include ("server.php");
if (!isset($_SESSION['id']))
{
    header("location: login.php");
    exit();
}

if (!isset($_SESSION['mode']))
{
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create an invite!</title>
    <link rel="stylesheet" href="style/main.css">
  </head>
  <body>
    <!-- navigation -->
    <div class="navbar">
      <a href="index.php"><h2 class="welcome">Welcome, <?php echo $_SESSION['username']; ?></h2></a>
      <a href="create.php?"><div class="option">Create new</div></a>
      <a href="view.php?view=1"><div class="option">Your Invites</div></a>
      <a href="inbox.php?inbox=1"><div class="option">Inbox</div></a>
      <a href="private.php?logout=1"><div class="option">Logout</div></a>
    </div>
    <div class="intro">
      <h1>You have chosen to create a private event!</h1>
      <p>Please enter the usernames of the users to whom you wish to invite </p>
      <form class="invitee-form" action="private.php" method="post">
        <input type="text" name="invitee" required>
        <button type="submit" name="invitee-btn">Add</button>
      </form>
      <?php
if (isset($_SESSION['private'])): ?>
      <div class="warning">
        User added.
      </div>
      <?php
    unset($_SESSION['private']);
endif
?>
      <br>
      <button type="button" name="home" onclick="window.location.href = 'index.php'">Done</button>
  </div>
  </body>
</html>
