<?php
$connect = mysqli_connect("localhost", "root", "", "lavadero", "3306");
if (!$connect) {
    die("NO SE CONECTÓ" . mysqli_connect_error());
}
