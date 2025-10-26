<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard(allow_guests: true, redirect_logged_in: true);
require_once MODELS_DIR . 'customer-db.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['UserID']) && !isset($_SESSION['Username'])) || (isset($_SESSION['Type']) && $_SESSION['Type'] == 'Administrator')) {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Customer")) {
    if (usernameTaken($_POST['username'])) {
      header("Location: addCustomer?error=Username is already taken");
      exit();
    } else {
      addUser($_POST['username'], $_POST['password'], $_POST['type'], $_POST['fname'], $_POST['lname']);
      addCustomer($_POST['username'], $_POST['st'], $_POST['city'], $_POST['state'], $_POST['zip']);
      header("Location: login");
      exit();
    }
  }

}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="include some description about your page">

  <title>Create Account</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="icon" type="image/png" href="<?= IMG_PATH ?>logos/logo_blank.png">
  <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
  <link rel="stylesheet" href="<?= CSS_PATH ?>form.css">
</head>

<body>
  <div class="container">
    <div class="form-header">
      <img src="<?= IMG_PATH ?>logos/logo_blank.png" alt="Logo" class="logo">
      <h1 class="title-content">Welcome to ContractorConnector</h1>
    </div>
    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form name="mainForm" action="addCustomer" method="post">
      <div id="liner"></div>
      <div class="row mb-3 mx-3">
        Username:
        <input type="text" class="form-control" name="username" maxlength=19 required />
      </div>
      <div class="row mb-3 mx-3">
        Password:
        <input type="password" class="form-control" name="password" maxlength=29 required />
      </div>
      <div class="row mb-3 mx-3">
        First Name:
        <input type="text" class="form-control" name="fname" maxlength=10 required />
      </div>
      <div class="row mb-3 mx-3">
        Last Name:
        <input type="text" class="form-control" name="lname" maxlength=10 required />
      </div>
      <div id="liner"></div>
      <div id="address">
        Address:
      </div>
      <div class="row mb-3 mx-3">
        Street:
        <input type="text" class="form-control" name="st" maxlength=20 required />
        City:
        <input type="text" class="form-control" name="city" maxlength=25 required />
        State:
        <input type="text" class="form-control" name="state" maxlength=2 required />
        Zip:
        <input type="text" class="form-control" name="zip" pattern="\b\d{5}\b" required />
      </div>
      <input type="hidden" name="type" value="Customer" />
      <div id="liner"></div>
      <div class="button-form-layout">
        <button type="button" class="btn btn-grey" onclick="window.location.href='login';" name="actionBtn">Back</button>
        <button type="submit" class="btn btn-red" name="actionBtn" title="class to add Customer/User">Create Customer</button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
ob_end_flush();
?>