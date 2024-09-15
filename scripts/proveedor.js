async function get(id) {
    const url = `../include/editproveemodal.php?id=${encodeURIComponent(id)}`;
    try {
        // Realiza la solicitud GET
        const response = await fetch(url, {
            method: 'GET',
        });// Verifica si la respuesta es exitosa
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }

        // Convierte la respuesta a formato JSON
        const data = await response.json();

        // Maneja los datos recibidos
        console.log('Datos recibidos:', data);
        return data; // Devuelve los datos para que puedan ser utilizados en otras partes del código

    } catch (error) {
        // Maneja cualquier error que ocurra durante la solicitud o el procesamiento
        console.error('Error al realizar la solicitud:', error);
        // Puedes optar por devolver un valor predeterminado o lanzar el error para que lo maneje el llamador
        return null;
    }
};