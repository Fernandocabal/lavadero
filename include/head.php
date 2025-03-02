<?php
session_start();
$id_empresa = $_SESSION['id_empresa_activa'];
echo "
    <script src='../node_modules/jquery/dist/jquery.min.js' crossorigin='anonymous'></script>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../assets/css/style.css'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='../node_modules/select2/css/select2.min.css' rel='stylesheet' />
    <script src='../node_modules/select2/js/select2.min.js'></script>
    <script src='../node_modules/sweetalert2/dist/sweetalert2.min.js'></script>
    <link rel='stylesheet' href='../node_modules/sweetalert2/dist/sweetalert2.min.css'>
    <link rel='stylesheet' href='../node_modules/bootstrap/dist/css/bootstrap.min.css'>
    <link href='../node_modules/select2/css/select2-bootstrap-5-theme.css' rel='stylesheet'>
    <link rel='icon' href='../assets/img/empresa_" . $id_empresa . ".png'>";
