//Sección de select 2
$(document).ready(function () {
    $('#select_nombre_empresa').select2({
        placeholder: "Selecciones una empresa",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_sucursal').select2({
        placeholder: "Sucursal",
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
        $('#select_sucursal').empty().trigger('change');
        $('#select_sucursal').select2({
            placeholder: "Seleccione una sucursal",
            width: '100%',
            theme: 'bootstrap-5'
        });
        $('#select_caja').empty().trigger('change');
        $('#select_caja').select2({
            placeholder: "Primero Selecciona una Sucursal",
            width: '100%',
            theme: 'bootstrap-5'
        });
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
    function populateSucursalSelect(data, placeholder = "Seleccione una sucursal") {
        const $select = $('#select_sucursal').empty();

        const placeholderOption = new Option(placeholder, '', true, true);
        placeholderOption.disabled = true; // Deshabilitar la opción
        placeholderOption.selected = true; // Seleccionarla por defecto
        $select.append(placeholderOption);

        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                const texto = `${item.nro_sucursal} - ${item.nombre}`;
                const option = new Option(texto, item.id_sucursal);
                $select.append(option);
            });
        } else {
            console.warn("No se encontraron datos para las sucursales.");
        }

        $select.select2({
            placeholder: placeholder,
            width: '100%',
            theme: 'bootstrap-5'
        });
    }
    function populateCajaSelect(data, placeholder = "Selecciona una Caja") {
        const $select = $('#select_caja').empty();

        const placeholderOption = new Option(placeholder, '', true, true);
        placeholderOption.disabled = true; // Deshabilitar la opción
        placeholderOption.selected = true; // Seleccionarla por defecto
        $select.append(placeholderOption);

        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                $('#select_caja').append(
                    new Option(item.nro_caja, item.id_caja)
                );
            });
        } else {
            console.warn("No se encontraron datos para las cajas.");
        }

        $select.select2({
            placeholder: placeholder,
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
    }).then(() => {
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