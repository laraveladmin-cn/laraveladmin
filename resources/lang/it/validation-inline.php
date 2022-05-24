<?php 
$str = <<<'str'
{
    "accepted": "Devi accettare.",
    "active_url": "Non è un URL valido.",
    "after": "Deve essere più tardi della data.",
    "after_or_equal": "Deve essere uguale a: data o successiva.",
    "alpha": "Può consistere solo di lettere.",
    "alpha_dash": "Solo lettere, numeri, trattini (-) e sottolineature () forma.",
    "alpha_num": "Può consistere solo di lettere e numeri.",
    "array": "Dev'essere un array.",
    "before": "Deve essere prima della data.",
    "before_or_equal": "Deve essere uguale a: data o precedente.",
    "between": {
        "numeric": "Deve essere tra: Min -: max.",
        "file": "Deve essere tra: Min -: Max KB.",
        "string": "Deve essere tra: Min -: Max caratteri.",
        "array": "Ci devono essere solo: Min -: Max unità."
    },
    "boolean": "Dev'essere booleano.",
    "confirmed": "I due input sono incoerenti.",
    "date": "Non è una data valida.",
    "date_equals": "Deve essere uguale a: data.",
    "date_format": "Il formato deve essere: format.",
    "different": "Dev'essere diverso dall'altro.",
    "digits": "Devono essere cifre.",
    "digits_between": "Deve essere un numero tra: min e: cifre massime.",
    "dimensions": "La dimensione dell'immagine non è corretta.",
    "distinct": "Esiste già.",
    "email": "Non una cassetta postale legale.",
    "ends_with": "Deve finire con: valori.",
    "exists": "Inesistente.",
    "file": "Dev'essere un fascicolo.",
    "filled": "Non può essere vuoto.",
    "gt": {
        "numeric": "Deve essere maggiore di: valore.",
        "file": "Deve essere maggiore di: valore KB.",
        "string": "Devono essere più di: caratteri di valore.",
        "array": "Devono essere più di: elementi di valore."
    },
    "gte": {
        "numeric": "Deve essere maggiore o uguale a: valore.",
        "file": "Deve essere maggiore o uguale a: valore KB.",
        "string": "Deve essere maggiore o uguale a: caratteri di valore.",
        "array": "Deve essere più o uguale a: elementi di valore."
    },
    "image": "Dev'essere una foto.",
    "in": "Opzione non valida.",
    "in_array": "Deve essere in: altro.",
    "integer": "Dev'essere un numero intero.",
    "ip": "Deve essere un indirizzo IP valido.",
    "ipv4": "Deve essere un indirizzo IPv4 valido.",
    "ipv6": "Deve essere un indirizzo IPv6 valido.",
    "json": "Deve essere nel formato JSON corretto.",
    "lt": {
        "numeric": "Deve essere inferiore a: valore.",
        "file": "Deve essere inferiore a: valore KB.",
        "string": "Deve essere inferiore a: caratteri di valore.",
        "array": "Deve essere inferiore a: elementi di valore."
    },
    "lte": {
        "numeric": "Deve essere inferiore o uguale a: valore.",
        "file": "Deve essere inferiore o uguale a: valore KB.",
        "string": "Deve essere inferiore o uguale a: caratteri di valore.",
        "array": "Deve essere inferiore o uguale a: elementi di valore."
    },
    "max": {
        "numeric": "Non può essere maggiore di: max.",
        "file": "Non può essere maggiore di: Max KB.",
        "string": "Non può essere maggiore di: Numero massimo di caratteri.",
        "array": "Al massimo: cellule massime."
    },
    "mimes": "Deve essere un file di tipo: valori.",
    "mimetypes": "Deve essere un file di tipo: valori.",
    "min": {
        "numeric": "Deve essere maggiore o uguale a: min.",
        "file": "Le dimensioni non possono essere inferiori a: Min KB.",
        "string": "Almeno: caratteri minimi.",
        "array": "Almeno: unità minime."
    },
    "not_in": "Opzione non valida.",
    "not_regex": "Errore di formato.",
    "numeric": "Dev'essere un numero.",
    "password": "Errore password",
    "present": "Deve esistere.",
    "regex": "Formato errato.",
    "required": "Non può essere vuoto.",
    "required_if": "Quando: altro è: valore, non può essere vuoto.",
    "required_unless": "Non può essere vuoto quando: altro non è: valori.",
    "required_with": "Quando: valori esiste, non può essere vuoto.",
    "required_with_all": "Quando: valori esiste, non può essere vuoto.",
    "required_without": "Quando: valori non esistono, non possono essere vuoti.",
    "required_without_all": "Quando: i valori non esistono, non possono essere vuoti.",
    "same": "Deve essere uguale a: altri.",
    "size": {
        "numeric": "Le dimensioni devono essere: dimensioni.",
        "file": "Le dimensioni devono essere: size KB.",
        "string": "Devono essere: caratteri di dimensione.",
        "array": "Devono essere: unità di misura."
    },
    "starts_with": "Deve iniziare con: valori.",
    "string": "Dev'essere una corda.",
    "timezone": "Deve essere un valore di fuso orario valido.",
    "unique": "Esiste già.",
    "uploaded": "Caricamento fallito.",
    "url": "Formato errato.",
    "uuid": "Deve essere un UUID valido.",
    "custom": {
        "attribute-name": {
            "rule-name": "Messaggio personalizzato"
        }
    },
    "attributes": {
        "name": "Nome",
        "username": "Nome utente",
        "email": "Cassetta postale",
        "first_name": "Nome",
        "last_name": "Cognome",
        "password": "Password",
        "password_confirmation": "Conferma password",
        "city": "città",
        "country": "Paese",
        "address": "Indirizzo",
        "phone": "Telefono",
        "mobile": "Telefono cellulare",
        "age": "Età",
        "sex": "Sesso",
        "gender": "Sesso",
        "day": "Giorno",
        "month": "Mese",
        "year": "Anno",
        "hour": "Tempo",
        "minute": "Branch",
        "second": "Secondo",
        "title": "Titolo",
        "content": "Contenuto",
        "description": "Descrivere",
        "excerpt": "Astratto",
        "date": "Data",
        "time": "Tempo",
        "available": "Disponibile",
        "size": "Dimensione"
    }
}
str;
return json_decode($str,true);