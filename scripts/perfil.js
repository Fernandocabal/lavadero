//Sección de select 2
$(document).ready(function () {
    $('#select_sucursal').select2({
        placeholder: "Sucursal",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_nombre_empresa').select2({
        placeholder: "Selecciones una empresa",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_caja').select2({
        placeholder: "Caja",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_nombre_empresa').on('select2:select', function (e) {
        let data = e.params.data;
        $('#select_caja').val(null).trigger('change');
        $.ajax({
            type: 'POST',
            url: '../backend/jsonsucursal.php',
            data: {
                tipo: 'sucursal',
                id: data['id']
            },
            success: function (response) {
                if (response) {
                    populateSucursalSelect(response.sucursales);

                } else {
                    console.error("Respuesta del servidor inválida:", response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error trayendo datos de la base de datos: ", textStatus, errorThrown);
            }
        });
    });
    $('#select_sucursal').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../backend/jsonsucursal.php',
            data: {
                tipo: 'caja',
                id: data['id']
            },
            success: function (response) {
                let parsedResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (parsedResponse && parsedResponse.cajas) {
                    populateCajaSelect(parsedResponse.cajas);
                } else {
                    console.error("No se encontraron cajas.");
                }
            }
        });
    });
    function populateSucursalSelect(data) {
        $('#select_sucursal').empty().select2({
            placeholder: "Seleccione una sucursal",
        });
        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                $('#select_sucursal').append(
                    new Option(item.nombre, item.id_sucursal)
                );
            });
        } else {
            console.warn("No se encontraron datos para las sucursales.");
        }

        $('#select_sucursal').select2({
            placeholder: "Seleccione una sucursal",
            width: '100%',
            theme: 'bootstrap-5'
        });
    }
    function populateCajaSelect(data) {
        $('#select_caja').empty().select2({
            placeholder: "Seleccione una caja",
        });

        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                $('#select_caja').append(
                    new Option(item.prefijo, item.prefijo)
                );
            });
        } else {
            console.warn("No se encontraron datos para las cajas.");
        }

        $('#select_caja').select2({
            placeholder: "Seleccione una caja",
            width: '100%',
            theme: 'bootstrap-5'
        });
    }
});

btn_change_password.addEventListener("click", function (event) {
    event.preventDefault();
    const passActual = document.getElementById("pass-actual");
    if (passwordactual()) {
        passActual.focus();
        Swal.fire({
            icon: "warning",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Ingresa tu contraseña actual",
            customClass: {
                popup: 'custom-swal'
            },
        })
        return;
    }
    if (!confirmPassword()) {
        Swal.fire({
            icon: "warning",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Verifica tu nueva contraseña",
            customClass: {
                popup: 'custom-swal'
            },
        })
        return;
    }
    Swal.fire({
        showConfirmButton: false,
        text: "Procesando",
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 1500,
        customClass: {
            popup: 'custom-swal'
        },
    });
    const formData = new FormData(form);
    fetch('../backend/changepassword.php', {
        method: 'POST',
        body: formData,
    })
        //PARA DEPURACIÓN
        // .then(response => {
        //     return response.text();
        // })
        // .then(data => {
        //     console.log(data);
        //     try {
        //         const jsonData = JSON.parse(data);
        //     } catch (error) {
        //         console.error('Error al parsear JSON:', error);
        //     }
        // })
        // .catch(error => {
        //     console.error('Error en la petición:', error);
        // });
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Excelente",
                    customClass: {
                        popup: 'custom-swal'
                    },
                    willClose: () => {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Ocurrió un error",
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                text: 'Ocurrió un error al enviar los datos',
                customClass: {
                    popup: 'custom-swal'
                },
            });
        });

});
btn_change_empresa.addEventListener("click", function (evento) {
    evento.preventDefault();
    const formData = new FormData(form_change_empresa);
    fetch('../backend/change_empresa.php', {
        method: 'POST',
        body: formData,
    })
        // PARA DEPURACIÓN
        // .then(response => {
        //     return response.text();
        // })
        // .then(data => {
        //     console.log(data);
        //     try {
        //         const jsonData = JSON.parse(data);
        //     } catch (error) {
        //         console.error('Error al parsear JSON:', error);
        //     }
        // })
        // .catch(error => {
        //     console.error('Error en la petición:', error);
        // });
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Excelente",
                    customClass: {
                        popup: 'custom-swal'
                    },
                    willClose: () => {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Ocurrió un error",
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                text: 'Ocurrió un error al enviar los datos',
                customClass: {
                    popup: 'custom-swal'
                },
            });
        });
});