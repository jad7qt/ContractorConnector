<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard(allow_cust: false);
require_once MODELS_DIR . 'acceptJob-db.php';
require_once MODELS_DIR . 'createProject-db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Administrator') {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Assign Tech")) {
    acceptJob($_POST['techid'], $_POST['projid']);
    header("Location: homepage");
    exit();
  }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Type'] == 'Technician') {
  header("Location: assignTech?error=Only Admins can assign Technicians");
}
?>

<?php
$projid = $_GET['id'];
$Techs = array();
$Techs = selectAllTechs();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jared Dutt">
  <meta name="description" content="Page to create a new project for customer view">

  <title>Assign Technician</title>
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
      <h1 class="title-content">Assign a Technician to Project</h1>
    </div>
    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form name="mainForm" action="assignTech" method="post">
      <div id="liner"></div>
      <div class="row mb-3 mx-3">
        Technician to Assign:
        <select id="techid" style="width:550px" name="techid" class="form-control" required>
          <?php foreach ($Techs as $item): ?>
            <option value="<?php echo $item['UserID']; ?>">
              <?php echo $item['FirstName'] . " " . $item['LastName'] . " (" . $item['Username'] . ")"; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="hidden" name="projid" value="<?php echo $projid; ?>" />
      <div id="liner"></div>
      <div class="button-form-layout">
        <button type="button" class="btn btn-grey" onclick="window.location.href='homepage';" name="actionBtn">Back</button>
        <button type="submit" class="btn btn-red" name="actionBtn" value="Assign Tech" title="class to assign Tech">Assign Tech</button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
ob_end_flush();
?>