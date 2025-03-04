let formfactura = document.getElementById('formfactura'),
    selectservice = document.getElementById('selectservice'),
    btninsertfactura = document.getElementById('insertfactura'),
    btn_insert_timbrado = document.getElementById('insert_timbrado'),
    modaltimbrado = new bootstrap.Modal(document.getElementById('addtimbradoandnumeracion'), {
        backdrop: 'static',
        keyboard: false
    });

window.addEventListener("load", async function () {
    try {
        const response = await fetch("../backend/datos_factura/datosfactura.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        });

        // Ver el texto bruto antes de tratar de convertirlo a JSON
        // const responseText = await response.text();
        // console.log("Respuesta del servidor:", responseText);

        // // Intentar convertir la respuesta a JSON
        // const datatext = JSON.parse(responseText);

        if (!response.ok) {
            throw new Error("Error en la petición");
        }

        const data = await response.json();

        if (!data.success) {
            // console.error("Error:", data.message);
            const factura_numeracion = this.document.getElementById('factura_numeracion');
            const factura_timbrado = this.document.getElementById('factura_timbrado');
            const nro_factura = document.getElementById('nro_factura');
            nro_factura.value = data.prefijosucursal + '-' + data.prefijocaja + '-0000000';
            factura_numeracion.textContent = data.nro_factura;
            factura_timbrado.textContent = data.nro_timbrado;
            factura_numeracion.style.backgroundColor = "rgb(239, 13, 13, 0.5)";
            factura_timbrado.style.backgroundColor = "rgb(239, 13, 13, 0.5)";

            Swal.fire({
                title: 'Timbrado y Numeración',
                icon: 'warning',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showCancelButton: false,
                focusCancel: false,
                focusConfirm: false,
                text: data.message,
                confirmButtonColor: "#212529",
                confirmButtonText: 'Cargar Datos',
                customClass: {
                    popup: 'custom-swal'
                },
            }).then(result => {
                if (result.isConfirmed) {
                    modaltimbrado.show();
                }
            });
            return;
        }
        // console.log("Datos obtenidos:", data);
        if (data.success) {
            const factura_numeracion = this.document.getElementById('factura_numeracion');
            const factura_timbrado = this.document.getElementById('factura_timbrado');
            factura_numeracion.textContent = data.nro_factura;
            factura_timbrado.textContent = data.nro_timbrado;
        }

    } catch (error) {

        console.error("Error al obtener datos del usuario:", error);
    }
});

btn_insert_timbrado.addEventListener('click', (e) => {
    e.preventDefault();
    if (timbrado.value == 0) {
        timbrado.classList.add('is-invalid');
    } else if (fecha_inicio.value == 0) {
        fecha_inicio.classList.add('is-invalid');
    } else if (fecha_vencimiento.value == 0) {
        fecha_vencimiento.classList.add('is-invalid');
    } else if (nrofactura.value == 0) {
        nrofactura.classList.add('is-invalid');
    } else {
        modaltimbrado.hide();
        const formData = new FormData(form_timbrado);
        fetch('../backend/timbrado/insert_timbrado.php', {
            method: 'POST',
            body: formData
        })
            // .then(response => {
            //     return response.text(); // Cambiar a text() para ver la respuesta completa
            // })
            // .then(data => {
            //     console.log(data);
            // })
            // .catch(error => {
            //     console.error('Error en la petición:', error);
            // });
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        text: data.message,
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
                            formfactura.reset();
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: "#212529",
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'custom-swal'
                        },
                    }).then(result => {
                        if (result.isConfirmed) {
                            formfactura.reset();
                            location.reload();
                        }
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

    }
});
// Seccion para hacer fech a la BD e insertar la factura
btninsertfactura.addEventListener('click', (evento) => {
    evento.preventDefault();
    const nroci = document.getElementById('nroci');
    if (nroci.value == 0) {
        Swal.fire({
            title: 'Sin cliente',
            icon: 'warning',
            text: 'Por favor selecciona un cliente',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        });

    } else if (selectservice.value == 0) {
        Swal.fire({
            title: 'Sin producto',
            icon: 'warning',
            text: 'Debes de seleccionar al menos 1 producto',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        });
    } else {
        const formData = new FormData(formfactura);
        fetch('../backend/insertfactura.php', {
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
                        text: data.message,
                        icon: 'success',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonColor: "#212529",
                        confirmButtonText: 'Imprimir',
                        customClass: {
                            popup: 'custom-swal'
                        },
                    }).then(result => {
                        if (result.isConfirmed) {
                            formfactura.reset();
                            window.location.href = `../backend/facturafpdf.php?id=${data.id}`;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
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

    }
});