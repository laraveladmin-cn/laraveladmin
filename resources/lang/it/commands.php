<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Compilare e generare il file di entrata front-end \"index. HTML\"",
    "Execute all migration files": "Esegui tutti i file di migrazione",
    "Is the \":file\" file already overwritten?": "Il file \": file\" esiste già. Vuoi sovrascriverlo? [y|N]",
    "The \":file\" file already exists": "Il file \": file\" esiste già",
    "File \":file\" created successfully": "Il file \": file\" è stato creato con successo",
    "Failed to create file \":file\"": "Creazione del file ': file' non riuscita",
    "Generate all resources": "Genera tutte le risorse",
    "Custom template controller generation": "Generazione controller modello personalizzato",
    "Created At": "Tempo di creazione",
    "Updated At": "Tempo di modifica",
    "Deleted At": "Elimina ora",
    "Custom template model generation": "Generazione di modelli personalizzati",
    "Custom template data fill file generation": "Generazione di file di riempimento dati del modello personalizzato",
    "Custom template front-end view generation": "Generazione della vista frontale del modello personalizzato",
    "The application language is not set to English to execute": "Può essere eseguito solo quando la lingua dell'applicazione non è impostata su inglese",
    "From \":old\" to \":new\"": "Da \": vecchio\" a \": nuovo\"",
    "Failed to translate \":old\"": "Traduzione \": old\" non riuscita",
    "Failed to translate \":old\" into \":lang\"": "Impossibile tradurre \": old\" in \": Lang\"",
    "This command can only be executed in the development environment": "Questo comando può essere eseguito solo nell'ambiente di sviluppo",
    "Automatic scan to generate Api document data": "Scansiona e genera automaticamente i dati dei documenti API",
    "Initializing the creation of a soft connection": "Inizializza crea connessione morbida",
    "The \":link\" link has been connected to \":target\"": "Connessione morbida \": link\" è già connesso a \": target\"",
    "The links have been created": "Tutti i link sono stati creati",
    "Generate software code text for software copyright application": "Genera il testo del codice software per richiedere il copyright del software",
    "To enable support for relative links, please install the symfony/filesystem package": "Per abilitare il supporto per i collegamenti relativi, installare il pacchetto symfony / filesystem",
    "Failed to delete file \":file\"": "Eliminazione del file '': file ''non riuscita"
}
str;
return json_decode($str,true);