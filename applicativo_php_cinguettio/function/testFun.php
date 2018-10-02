<?php

// inclusione dei file contenenti funzioni e query
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    require_once '../function/funBacheca.php';
    require_once '../query/queryBacheca.php';

    
    session_start();
    //echo '('. $key .')' . $value . ': ' .$ret ."\n";
    /*
    $input['id_cinguettio'] = '789';
    $input['utente_seguace'] = 'ismail@gmail.com';
    $input['utente_seguito'] = 'ismail@gmail.com';
    $input['utente_luogo'] = 'portoismail@gmail.com';
    $input['utente_segnalato'] = 'ismail@gmail.com';
    $input['utente_giudicato'] = 'ismail@gmail.com';
    $input['email_utente'] = 'ismail@gmail.com';
    $input['password'] = 'ciaoasdfasdcome';
    $input['nickname'] = "ciao";
    
    /*******info utente*****************************
    $input['file'] = '';
    $input['nome'] ="";
    $input['cognome'] ="";
    $input['nazione_nascita'] ="";
    $input['regione_nascita'] ="";
    $input['citta_residenza'] ="";
    $input['hobby_1'] = "sport";
    $input['hobby_2'] = '';
    $input['hobby_3'] = "";
    $input['hobby_4'] = "";
    $input['hobby_5'] = "";
    $input['hobby_6'] = "";
    $input['hobby_7'] = "";
    $input['hobby_8'] = "";
    $input['hobby_9'] = "";
    $input['hobby_10'] = "";
    $input['sesso'] = "";
    $input['giorno'] = "";
    $input['mese'] = "";
    $input['anno'] = "";
    
    /**********************************************
    
    
    $input['commento'] = "Penea209847";
    $input['messaggio'] = "ciaso";
    $input['descrizione_foto'] = "ciaso";
    */
    $input['gradi_lat'] = "70";
    $input['minuti_lat'] = "58";
    $input['secondi_lat'] = "50";
    $input['direzione_lat'] = "n";
    $input['gradi_lng'] = "115";
    $input['minuti_lng'] = "57";
    $input['secondi_lng'] = "59";
    $input['direzione_lng'] = "E";
    
    header('Content-type: text/plain');
    $num_comm = queryNumeroMaxCommenti('gianluca@live.it', 3);
    $commenti = queryCommenti('gianluca@live.it', 3);
    
    //print_r($num_comm);
    //print_r($commenti);
    
    $id_modal = '1_sissi@live.it';
    
    printModal('1', 'sissi@live.it');
    
    echo "\n\n";
    
    echo '<button onclick="showModal(' ."'" . $id_modal . "'," . "'post-container'" . ')" class="inserimento-commento">'; 
    echo 'Inserisci un commento </button>';
    
//    $latitudine = GMStoDecimal($input['gradi_lat'], $input['minuti_lat'], $input['secondi_lat'], $input['direzione_lat']);
//    $longitudine = GMStoDecimal($input['gradi_lng'], $input['minuti_lng'], $input['secondi_lng'], $input['direzione_lng']);
//    
//    echo $latitudine . "\n";
//    echo $longitudine . "\n";
//    
//    echo 'lat: ' . decimalToGMS($latitudine, 'lat') . "\n";
//    echo 'lat: ' . decimalToGMS($longitudine, 'lng') . "\n";
    
    
    
    
    //echo 'Input checker value: ' . inputChecker($input) ."\n";
    
    
    
    
 