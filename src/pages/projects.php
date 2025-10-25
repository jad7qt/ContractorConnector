<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'customer-db.php';
require_once MODELS_DIR . 'projects-db.php';

$projects = array();
$type = $_SESSION['Type'];

// Display Projects

// Admin master project table query
if ($type == 'Administrator') {
  $projects = adminMasterTable();
  $table_title = 'Admin Project Master Table';
} elseif ($type == 'Technician') {
  $projects = techProjTable($_SESSION['UserID']);
  $table_title = 'Technician Jobs Table';
} else {
  $projects = custProjTable($_SESSION['UserID']);
  $table_title = 'Customer Projects Table';
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Projects</title>
  <link rel="icon" type="image/png" href="<?= IMG_PATH ?>logos/logo_blank.png">
  <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
  <link rel="stylesheet" href="<?= CSS_PATH ?>projects.css">
</head>


<!--HEADER-->
<?php include COMPONENTS_DIR . 'header.php'; ?>
<!--HEADER-->
<!--hamburger-->
<?php include COMPONENTS_DIR . 'hamburger.php'; ?>
<!--hamburger-->


<div class="results-container">
  <h3><?php echo $table_title; ?></h3>
  <?php if (count($projects) > 0): ?>
    <table>
      <thead>
        <tr>
          <th> Details </th>
          <?php if ($_SESSION['Type'] != 'Customer'): ?>
            <th>Customer Name</th>
          <?php endif; ?>
          <th>Project Type</th>
          <th>Description</th>
          <th>Project Address</th>
          <th>Start Date</th>
          <th>End Date</th>
          <?php if ($_SESSION['Type'] != 'Technician'): ?>
            <th>Technician Name</th>
          <?php endif; ?>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projects as $item): ?>
          <tr>
            <td>
              <a id="detailsRed" href="projectDetails?id=<?php echo $item['ProjectID']; ?>">
                <img src="<?= IMG_PATH ?>icons/info.png" alt="Info" style="max-width: 30px; max-height: 30px;">
              </a>
            </td>
            <?php if ($_SESSION['Type'] != 'Customer'): ?>
              <td><?php echo $item['Customer_Name']; ?></td>
            <?php endif; ?>
            <td><?php echo $item['JobType']; ?></td>
            <td><?php echo $item['Description']; ?></td>
            <td><?php echo $item['Project_Address']; ?></td>
            <td><?php echo $item['StartDate']; ?></td>
            <td><?php echo $item['EndDate']; ?></td>
            <?php if ($_SESSION['Type'] != 'Technician'): ?>
              <td class="techNames">
                <b>
                  <a id="techName" href="profile?id=<?php echo $item['TechnicianID']; ?>">
                    <?php echo $item['Technician_Name']; ?>
                  </a>
                </b>
              </td>
            <?php endif; ?>
            <td>
              <?php if ($item['Completed'] == "1"): ?>
                <img src="<?= IMG_PATH ?>icons/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">
              <?php else: ?>
                <img src="<?= IMG_PATH ?>icons/ongoing.png" alt="Completed"
                  style="max-width: 30px; max-height: 30px;">
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No results found</p>
  <?php endif; ?>

  <?php if ($_SESSION['Type'] == 'Customer'): ?>
    <button id="buttonNewProject" type="button" onclick="window.location.href='createProject'"
      class="btn btn-primary">
      Add a New Project
    </button>
  <?php endif; ?>
</div>

</body>

</html>

<?php
ob_end_flush();
?>