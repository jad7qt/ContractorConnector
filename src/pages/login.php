<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard(allow_guests: true, redirect_logged_in: true, allow_admin: false);
require_once MODELS_DIR . 'homepage-db.php';

if (isset($_POST['uname']) && isset($_POST['password']) && !empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Login")) {

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $uname = validate($_POST['uname']);
  $pass = validate($_POST['password']);

  if (isset($_POST['timezone'])) {
    $_SESSION['timezone'] = $_POST['timezone'];
  }

  if (empty($uname)) {

    header("Location: login?error=User Name is required");

    exit();

  } else if (empty($pass)) {

    header("Location: login?error=Password is required");

    exit();

  } else {
    

    global $db;
    $query1 = "SELECT * FROM User WHERE Username=:username";
    $statement = $db->prepare($query1);
    $statement->bindValue(':username', $uname);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    if ($result && password_verify($pass, $result['Password'])) {

      echo "Logged in!";
      $_SESSION['Username'] = $result['Username'];
      $_SESSION['FirstName'] = $result['FirstName'];
      $_SESSION['LastName'] = $result['LastName'];
      $_SESSION['UserID'] = $result['UserID'];
      $_SESSION['Type'] = $result['Type'];

      header("Location: " . BASE_URL . "homepage");

      exit();

    } else {

      header("Location: login?error=Incorect User name or password");

      exit();

    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>login.css">
</head>

<body>
  <header style="position: fixed; left: 0; top: 0; width: 100%;">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center;">
        <img src="<?php echo IMG_PATH; ?>logos/logo_blank.png" alt="ContractorConnections Logo"
          style="max-width: 50px; max-height: 50px; margin-right: 10px;">
        <h1 style="margin: 0;">ContractorConnector</h1>
      </div>
      <nav>
        <ul style="display: flex; align-items: center; justify-content: flex-end; margin: 0;">
          <li><a href="about">About</a></li>
          <li><a href="services">Services</a></li>
          <li><a href="contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <form action="login" method="post">
      <h2>LOGIN</h2>
      <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
      <?php } ?>
      <label>User Name</label>
      <input type="text" name="uname" placeholder="User Name"><br>
      <label>Password</label>
      <input type="password" name="password" placeholder="Password"><br>
      <button class="btnlogin" type="submit" name="actionBtn" value="Login">
        Login <img src="<?php echo IMG_PATH; ?>icons/login.png" alt="Login"
          style="max-width: 20px; max-height: 20px; filter: invert(1); display: inline-block; vertical-align: middle;">
      </button>
      <button id="signUpBtn" type="button" onclick="window.location.href='addCustomer';" name="actionBtn"
        value="SignUp">
        SignUp <img src="<?php echo IMG_PATH; ?>icons/signup.png" alt="SignUp"
          style="max-width: 20px; max-height: 20px; filter: invert(1); display: inline-block; vertical-align: middle;">
      </button>
      <input type="hidden" name="timezone" id="timezoneInput">
    </form>
  </main>

  <footer>
    <div class="container">
      <p>&copy; 2023 ContractorConnector. All Rights Reserved.</p>
    </div>
  </footer>
  <script src="<?php echo JS_PATH; ?>timezone.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>