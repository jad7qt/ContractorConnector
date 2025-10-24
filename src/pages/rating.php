<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'rating-db.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "rate")) {
    // rates($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
    rateTech($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
    $id = $_POST['TechID'];
    header("Location: profile?id=$id");
    exit();
  } elseif (!empty($_POST['actionBtn']) && $_POST['actionBtn'] == 'updateRate') {
    updateRateTech($_SESSION['UserID'], $_POST['TechID'], $_POST['rating'], $_POST['comment']);
    $id = $_POST['TechID'];
    header("Location: profile?id=$id");
    exit();
  } elseif (!empty($_POST['actionBtn']) && $_POST['actionBtn'] == 'deleteRate') {
    deleteRateTech($_SESSION['UserID'], $_POST['TechID']);
    $id = $_POST['TechID'];
    header("Location: profile?id=$id");
    exit();
  }
}

?>


<?php
ob_end_flush();
?>