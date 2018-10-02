<?php

// query per l'estrazione delle info utente
function queryInfoUtente(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT * FROM utente NATURAL JOIN info_utente WHERE email_utente=' . $email_utente;
    return $sql;
}

// query per l'estrazione degli hobby
function queryHobbyUtente(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT tipo_hobby FROM hobby WHERE email_utente=' . $email_utente;
    return $sql;
}

// query per il numero di richieste
function queryRichieste(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT count(*) AS num_richieste FROM seguaci_seguiti ' . 
              'WHERE utente_seguito=' . $email_utente . ' AND richiesta_accettata=FALSE';
    return $sql;
}

// query per il numero di utenti seguaci
function querySeguaci(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT count(*) AS num_seguaci FROM seguaci_seguiti ' . 
              'WHERE utente_seguito=' . $email_utente . ' AND richiesta_accettata=TRUE';
    return $sql;
}

// query per il numero di utenti seguiti
function querySeguiti(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT count(*) AS num_seguiti FROM seguaci_seguiti ' . 
              'WHERE utente_seguace=' . $email_utente . ' AND richiesta_accettata = TRUE';
    return $sql;
}

// query per il numero di luoghi preferiti
function queryLuoghiPreferiti(){
    $email_utente = "'" . $_SESSION['email_utente'] . "'";
    $sql = 'SELECT count(*) AS num_luogo_preferito FROM luogo_preferito WHERE email_utente=' . $email_utente;
    return $sql;
}


//query per la modifica della foto profilo
function queryUpdateFotoProfilo($input){
    
    $utente = "'" . $_SESSION['email_utente'] . "'";
    
    $sql = 'UPDATE utente SET img_profilo=' . $input['img_profilo']  . ', ' .  
              'path_img_profilo=' .  $input['path_img_profilo'] . ' WHERE  email_utente=' . $utente;
    
    return $sql;
}

//  query per la select dei post inseriti dalle persone seguite dall'utente 
function queryPostListProfilo (){

$sql = '
    SELECT 
            email_utente, utente_esperto, nickname, path_img_profilo,
            tipo_cinguettio, id_cinguettio,data_ora_cinguettio,
            descrizione_foto, nome_foto, path_foto, 
            messaggio, inappropriato, oscurato, 
            latitudine, longitudine
    FROM 
             (utente NATURAL JOIN cinguettio NATURAL JOIN 
             (foto NATURAL LEFT OUTER JOIN testo NATURAL LEFT OUTER JOIN luogo))
    WHERE
            email_utente =' . "'" . $_SESSION['email_utente'] . "'" . ' 
            
    UNION

    SELECT 
            email_utente, utente_esperto, nickname, path_img_profilo,
            tipo_cinguettio, id_cinguettio,data_ora_cinguettio,
            descrizione_foto, nome_foto, path_foto, 
            messaggio, inappropriato, oscurato, 
            latitudine, longitudine
    FROM 
            (utente NATURAL JOIN cinguettio NATURAL JOIN
            (foto NATURAL RIGHT OUTER JOIN testo NATURAL LEFT OUTER JOIN luogo))
    WHERE
            email_utente =' . "'" . $_SESSION['email_utente'] . "'"  .
            
    "UNION

    SELECT 
            email_utente, utente_esperto, nickname, path_img_profilo,
            tipo_cinguettio, id_cinguettio,data_ora_cinguettio,
            descrizione_foto, nome_foto, path_foto, 
            messaggio, inappropriato, oscurato, 
            latitudine, longitudine
    FROM 
            (utente NATURAL JOIN cinguettio NATURAL JOIN
            (foto NATURAL RIGHT OUTER JOIN testo NATURAL RIGHT OUTER JOIN luogo))
            WHERE
            email_utente ='"  . $_SESSION['email_utente'] . "'" . "

    ORDER BY data_ora_cinguettio DESC";

    return $sql;
}