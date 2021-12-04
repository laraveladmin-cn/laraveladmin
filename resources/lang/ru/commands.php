<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "Компиляция и создание входного файла \"index.html\"",
    "Execute all migration files": "выполнить все файлы переноса",
    "Is the \":file\" file already overwritten?": "файл \": file\" уже существует?Y божество н.",
    "The \":file\" file already exists": "файл \": file\" уже существует",
    "File \":file\" created successfully": "файл «: file » создан успешно",
    "Failed to create file \":file\"": "Ошибка создания файла \": file\"",
    "Generate all resources": "генерировать все ресурсы",
    "Custom template controller generation": "Настройка диспетчера шаблонов",
    "Created At": "время создания",
    "Updated At": "время изменения",
    "Deleted At": "время удаления",
    "Custom template model generation": "Создать шаблон",
    "Custom template data fill file generation": "Создание файла с использованием шаблона",
    "Custom template front-end view generation": "Создать профиль",
    "The application language is not set to English to execute": "язык приложения не установлен на английском",
    "From \":old\" to \":new\"": "от «: old » до «: new »",
    "Failed to translate \":old\"": "ошибка перевода \": old\"",
    "Failed to translate \":old\" into \":lang\"": "перевод \": old\" на \": lang\" не удалось",
    "This command can only be executed in the development environment": "Выполнение команды возможно только в условиях разработки",
    "Automatic scan to generate Api document data": "генерировать данные для документа Api",
    "Initializing the creation of a soft connection": "инициализация создания мягких соединений",
    "The \":link\" link has been connected to \":target\"": "гибкое соединение \": link\" уже соединено с \"target\"",
    "The links have been created": "Все ссылки созданы",
    "Generate software code text for software copyright application": "текст программного обеспечения для получения авторских прав на программное обеспечение",
    "To enable support for relative links, please install the symfony/filesystem package": "чтобы включить поддержку относительных ссылок, установите пакет symfony / fileSystem",
    "Failed to delete file \":file\"": "Ошибка удаления файла: file"
}
str;
return json_decode($str,true);