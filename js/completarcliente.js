function buscarCliente() {
    var ruc = document.getElementById("ruc").value;
    if (ruc.length >= 3) { // Ajustar la longitud mínima según tus necesidades
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../componetes/buscar_cliente.php?ruc=" + ruc, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                if (response.success) {
                    document.getElementById("nombrecliente").value
                        = response.data.nombres;
                    document.getElementById("direccion").value
                        = response.data.direccion;
                    document.getElementById("email").value
                        = response.data.email;
                    document.getElementById("phonenumber").value
                        = response.data.phonenumber;
                    // Completar otros campos del cliente

                    // Manejar caso de cliente no encontrado
                } else if (ruc.length === 2) {
                    // Si el RUC está vacío, limpiar los otros campos
                    document.getElementById("nombrecliente").value = "";
                    // ... (limpiar otros campos)
                }
            }
        };
        xhr.send();
    }
}