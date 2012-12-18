var conn = new WebSocket('ws://localhost:1232');
var messages = $('.messages');
var form = $('form');

form.submit(function (e) {
  e.preventDefault();

  var input = form.find('*[name=message]');

  // Enviamos correo a los demas clientes
  conn.send(input.val());

  // Limpiamos input
  input.val('');
});

conn.onopen = function(e) {
  console.log("Conexión establecida");
};

conn.onmessage = function(e) {
  var message = e.data;

  messages.append($('<div></div>').text(message));
};
