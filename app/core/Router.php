<?

namespace app\core;

class Router {

  protected $routes = [];
  protected $params = [];

  function __construct() {
    $arr = require_once 'app/config/routes.php';
    foreach ($arr as $key => $val) {
      $this->add($key, $val);
    }
  }

  public function add($route, $params) {
    $route = preg_replace('/{:query}/', '(\?.*)?', $route);
    $route = "#^$route$#";
    $this->routes[$route] = $params;
  }

  function match() {
    $url = trim($_SERVER['REQUEST_URI'], '/');
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  function run() {
    if ($this->match()) {
      $path = 'app\controllers\\' . ucfirst($this->params['controller'] . 'Controller');
      if (class_exists($path)) {
        $action = $this->params['action'] . 'Action';
        if (method_exists($path, $action)) {
          $controller = new $path($this->params);
          $controller->$action();
        } else {
          View::errorCode(404);
        }
      } else {
        View::errorCode(404);
      }
    } else {
      View::errorCode(404);
    }
  }
}