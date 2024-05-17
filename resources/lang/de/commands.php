<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Kompilieren und generieren Sie die Frontend-Eingabedatei \"index. HTML\"",
    "Execute all migration files": "Alle Migrationsdateien ausführen",
    "Is the \":file\" file already overwritten?": "Die Datei \":file\" existiert bereits. Möchten Sie sie überschreiben? [y|N]",
    "The \":file\" file already exists": "Die Datei \":file\" existiert bereits",
    "File \":file\" created successfully": "Die Datei \":file\" wurde erfolgreich erstellt",
    "Failed to create file \":file\"": "Datei ':file' konnte nicht erstellt werden",
    "Generate all resources": "Alle Ressourcen generieren",
    "Custom template controller generation": "Generierung benutzerdefinierter Vorlagencontroller",
    "Created At": "Erstellungszeit",
    "Updated At": "Änderungszeit",
    "Deleted At": "Zeit löschen",
    "Custom template model generation": "Generierung benutzerdefinierter Vorlagen",
    "Custom template data fill file generation": "Generierung benutzerdefinierter Vorlagendaten zur Ausfülldatei",
    "Custom template front-end view generation": "Generierung benutzerdefinierter Vorlagen-Frontend-Ansicht",
    "The application language is not set to English to execute": "Es kann nur ausgeführt werden, wenn die Sprache der Anwendung nicht auf Englisch eingestellt ist",
    "From \":old\" to \":new\"": "Von \": alt\" zu \": neu\"",
    "Failed to translate \":old\"": "Übersetzen von \": old\"",
    "Failed to translate \":old\" into \":lang\"": "Übersetzen von \": old\" in \": Lang\" fehlgeschlagen",
    "This command can only be executed in the development environment": "Dieser Befehl kann nur in der Entwicklungsumgebung ausgeführt werden",
    "Automatic scan to generate Api document data": "Automatisches Scannen und Generieren von API-Dokumentdaten",
    "Initializing the creation of a soft connection": "Initialisieren Softverbindung erstellen",
    "The \":link\" link has been connected to \":target\"": "Soft connection \": link\" ist bereits mit \": target\" verbunden",
    "The links have been created": "Alle Links wurden erstellt",
    "Generate software code text for software copyright application": "Generieren von Software Code Text für die Beantragung von Software Copyright",
    "To enable support for relative links, please install the symfony/filesystem package": "Um die Unterstützung für relative Links zu aktivieren, installieren Sie das Dateisystem-Paket symfony.",
    "Failed to delete file \":file\"": "Datei ''': Datei ''konnte nicht gelöscht werden"
}
str;
return json_decode($str,true);