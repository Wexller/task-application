<?

namespace app\models;

use app\core\Model;

class Account extends Model {
  private $errors = array();
  private $passwordKey = 'JeeBee';

  function login($post = []) {
    if (empty($post)) {
      http_response_code(400);
      return 'Неверный запрос';
    }

    if (!$this->isValid($post)) {
      http_response_code(400);
      return $this->errors;
    }

    $params = array(
      'login' => $post['login'],
      'password' => md5($post['password'] . $this->passwordKey)
    );

    return $this->db->row("SELECT id, login, is_admin FROM accounts WHERE login=:login AND password=:password", $params);
  }

  private function isValid ($data) {

    foreach ($data as $key => $value) {
      switch ($key) {

        case 'login':
          if (!preg_match("/^[a-zA-Z0-9]+$/u", $value)) {
            $this->errors['login'] = "Неверный формат логина";
          }

          if (mb_strlen($value) === 0) {
            $this->errors['login'] = "Логин не должен быть пустой";
          }
        break;

        case 'password':
          if (mb_strlen($value) <= 0) {
            $this->errors['password'] = "Пароль не должен быть пустой";
          }
        break;
      }
    }

    return empty($this->errors);
  }
}