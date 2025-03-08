//Sección de select 2
$(document).ready(function () {
    $('#select_nombre_empresa').select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados"; // Mensaje en español
            }
        },
        placeholder: "Selecciona una empresa",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_sucursal').select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados"; // Mensaje en español
            }
        },
        placeholder: "Primero Selecciona una Empresa",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#select_caja').select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados"; // Mensaje en español
            }
        },
        placeholder: "Primero Selecciona una Empresa",
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
            placeholder: "Primero selecciona una Sucursal",
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
                try {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    if (data && data.sucursales) {
                        populateSucursalSelect(data.sucursales);
                    } else {
                        console.error("Respuesta del servidor inválida:", data);
                    }
                } catch (error) {
                    console.error("Error al parsear la respuesta:", error);
                }
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
    function populateSucursalSelect(data, placeholder = "Seleccione una Sucursal") {
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
    function populateCajaSelect(data, placeholder = "Seleccione una Caja") {
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
//fin de seccion select2
btn_insert_user.addEventListener("click", function (event) {
    event.preventDefault();
    Swal.fire({
        showConfirmButton: false,
        text: "Procesando",
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 1000,
        customClass: {
            popup: 'custom-swal'
        },
    });
    const formData = new FormData(form);
    fetch('../backend/crear_usuario/insert_usuario.php', {
        method: 'POST',
        body: formData,
    })
        // PARA DEPURACIÓN
        //         .then(response => {
        //             return response.text();
        //         })
        //         .then(data => {
        //             console.log(data);
        //             try {
        //                 const jsonData = JSON.parse(data);
        //             } catch (error) {
        //                 console.error('Error al parsear JSON:', error);
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error en la petición:', error);
        //         });
        // });

        .then(response => response.json())
        .then(data => {
            // Verificar si la creación del usuario fue exitosa
            if (!data.session.success) {
                Swal.fire({
                    text: data.session.message,
                    icon: 'warning',
                    confirmButtonColor: "#212529",
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        popup: 'custom-swal'
                    }
                });
            }
            if (data.usuario.success) {
                Swal.fire({
                    icon: "success",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.usuario.message + " Nombre de usuario: " + data.usuario.userData.username,
                    customClass: {
                        popup: 'custom-swal'
                    }
                }).then(() => {  // Cuando se cierra el primer Swal
                    if (data.correo.success) {
                        Swal.fire({
                            text: data.correo.message,
                            confirmButtonColor: "#212529",
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                popup: 'custom-swal'
                            }
                        }).then(() => {
                            form.reset();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.correo.message,
                            icon: 'error',
                            confirmButtonColor: "#212529",
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                popup: 'custom-swal'
                            }
                        }).then(() => {
                            form.reset();
                            location.reload();
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.usuario.message,
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        popup: 'custom-swal'
                    }
                }).then(() => {
                    modal_registrar.show();
                });
            }
        })
        .catch(error => {
            // Manejo de errores en la solicitud
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error en la solicitud: ' + error.message,
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: 'Aceptar',
                customClass: {
                    popup: 'custom-swal'
                }
            });
        });

});
