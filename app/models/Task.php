<?

namespace app\models;

use app\core\Model;

class Task extends Model {
  private $recordsPerPage = 3;
  private $minNameLength = 3;
  private $minTextLength = 5;
  private $errors = array();

  // Получение списка всех задач
  public function getTasks($get = []) {
    // Количество страниц для пагинации
    $pagesCount = ceil($this->db->column('SELECT COUNT(*) FROM tasks') / $this->recordsPerPage);


    // Параметры для сортировки и текущеая страница
    $page = (isset($_GET['page'])
      && is_numeric($_GET['page'])
      && $_GET['page'] <= $pagesCount
      && $_GET['page'] > 0) ? $_GET['page'] : 1;
    $by = (isset($_GET['by']) && $this->is_allow($_GET['by'])) ? $_GET['by'] : 'id';
    $order = (isset($_GET['order']) && $this->is_allow($_GET['order'])) ? mb_strtoupper($_GET['order']) : 'ASC';

    $offset = ($page - 1) * 3;

    return array(
      'QUERY' => $this->db->row("SELECT * FROM tasks ORDER BY $by $order LIMIT $offset, $this->recordsPerPage"),
      'PAGE_COUNT' => $pagesCount
    );
  }

  // Создание задачи
  public function createTask($post = []) {
    if (empty($post)) {
      http_response_code(400);
      return 'Неверный запрос';
    }

    if (!$this->isValid($post)) {
      http_response_code(400);
      return $this->errors;
    }

    $params = [
      'id' => '',
      'name' => $post['name'],
      'email' => $post['email'],
      'text' => $post['text'],
      'completed' => 0,
      'text_edited' => 0,
    ];

    $this->db->query('INSERT INTO tasks VALUES (:id, :name, :email, :text, :completed, :text_edited)', $params);

    return 'Задача успешно добавлена';
  }

  // Обновление задачи
  public function updateTask($post = []) {
    if (empty($post)) {
      http_response_code(400);
      return 'Неверный запрос';
    }

    if (!$this->isValid($post)) {
      http_response_code(400);
      return $this->errors;
    }

    $param = [
      'id' => $post['id']
    ];

    $taskInfo = $this->db->row('SELECT text, text_edited FROM tasks WHERE id=:id', $param)[0];

    $textEdited = $taskInfo['text_edited'];

    // Пометка, что задача отредактирована
    if(strcmp($taskInfo['text'], $post['text']) !== 0) {
      $textEdited = 1;
    }

    $completed = isset($post['completed']) && $post['completed'] === 'on' ? 1 : 0;

    $params = [
      'id' => $post['id'],
      'text' => $post['text'],
      'completed' => $completed,
      'text_edited' => $textEdited,
    ];

    $this->db->query('UPDATE tasks SET text=:text, completed=:completed, text_edited=:text_edited WHERE id=:id', $params);

    return 'Задача успешно изменена';
  }

  public function getTask($post) {
    if (empty($post)) {
      http_response_code(400);
      return 'Неверный запрос';
    }

    $params = [
      'id' => $post['id']
    ];

    return $this->db->row('SELECT * FROM tasks WHERE id=:id', $params);
  }

  // Разрешенные названия для запроса
  private function is_allow($value) {
    $allowed = array('id', 'name', 'email', 'completed', 'asc', 'desc');

    return in_array($value, $allowed);
  }

  // Проверка полей на валидность
  private function isValid ($data) {
    foreach ($data as $key => $value) {
      switch ($key) {
        case 'name':
          if (!preg_match("/^[a-zA-Zа-яёА-ЯЁ ]+$/u", $value)) {
            $this->errors['name'] = "Неверный формат ввода";
          }

          if (mb_strlen($value) < $this->minNameLength) {
            $this->errors['name'] = (isset($this->errors['name'])
              ? $this->errors['name'] . '. '
              : '') .
              "Минимальная длина имени должна быть не меньше $this->minNameLength символов";
          }
        break;

        case 'email':
          if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Неверный формат E-mail адреса";
          }
        break;

        case 'text':
          if (mb_strlen($value) < $this->minTextLength) {
            $this->errors['text'] = "Минимальная длина текста должна быть не меньше $this->minTextLength символов";
          }
        break;
      }
    }

    return empty($this->errors);
  }
}