<?php
session_start();

//conn to database
$db = mysqli_connect("localhost", "root", "", "delta") or die("Can't connect");
$errors = array();
$username = "";

//sign up
if (isset($_POST['signup-btn']))
{
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $confirm = mysqli_real_escape_string($db, $_POST['confirm']);

    //check for errors during entry
    if (empty($username)) $errors['username'] = "Username required";
    if (empty($email)) $errors['email'] = "Email ID required";
    if (empty($password)) $errors['password'] = "Password required";
    if ($confirm != $password) $errors['mismatch'] = "Password does not match";

    $query = "SELECT * FROM user WHERE email=? OR username=?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "ss", $email, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        if ($user)
        {
            if ($user['email'] == $email) $errors['email_exist'] = "You have already registered with this email ID";
            if ($user['username'] == $username) $errors['username_exist'] = "This username already exists. Please enter a different one.";
        }
    }

    //register a user
    if (count($errors) == 0)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username,email,password) VALUES (?,?,?);";

        $stmt = mysqli_stmt_init($db);

        if (!mysqli_stmt_prepare($stmt, $query))
        {
            echo "FAILED";
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
            mysqli_stmt_execute($stmt);
            $_SESSION['message'] = "Signed in";

            header("location: login.php");
            exit();
        }
    }
}

//login
if (isset($_POST['login-btn']))
{
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //check error
    if (empty($username)) $errors['username'] = "Username required";
    if (empty($password)) $errors['password'] = "Password required";

    //log the user in
    if (count($errors == 0))
    {
        $query = "SELECT * FROM user WHERE username=?";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $query))
        {
            echo "FAILED";
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            if ($user)
            {
                if (password_verify($password, $user['password']))
                {
                    $_SESSION['message'] = "Logged in";
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $user['id'];

                    header("location: index.php");
                    exit();
                }
                else
                {
                    $errors['cred'] = "Wrong credentials. Please try again.";
                }
            }
        }
    }
}

//logout
if (isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['message']);
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['created']);
    unset($_SESSION['mode']);
    unset($_SESSION['private']);
    header("location: login.php");
    exit();
}

//create an invite
$date = "";
$day = "";
$time = "";
$venue = "";
$head = "";
$body = "";
$foot = "";
$mode = "";

if (isset($_POST['create-btn']))
{

    unset($_SESSION['date']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);
    unset($_SESSION['venue']);
    unset($_SESSION['head']);
    unset($_SESSION['body']);
    unset($_SESSION['foot']);

    $date = mysqli_real_escape_string($db, $_POST['date']);
    $day = mysqli_real_escape_string($db, $_POST['day']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $venue = mysqli_real_escape_string($db, $_POST['venue']);
    $head = mysqli_real_escape_string($db, $_POST['head']);
    $body = mysqli_real_escape_string($db, $_POST['body']);
    $foot = mysqli_real_escape_string($db, $_POST['foot']);
    $mode = mysqli_real_escape_string($db, $_POST['mode']);

    //check reqd fields
    if (empty($date)) $errors['date'] = "Date is required";
    if (empty($time)) $errors['time'] = "Time is required";
    if (empty($head)) $errors['head'] = "Header is required";
    if (empty($body)) $errors['body'] = "Body is required";
    if (empty($venue)) $errors['venue'] = "Venue is required";
    if (empty($mode)) $errors['mode'] = "Please select invite mode";

    if (count($errors) == 0)
    {
        $_SESSION['date'] = $date;
        $_SESSION['day'] = $day;
        $_SESSION['time'] = $time;
        $_SESSION['venue'] = $venue;
        $_SESSION['head'] = $head;
        $_SESSION['body'] = $body;
        $_SESSION['foot'] = $foot;

        $_SESSION['created'] = "Yes";
        if ($mode == "private")
        {
            $_SESSION['mode'] = "private";
            header("location: private.php");
        }
    }

    else
    { //public
        $query = "SELECT MAX(id) from user;";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $query))
        {
            echo "FAILED";
        }
        else
        {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $inv = mysqli_fetch_assoc($result);
            $max_id = $inv['MAX(id)'];
        }
        //send to all
        for ($i = 1;$i <= $max_id;$i++)
        {
            if ($i == $_SESSION['id']) continue;
            else
            {
                $query = "INSERT INTO invites (date,day,time,venue,head,body,foot,sender_id,receiver_id) VALUES (?,?,?,?,?,?,?,?,?);";
                $stmt = mysqli_stmt_init($db);
                if (!mysqli_stmt_prepare($stmt, $query))
                {
                    echo "FAILED";
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "sssssssii", $date, $day, $time, $venue, $head, $body, $foot, $sender_id, $i);
                    mysqli_stmt_execute($stmt);
                    unset($_SESSION['date']);
                    unset($_SESSION['day']);
                    unset($_SESSION['time']);
                    unset($_SESSION['venue']);
                    unset($_SESSION['head']);
                    unset($_SESSION['body']);
                    unset($_SESSION['foot']);

                }
            }
        }
    }
}

if (isset($_POST['invitee-btn']))
{

    //get receiver id
    $receiver_id;
    $invitee = mysqli_real_escape_string($db, $_POST['invitee']);
    $query = "SELECT id FROM user WHERE username=?;";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $invitee);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $receiver = mysqli_fetch_assoc($result);
        $receiver_id = $receiver['id'];
    }

    //insert
    $query = "INSERT INTO invites (date,day,time,venue,head,body,foot,sender_id,receiver_id) VALUES (?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED here";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "sssssssii", $_SESSION['date'], $_SESSION['day'], $_SESSION['time'], $_SESSION['venue'], $_SESSION['head'], $_SESSION['body'], $_SESSION['foot'], $_SESSION['id'], $receiver_id);
        mysqli_stmt_execute($stmt);
        $_SESSION['private'] = "Yes";
    }
}

//your invites
$result;
$accepted;
if (isset($_GET['view']))
{
    //retrieve sent invites
    $_SESSION['view'] = "Viewing";

    $query = "SELECT * FROM invites WHERE sender_id =?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    //retrieve accepted invites
    $query = "SELECT * FROM invites WHERE receiver_id =? AND response='yes';";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $accepted = mysqli_stmt_get_result($stmt);
    }
}

//view invite using dynamic link
$sent;
if (isset($_GET['inv_no']))
{
    if (!isset($_SESSION['view']))
    {
        $_SESSION['inv_no'] = $_GET['inv_no'];
    }
    $query = "SELECT * FROM invites WHERE inv_no=?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "i", $_GET['inv_no']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $sent = mysqli_fetch_assoc($res);
    }

}

//view inbox
$res;
if (isset($_GET['inbox']))
{
    unset($_SESSION['view']);
    $query = "SELECT * FROM invites WHERE receiver_id=? AND response IS NULL;";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
}

//accept or deny invitations
if (isset($_GET['response']))
{
    $query = "UPDATE invites SET response=? WHERE inv_no=?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $query))
    {
        echo "FAILED";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "si", $_GET['response'], $_SESSION['inv_no']);
        mysqli_stmt_execute($stmt);
        header("location:view.php?view=1");
        unset($_SESSION['inv_no']);
    }
}

?>
