<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Compiler pour générer le fichier d'entrée frontale \"index.html\"",
    "Execute all migration files": "Exécuter tous les fichiers de migration",
    "Is the \":file\" file already overwritten?": "Le fichier «: File » existe - t - il déjà?Y | n]",
    "The \":file\" file already exists": "Le fichier «: file» existe déjà",
    "File \":file\" created successfully": "Fichier \": fichier\" créé avec succès",
    "Failed to create file \":file\"": "Impossible de créer le fichier «: File »",
    "Generate all resources": "Générer toutes les ressources",
    "Custom template controller generation": "Personnaliser la génération du Contrôleur de modèle",
    "Created At": "Temps de création",
    "Updated At": "Temps de modification",
    "Deleted At": "Supprimer le temps",
    "Custom template model generation": "Génération de modèles personnalisés",
    "Custom template data fill file generation": "Génération de fichiers de remplissage de données de modèle personnalisés",
    "Custom template front-end view generation": "Personnaliser la génération de la vue avant du modèle",
    "The application language is not set to English to execute": "Ne peut être exécuté que si la langue appliquée n'est pas définie à l'anglais",
    "From \":old\" to \":new\"": "De \": ancien\" à \": nouveau\"",
    "Failed to translate \":old\"": "La traduction «: old» a échoué",
    "Failed to translate \":old\" into \":lang\"": "Impossible de traduire «: Old » en «: Lang »",
    "This command can only be executed in the development environment": "Cette commande ne peut être exécutée que dans un environnement de développement",
    "Automatic scan to generate Api document data": "Numériser automatiquement les données du document API généré",
    "Initializing the creation of a soft connection": "Initialiser la création d'une connexion souple",
    "The \":link\" link has been connected to \":target\"": "La connexion souple «: Link » est déjà connectée à «: target »",
    "The links have been created": "Tous les liens ont été créés",
    "Generate software code text for software copyright application": "Générer le texte du code logiciel pour demander le droit d'auteur sur le logiciel",
    "To enable support for relative links, please install the symfony/filesystem package": "Pour activer la prise en charge des liens relatifs, installez le paquet sysmfony / Filesystem"
}
str;
return json_decode($str,true);