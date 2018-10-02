
<?php

//query di select delle info utente
function queryInfoProfilo () {
    
    $sql = 'SELECT utente_esperto,path_img_profilo ' . 
              'FROM utente WHERE email_utente = ' .
              "'" . $_SESSION['email_utente'] . "'";
    
    return $sql;
}

//  query per la select dei post inseriti dalle persone seguite dall'utente 
function queryPostList (){

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
            email_utente =' . "'" . $_SESSION['email_utente'] . "'" . 'OR 
            email_utente IN (
                    SELECT utente_seguito
                    FROM seguaci_seguiti
                    WHERE utente_seguace =' . "'" . $_SESSION['email_utente'] . "'" . 'AND richiesta_accettata = true
            )

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
            email_utente =' . "'" . $_SESSION['email_utente'] . "'" . 'OR 
            email_utente IN (
                    SELECT utente_seguito
                    FROM seguaci_seguiti
                    WHERE utente_seguace =' . "'" . $_SESSION['email_utente'] . "'" . 'AND richiesta_accettata = true
            )

    UNION

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
            email_utente =' . "'" . $_SESSION['email_utente'] . "'" . 'OR 
            email_utente IN (
                    SELECT utente_seguito
                    FROM seguaci_seguiti
                    WHERE utente_seguace =' . "'" . $_SESSION['email_utente'] . "'" . 'AND richiesta_accettata = true
            )

    ORDER BY data_ora_cinguettio DESC';

    return $sql;
}

// query per l'inserimento di un cinguettio di tipo foto
function queryInsFoto ($input){
    
    $sql = 'INSERT INTO foto(email_utente, id_cinguettio, nome_foto, path_foto,descrizione_foto) ' 
            . 'VALUES(' . "'" . $_SESSION['email_utente'] . "'" . ',' . ' DEFAULT, ' . $input['nome_foto'] . ', '  
            . $input['path_foto'] . ', ' . $input['descrizione_foto']  . ')'; 
    
    return $sql;
              
} 

// query per l'inserimento di un cinguettio di tipo luogo
function queryInsLuogo ($lat, $lng){
    
    $sql = 'INSERT INTO luogo(email_utente, id_cinguettio, latitudine, longitudine) ' 
            . 'VALUES(' . "'" . $_SESSION['email_utente'] . "'" . ',' . ' DEFAULT, ' . $lat . ', '  
            .  $lng  . ')'; 
    
    return $sql;
              
}

// query per l'inserimento di un cinguettio di tipo testo
function queryInsTesto($msg){
    
    $sql = 'INSERT INTO testo(email_utente, id_cinguettio, messaggio, inappropriato, oscurato) ' 
            . 'VALUES(' . "'" . $_SESSION['email_utente'] . "'" . ',' . ' DEFAULT, ' . $msg . ', '  
            .   'DEFAULT, DEFAULT)'; 
    
    return $sql;
              
}

// query per la ricerca dei commenti
function queryCommenti ($utente_giudicato, $id_cinguettio){
    
    $sql = 'SELECT email_utente, nickname, data_ora_commento, commento ' .
              'FROM giudizio_foto NATURAL JOIN utente ' .
              'WHERE id_cinguettio=' . "'" . $id_cinguettio ."'" . ' AND ' . 
              'utente_giudicato =' . "'" . $utente_giudicato . "' " .
              'ORDER BY data_ora_commento DESC';
    
    
    return $sql;
}


// query per la verifica del numero massimo di commenti inseriti
function queryNumeroMaxCommenti ($utente_giudicato, $id_cinguettio){
    
    $sql = 'SELECT count(*) AS num_commenti ' .
              'FROM giudizio_foto ' .
              'WHERE id_cinguettio=' . "'" . $id_cinguettio ."'" . ' AND ' . 
              'utente_giudicato=' . "'" . $utente_giudicato . "' AND " .
              'email_utente=' . "'" . $_SESSION['email_utente'] ."'";
    
    return $sql;
}

// query per l'elenco degli utenti che hanno effettuato una segnalazione per un dato messaggio di testo
function queryListaSegnalanti ($utente_segnalato, $id_cinguettio ){
    
    $sql = 'SELECT nickname ' .
              'FROM segnala_testo NATURAL JOIN utente ' .
              'WHERE utente_segnalato=' .
              "'" . $utente_segnalato . "'" . ' AND ' .
              'id_cinguettio='  . $id_cinguettio;
            
    return $sql;
    
}

//query per sapere se l'utente ha già già segnalato il post
function queryTestoSegnalato($utente_segnalato, $id_cinguettio){
    
    $sql = 'SELECT * ' .
              'FROM segnala_testo ' .
              'WHERE utente_segnalato=' . "'" . $utente_segnalato . "'" . ' AND ' .
              'email_utente=' . "'" . $_SESSION['email_utente'] . "'" .  ' AND ' .
              'id_cinguettio='  . $id_cinguettio;
            
    return $sql;
    
    
}

// query per sapere se l'utente ha già definito il luogo come luogo preferito
function queryLuogoPreferito ($utente_luogo, $id_cinguettio){
    
    $sql = 'SELECT * ' .
              'FROM luogo_preferito ' .
              'WHERE utente_luogo=' . "'" . $utente_luogo . "'" . ' AND ' .
              'email_utente=' . "'" . $_SESSION['email_utente'] . "'" .  ' AND ' .
              'id_cinguettio='  . $id_cinguettio;
            
    return $sql;
    
}

// query per l'inserimento di un commento di un utente ad uno specifico post
function queryInsCommento($utente_giudicato, $id_cinguettio, $commento){
    
    $sql = 'INSERT INTO giudizio_foto(email_utente, utente_giudicato, id_cinguettio,' . 
              'data_ora_commento, commento)' .
              'VALUES(' . "'" . $_SESSION['email_utente'] . "', " .
              $utente_giudicato . ", " . $id_cinguettio . ", " . 'DEFAULT, ' . $commento . ')';
    
    return $sql;
}

// query per l'inserimento di un luogo preferito
function queryInsLuogoPreferito($utente_luogo, $id_cinguettio){
    
    $sql = 'INSERT INTO luogo_preferito(email_utente, utente_luogo, id_cinguettio) ' . 
              'VALUES(' . "'" . $_SESSION['email_utente'] . "', " .
              $utente_luogo . ", " . $id_cinguettio . ')';
    
    return $sql;
}

// query per la segnalazione di un messaggio di testo
function querySegnalaTesto($utente_segnalato, $id_cinguettio){
    
    $sql = 'INSERT INTO segnala_testo(email_utente, utente_segnalato, id_cinguettio) ' . 
              'VALUES(' . "'" . $_SESSION['email_utente'] . "', " .
              $utente_segnalato . ", " . $id_cinguettio . ')';
    
    return $sql;
}