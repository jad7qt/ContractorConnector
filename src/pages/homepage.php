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
  <link rel="stylesheet" href="public/css/homepage.css">
  <link rel="stylesheet" type="text/css" href="public/css/projects.css">
</head>

<!--HEADER-->
<?php include COMPONENTS_DIR . 'header.php'; ?>
<!--HEADER-->
<!--hamburger-->
<?php include COMPONENTS_DIR . 'hamburger.php'; ?>
<!--hamburger-->

<div class="search-container">
  <form action="searchResults.php" method="POST">
    <label for="occupation-type">Search for a <b>Local Technician</b></label>
    <div>
      <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Occupation">
      <button type="submit">
        <img src="public/images/icons/search.png" alt="Search"
          style="max-width: 20px; max-height: 20px; filter: invert(1);">
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
            <td>
              <?php echo '<a href="projectDetails.php?id=' . $item['ProjectID'] . '"><img id="infoImg" src="public/images/icons/info.png" alt="Project Info" style="max-width: 30px; max-height: 30px;"></a>'; ?>
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
            <td>
              <?php
              if ($item['Completed'] == "1") {
                echo '<img src="public/images/icons/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
              } else {
                echo '<img src="public/images/icons/ongoing.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
              }
              ?>
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
            <td>
              <?php echo '<a id="infoBtn" href="projectDetails.php?id=' . $item['ProjectID'] . '"><img src="public/images/icons/info.png" alt="info" style="max-width: 30px; max-height: 30px;"></a>'; ?>
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
              <td class="text-center">
                <?php echo '<a id="red" href="assignTech.php?id=' . $item['ProjectID'] . '"><img src="public/images/icons/signup.png" alt="Assign Technician" width=40" height="40"></a>'; ?>
              </td>
            <?php endif; ?>
            <td>
              <?php
              if ($item['Completed'] == "1") {
                echo '<img src="public/images/icons/check.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
              } else {
                echo '<img src="public/images/icons/ongoing.png" alt="Completed" style="max-width: 30px; max-height: 30px;">';
              }
              ?>
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