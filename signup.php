<?php include ("server.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style/styles.css">
  </head>
  <body>
    <div class="form-box">
      <h2 class = "center-align">Register</h2>
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

      <form class="reg-form" action="signup.php" method="post">
        <div class="form-entry">
        <label for="username">Username </label>
        <input type="text" name="username" required>
        <br>
      </div>
      <br>

        <div class = "form-entry">
          <label for="email">Email ID  </label>
          <input type="email" name="email" required>
        </div>
        <br>

        <div class="form-entry">
          <label for="password">Password </label>
          <input type="password" name="password" required>
        </div>
        <br>

        <div class="form-entry">
          <label for="confirm">Confirm Password </label>
          <input type="password" name="confirm" required>
        </div>
        <br>
        <button type="submit" name="signup-btn" class="myButton">Sign Up</button>
        <p class = "center-align">Already a user?<a href="login.php"> Login!</a></p>
      </form>
    </div>

  </body>
</html>
