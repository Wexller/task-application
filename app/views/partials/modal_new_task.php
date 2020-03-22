<!-- Форма добавления новой задачи -->
<div class="modal fade" id="create-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить задачу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="task/create" method="post" name="create-task">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="task-name">Ваше имя</label>
                        <input type="text" id="task-name" class="form-control"
                               placeholder="Введите имя" name="name">
                    </div>
                    <div class="form-group">
                        <label for="task-email">E-mail</label>
                        <input type="email" id="task-email" class="form-control" aria-describedby="emailHelp"
                               placeholder="Введите E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <label for="task-text">Текст задачи</label>
                        <textarea id="task-text" class="form-control" rows="3" name="text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>