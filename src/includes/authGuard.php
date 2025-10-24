<?php
// Function for redirecting users based on authorization status of current login credentials.
function auth_guard($allow_guests = false, $redirect_logged_in = false, $allow_cust = true, $allow_tech = true, $allow_admin = true) {

  $is_logged_in = isset($_SESSION['UserID']) && isset($_SESSION['Username']);
  $type = isset($_SESSION['Type']) ? $_SESSION['Type'] : '';

  $allowed = false;

  // Check Special Admin rules
  if ($type === 'Administrator') {
    $allowed = true ? $allow_admin : false;
    if (!$allowed) {
      header(header: 'Location: ' . BASE_URL . 'homepage');
      exit;
    }
    return $allowed;
  }

  // Redirect logged in users (non-admin) if required
  if ($redirect_logged_in) {
    if ($is_logged_in) {
      header(header: 'Location: ' . BASE_URL . 'homepage');
      exit;
    }
  }
  
  // If user type not allowed on this page, return
  if ((!$allow_cust && $type === 'Customer') || (!$allow_tech && $type === 'Technician')) {
    header('Location: ' . BASE_URL . 'homepage');
    exit;
  }

  if ($is_logged_in || $allow_guests) {
    $allowed = true;
  }

  if (!$allowed) {
    header('Location: ' . BASE_URL . 'login');
    exit;
  }
  return $allowed;
}
?>