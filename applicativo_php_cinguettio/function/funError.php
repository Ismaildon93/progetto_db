<?php

/*
 * Questo file contiene funzioni per la gestione degli errori:
 * 
 * 1) redirectError ->  per la redirezione dell'utente nella pagina error
 * 2) printError  ->  per la stampa del messaggio di errore e del link di recupero
 * 
 */

/***************************************************************************************
***************************************************************************************/

/**
 * Questa funzione prende in ingresso un codice di errore e reindirizza l'utente alla pagina error.php 
 * passando alla pagina il codice dell'errore e link per il reindirizzamento
 * 
 * @param string $codiceErrore codice dell'errore passando alla pagina l'errore e il codice dell errore
 * @return no return 
 **/
function redirectError ($codiceErrore) {
    
    // reindirezzamento alla pagina di errore
    header("Location: ../visual/error.php?error={$codiceErrore}");
    exit();
}

/**
 * Questa funzione in base al codice di errore ricevuto stampa un messaggio di errore e il
 * link di reindirizzamento
 * 
 * @param string $codiceErrore codice dell'errore
 * @return no return 
 */
function printError($codiceErrore){
    
    // le pagine di visualizzazione
    $pagine_di_visualizzazione = array(
        'profilo.php', 'bacheca.php', 'completaProfilo.php',
        'datiUtente.php', 'error.php', 'listaSeguaci.php', 'loginRegistrazione.php',
        'listaSeguiti.php', 'luogoPreferito.php', 'ricercaUtente.php', 'richieste.php'
    );
    
    // memorizzo l'url della pagina precedente 
    $pag_precedente = explode ('/',$_SERVER['HTTP_REFERER']);
    $pagina = end($pag_precedente);
    
    //verifico se la pagina precedente
    if(in_array($pagina, $pagine_di_visualizzazione) && (!empty($pag_precedente))) {
        // creo il link per tornare alla pagina precedente
        $link =  '<br><a class="link-msg-errore" href="' . $pagina . '"> torna indietro </a>';
    }else{
        // creo il link per tornare alla pagina iniziale
        $link = '<br><a class="link-msg-errore" href="../index.php"> torna alla pagina iniziale </a>';
    }
    
    switch ($codiceErrore){
        
        case FAIL_SESSION: 
            echo 'Non sei loggato ' . $link;
            break;
        
        case FAIL_DB_CONN: 
            echo 'Connesione al database fallita' . $link;
            break;         
    
        case FAIL_INPUT: 
            echo 'Input non valido' . $link;
            break;         
        
        case FAIL_LOGIN: 
            echo 'Non sei registrato registrati!' . $link;
            break;
        
        case FAIL_PWD_CONF_REG:
            echo 'La password di conferma è errata' . $link;
            break;
    
        case FAIL_REG:
            echo 'Email o nickname già esistenti' . $link;
            break;
        
        case FAIL_DATA_NASCITA:
            echo 'input non valido la data di nascita è maggiore della data corrente' . $link;
            break;
        
        case FAIL_UPLOAD:
            echo 'input non valido i formati disponibili sono .png  .jpeg .jpg  ' . $link;
            break;
        
        case FAIL_FILE_CORRUPT:
            echo 'File corrotto impossibile caricarlo' . $link;
            break;
        
        case FAIL_LAT:
            echo 'Valore di latitudine non consentito' . $link;
            break;
        
       case FAIL_LNG:
            echo 'Valore di longitudine non consentito' . $link;
            break;

        case FAIL_INVALID_DATA:
            echo 'Valore invalido per la data di nascita' . $link;
            break;

        default:
            echo 'Errore' . $link; 
    }   
}