<div class="modal fade" id="addtimbradoandnumeracion" tabindex="-1" aria-labelledby="addtimbradoandnumeracionmodal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header m-0 p-1">
                <h1 class="modal-title fs-6" id="addtimbradoandnumeracionmodal">Agregar Timbrado y Numeracion</h1>
            </div>
            <div class="modal-body p-0">
                <form action="" method="post" id="form_timbrado" class="d-flex flex-column">
                    <div class="d-flex justify-content-around pb-2 pt-2">
                        <div class="col-sm-2">
                            <label for="nrotimbrado" class="form-label form-label-sm required">Timbrado Nro</label>
                            <input type="text" class="form-control form-control-sm" id="nrotimbrado" name="nrotimbrado" placeholder="0000000" autocomplete="off">
                            <div class="invalid-feedback">
                                Debe de contener al menos 7 caractares
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="fecha_inicio" class="form-label form-label-sm required">Fecha de Inicio</label>
                            <input type="date" class="form-control form-control-sm " id="fecha_inicio" name="fecha_inicio" placeholder="00/00/0000" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Obligatorio
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="fecha_vencimiento" class="form-label form-label-sm required">Fecha Vencimiento</label>
                            <input type="date" class="form-control form-control-sm col-md-6" id="fecha_vencimiento" name="fecha_vencimiento" placeholder="00/00/0000" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Obligatorio
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="nro_factura" class="form-label form-label-sm required">Numeracion</label>
                            <input type="text" class="form-control form-control-sm " id="nro_factura" name="nro_factura" placeholder="000-000-0000000" maxlength="15" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-1">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-dark btn-sm" id="insert_timbrado">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>