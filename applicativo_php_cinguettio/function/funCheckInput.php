<?php

/* 
 * Questo file contiene le funzioni per il controllo del formato dell'input
 * 
 * 0) id_cinguettio -> verifica il corretto formato per cinguettio
 * 1) emailFormat -> verifica il corretto formato per la email
 * 2) pwdFormat -> verifica il corretto formato per la password
 * 3) nickFormat -> verifica il corretto formato per il nickname
 * 4) nameFormat -> verifica il corretto formato per nomi e cognomi
 * 5) placeFormat -> verifica il corretto formato per i nomi dei luoghi quali nazione_nascita
 *                           regione_nascita e citta_residenza
 * 6) hobbyFormat -> verifica il corretto formato degli hobby
 * 7) sexFormat -> verifica il corretto formato del sesso dell'utente
 * 8) dayFormat -> verifica il corretto formato per il giorno 
*  9) monthFormat -> verifica il corretto formato per il mese
 * 10) yearFormat -> verifica il corretto formato per l'anno
 * 11) textFormat -> verifica il corretto formato per il testo
 * 12) descrFormat -> verifica il corretto formato per la descrizione delle foto
 * 13) gradiLatFormat -> verifica il corretto formato per i gradi della latitudine
 * 14) gradiLngFormat -> verifica il corret formato per i gradi della longitudine
 * 15) secMinFormat -> verifica il corretto formato per minuti e secondi
 * 16) direzioneLatFormat -> verifica il corretto formato per la direzione della latitudine 
 * 17) direzioneLngFormat -> verifica il corretto formato per la direzione della longitudine
 * 19) inputChecker -> verifica che tutto l'input dell'utente sia ben formattato
 * 20) fileChecker -> verifica che il file inviato dall'utente sia un foto
 **/

/***************************************************************************************
***************************************************************************************/

/**
 *  0) Questa funzione prende in ingresso una stringa e verifica che id_cinguettio sia nel corretto formato  
 * In caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function idFormat($value){
    
    if(!preg_match(VALID_INT_FORMAT,$value)){
        return false;
    }
    
    return true;

}

/**
 *  1) Questa funzione prende in ingresso una stringa e verifica che sia un indirizzo email nel corretto 
 * formato
 * In caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function emailFormat ($value){
    
    $len = strlen($value);
    if(!preg_match(VALID_EMAIL_FORMAT,$value) || $len > 70){
        return false;
    }
    
    return true;
}

/**
 *  2) Questa funzione prende in ingresso una stringa e verifica che la password sia in un formato corretto 
 * In caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function pwdFormat ($value){
    
    if(!preg_match(VALID_PWD_FORMAT,$value)){
        return false;
    }
    
    return true;
}


/**
 *  3) Questa funzione prende in ingresso una stringa e verifica che il nickname sia in un formato corretto 
 * In caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function nickFormat ($value){
    
    if(!preg_match(VALID_NICK_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 4) Questa funzione prende in ingresso una stringa e verifica che il nome o il cognome di un utente siano 
 * in un formato corretto 
 * In caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function nameFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_NAME_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 5) Questa funzione prende in ingresso una stringa e verifica che nazione_nascita, citta_residenza o 
 * regione_nascita siano in un formato corretto 
 * in caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function placeFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_PLACE_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 6) Questa funzione prende in ingresso una stringa e una regex e controlla che l'hobby sia 
 * in un formato corretto definito dalla regex in caso negativo restituisce false  
 * 
 * @param string $value  
 * @param string $regex
 * @return boolean
 */
function hobbyFormat ($value, $regex){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match($regex,$value)){
        return false;
    }
    
    return true;
}

/**
 * 7) Questa funzione prende in ingresso una stringa e verifica che il sesso inserito dall'utente
 * sia in un formato corretto 
 * in caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function sexFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_SEX_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 8) Questa funzione prende in ingresso una stringa e verifica che il giorno inserito dall'utente
 * sia in un formato corretto 
 * in caso negativo restituisce false   
 * 
 * @param string $value  
 * @return boolean
 */
function dayFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_DAY_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 9) Questa funzione prende in ingresso una stringa e verifica che il mese inserito dall'utente
 * sia in un formato corretto  
 * in caso negativo restituisce false  
 * 
 * @param string $value  
 * @return boolean
 */
function monthFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_MONTH_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 10) Questa funzione prende in ingresso una stringa e verifica che L'anno inserito dall'utente
 * sia in un formato corretto   
 * in caso negativo restituisce false 
 * 
 * @param string $value  
 * @return boolean
 */
function yearFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_YEAR_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 11) Questa funzione prende in ingresso una stringa e verifica che il testo inserito dall'utente
 * sia in un formato corretto   
 * in caso negativo restituisce false 
 * 
 * @param string $value  
 * @return boolean
 */
function textFormat ($value){
    
    if(!preg_match(VALID_TEXT_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 12) Questa funzione prende in ingresso una stringa e verifica che il testo di descrizione_foto 
 * sia in un formato corretto 
 * in caso negativo restituisce false    
 * 
 * @param string $value  
 * @return boolean
 */
function descrFormat ($value){
    
    if(strlen($value) == 0){
        return true;
    }
    
    else if(!preg_match(VALID_DESCR_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 13) Questa funzione prende in ingresso una stringa e verifica che  i gradi per la latitudine inseriti dall'utente
 * sia in un formato corretto   
 * in caso negativo restituisce false
 * 
 * @param string $value  
 * @return boolean
 */
function gradiLatFormat ($value){
     
    if(!preg_match(VALID_GRADI_LAT_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 14) Questa funzione prende in ingresso una stringa e verifica che  i gradi per la lognitudine inseriti dall'utente
 * sia in un formato corretto   
 * in caso negativo restituisce false
 * 
 * @param string $value  
 * @return boolean
 */
function gradiLngFormat ($value){
     
    if(!preg_match(VALID_GRADI_LNG_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 15) Questa funzione prende in ingresso una stringa e verifica che i minuti o i secondi inseriti dall'utente
 * sia in un formato corretto   
 * in caso negativo restituisce false
 * 
 * @param string $value  
 * @return boolean
 */
function secMinFormat ($value){
     
    if(!preg_match(VALID_SEC_MIN_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 16) Questa funzione prende in ingresso una stringa e verifica che la direzione per la latitudine inserita 
 * dall'utente sia in un formato corretto   
 * in caso negativo restituisce false
 * 
 * @param string $value  
 * @return boolean
 */
function direzioneLatFormat ($value){
     
    if(!preg_match(VALID_DIR_LAT_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 17) Questa funzione prende in ingresso una stringa e verifica che la direzione per la longitudine inserita 
 * dall'utente sia in un formato corretto   
 * in caso negativo restituisce false
 * 
 * @param string $value  
 * @return boolean
 */
function direzioneLngFormat ($value){
     
    if(!preg_match(VALID_DIR_LNG_FORMAT,$value)){
        return false;
    }
    
    return true;
}

/**
 * 18) Questa funzione prende in ingresso un array che rappresenta l'input inserito dall'utente e 
 * verifica che tutti i dati inseriti  siano nel corretto formato 
 * in caso negativo restituisce false
 * 
 * @param type $input
 * @return boolean
 */
function inputChecker($input){
    
    // il valore che deve essere restituito
    $ret = true;
    
    foreach($input as $key => $value){
        
        switch ($key){
            case 'file': // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break; 
            case 'id_cinguettio': // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    $ret = idFormat($value);// echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'utente_seguace': 
            case 'utente_seguito':
            case 'utente_segnalato':
            case 'utente_giudicato':    
            case 'utente_luogo':    
            case 'email_utente':
                    $ret = emailFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n"; 
                    break;
            case 'password_conferma':   
            case 'password':
                    $ret = pwdFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'nickname':
                    $ret = nickFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'nome':
                    $ret = nameFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;    
            case 'cognome':
                    $ret = nameFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;  
            case 'sesso':
                    $ret = sexFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;    
            case 'giorno':
                    $ret = dayFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'mese':
                    $ret = monthFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'anno':
                    $ret = yearFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'nazione_nascita':
            case 'regione_nascita':
            case 'citta_residenza':
                    $ret = placeFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_1':
                    $ret = hobbyFormat($value, VALID_HOBBY_1_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_2':
                    $ret = hobbyFormat($value, VALID_HOBBY_2_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_3':
                    $ret = hobbyFormat($value, VALID_HOBBY_3_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;                
            case 'hobby_4':
                    $ret = hobbyFormat($value, VALID_HOBBY_4_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_5':
                    $ret = hobbyFormat($value, VALID_HOBBY_5_FORMAT); // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_6':
                    $ret = hobbyFormat($value, VALID_HOBBY_6_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_7':
                    $ret = hobbyFormat($value, VALID_HOBBY_7_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_8':
                    $ret = hobbyFormat($value, VALID_HOBBY_8_FORMAT);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_9':
                    $ret = hobbyFormat($value, VALID_HOBBY_9_FORMAT); // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'hobby_10':
                    $ret = hobbyFormat($value, VALID_HOBBY_10_FORMAT); // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;    
            case 'commento':
            case 'messaggio':
                    $ret = textFormat($value); // echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'descrizione_foto':
                    $ret = descrFormat($value);// echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'gradi_lat':
                    $ret = gradiLatFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'gradi_lng':    
                    $ret = gradiLngFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            case 'minuti_lat':
            case 'minuti_lng':    
                    $ret = secMinFormat($value); //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;    
             case 'secondi_lat':
             case 'secondi_lng':    
                    $ret = secMinFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;    
             case 'direzione_lat':
                    $ret = direzioneLatFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
             case 'direzione_lng':
                    $ret = direzioneLngFormat($value);  //echo '('. $key .')' . $value . ': ' .$ret ."\n";
                    break;
            default:
                    return false;
        }    
        
        if($ret == false){
            break;
        }
    }    
    return $ret;
}

 /**
  * 19) Questa funzione prende in ingresso una stringa che rappresenta il nome del file e verifica che il 
  * file sia stato effetivamente inviato e verifica che il file abbia un estensione corretta ovvero che sia 
  * un immagine.  
  * 
  * @param string $nome_file
  * @return boolean 
  */
function fileChecker($nome_file){
    
    // controllo che sia stato inviato un file altrimenti restituisco false
    if(empty($_FILES['file'])){
        return false;
    }
    
    // memorizzo l'estensione
    $ext = trim(strtolower(end($nome_file)));
        
    // verifico che sia stato inviato un file contente un foto i formati disponibili sono jpg png jpeg
    if(!preg_match(VALID_FILE_FORMAT, $ext)){
       return false;
    }
    
    return true;
}

    
