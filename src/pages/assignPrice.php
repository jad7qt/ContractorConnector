<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard(allow_cust: false);
require_once MODELS_DIR . 'acceptJob-db.php';
require_once MODELS_DIR . 'createProject-db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SESSION['Type'] == 'Administrator' || $_SESSION['Type'] == 'Technician')) {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Assign Price")) {
    assignPrice($_POST['projid'], $_POST['price']);
    header("Location: payments.php");
    exit();
  }
}

$projid = $_GET['id'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jared Dutt">
  <meta name="description" content="Page to create a new project for customer view">
  <title>Assign Price</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/public/images/db-icon.png" />
  <link rel="stylesheet" href="public/css/addCustomer.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <img src="<?php echo IMG_PATH; ?>/logos/logo_blank.png" alt="Logo" class="logo">
      <h1 class="site-title">Assign Price for Project</h1>
    </div>
    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form name="mainForm" action="assignPrice.php" method="post">
      <div class="row mb-3 mx-3">
        Price to Assign:
        <input type="number" class="form-control" name="price" required />
      </div>
      <input type="hidden" name="projid" value="<?php echo $projid; ?>" />
      <div id="button-layout">
        <input id="buttonAssignPrice" type="submit" class="btn btn-primary" name="actionBtn" value="Assign Price"
          title="class to assign Price" />
        <button id="backBtn" type="button" onclick="window.location.href='payments.php';" name="actionBtn"
          value="Back">Back
        </button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
ob_end_flush();
?>