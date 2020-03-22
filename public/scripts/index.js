$(document).ready(() => {

  $('#show-modal').click( function () {
    $($(this).attr('data-target')).modal('show')
  });

  $('form[name="create-task"]').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: response => {
        $('#' + $(this).attr('name')).modal('hide');
        $(this)[0].reset();

        setTimeout(() => {
          $('#modal-info').modal('show');
          $('#modal-info .modal-body').text(JSON.parse(response));
        }, 300)
      },
      error: response => {
        const resp = JSON.parse(response.responseText);
        const showError = text => `<small class="text-danger invalid-text">${text}</small>`;

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-text').remove();
        for (let key in resp) {
          $(this).find('[name="' + key + '"]').addClass('is-invalid');
          $(this).find('[name="' + key + '"]').after(showError(resp[key]));
        }
      }
    });
  });

  $('form[name="login"]').submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: () => {
        $('#' + $(this).attr('name')).modal('hide');
        $(this)[0].reset();

        document.location.reload();
      },
      error: response => {
        const resp = JSON.parse(response.responseText);
        const showError = text => `<small class="text-danger invalid-text">${text}</small>`;

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-text').remove();
        for (let key in resp) {
          $(this).find('[name="' + key + '"]').addClass('is-invalid');
          $(this).find('[name="' + key + '"]').after(showError(resp[key]));
        }
      }
    });
  });

  $('form[name="update-task"]').submit(function (event) {
    event.preventDefault();

    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: (response) => {
        $('#' + $(this).attr('name')).modal('hide');
        $(this)[0].reset();

        setTimeout(() => {
          $('#modal-info').modal('show');
          $('#modal-info .modal-body').text(JSON.parse(response));
        }, 300)
      },
      error: response => {
        if (response.status === 403) {
          $('#' + $(this).attr('name')).modal('hide');
          $(this)[0].reset();

          setTimeout(() => {
            $('#modal-info').modal('show');
            $('#modal-info .modal-body').text(JSON.parse(response.responseText));
          }, 300);

          return;
        }

        const resp = JSON.parse(response.responseText);
        const showError = text => `<small class="text-danger invalid-text">${text}</small>`;

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-text').remove();
        for (let key in resp) {
          $(this).find('[name="' + key + '"]').addClass('is-invalid');
          $(this).find('[name="' + key + '"]').after(showError(resp[key]));
        }
      }
    });
  });

  $('#modal-info').on('hidden.bs.modal', () => {
    document.location.reload();
  });

  $('#login-modal').click( function () {
    $($(this).attr('data-target')).modal('show')
  });

  const table = $('table tbody');

  $('.page-link').click(function (event) {
    event.preventDefault();
    const url = document.URL;
    const queryPage = +getQueryParams('page', url) || 1;
    const $dataPage = $(this).attr('data-page');

    let page;
    const maxPage = +$('.page-number').last().attr('data-page');

    if ($dataPage === 'prev') {
      page = (queryPage - 1 > 0) ? queryPage - 1 : 1
    } else if ($dataPage === 'next') {
      page = (queryPage + 1 <= maxPage) ? queryPage + 1 : maxPage
    } else {
      page = +$dataPage
    }

    if (queryPage === page) {
      return
    }

    $('.page-number').parent().removeClass('active');
    $('[data-page="' + page + '"]').parent().addClass('active');

    const requestUrl = updateQueryStringParameter(url, 'page', page);

    window.history.pushState({}, '', requestUrl);
    ajaxGet(requestUrl);
  });

  $('.table-sort').click(function () {
    const url = document.URL;
    const $sortElement = $(this).children('.fa-sort');

    const dataQueryBy = $(this).attr('data-query');
    const dataQueryOrder = $sortElement.attr('data-order');

    $('.fa-sort').removeClass('fa-sort-desc');
    $('.fa-sort').removeClass('fa-sort-asc');

    let order = 'desc';
    if (dataQueryOrder === 'desc') {
      order = 'asc';
    }

    $sortElement.addClass('fa-sort-' + order);
    $sortElement.attr('data-order', order);

    let tempUrl = updateQueryStringParameter(url, 'order', order);
    const requestUrl = updateQueryStringParameter(tempUrl, 'by', dataQueryBy);

    window.history.pushState({}, '', requestUrl);
    ajaxGet(requestUrl);
  });

  $('#login-logout').click(() => {
    let logout = confirm('Вы уверены?');

    if (logout) {
      $.get({
        url: 'account/logout',
        success: () => {
          document.location.reload();
        }
      });
    }
  });

  const editListener = () => {
    $('.update-task').click(function (event) {
      event.preventDefault();
      const id = $(this).attr('data-id');
      const $updateForm = $('#update-task [name="update-task"]');

      $.post({
        url: 'task/get_task',
        data: {
          id: id
        },
        success: response => {
          const task = JSON.parse(response)[0];
          $updateForm.find('#update-name').text(task.name);
          $updateForm.find('#update-email').text(task.email);
          $updateForm.find('#update-id').attr('value', task.id);
          $updateForm.find('#update-text').text(task.text);
          $updateForm.find('#update-completed')
            .attr('checked', Boolean(parseInt(task.completed)));

          $('#update-task').modal('show');
        },
        error: response => {
          if (response.status === 403) {
            $('#modal-info').modal('show');
            $('#modal-info .modal-body').text(JSON.parse(response.responseText));

            return;
          }
          console.log(JSON.parse(response));
        }
      });
    });
  };

  editListener();

  const ajaxGet = request => {
    $.get({
      url: request,
      success: response => {
        table.html($(response).find('table tbody').html())
        editListener()
      },
      error: response => {
        console.log(response)
      }
    });
  };

  const updateQueryStringParameter = (uri, key, value) => {
    let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    let separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
      return uri + separator + key + "=" + value;
    }
  };

  const getQueryParams = (params, url) => {
    let href = url;
    let reg = new RegExp('[?&]' + params + '=([^&#]*)', 'i');
    let queryString = reg.exec(href);
    return queryString ? queryString[1] : null;
  };
});