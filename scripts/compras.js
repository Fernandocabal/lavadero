let fechafactura = document.getElementById('fechafactura'),
    form = document.getElementById('formcompras'),
    nombreproveedor = document.getElementById('nombreproveedor'),
    proveedor = document.getElementById('idproveedor'),
    id_proveedor = document.getElementById('id_proveedor'),
    insertcompra = document.getElementById('insertcompra');

form.addEventListener('submit', (evento) => {
    evento.preventDefault();
    const formData = new FormData(form);
    fetch('../backend/insertcompra.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            return response.text(); // Cambiar a text() para ver la respuesta completa
        })
        .then(data => {
            console.log(data); // Mostrar la respuesta completa en la consola
            try {
                const jsonData = JSON.parse(data); // Intentar parsear a JSON
                // Procesar jsonData aquí
            } catch (error) {
                console.error('Error al parsear JSON:', error);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
    // .then(response => response.json())
    // .then(data => {
    //     if (data.success) {
    //         Swal.fire({
    //             title: 'Registro cargado correctamente',
    //             text: data.message + '' + data.id,
    //             icon: 'success',
    //             allowEscapeKey: false,
    //             allowOutsideClick: false,
    //             showConfirmButton: true,
    //             showCancelButton: false,
    //             focusConfirm: true,
    //             confirmButtonColor: "#212529",
    //             confirmButtonText: 'Aceptar',
    //             customClass: {
    //                 popup: 'custom-swal'
    //             },
    //         });
    //     } else {
    //         Swal.fire({
    //             title: 'Error',
    //             text: data.message,
    //             icon: 'error',
    //             confirmButtonColor: "#212529",
    //             confirmButtonText: 'Aceptar',
    //             customClass: {
    //                 popup: 'custom-swal'
    //             },
    //         });
    //     }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    //     Swal.fire({
    //         title: 'Error',
    //         text: error,
    //         icon: 'error',
    //         confirmButtonColor: "#212529",
    //         confirmButtonText: 'Aceptar',
    //         customClass: {
    //             popup: 'custom-swal'
    //         },
    //     });
    // });

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
