<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard(allow_cust: false, allow_tech: false);
require_once MODELS_DIR . 'customer-db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Administrator') {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Technician")) {
    if (usernameTaken($_POST['username'])) {
      header("Location: addTechnician?error=Username is already taken");
      exit();
    } else {
      addUser($_POST['username'], $_POST['password'], $_POST['type'], $_POST['fname'], $_POST['lname']);
      addTechnician($_POST['username'], $_POST['occupation-type']);
      header("Location: homepage");
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Add Technician</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/public/images/db-icon.png" />
  <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
  <link rel="stylesheet" href="<?= CSS_PATH ?>addTechnician.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <img src="<?= IMG_PATH ?>logos/logo_blank.png" alt="Logo" class="logo">
      <h1 class="site-title">Create Technician</h1>
    </div>
    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form name="mainForm" action="addTechnician" method="post">
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
      <div id="Occupation">
        Occupation Type:
      </div>
      <div class="row mb-3 mx-3">
        Occupation:
        <input type="text" class="form-control" name="occupation-type" maxlength=18 required />
      </div>
      <input type="hidden" name="type" value="Technician" />
      <div id="button-layout">
        <input id="buttonCreateTechnician" type="submit" class="btn btn-primary" name="actionBtn"
          value="Create Technician" title="class to add Technician/User" />
        <button type="button" onclick="window.location.href='homepage';" name="actionBtn" value="Back">Back</button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
ob_end_flush();
?>