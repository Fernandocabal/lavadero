<?php
$dsn = 'mysql:host=localhost;dbname=lavadero;charset=utf8';
$username = 'root';
$password = '';

try {
    $connect = new PDO($dsn, $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa";
} catch (PDOException $e) {
    die("NO SE CONECTÓ: " . $e->getMessage());
}
?>

<?php
// $dsn = 'mysql:host=bihq7cbc9dmtmxtcrxnb-mysql.services.clever-cloud.com;dbname=bihq7cbc9dmtmxtcrxnb;charset=utf8';
// $username = 'u1pmsielszqljh5d';
// $password = 'ndqyGPJ4IMRxiyS5IzF1';

// try {
//     $connect = new PDO($dsn, $username, $password);
//     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Conexión exitosa";
// } catch (PDOException $e) {
//     die("NO SE CONECTÓ: " . $e->getMessage());
// }
?>
