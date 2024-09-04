<?php


function estalogueado()
{
    $inactivo = 2;

    var_dump($_SESSION);

    if (isset($_SESSION['nombre'])) {
        if ((time() - $_SESSION['last_activity']) >  $inactivo) {
            return false;
        }

        $_SESSION['last_activity'] = time();
        return true;
    }

    return false;
}
