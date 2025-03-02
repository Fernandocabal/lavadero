let formfactura = document.getElementById('formfactura'),
    selectservice = document.getElementById('selectservice'),
    btninsertfactura = document.getElementById('insertfactura');
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
        //             text: data.message,
        //             icon: 'success',
        //             allowEscapeKey: false,
        //             allowOutsideClick: false,
        //             showConfirmButton: true,
        //             showCancelButton: false,
        //             focusConfirm: true,
        //             confirmButtonColor: "#212529",
        //             confirmButtonText: 'Imprimir',
        //             customClass: {
        //                 popup: 'custom-swal'
        //             },
        //         }).then(result => {
        //             if (result.isConfirmed) {
        //                 formfactura.reset();
        //                 window.location.href = `../backend/facturafpdf.php?id=${data.id}`;
        //             }
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

    }
});