let fechafactura = document.getElementById('fechafactura'),
    form = document.getElementById('formcompras'),
    nombreproveedor = document.getElementById('nombreproveedor'),
    proveedor = document.getElementById('idproveedor'),
    id_proveedor = document.getElementById('id_proveedor'),
    concepto = document.getElementById('conceptodecompra'),
    insertcompra = document.getElementById('insertcompra');

form.addEventListener('submit', (evento) => {
    evento.preventDefault();
    const formData = new FormData(form);
    if (rucproveedor.value === '') {
        Swal.fire({
            title: 'Sin Proveedor',
            icon: 'warning',
            text: 'Seleccione un proveedor',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        });
    } else if (timbrado.value === '') {
        Swal.fire({
            title: 'Sin Timbrado',
            icon: 'warning',
            text: 'Escribe un timbrado',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        }).then(() => {
            setTimeout(() => {
                timbrado.focus();
            }, 300);
        });
    } else if (concepto.value === '') {
        Swal.fire({
            title: 'Sin Concepto',
            icon: 'warning',
            text: 'Escribe un concepto de compra',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        }).then(() => {
            setTimeout(() => {
                concepto.focus();
            }, 300);
        });
    } else {
        fetch('../backend/insertcompra.php', {
            method: 'POST',
            body: formData
        })
            // .then(response => {
            //     return response.text(); // Cambiar a text() para ver la respuesta completa
            // })
            // .then(data => {
            //     console.log(data); // Mostrar la respuesta completa en la consola
            //     try {
            //         const jsonData = JSON.parse(data); // Intentar parsear a JSON
            //         // Procesar jsonData aquí
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
                        title: 'Registro cargado correctamente',
                        text: data.message + '' + data.id,
                        icon: 'success',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonColor: "#212529",
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'custom-swal'
                        },
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Atención',
                        text: data.message,
                        icon: 'warning',
                        confirmButtonColor: "#212529",
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'custom-swal'
                        },
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error,
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            });
    };
})
$(document).ready(function () {

    $('#idproveedor').select2({
        placeholder: "Busca por nombre o ruc",
        width: '100%'
    });
    $('#idproveedor').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../backend/obtener_datos_proveedor.php',
            data: {
                id: data['id']
            },
            success: function (response) {
                if (response) {
                    try {
                        let responseobjet = JSON.parse(response);
                        console.log("Respuesta del servidor:", responseobjet);
                        if (responseobjet.success && responseobjet.respuesta) {
                            $('#rucproveedor').val(responseobjet.respuesta.ruc_proveedor);
                            $('#id_proveedor').val(responseobjet.respuesta.id_proveedor)
                        } else {
                            console.error("Error en la respuesta:", responseobjet.message);
                            alert("No se encontraron datos del proveedor.");
                        }
                    } catch (e) {
                        console.error("Error al parsear la respuesta:", e);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error trayendo datos de la base de datos: ", textStatus, errorThrown);
            }
        });
    });
});
