<?php
// Function for redirecting users based on authorization status of current login credentials.
function auth_guard(array $permissions = ['allow_guests' => false, 'redirect_logged_in' => false,]) {
  $permissions = array_merge([
    'allow_guests' => false,
    'redirect_logged_in' => false,  // Redirect logged in users, (Sign up page)
  ], $permissions);

  $is_logged_in = isset($_SESSION['UserID']) && isset($_SESSION['Username']);
  $is_admin = ($is_logged_in && isset($_SESSION['Type']) && $_SESSION['Type'] === 'Administrator');

  $allowed = false;

  // Always allow Administrators
  if ($is_admin) {
    $allowed = true;
    return $allowed;
  }

  // Redirect logged in users if required
  if ($permissions['redirect_logged_in']) {
    if ($is_logged_in) {
      header('Location: ' . BASE_URL . 'homepage.php');
      exit;
    }
  }

  if ($is_logged_in || $permissions['allow_guests']) {
    $allowed = true;
  }

  if (!$allowed) {
    header('Location: ' . BASE_URL . 'login.php');
      exit;
  }
  return $allowed;
}
?>