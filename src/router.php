<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$path = '/' . trim(substr($uri, strlen($base)), '/');
$path = $path === '/' ? '/' : rtrim($path, '/');  // drop trailing slash

switch ($path) {
  case '/':                   // URL (without file name) to a default LOGIN screen
  case '/login':
    require __DIR__ . '/pages/login.php';
    break;
  case '/about':
    require __DIR__ . '/pages/about.php';
    break;
  case '/addCustomer':
    require __DIR__ . '/pages/addCustomer.php';
    break;
  case '/addPayment':
    require __DIR__ . '/pages/addPayment.php';
    break;
  case '/addTechnician':
    require __DIR__ . '/pages/addTechnician.php';
    break;
  case '/assignPrice':
    require __DIR__ . '/pages/assignPrice.php';
    break;
  case '/assignTech':
    require __DIR__ . '/pages/assignTech.php';
    break;
  case '/contact':
    require __DIR__ . '/pages/contact.php';
    break;
  case '/createProject':
    require __DIR__ . '/pages/createProject.php';
    break;
  case '/homepage':
    require __DIR__ . '/pages/homepage.php';
    break;
  case '/logout':
    require __DIR__ . '/pages/logout.php';
    break;
  case '/payments':
    require __DIR__ . '/pages/payments.php';
    break;
  case '/profile':
    require __DIR__ . '/pages/profile.php';
    break;
  case '/projectDetails':
    require __DIR__ . '/pages/projectDetails.php';
    break;
  case '/projects':
    require __DIR__ . '/pages/projects.php';
    break;
  case '/rating':
    require __DIR__ . '/pages/rating.php';
    break;
  case '/searchResults':
    require __DIR__ . '/pages/searchResults.php';
    break;
  case '/services':
    require __DIR__ . '/pages/services.php';
    break;
  case '/technicians':
    require __DIR__ . '/pages/technicians.php';
    break;
  case '/updateprofile':
    require __DIR__ . '/pages/updateprofile.php';
    break;
  default:
    http_response_code(404);
    exit('Not Found');
}
?>