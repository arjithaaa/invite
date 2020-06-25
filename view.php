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
    <title>View your invites</title>
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
      <a href="view.php?logout=1"><div class="option">Logout</div></a>
    </div>

    <!-- view your invites  -->
    <div class="sent">
      <h2 class="title">Sent Invites</h2>
      <ul>
        <?php
        $check = "";
while ($inv = mysqli_fetch_assoc($result))
{
    if($inv['head']==$check)continue;
    echo "<a href = 'dynamic.php?inv_no={$inv['inv_no']}'><li class='display-invites'>{$inv['head']}</li></a>";
    $check = $inv['head'];
}
?>
      </ul>
    </div>

    <!-- accepted invites -->
    <div class="accepted">
      <h2 class="title">Accepted Invites</h2>
      <ul>
        <?php
$inv;
while ($inv = mysqli_fetch_assoc($accepted))
{
    echo "<a href = 'dynamic.php?inv_no={$inv['inv_no']}'><li class='display-invites'>{$inv['head']}</li></a>";
}
?>
      </ul>
    </div>




  </body>
</html>
