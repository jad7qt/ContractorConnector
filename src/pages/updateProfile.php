<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'customer-db.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update Profile")) {
    if (usernameTaken($_POST['username']) && newUsernameTaken($_POST['username'])['UserID'] != $_SESSION['UserID']) {
      header("Location: updateprofile?error=Username is already taken");
      exit();
    }
    if ($_SESSION['Type'] == 'Administrator') { // Admin
      updateUser($_SESSION['UserID'], $_POST['username'], $_POST['fname'], $_POST['lname']);
      updateAdmin($_SESSION['UserID'], $_POST['st'], $_POST['city'], $_POST['state'], $_POST['zip']);

    } elseif ($_SESSION['Type'] == 'Technician') { // Technician
      updateUser($_SESSION['UserID'], $_POST['username'], $_POST['fname'], $_POST['lname']);

    } else { // Customer type
      updateUser($_SESSION['UserID'], $_POST['username'], $_POST['fname'], $_POST['lname']);
      updateCust($_SESSION['UserID'], $_POST['st'], $_POST['city'], $_POST['state'], $_POST['zip']);
    }

    // RESET SESSION VARIABLES
    global $db;
    $query1 = "SELECT * FROM User WHERE UserID=:userid";
    $statement = $db->prepare($query1);
    $statement->bindValue(':userid', $_SESSION['UserID']);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    $_SESSION['Username'] = $result[0]['Username'];
    $_SESSION['FirstName'] = $result[0]['FirstName'];
    $_SESSION['LastName'] = $result[0]['LastName'];
    $_SESSION['UserID'] = $result[0]['UserID'];
    $_SESSION['Type'] = $result[0]['Type'];
    header("Location: profile");
    exit();
  }

}
?>

<?php
$address = array();

if ($_SESSION['Type'] == 'Customer') {
  $address = getCustAddressSep($_SESSION['UserID']);
} elseif ($_SESSION['Type'] == 'Administrator') {
  $address = getAdminAddressSep($_SESSION['UserID']);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="include some description about your page">
  <title>Update Profile</title>
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
      <h1 class="title-content">Update Your Profile</h1>
    </div>

    <!-- FORM  -->
    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form name="mainForm" action="updateprofile" method="post">
      <div id="liner"></div>
      <div class="row mb-3 mx-3">
        Username:
        <input type="text" class="form-control" name="username" maxlength=19 value=<?php echo $_SESSION['Username']; ?>
          required />
      </div>
      <div class="row mb-3 mx-3">
        First Name:
        <input type="text" class="form-control" name="fname" maxlength=10 value=<?php echo $_SESSION['FirstName']; ?>
          required />
      </div>
      <div class="row mb-3 mx-3">
        Last Name:
        <input type="text" class="form-control" name="lname" maxlength=10 value=<?php echo $_SESSION['LastName']; ?>
          required />
      </div>
      <div id="liner"></div>

      <?php if ($_SESSION['Type'] == "Customer" || $_SESSION['Type'] == "Administrator") { ?>
        <div id="address">
          Address:
        </div>
        <div class="row mb-3 mx-3">
          Street:
          <input type="text" class="form-control" name="st" value="<?php echo $address['Street']; ?>" maxlength=20
            required />
          City:
          <input type="text" class="form-control" name="city" value="<?php echo $address['City']; ?>" maxlength=25
            required />
          State:
          <input type="text" class="form-control" name="state" value="<?php echo $address['State']; ?>" maxlength=2
            required />
          Zip:
          <input type="text" class="form-control" name="zip" value="<?php echo $address['Zip']; ?>" pattern="\b\d{5}\b"
            required />
        </div>
      <?php } ?>

      <div id="liner"></div>
      <div class="button-form-layout">
        <button type="button" class="btn btn-grey" onclick="window.location.href='profile';" name="actionBtn">Back</button>
        <button type="submit" class="btn btn-red" name="actionBtn" title="Update existing customer data">Update
          Profile</button>
      </div>
    </form>
    <!-- END FORM -->


  </div>
</body>

</html>

<?php
ob_end_flush();
?>