<!--Форма входа-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Форма входа</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="account/login" method="post" name="login">
        <div class="modal-body">
          <div class="form-group">
            <label for="login-login">Логин</label>
            <input id="login-login" type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Введите логин" name="login">
          </div>
          <div class="form-group">
            <label for="login-password">Пароль</label>
            <input id="login-password" type="password" class="form-control" aria-describedby="passwordHelp"
                   placeholder="Введите пароль" name="password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary">Войти</button>
        </div>
      </form>
    </div>
  </div>
</div>