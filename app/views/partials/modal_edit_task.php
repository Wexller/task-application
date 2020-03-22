<!-- Форма редактирования задачи -->
<div class="modal fade" id="update-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Изменить задачу</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="task/update" method="post" name="update-task">
          <div class="modal-body">
            <div class="form-group">
              Имя: <b><span id="update-name"></span></b>
            </div>
            <div class="form-group">
              Email: <b><span id="update-email"></span></b>
            </div>
            <input type="text" id="update-id" name="id" hidden>

            <div class="form-group">
              <label for="task-text">Текст задачи</label>
              <textarea id="update-text" class="form-control" rows="3" name="text" required></textarea>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="update-completed" name="completed">
              <label class="form-check-label" for="update-completed">
                Выполнена
              </label>
            </div>
          </div>
          <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary">Изменить</button>
          </div>
        </form>
    </div>
  </div>
</div>