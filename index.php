<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

/**
 * Given an FQCN, requires the correct file
 * @param string $fqcn
 */
function fqcn_to_file_path(string $fqcn) {
    // We have to look into src folder
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $fqcn) . '.php';
}
spl_autoload_register('fqcn_to_file_path');

use App\FlashSession;
use Controllers\AuthController;
use Controllers\CartController;
use Controllers\TestController;
use Controllers\StaticController;
use Controllers\CommandController;
use Controllers\ContactController;
use Controllers\PaymentController;
use Controllers\ProductController;
use App\Exceptions\NotFoundException;
use App\Exceptions\AccessDeniedException;

require_once __DIR__ . '/src/helpers/main.php';
require_once __DIR__ . '/src/helpers/validation.php';
require_once __DIR__ . '/src/helpers/session_flash.php';

$route = $_SERVER['PATH_INFO'] ?? '/home';

try {
    write_log('Called page ' . $route);

    switch ($route) {
        case '/':
        case '/home':
            StaticController::displayHomepage();
            break;

        case '/terms/cgu':
            StaticController::displayCGU();
            break;

        case '/terms/cgv':
            StaticController::displayCGV();
            break;

        case '/terms/confidentials':
            StaticController::displayConfidentials();
            break;

        case '/contact':
            ContactController::displayContact();
            break;

        case '/contact-handler':
            ContactController::handleContact();
            break;

        case '/login':
            AuthController::displayLoginForm();
            break;

        case '/login-handler':
            AuthController::processLoginForm();
            break;

        case '/logout':
            AuthController::logout();
            break;

        case '/register':
            AuthController::displayRegisterForm();
            break;

        case '/register-handler':
            AuthController::handleRegisterForm();
            break;

        case '/me':
            AuthController::displayProfile();
            break;

        case '/me/update':
            AuthController::handleUpdateProfile();
            break;

        case '/me/delete':
            AuthController::delete();
            break;

        case '/products/list':
            ProductController::list();
            break;

        case '/products/details':
            ProductController::details();
            break;

        case '/products/update':
            ProductController::displayUpdateForm();
            break;

        case '/products/create':
            ProductController::displayCreateForm();
            break;

        case '/products/delete':
            ProductController::delete();
            break;

        case '/products/update-handler':
            ProductController::handleUpdateForm();
            break;

        case '/products/create-handler':
            ProductController::handleCreateForm();
            break;

        case '/cart/add':
            CartController::add();
            break;

        case '/cart/remove':
            CartController::remove();
            break;

        case '/cart/update':
            CartController::update();
            break;

        case '/cart/empty':
            CartController::empty();
            break;

        case '/cart':
            CartController::displayCart();
            break;

        case '/order':
            CommandController::displayOrderForm();
            break;

        case '/order-handler':
            CommandController::handleOrderForm();
            break;

        case '/pay/cb':
            PaymentController::pay();
            break;
            
        case '/pay/paypal':
            PaymentController::paypal();
            break;
            
        case '/pay/other':
            PaymentController::payOther();
            break;

        case '/pay/success':
            PaymentController::success();
            break;

        case '/pay/cancel':
            PaymentController::cancel();
            break;

        case '/error/403':  // Pour tester la page 403
            error403();

        case '/error/404':  // Pour tester la page 404
            error404();

        case '/error/500':  // Pour tester la page 500
            error();

        case '/test':  // Pour tester la page 500
            TestController::test();

        default:
            error404();
    }
} catch (AccessDeniedException $e) {
    write_log($e->getMessage(), 'error');
    include view('errors/403');
} catch (NotFoundException $e) {
    write_log($e->getMessage(), 'error');
    include view('errors/404');
} catch (Exception $e) {
    write_log($e->getMessage(), 'error');
    include view('errors/500');
}

FlashSession::clear();
