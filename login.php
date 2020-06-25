<?php include ("server.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="style/styles.css">
  </head>
  <body>
    <div class="form-box">
      <h2 class = "center-align">Login</h2>
      <?php if ($errors > 0): ?>
        <div class="warning">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li>
                <?php echo $error; ?>
              </li>
            <?php
    endforeach ?>
          </ul>
        </div>
        <?php
endif ?>
      <form class="login" action="login.php" method="post">
        <div class="form-entry">
          <label for="username">Username </label>
          <input type="text" name="username" required>
        </div>
        <br>

        <div class="form-entry">
          <label for="password">Password </label>
          <input type="password" name="password" required>
        </div>

        <br>
        <button type="submit" name="login-btn">Login</button>
        <p class="center-align">Not a user?<a href="signup.php"> Sign up!</a></p>
      </form>
    </div>

  </body>
</html>
