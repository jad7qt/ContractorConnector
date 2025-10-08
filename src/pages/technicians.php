<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'search-db.php';

$type = $_SESSION['Type'];
$Technician = array();

//check if search entered
if (isset($_POST['occupation-type'])) {
  $Technician = searchTechByName($_POST['occupation-type']);
} else {
  $Technician = getAllTech();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Search Results</title>
  <link rel="stylesheet" type="text/css" href="public/css/technicians.css">
</head>

<body>

  <!--HEADER-->
  <?php include COMPONENTS_DIR . 'header.php'; ?>
  <!--HEADER-->
  <!--hamburger-->
  <?php include COMPONENTS_DIR . 'hamburger.php'; ?>
  <!--hamburger-->

  <div class="search-container">
    <form action="technicians.php" method="POST">
      <label for="occupation-type">Search for a <b>Technician</b></label>
      <div>
        <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Name">
        <button type="submit">
          <img src="public/images/icons/search.png" alt="Search"
            style="max-width: 20px; max-height: 20px; filter: invert(1);">
        </button>

        <!--     ADD Technician if they arent in the system    -->
        <?php if ($_SESSION['Type'] == 'Administrator') { ?>
          <button type="button" class="techButton" onclick="window.location.href='addTechnician.php';"
            value="Add Technician"> <span class="plus-sign">+</span>
            Add Technician</button>
        <?php } ?>

      </div>
  </div>

  </form>
  </div>


  <div class="results-container">
    <h3>Technician Search Results</h3>
    <?php if (count($Technician) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Technician Name</th>
            <th>Occupation Type</th>
            <th>Rating</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($Technician as $item): ?>
            <tr>
              <td class="techNames">
                <b><?php echo '<a id="techName" href="profile.php?id=' . $item['userID'] . '">' . $item['Technician_Name'] . '</a>'; ?></b>
              </td>
              <td><?php echo $item['OccupationType']; ?></td>
              <td>
                <?php if ($item['Rating']): ?>
                  <img src="public/images/icons/star.png" alt="Star" style="width: 20px; height: 20px;">
                  <?php echo $item['Rating']; ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No results found.</p>
    <?php endif; ?>
  </div>

</html>

<?php
ob_end_flush();
?>