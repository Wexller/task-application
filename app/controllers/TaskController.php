<?

namespace app\controllers;

use app\core\Controller;

Class TaskController extends Controller {
  public function indexAction() {
    $result = $this->model->getTasks();
    $vars = array(
      'tasks' => $result['QUERY'],
      'pageCount' => $result['PAGE_COUNT'],
    );

    $this->view->render('Список задач', $vars);
  }

  // Создание задачи
  public function createAction() {
    $this->checkRequest($_POST);
    echo json_encode($this->model->createTask($_POST));
  }

  // Получение задачи для редактирования. Если не админ, то вывод ошибки
  public function getTaskAction() {
    if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']) {
      $this->checkRequest($_POST);
      echo json_encode($this->model->getTask($_POST));
    } else {
      http_response_code(403);
      echo json_encode('Доступ запрещён. Требуется авторизация');
    }
  }

  // Обновление задачи. Если не админ, то вывод ошибки
  public function updateAction() {
    if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']) {
      $this->checkRequest($_POST);
      echo json_encode($this->model->updateTask($_POST));
    } else {
      http_response_code(403);
      echo json_encode('Доступ запрещён. Требуется авторизация');
    }
  }

  // Если пустой запрос, то редирект на главную
  private function checkRequest($query) {
    if (empty($query)) {
      header("Location: /", true, 301);
      exit();
    }
  }
}