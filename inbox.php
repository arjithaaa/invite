<?php $_SESSION['view'] = "Yes";
include ("server.php");
if (!isset($_SESSION['username']))
{
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inbox</title>
    <link rel="stylesheet" href="style/main.css">
  </head>
  <body>
    <!-- navigation -->
    <div class="navbar">
      <a href="index.php"><h2 class="welcome">Welcome, <?php echo $_SESSION['username']; ?></h2></a>
      <a href="create.php?"><div class="option">Create new</div></a>
      <a href="view.php?view=1"><div class="option">Your Invites</div></a>
      <a href="inbox.php?inbox=1"><div class="option">Inbox</div></a>
      <a href="create.php?logout=1"><div class="option">Logout</div></a>
    </div>

    <!-- inbox  -->
    <div class="sent">
      <h2 class="title">Your Inbox</h2>
      <ul>
        <?php
while ($invite = mysqli_fetch_assoc($res))
{
    echo "<a href = 'dynamic.php?inv_no={$invite['inv_no']}'><li class='display-invites'>{$invite['head']}</li></a>";
}
?>
      </ul>
    </div>
  </body>
</html>
