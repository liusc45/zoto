// Función para obtener los datos del canvas
function getCanvasData() {
    const canvas = document.getElementById('eyeCanvas');
    // Convertir el canvas a base64
    return canvas.toDataURL('image/png');
}

// Modificar la función getJsonForm() existente para incluir los datos del canvas
function getJsonForm() {
    const form = document.getElementById('form-visual-evaluation');
    const formData = new FormData(form);
    
    // Agregar los datos del canvas
    const canvasData = getCanvasData();
    formData.append('canvas_image', canvasData);

    // Realizar la petición AJAX
    fetch('/ruta/al/endpoint', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Mostrar mensaje de éxito
            alert('Datos guardados correctamente');
        } else {
            // Mostrar mensaje de error
            alert('Error al guardar los datos');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los datos');
    });
}