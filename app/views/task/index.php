<div class="login-button-block">
  <? if (isset($_SESSION['LOGIN']) && $_SESSION['LOGIN']): ?>
      <button type="button" class="btn btn-danger" id="login-logout" data-toggle="modal">
          Выйти
      </button>
  <? else: ?>
      <button type="button" class="btn btn-secondary" id="login-modal" data-toggle="modal" data-target="#login">
          Войти
      </button>
  <? endif; ?>
</div>

<h2>Задачник</h2>

<section class="section-tasks">
    <div class="control-block">
      <? if ($pageCount > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#" data-page="prev">Предыдущая</a></li>
              <? for ($i = 1; $i <= $pageCount; $i++): ?>
                  <li class="page-item<?
                  if(isset($_GET['page']) && (int) $_GET['page'] === $i) {
                    echo ' active';
                  }
                  elseif (empty($_GET['page']) && $i === 1) {
                    echo ' active';
                  }
                  ?>"><a class="page-link page-number" href="#"
                         data-page="<?= $i ?>"><?= $i ?></a></li>
              <? endfor; ?>
                <li class="page-item"><a class="page-link" href="#" data-page="next">Следующая</a></li>
            </ul>
        </nav>
        <?else:?>
        <div class="epmty-block"></div>
        <?endif;?>
        <button type="button" class="btn btn-primary" id="show-modal" data-toggle="modal" data-target="#create-task">
            Добавить задачу
        </button>
    </div>

    <table class="table">
        <thead class="thead-dark">

            <th scope="col" class="table-sort col-2" data-query="name">
                Имя
                <i class="fa fa-fw fa-sort<?
                if(isset($_GET['order']) && (isset($_GET['by']) && $_GET['by'] === 'name')) {
                    echo ' fa-sort-' . $_GET['order'];
                }
                ?>" data-order="desc"></i>
            </th>
            <th scope="col" class="table-sort col-2" data-query="email">
                E-mail
                <i class="fa fa-fw fa-sort<?
                if(isset($_GET['order']) && (isset($_GET['by']) && $_GET['by'] === 'email')) {
                  echo ' fa-sort-' . $_GET['order'];
                }
                ?>" data-order="desc"></i>
            </th>
            <th scope="col" class="table-sort text-center col-2" data-query="completed">
                Статус
                <i class="fa fa-fw fa-sort<?
                if(isset($_GET['order']) && (isset($_GET['by']) && $_GET['by'] === 'completed')) {
                  echo ' fa-sort-' . $_GET['order'];
                }
                ?>" data-order="completed"></i>
            </th>

            <th scope="col" class="col-<?= isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] ? '4' : '6'?>">Текст</th>

            <? if(isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']): ?>
                <th scope="col" class="col-2">Редактирование</th>
            <? endif; ?>
        </thead>
        <tbody>
        <? foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['name']) ?></td>
            <td><?= htmlspecialchars($task['email']) ?></td>
            <td class="text-center">
                <i class="fa fa-<?= (bool)(int)$task['completed'] ? 'check-square' : 'times' ?>"
                   aria-hidden="true"
                   style="font-size: 20px; color: #<?= (bool)(int)$task['completed'] ? '28a745' : 'dc3545'?>"></i>
            </td>
            <td>
              <?= htmlspecialchars($task['text']) ?>
              <? if(isset($task['text_edited']) && (bool)(int)$task['text_edited']): ?>
                  <div class="alert alert-warning" role="alert">
                      Отредактировано администратором
                  </div>
              <? endif; ?>
            </td>
            <? if(isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']): ?>
                <td class="text-center"><button class="btn btn-warning update-task" data-id="<?=$task['id']?>">Изменить</button></td>
            <? endif; ?>
        <tr>
          <? endforeach; ?>
        </tbody>
    </table>

    <?if (empty($tasks)): ?>
        <div class="alert alert-primary" role="alert">
            Задач нет!
        </div>
    <?endif;?>
</section>

<? require_once 'app/views/partials/modal_new_task.php' ?>

<?
if ((isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'])) {
  require_once 'app/views/partials/modal_edit_task.php';
}?>