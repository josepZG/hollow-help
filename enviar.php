<?php
// Configuración del correo
$destinatario = $email; 
$asunto = "Nuevo mensaje desde el formulario de contacto";

// Verificar que el formulario haya sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar los campos
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"]));
    
    $errores = "";

    // Validar nombre
    if (empty($nombre)) {
        $errores .= "El nombre es obligatorio. <br>";
    }

    // Validar correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores .= "El correo electrónico no es válido. <br>";
    }

    // Validar mensaje
    if (empty($mensaje)) {
        $errores .= "El mensaje no puede estar vacío. <br>";
    }

    // Si no hay errores, enviar el correo
    if (empty($errores)) {
        $cuerpoMensaje = "Has recibido un nuevo mensaje de: \n\n";
        $cuerpoMensaje .= "Nombre: $nombre \n";
        $cuerpoMensaje .= "Correo electrónico: $email \n\n";
        $cuerpoMensaje .= "Mensaje: \n$mensaje \n";

        // Encabezados del correo
        $headers = "From: $email" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Intentar enviar el correo
        if (mail($destinatario, $asunto, $cuerpoMensaje, $headers)) {
            echo "Tu mensaje ha sido enviado correctamente.";
        } else {
            echo "Hubo un error al enviar el mensaje. Por favor, inténtalo más tarde.";
        }
    } else {
        // Mostrar errores de validación
        echo "Error: <br>" . $errores;
    }
} else {
    echo "No se ha enviado el formulario correctamente.";
}
?>
