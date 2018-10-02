<?php

// query per la ricerca di tutti gli utenti
function queryRicercaTuttiGliUtenti(){
    
    $sql = 'SELECT email_utente, nickname, utente_esperto, utente_seguito, utente_seguace, path_img_profilo, data_ora_richiesta, ' .
              'richiesta_accettata, data_ora_risposta ' . 
              'FROM (utente NATURAL JOIN info_utente ) LEFT OUTER JOIN seguaci_seguiti ' .  
              'ON email_utente = utente_seguito AND utente_seguace =' . 
              "'" . $_SESSION['email_utente'] . "'" ;
    
    return $sql;
}

// query per la ricerca degli utenti tramite email o nickname
function queryRicercaEmailNickname ($input){
    
    // stabilisco la condizione della query
    if(!empty($input['email_utente'])){
        $condizione = ' WHERE email_utente=' . $input['email_utente'];
    }else{
        $condizione = ' WHERE nickname=' . $input['nickname'];
    }    
    
    $sql = 'SELECT email_utente, utente_seguito, utente_seguace, nickname, utente_esperto, path_img_profilo, data_ora_richiesta, ' .
              'richiesta_accettata, data_ora_risposta ' . 
              'FROM (utente NATURAL JOIN info_utente ) LEFT OUTER JOIN seguaci_seguiti ' .  
              'ON email_utente = utente_seguito AND utente_seguace =' . 
              "'" . $_SESSION['email_utente'] . "' " .
              $condizione;
    
    return $sql;
    
}

// query per la ricerca avanzata
function queryRicercaAvanzata ($info_utente, $hobby){
    
    // condizione dell'info utente
    $cond_info_utente = '';
    $cond_hobby = '';
    
    foreach ($info_utente as $key => $value) {
        if($value != 'NULL'){
            $cond_info_utente .= $key . '=' . $value . ' AND ';
        }        
    }
    
    //considero il caso cui siano stati inseriti hobby nella ricerca
    //in caso affermativo viene aggiunta la condizione per gli hobby
    if(!empty($hobby)){
        foreach ($hobby as $key => $value) {
            $cond_hobby .= 'tipo_hobby' . '=' . $value . ' OR ';        
        }    
        $condizione = (trim($cond_info_utente . '(' . $cond_hobby  , 'OR ')) . ')';    
    }
    // nel caso gli hobby non siano stati inseriti ripulisco la condizione togliendo and finali e 
    // considero solo come condizione le info utente
    else{
        $condizione = trim($cond_info_utente , 'AND ');
    }
    
    $sql = 'SELECT email_utente, nickname, utente_esperto, utente_seguito, utente_seguace, path_img_profilo, data_ora_richiesta, ' .
              'richiesta_accettata, data_ora_risposta ' . 
              'FROM (utente NATURAL JOIN info_utente ) LEFT OUTER JOIN seguaci_seguiti ' .  
              'ON email_utente = utente_seguito AND utente_seguace =' . 
              "'" . $_SESSION['email_utente'] . "' " .
              'WHERE email_utente IN (' .
              'SELECT email_utente ' .
              'FROM info_utente NATURAL LEFT OUTER JOIN hobby ' .
              'WHERE ' . $condizione . ')'; 

    return $sql;
}

// query per iniziare smettere di seguire un utente
function querySmettiDiSeguire($utente_seguito){
    
   $sql = 'DELETE FROM seguaci_seguiti '
           . 'WHERE utente_seguace=' . "'" . $_SESSION['email_utente'] . "' AND "     
           .  'utente_seguito=' . $utente_seguito;  
    
   return $sql;
    
}

// query per iniziare a seguire un utente
function querySegui($utente_seguito){
    
   $sql = 'INSERT INTO seguaci_seguiti(utente_seguace, utente_seguito) ' .
             'VALUES(' .  "'" . $_SESSION['email_utente'] . "'" . ',' . $utente_seguito . ')';
             
   
   return $sql;
    
}