<?php

// parametri
$token_accesso_pagina = 'EAAHvZAl2auPABAGMipa8Qb2lhLeqMYWyCA4sHEOFz6XLPlGyZBZC6oHZCyLw0I7oqjoFcSZCgZATWXt9y2tZBWpcWZCRURJb5gL8EZAulNK1IUz1N0ZCRZCnGLWQ4nu1tKuFSTJTJCqJaRbDwcofuKbcyjcO8DGXMZCrO8ktBjuF10So39mwLBWYRBQx';
$token_verifica = 'fb_bot';

// Convalida il token di verifica necessario per configurare il webhook
if (isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] === '$token_verifica') {
        echo $_GET['hub_challenge'];
        return;
    } else {
        echo 'Token di verifica non valido.';
        return;
    }
}

// Ricevi e invia messaggi
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {

    // Invia l'ID della pagina Facebook
    $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
    // Messaggio inviato dall'utente
    $message = $input['entry'][0]['messaging'][0]['message']['text'];

    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=$token_accesso_pagina';

    // Inizializza curl
    $ch = curl_init($url);
    /* Prepara risposta
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
        "message":{
            "text":"Hai scritto:, ' . $message . '"
        }
    }';

    // Impostazioni curl per inviare i dati di un post JSON
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        // L'utente riceve il messaggio dal bot
        $result = curl_exec($ch);
    }
}

?>
