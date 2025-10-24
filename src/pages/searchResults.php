<?php
require_once INCLUDES_DIR . 'authGuard.php';
auth_guard();
require_once MODELS_DIR . 'search-db.php';

$Technician = array();
$User = array();

// Search for technicians
if (isset($_POST['occupation-type'])) {
  $Technician = searchTechByOcc($_POST['occupation-type']);
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Search Results</title>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>searchResults.css">
</head>

<body>

  <!--HEADER-->
  <?php include COMPONENTS_DIR . 'header.php'; ?>
  <!--HEADER-->
  <!--hamburger-->
  <?php include COMPONENTS_DIR . 'hamburger.php'; ?>
  <!--hamburger-->


  <div class="results-container">
    <h3>Technician Results</h3>
    <?php if (count($Technician) > 0 || count($User) > 0): ?>
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
                  <a id="techName" href="profile.php?id=<?php echo $item['userID']; ?>">
                    <?php echo $item['Technician_Name']; ?>
                  </a>
                </b>
              </td>
              <td><?php echo $item['OccupationType']; ?></td>
              <td><?php echo $item['Rating']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No results found.</p>
    <?php endif; ?>
  </div>
</body>

</html>


<?php
ob_end_flush();
?>