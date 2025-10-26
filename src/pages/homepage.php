<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'homepage-db.php';

$user_id = $_SESSION['UserID'];
$user_type = $_SESSION['Type'];

$projects = array();
$prev_projects = array();
$unassigned = array();
$amount_owed = 0;
$project_section_title = "Your Current Projects";
$history_section_title = "Your Previous Projects";

switch ($user_type) {
  case 'Administrator':
    $projects = getAdminProjs();
    $unassigned = getUnassigned();
    $table2 = $unassigned;
    $project_section_title = "Recently Added Projects";
    $history_section_title = "Unassigned Projects";
    break;
  case 'Technician':
    $projects = getTechProjs($user_id);
    $unassigned = getUnassigned();
    $table2 = $unassigned;
    $project_section_title = "Your Current Jobs";
    $history_section_title = "Unassigned Projects";
    break;
  case 'Customer':
    $projects = getCustProjs($user_id, 0);
    $prev_projects = getCustProjs($user_id, 1);
    $table2 = $prev_projects;
    $amount_owed = getAmountOwed($user_id);
    $project_section_title = "Your Current Projects";
    $history_section_title = "Your Previous Projects";
    break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ContractorConnector</title>
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

<div class="search-container">
  <form class="search-bar-form" action="searchResults" method="POST">
    <label for="occupation-type">Search for a <b>Local Technician</b></label>
    <div class="search-bar">
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Occupation">
      <button class="btn btn-red" type="submit">
        <img class="invert-icon" src="<?= IMG_PATH ?>icons/search.png" alt="Search">
      </button>
    </div>
  </form>
</div>

<?php if ($_SESSION['Type'] == 'Customer'): ?>
  <!-- Customer-specific balance section -->
  <div class="results-container">
    <h3>Total Outstanding Balance</h3>
    <div class="amount-owed">
      <?php echo '$' . number_format((float) $amount_owed, 2); ?>
    </div>
  </div>
<?php endif; ?>

<div class="results-container">
  <h3><?php echo $project_section_title; ?></h3>

  <?php if (count($projects) > 0): ?>
    <table>
      <thead>
        <tr>
          <th> Details </th>
          <?php if ($user_type != 'Customer'): ?>
            <th>Customer Name</th>
          <?php endif; ?>
          <th>Project Type</th>
          <th>Description</th>
          <th>Project Address</th>
          <th>Start Date</th>
          <th>End Date</th>
          <?php if ($user_type != 'Technician'): ?>
            <th>Technician Name</th>
          <?php endif; ?>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projects as $item): ?>
          <tr>
            <td class="icon-td">
              <a href="projectDetails?id=<?php echo $item['ProjectID']; ?>">
                <img class="icon-md" src="<?= IMG_PATH ?>icons/info.png" alt="Project Info">
              </a>
            </td>
            <?php if ($user_type != 'Customer'): ?>
              <td><?php echo $item['Customer_Name']; ?></td>
            <?php endif; ?>
            <td><?php echo $item['JobType']; ?></td>
            <td><?php echo $item['Description']; ?></td>
            <td><?php echo $item['Project_Address']; ?></td>
            <td><?php echo $item['StartDate']; ?></td>
            <td><?php echo $item['EndDate']; ?></td>
            <?php if ($user_type != 'Technician'): ?>
              <td><?php echo $item['Technician_Name']; ?></td>
            <?php endif; ?>
            <td class="icon-td">
              <?php if ($item['Completed'] == "1"): ?>
                <img class="icon-md" src="<?= IMG_PATH ?>icons/check.png" alt="Completed">
              <?php else: ?>
                <img class="icon-md" src="<?= IMG_PATH ?>icons/ongoing.png" alt="Ongoing">
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-results">No Projects Found</p>
  <?php endif; ?>
</div>

<div class="results-container">
  <h3><?php echo $history_section_title; ?></h3>
  <?php if (count($table2) > 0): ?>
    <table>
      <thead>
        <tr>
          <th> Details </th>
          <?php if ($user_type != 'Customer'): ?>
            <th>Customer Name</th>
          <?php endif; ?>
          <th>Project Type</th>
          <th>Description</th>
          <th>Project Address</th>
          <th>Start Date</th>
          <th>End Date</th>
          <?php if ($user_type == 'Customer'): ?>
            <th>Technician Name</th>
          <?php elseif ($user_type == 'Administrator'): ?>
            <th>Accept Job</th>
          <?php endif; ?>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($table2 as $item): ?>
          <tr>
            <td class="icon-td">
              <a href="projectDetails?id=<?= $item['ProjectID'] ?>">
                <img class="icon-md" src="<?= IMG_PATH ?>icons/info.png" alt="info">
              </a>
            </td>
            <?php if ($user_type != 'Customer'): ?>
              <td><?php echo $item['Customer_Name']; ?></td>
            <?php endif; ?>
            <td><?php echo $item['JobType']; ?></td>
            <td><?php echo $item['Description']; ?></td>
            <td><?php echo $item['Project_Address']; ?></td>
            <td><?php echo $item['StartDate']; ?></td>
            <td><?php echo $item['EndDate']; ?></td>
            <?php if ($user_type == 'Customer'): ?>
              <td><?php echo $item['Technician_Name']; ?></td>
            <?php elseif ($user_type == 'Administrator'): ?>
              <td class="icon-td">
                <a href="assignTech?id=<?= $item['ProjectID'] ?>">
                  <img src="<?= IMG_PATH ?>icons/signup.png" alt="Assign Technician" width="40" height="40">
                </a>
              </td>
            <?php endif; ?>
            <td class="icon-td">
              <?php if ($item['Completed'] == "1"): ?>
                <img class="icon-md" src="<?= IMG_PATH ?>icons/check.png" alt="Completed">
              <?php else: ?>
                <img class="icon-md" src="<?= IMG_PATH ?>icons/ongoing.png" alt="Ongoing">
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-results">No Projects Found</p>
  <?php endif; ?>
</div>

</html>

<?php
ob_end_flush();
?>