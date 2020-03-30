<?

namespace app\controllers;

use app\core\Controller;

Class AccountController extends Controller {
  public function loginAction() {
    if (empty($_POST)) {
      header("Location: /", true, 301);
      exit();
    }

    // Запрос логина
    $loginResponse = $this->model->login($_POST);

    if (http_response_code() === 400) {
      echo json_encode($loginResponse);
      return;
    }

    // Если совпадений нет, то ответ ошибка
    if (empty($loginResponse)) {
      http_response_code(400);
      echo json_encode(array(
        'login' => 'Неверные данные',
        'password' => 'Неверные данные'
      ));
      return;
    }

    $_SESSION['LOGIN'] = true;

    if(boolval($loginResponse[0]['is_admin'])) {
      $_SESSION['ADMIN'] = true;
    }
  }

  public function logoutAction() {
    unset($_SESSION['LOGIN']);

    if ($_SESSION['ADMIN']) {
      unset($_SESSION['ADMIN']);
    }
  }
}