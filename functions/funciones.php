<?php

function estalogueado()
{
    $inactivo = 3600;
    if (isset($_SESSION['nombre'])) {
        if ((time() - $_SESSION['last_activity']) >  $inactivo) {
            return false;
        }

        $_SESSION['last_activity'] = time();
        return true;
    }

    return false;
}
function estaSesionIniciada()
{
    return isset($_SESSION['nombre']);
}
