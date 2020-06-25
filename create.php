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
    <title>Create an invite!</title>
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
      <a href="create.php?logout=1"><div class="option">Logout</div></a>
    </div>

    <!-- creating an invite -->
    <h1 class = "center-align"><strong>Create an invitation</strong></h1>
    <?php
if (isset($_SESSION['created'])): ?>
    <div class="warning">
      Invite created.
    </div>
    <?php
    unset($_SESSION['created']);
endif
?>
    <br>
    <?php if ($errors > 0): ?>
          <div class="warning">
            <?php foreach ($errors as $error): ?>
              <p><?php echo $error; ?></p>
            <?php
    endforeach ?>
          </div>
        <?php
endif ?>
    <form class="create-form" action="create.php" method="post">
      <div class="form-entry">
        <label for="date">Date* </label>
        <input type="date" name="date" value='<?php echo $date; ?>' required>
        <br>
      </div>
      <br>

      <div class="form-entry">
        <label for="day">Day </label>
        <input type="text" name="day" value='<?php echo $day; ?>'>
        <br>
      </div>
      <br>

      <div class = "form-entry">
        <label for="time">Time (24h Format)* </label>
        <input type="time" name="time" value='<?php echo $time; ?>' required>
      </div>
      <br>

      <div class="form-entry">
        <label for="venue">Venue* </label>
        <input type="text" name="venue" value='<?php echo $venue; ?>' required>
      </div>
      <br>

      <div class="form-entry">
        <label for="head">Header* </label>
        <textarea name="head" rows="8" cols="80" required><?php echo $head; ?></textarea>
      </div>
      <br>

      <div class="form-entry">
        <label for="body">Body* </label>
        <textarea name="body" rows="8" cols="80" required><?php echo $body; ?></textarea>
      </div>
      <br>

      <div class="form-entry">
        <label for="foot">Footer </label>
        <textarea name="foot" rows="8" cols="80"><?php echo $foot; ?></textarea>
      </div>
      <br>

      <div class="form-entry">
        <label for="mode">Invite mode* </label>
        <input type="radio" name="mode" value="public">
        <label for="nature">Public</label>
        <input type="radio" name="mode" value="private">
        <label for="nature">Private</label>
      </div>
      <br>

      <br>
      <button type="submit" name="create-btn" class="myButton">Create</button>
    </form>
  </body>
</html>
