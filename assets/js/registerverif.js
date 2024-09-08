let
    inputname = document.getElementById('inputname'),
    formregis = document.getElementById('formregis'),
    inputvehiculo = document.getElementById('inputvehiculo'),
    option_container = document.getElementById('option-container'),
    totalValueElement = document.getElementById('viewvalor');
const optionbox = document.querySelectorAll('input[type="checkbox"]');
const optionboxArray = Array.from(optionbox);
formregis.addEventListener("submit", function (event) {
    const value = inputname.value;
    if (value === '') {
        event.preventDefault();
        inputname.classList.toggle('is-invalid');
        inputname.focus();
    } else {
        if (inputvehiculo.selectedIndex == 0) {
            event.preventDefault();
            inputvehiculo.classList.toggle('is-invalid');
            inputvehiculo.focus();
        }

    }

});

//Sección para mostar las opciones de acuerdo al tipo de vehiculo seleccionado
const vehicleSelect = document.getElementById('inputvehiculo');
const optionContainer = document.getElementById('option-container');

vehicleSelect.addEventListener('change', function () {
    const selectedVehicleId = this.value;
    optionContainer.innerHTML = '';
    if (selectedVehicleId) {
        fetch(`../backend/viewoption.php?vehicleId=${selectedVehicleId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.options.forEach(option => {
                        const optionElement = document.createElement('div');
                        optionElement.classList.add('form-check', 'd-flex', 'justify-content-between');

                        const divcontainer = document.createElement('div');

                        const checkboxLabel = document.createElement('label');
                        checkboxLabel.classList.add('form-check-label');
                        checkboxLabel.htmlFor = option.id_precios;
                        checkboxLabel.textContent = option.producto;

                        const valueinput = document.createElement('input');
                        valueinput.type = 'hidden';
                        valueinput.name = 'nombre[]';
                        valueinput.value = option.producto;

                        const checkboxvalue = document.createElement('div');
                        checkboxvalue.textContent = option.precio + ' GS'

                        const checkboxElement = document.createElement('input');
                        checkboxElement.classList.add('form-check-input');
                        checkboxElement.type = 'checkbox';
                        checkboxElement.name = 'opcion[]';
                        checkboxElement.value = option.precio;
                        checkboxElement.id = option.id_precios;

                        divcontainer.appendChild(checkboxElement);
                        divcontainer.appendChild(checkboxLabel);
                        divcontainer.appendChild(valueinput);

                        optionElement.appendChild(divcontainer);
                        optionElement.appendChild(divcontainer);
                        optionElement.appendChild(divcontainer);
                        optionElement.appendChild(checkboxvalue);

                        optionContainer.appendChild(optionElement);
                    });
                } else {
                    console.error('Error al obtener opciones:', data.error);
                }
            });
    }
});