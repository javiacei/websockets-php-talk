$(document).ready(function(){

  var states = {
    todo  : "label label-info",
    doing : "label label-warning",
    done  : "label label-success"
  };

  var actualizarTarea = function(taskId, stateName, username) {

    // Añadimos el usuario que ha cambiado el estado
    $("#users_task_id_" + taskId).append('<span class="label">' + username + '</span>');

    // Cambiamos el estado de la tarea
    var state = $("#state_task_id_" + taskId);
    state.attr('class', states[stateName]);
    state.html(stateName);
  }

  $(".change-state").each(function(i, e){
    $(e).on('click', function(event){
      event.preventDefault();

      var data = $.parseJSON($(this).attr("data-href"));

      $.ajax({
        type: "POST",
        url: data.url,
        success: function(e){
          actualizarTarea(e.task_id, e.state, e.username);
        }
      });
    });
  });

});
