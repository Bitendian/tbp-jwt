<?php

use Bitendian\TBP\UI\AbstractComponent;
use Bitendian\TBP\Utils\Router;

// Define basic paths
define('__CONFIG_DIR__', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config'));
define('__BASE_PATH__', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));

// Autoload PSR-4
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$routeData = getCurrentRoute($_REQUEST);

executeActionIfNeeded($_REQUEST);

// select layout with inner module
$layout = null;

$layoutClass = $routeData->layout;
$moduleClass = $routeData->module;

/**
 * @var $layout \Bitendian\TBP\UI\AbstractWidget
 */
$layout = new $layoutClass(new $moduleClass());

if ($layout != null) {
    // fetch layout
    $layout->fetch($_REQUEST);

    // render layout
    echo $layout->render();
} else {
    header("HTTP/1.0 404 Not Found");
}



die();

function getCurrentRoute(&$params)
{
    $routes = [];
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'routes.php');
    Router::load($routes);

    $urlPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    $routeData = Router::getRouteData($urlPath, 'Basic');
    if ($routeData === false) {
        $redirectUrl = Router::getRoute('list-examples', 'en_US.UTF8');
        header('Location: ' . $redirectUrl);
    }

    $params['locale'] = $routeData->lang;
    $params['urlKey'] = $routeData->urlKey;

    foreach ($routeData->vars as $name => $value) {
        $params[$name] = $value;
    }

    return $routeData;
}

function executeActionIfNeeded(&$params)
{
    // executing action if needed
    if (isset($params['Action'])) {
        $actionClass = AbstractComponent::actionDecode($params['Action']);

        /**
         * @var $action AbstractComponent
         */
        $action = new $actionClass();
        if (($redirectUrl = $action->action($params)) != null) {
            header("Location: " . $redirectUrl);
            die();
        }
    }
}
