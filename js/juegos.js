window.onload = function()
{
    //var timer = setInterval(actualizarTablas,1000);

    actualizarTablas();

    function actualizarTablas()
    {
        var req = new XMLHttpRequest();
          req.open('GET', 'consultasAjax.php?tablas', true);
          
          req.addEventListener("load", function () {
            var tbody1 = document.getElementById('tabla_ajax1');
            var tbody2 = document.getElementById('tabla_ajax2');
            var objContenidos = JSON.parse(req.response);

            tbody1.innerHTML = objContenidos.content1;
            tbody2.innerHTML = objContenidos.content2;
            console.log(objContenidos.turnos);

          });
          req.send(null);
    }
}