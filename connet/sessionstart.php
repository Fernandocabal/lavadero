<?php
session_start();
// if (isset($_SESSION['last_activity'])) {

//     //Tiempo en segundos para dar vida a la sesión.
//     $inactivo = 3600; //1 hora para destruir la sesión

//     //Calculamos tiempo de vida inactivo.
//     $vida_session = time() - $_SESSION['last_activity'];

//     //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
//     if ($vida_session > $inactivo) {
//         //Removemos sesión.
//         session_unset();
//         //Destruimos sesión.
//         session_destroy();
//         //Redirigimos pagina.
//         header("location:../index.php");

//         exit();
//     }
// }
// $_SESSION['last_activity'] = time();
