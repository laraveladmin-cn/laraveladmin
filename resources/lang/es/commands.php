<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Compilar y generar el archivo de entrada frontal \"index.html\"",
    "Execute all migration files": "Ejecutar todos los archivos de migración",
    "Is the \":file\" file already overwritten?": "¿El archivo \": file\" ya existe para sobrescribir?Y | N]",
    "The \":file\" file already exists": "El archivo \": Archivo\" ya existe",
    "File \":file\" created successfully": "Archivo \": Archivo\" creado con éxito",
    "Failed to create file \":file\"": "Falló la creación del archivo \": Archivo\"",
    "Generate all resources": "Generar todos los recursos",
    "Custom template controller generation": "Generación personalizada de controladores de plantillas",
    "Created At": "Tiempo de creación",
    "Updated At": "Tiempo de modificación",
    "Deleted At": "Tiempo de eliminación",
    "Custom template model generation": "Generación de modelos de plantilla personalizados",
    "Custom template data fill file generation": "Personalizar la generación de archivos de relleno de datos de plantilla",
    "Custom template front-end view generation": "Personalizar la generación de la vista frontal de la plantilla",
    "The application language is not set to English to execute": "El idioma aplicado no se puede ejecutar cuando no se establece en inglés",
    "From \":old\" to \":new\"": "De \": Old\" a \": New\"",
    "Failed to translate \":old\"": "Falló la traducción \": Old\"",
    "Failed to translate \":old\" into \":lang\"": "Falló la traducción \": Old\" a \": lang\"",
    "This command can only be executed in the development environment": "Este comando sólo se puede ejecutar en el entorno de desarrollo",
    "Automatic scan to generate Api document data": "Escaneo automático para generar datos de documentos API",
    "Initializing the creation of a soft connection": "Inicializar para crear una conexión suave",
    "The \":link\" link has been connected to \":target\"": "Conexión suave \": Link\" ya está conectada a \": target\"",
    "The links have been created": "Todos los enlaces han sido creados",
    "Generate software code text for software copyright application": "Generar texto de código de software para solicitar derechos de autor de software",
    "To enable support for relative links, please install the symfony/filesystem package": "Para habilitar el soporte de enlaces relativos, instale el paquete symfony / Filesystem"
}
str;
return json_decode($str,true);