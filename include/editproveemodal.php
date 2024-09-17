<div class="modal fade" id="editproveedor" tabindex="-1" aria-labelledby="editproveedormodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="editproveedormodal">Editar datos del proveedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form_edit" class="d-flex flex-column">
                    <div class="d-flex justify-content-around pb-2 pt-2">
                        <div class="col-5">
                            <label for="nameproveedor" class="form-label form-label-sm required">Nombre Proveedor</label>
                            <input type="text" class="form-control form-control-sm" id="nameproveedor" name="nameproveedor" placeholder="Juan" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                El nombre es obligatorio y no puede contener números y debe al menos tener 3 letras
                            </div>
                        </div>
                        <div class="col-5">
                            <label for="rucproveedor" class="form-label form-label-sm">C.I o RUC *</label>
                            <input type="text" class="form-control form-control-sm" id="rucproveedor" name="rucproveedor" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                No puede contener "." ni letras, debe ser mayor a 5 digitos
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around pb-2 pt-2">
                        <div class="col-md-5">
                            <label for="emailproveedor" class="form-label form-label-sm">Correo electrónico</label>
                            <input type="email" class="form-control form-control-sm" id="emailproveedor" name="emailproveedor" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                No puede contener espacios y debe incluir un "@"
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="telfproveedor" class="form-label form-label-sm">Celular</label>
                            <input type="text" class="form-control form-control-sm" id="telfproveedor" name="telfproveedor" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Debe de ser de 10 digitos y no puede contener espacios ni puntos "."
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around pb-2 pt-2">
                        <div class="col-md-5">
                            <label for="edit_direccion_proveedor" class="form-label form-label-sm">Direccion *</label>
                            <input type="text" class="form-control form-control-sm" id="edit_direccion_proveedor" name="edit_direccion_proveedor" placeholder="Av. Pratt Gill Ñemby" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es obligatorio
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="edit_ciudad_proveedor" class="form-label form-label-sm">Ciudad *</label>
                            <select class="form-select form-select-sm" id="edit_ciudad_proveedor" name="edit_ciudad_proveedor" autocomplete="off">
                                <option selected disabled>Selecciones una ciudad</option>
                                <?php
                                include "../backend/selectcontry.php";
                                ?>
                            </select>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es obligatorio
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_proveedor" name="id_proveedor">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-dark btn-sm" id="savedit">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>