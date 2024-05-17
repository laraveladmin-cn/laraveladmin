<?php 
$str = <<<'str'
{
    "accepted": "Du musst akzeptieren.",
    "active_url": "Ist keine gültige URL.",
    "after": "Muss später sein als: Datum.",
    "after_or_equal": "Muss gleich sein: Datum oder später.",
    "alpha": "Es kann nur aus Buchstaben bestehen.",
    "alpha_dash": "Nur Buchstaben, Zahlen, Bindestriche (-) und Unterstriche() Form.",
    "alpha_num": "Es kann nur aus Buchstaben und Zahlen bestehen.",
    "array": "Muss ein Array sein.",
    "before": "Muss früher sein als: Datum.",
    "before_or_equal": "Muss gleich sein: Datum oder früher.",
    "between": {
        "numeric": "Muss zwischen: Min -:max.",
        "file": "Muss zwischen: Min -: Max KB sein.",
        "string": "Muss zwischen Min -:Max Zeichen sein.",
        "array": "Es darf nur sein: Min -: Max Einheiten."
    },
    "boolean": "Muss Boolesch sein.",
    "confirmed": "Die beiden Eingänge sind inkonsistent.",
    "date": "Ist kein gültiges Datum.",
    "date_equals": "Muss gleich sein: Datum.",
    "date_format": "Das Format muss sein: format.",
    "different": "Muss anders sein als: anders.",
    "digits": "Muss: Ziffern Ziffern sein.",
    "digits_between": "Muss eine Zahl zwischen: min und: max Ziffern sein.",
    "dimensions": "Die Bildgröße ist falsch.",
    "distinct": "Es existiert bereits.",
    "email": "Kein legaler Briefkasten.",
    "ends_with": "Muss mit: Werten enden.",
    "exists": "Nicht existent.",
    "file": "Muss eine Akte sein.",
    "filled": "Kann nicht leer sein.",
    "gt": {
        "numeric": "Muss größer sein als: Wert.",
        "file": "Muss größer sein als: Wert KB.",
        "string": "Muss mehr sein als: Wertzeichen.",
        "array": "Muss mehr sein als: Wertelemente."
    },
    "gte": {
        "numeric": "Muss größer oder gleich sein: Wert.",
        "file": "Muss größer oder gleich sein: Wert KB.",
        "string": "Muss mehr als oder gleich sein: Wertzeichen.",
        "array": "Muss mehr als oder gleich sein: Wertelemente."
    },
    "image": "Muss ein Bild sein.",
    "in": "Ungültige Option.",
    "in_array": "Muss in: anderen sein.",
    "integer": "Muss eine ganze Zahl sein.",
    "ip": "Muss eine gültige IP-Adresse sein.",
    "ipv4": "Muss eine gültige IPv4-Adresse sein.",
    "ipv6": "Muss eine gültige IPv6-Adresse sein.",
    "json": "Muss im richtigen JSON-Format sein.",
    "lt": {
        "numeric": "Muss kleiner sein als: Wert.",
        "file": "Muss kleiner sein als: Wert KB.",
        "string": "Muss kleiner sein als: Wertzeichen.",
        "array": "Muss kleiner sein als: Wertelemente."
    },
    "lte": {
        "numeric": "Muss kleiner oder gleich sein: Wert.",
        "file": "Muss kleiner oder gleich sein: Wert KB.",
        "string": "Muss kleiner oder gleich: Wert Zeichen sein.",
        "array": "Muss kleiner oder gleich sein: Wertelemente."
    },
    "max": {
        "numeric": "Kann nicht größer sein als: max.",
        "file": "Kann nicht größer sein als: Max KB.",
        "string": "Kann nicht größer sein als: Max Zeichen.",
        "array": "Höchstens: Max Zellen."
    },
    "mimes": "Muss eine Datei vom Typ: values sein.",
    "mimetypes": "Muss eine Datei vom Typ: values sein.",
    "min": {
        "numeric": "Muss größer oder gleich sein: min.",
        "file": "Größe darf nicht kleiner sein als: Min KB.",
        "string": "Mindestens: Min Charaktere.",
        "array": "Mindestens: Min Einheiten."
    },
    "not_in": "Ungültige Option.",
    "not_regex": "Formatfehler.",
    "numeric": "Muss eine Nummer sein.",
    "password": "Passwort-Fehler",
    "present": "Muss existieren.",
    "regex": "Falsches Format.",
    "required": "Kann nicht leer sein.",
    "required_if": "Wenn: other: value ist, kann es nicht leer sein.",
    "required_unless": "Kann nicht leer sein, wenn: other nicht: Werte ist.",
    "required_with": "Wenn: Werte vorhanden sind, kann sie nicht leer sein.",
    "required_with_all": "Wenn: Werte vorhanden sind, kann sie nicht leer sein.",
    "required_without": "Wenn: Werte nicht existieren, kann sie nicht leer sein.",
    "required_without_all": "Wenn: Werte nicht existieren, kann sie nicht leer sein.",
    "same": "Muss dasselbe sein wie: andere.",
    "size": {
        "numeric": "Größe muss sein: Größe.",
        "file": "Größe muss sein: Größe KB.",
        "string": "Muss sein: Größe Zeichen.",
        "array": "Muss sein: Größeneinheiten."
    },
    "starts_with": "Muss mit: Werten beginnen.",
    "string": "Muss eine Schnur sein.",
    "timezone": "Muss ein gültiger Zeitzonenwert sein.",
    "unique": "Es existiert bereits.",
    "uploaded": "Hochladen fehlgeschlagen.",
    "url": "Falsches Format.",
    "uuid": "Muss eine gültige UUID sein.",
    "custom": {
        "attribute-name": {
            "rule-name": "Benutzerdefinierte Nachricht"
        }
    },
    "attributes": {
        "name": "Name",
        "username": "Benutzername",
        "email": "Postfach",
        "first_name": "Name",
        "last_name": "Nachname",
        "password": "Passwort",
        "password_confirmation": "Passwort bestätigen",
        "city": "Stadt",
        "country": "Land",
        "address": "Adresse",
        "phone": "Telefon",
        "mobile": "Handy",
        "age": "Alter",
        "sex": "Geschlecht",
        "gender": "Geschlecht",
        "day": "Tag",
        "month": "Monat",
        "year": "Jahr",
        "hour": "Zeit",
        "minute": "Zweig",
        "second": "Zweite",
        "title": "Titel",
        "content": "Inhalt",
        "description": "Beschreibung",
        "excerpt": "Abstract",
        "date": "Datum",
        "time": "Zeit",
        "available": "Verfügbar",
        "size": "Größe"
    }
}
str;
return json_decode($str,true);