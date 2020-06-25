<?php include ("server.php");
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
    <title>Home</title>
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
    <div class="intro">
      <h1>Welcome to InviteUs!</h1>
      <p>On this website, you can</p>
      <ul>
        <li>Create and send custom invites</li>
        <li>Receive invitations from other users</li>
        <li>Accept or deny invitations you receive</li>
        <li>View invites sent by you</li>
      </ul>
      <p>..and much more! To begin, choose your relevant option in the navigation bar.</p>
    </div>

  </body>
</html>
