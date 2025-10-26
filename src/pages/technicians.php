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
  <meta charset="UTF-8">
  <title>Search Results</title>
  <link rel="icon" type="image/png" href="<?= IMG_PATH ?>logos/logo_blank.png">
  <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
</head>

<body>

  <!--HEADER-->
  <?php include COMPONENTS_DIR . 'header.php'; ?>
  <!--HEADER-->
  <!--hamburger-->
  <?php include COMPONENTS_DIR . 'hamburger.php'; ?>
  <!--hamburger-->

  <div class="search-container">
    <form class="search-bar-form" action="technicians" method="POST">
      <label for="occupation-type">Search for a <b>Technician</b></label>
      <div class="search-bar">
        <input type="text" id="occupation-type" name="occupation-type" placeholder="Enter Name">
        <button class="btn btn-red" type="submit">
          <img class="invert-icon" src="<?= IMG_PATH ?>icons/search.png" alt="Search">
        </button>

        <?php if ($_SESSION['Type'] == 'Administrator') { ?>
          <button type="button" class="btn btn-grey" onclick="window.location.href='addTechnician';" value="Add Technician">
            <span class="plus-sign">+</span>Add Technician
          </button>
        <?php } ?>

      </div>
  </div>

  </form>
  </div>


  <div class="results-container results-small">
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
                <b>
                  <a id="techName" href="profile?id=<?php echo $item['userID']; ?>">
                    <?php echo $item['Technician_Name']; ?>
                  </a>
                </b>
              </td>
              <td><?php echo $item['OccupationType']; ?></td>
              <td>
                <?php if ($item['Rating']): ?>
                  <img class="icon" src="<?= IMG_PATH ?>icons/star.png" alt="Star">
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