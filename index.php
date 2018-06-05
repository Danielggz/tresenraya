<?php
include 'cabecera.php';
?>

<body>
    <div id="contenedor">

        <div id="titulo">
            <h1>Bienvenido a la app de tareas</h1>
        </div>

        <div id="botones">
            <form action="login.php" method="get">
                <input type="submit" value="Entrar"/>
            </form>
            <form action="registro.php" method="get">
                <input type="submit" value="Registrarse"/>
            </form>
        </div>
    </div> 
</body>
</html>