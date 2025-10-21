<?php
$uri     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base    = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$path    = '/' . trim(substr($uri, strlen($base)), '/');
$path    = $path === '/' ? '/' : rtrim($path, '/');  // drop trailing slash
echo "Requested path: $path";

switch ($path) {
  case '/':                   // URL (without file name) to a default LOGIN screen
  case '/login.php':
    require __DIR__ . '/pages/login.php';
    break;
  case '/about.html':
    require __DIR__ . '/pages/about.html';
    break;
  case '/addCustomer.php':
    require __DIR__ . '/pages/addCustomer.php';
    break;
  case '/addPayment.php':
    require __DIR__ . '/pages/addPayment.php';
    break;
  case '/addTechnician.php':
    require __DIR__ . '/pages/addTechnician.php';
    break;
  case '/assignPrice.php':
    require __DIR__ . '/pages/assignPrice.php';
    break;
  case '/assignTech.php':
    require __DIR__ . '/pages/assignTech.php';
    break;
  case '/contact-loggedin.php':
    require __DIR__ . '/pages/contact-loggedin.php';
    break;
  case '/contact.php':
    require __DIR__ . '/pages/contact.php';
    break;
  case '/createProject.php':
    require __DIR__ . '/pages/createProject.php';
    break;
  case '/homepage.php':
    require __DIR__ . '/pages/homepage.php';
    break;
  case '/logout.php':
    require __DIR__ . '/pages/logout.php';
    break;
  case '/payments.php':
    require __DIR__ . '/pages/payments.php';
    break;
  case '/profile.php':
    require __DIR__ . '/pages/profile.php';
    break;
  case '/projectDetails.php':
    require __DIR__ . '/pages/projectDetails.php';
    break;
  case '/projects.php':
    require __DIR__ . '/pages/projects.php';
    break;
  case '/rating.php':
    require __DIR__ . '/pages/rating.php';
    break;
  case '/searchResults.php':
    require __DIR__ . '/pages/searchResults.php';
    break;
  case '/services.html':
    require __DIR__ . '/pages/services.html';
    break;
  case '/technicians.php':
    require __DIR__ . '/pages/technicians.php';
    break;
  case '/updateProfile.php':
    require __DIR__ . '/pages/updateProfile.php';
    break;
  default:
    http_response_code(404);
    exit('Not Found');
}
?>