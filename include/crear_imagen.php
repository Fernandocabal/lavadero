<?php
function crearImagenGris($width, $height, $texto, $file_path)
{
    // Crear la imagen
    $image = imagecreatetruecolor($width, $height);

    // Definir colores
    $gris_claro = imagecolorallocate($image, 200, 200, 200); // Fondo gris claro
    $color_texto = imagecolorallocate($image, 0, 0, 0); // Texto en negro

    // Rellenar el fondo
    imagefill($image, 0, 0, $gris_claro);

    // Establecer la fuente y el tamaño del texto
    $font_path = './assets/font/arial.ttf';  // Ruta a la fuente
    $font_size = 20;  // Tamaño del texto

    // Verificar si la fuente existe
    if (!file_exists($font_path)) {
        die("Error: La fuente no existe en la ruta especificada.");
    }

    // Calcular el cuadro del texto
    $text_box = imagettfbbox($font_size, 0, $font_path, $texto);
    if (!$text_box) {
        die("Error: No se pudo calcular el cuadro del texto.");
    }

    $text_width = $text_box[2] - $text_box[0]; // Ancho del texto
    $text_height = $text_box[1] - $text_box[7]; // Altura del texto (corregido)

    // Calcular la posición para centrar el texto
    $x = ($width - $text_width) / 2; // Centrar horizontalmente
    $y = ($height - $text_height) / 2 + $text_height; // Centrar verticalmente (ajustado)

    // Agregar el texto en la imagen
    $result = imagettftext($image, $font_size, 0, $x, $y, $color_texto, $font_path, $texto);
    if (!$result) {
        die("Error: No se pudo agregar el texto a la imagen.");
    }

    // Guardar la imagen en un archivo
    if (!imagepng($image, $file_path)) {
        die("Error: No se pudo guardar la imagen.");
    }

    // Liberar la memoria
    imagedestroy($image);
}
