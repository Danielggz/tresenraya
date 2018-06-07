  window.onload=function(){
    var timer = this.setInterval(ajax, 5000);

  }
  function ajax(){
    var req = new XMLHttpRequest();
    req.open('GET', 'player2', true);

    req.addEventListener("load", function () {
        document.getElementById("jugador2").innerHTML = `
        <h2>Jugador 2</h2> 
        <script src='ajax_player2'></script>
        ` + req.responseText;
    });

    req.send(null);
  }  
    
    