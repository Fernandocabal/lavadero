function select_sucursal() {
    let empresa_select = select_empresa.value,
        sucursal_select = document.getElementById('select_sucursal'),
        select_caja = document.getElementById('select_caja');
    if (!empresa_select) return;
    fetch('../backend/jsonsucursal.php?id=' + empresa_select)
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
                sucursal_select.innerHTML = "<option value=''>Selecciona una sucursal</option>";
                data.sucursales.forEach(function (sucursal) {
                    var optionElement = document.createElement("option");
                    optionElement.value = sucursal.id_sucursal;
                    optionElement.textContent = sucursal.nombre;
                    sucursal_select.appendChild(optionElement);
                });
            } else {
                var optionElement = document.createElement("option");
                optionElement.value = '';
                optionElement.textContent = 'No hay sucursales disponibles';
                sucursal_select.appendChild(optionElement);
            }
        })
        .catch(error => {
            console.error('Error al cargar los productos:', error);
        });
};
select_empresa.addEventListener("change", select_sucursal)

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