let fechafactura = document.getElementById('fechafactura'),
    form = document.getElementById('formcompras'),
    nombreproveedor = document.getElementById('nombreproveedor'),
    proveedor = document.getElementById('proveedor');
proveedor.addEventListener('change', () => {
    const formData = new FormData(form);
    // for (let [key, value] of formData.entries()) {
    //     console.log(`${key}: ${value}`);
    // }
    if (proveedor.value.length >= 5) {
        fetch('../backend/obtener_datos_proveedor.php', {
            method: 'POST',
            body: formData,
        }).then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    const respuesta = data.respuesta;
                    nombreproveedor.value = respuesta.nombre_proveedor;
                } else {
                    Swal.fire({
                        icon: "error",
                        text: data.message || "Ocurrió un error",
                        confirmButtonColor: "#212529",
                        confirmButtonText: `Aceptar`
                    });
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: "error",
                    text: error || 'Ocurrió un error al enviar los datos',
                    confirmButtonColor: "#212529",
                    confirmButtonText: `Aceptar`
                });
            });
    } else {
        Swal.fire({
            icon: "error",
            text: 'Por favor verifique el ruc ingresado',
            confirmButtonColor: "#212529",
            confirmButtonText: `Aceptar`
        });
    }

});
