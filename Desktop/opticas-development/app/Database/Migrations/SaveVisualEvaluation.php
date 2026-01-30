public function saveVisualEvaluation() {
    // Obtener los datos del formulario
    $formData = $this->request->getPost();
    
    // Obtener los datos del canvas
    $canvasData = $this->request->getPost('canvas_image');
    
    // Remover el encabezado de datos base64
    $imageData = str_replace('data:image/png;base64,', '', $canvasData);
    $imageData = str_replace(' ', '+', $imageData);
    
    // Decodificar la imagen
    $imageBinary = base64_decode($imageData);
    
    // Crear un nombre único para la imagen
    $imageName = uniqid() . '.png';
    
    // Guardar la imagen en el sistema de archivos
    file_put_contents(WRITEPATH . 'uploads/visual_evaluations/' . $imageName, $imageBinary);
    
    // Guardar la referencia en la base de datos
    $data = [
        'patient_id' => $formData['patient'],
        'canvas_image' => $imageName,
        // ... otros campos del formulario
    ];
    
    // Usando el modelo correspondiente para guardar en la base de datos
    $visualEvaluationModel = new VisualEvaluationModel();
    $saved = $visualEvaluationModel->save($data);
    
    // Retornar respuesta
    return $this->response->setJSON([
        'success' => $saved,
        'message' => $saved ? 'Evaluación visual guardada correctamente' : 'Error al guardar la evaluación'
    ]);
}