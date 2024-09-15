<?php
include "../functions/conexion.php";
$id_proveedor = $_GET['id'];
try {
    $query = "SELECT * FROM `proveedores` WHERE id_proveedor = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id_proveedor, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row['id_proveedor'];
        $nombre_proveedor = $row['nombre_proveedor'];
        $ruc_proveedor = $row['ruc_proveedor'];
        $email = $row['email_proveedor'];
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<div class="modal fade" id="editproveedor" tabindex="-1" aria-labelledby="editproveedormodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editproveedormodal">Editar datos del proveedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="text" name="" id="" class="form-control" value="<?php echo $nombre_proveedor; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>