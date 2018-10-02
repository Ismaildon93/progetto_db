<?php

/**
* Questo file contiene gli script per la validazione dei cinguettii di tipo luogo
*  
*/
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../function/funBacheca.php';
    require_once '../query/queryBacheca.php';

    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
    
 ?>

<?php

    // verifico che l'input dell'utente sia stato inviato in post altrimenti redirigo a error.php
    if(!correctMethodInput('POST')){
        redirectError(FAIL_INPUT);
    }
    
    //pulisco da eventuale codice pericoloso l'input inserito dall' utente 
    $input = cleanInput($_POST);
    
    // verifico che l'input inserito dall'utente sia un formato corretto altrimenti redirigo a error.php
    if(!inputChecker($input)){
        redirectError(FAIL_INPUT);
    }
    
    // valore massimo consentito per la latitudine
    if($input['gradi_lat'] == 90){
        if($input['minuti_lat'] > 0 || $input['secondi_lat'] > 0){
            redirectError(FAIL_LAT);
        }
    }
    
    // valore massimo consentito per la latitudine
    if($input['gradi_lng'] == 180){
        if($input['minuti_lat'] > 0 || $input['secondi_lat'] > 0){
            redirectError(FAIL_LNG);
        }
    }
    
    //converto la latudine espressa in GMS(gradi minuti secondi) in latitudine espressa in decimale
    $latitudine = GMStoDecimal($input['gradi_lat'], $input['minuti_lat'], $input['secondi_lat'], $input['direzione_lat']);
    //converto la longitudine espressa in GMS(gradi minuti secondi) in longitudine espressa in decimale
    $longitudine = GMStoDecimal($input['gradi_lng'], $input['minuti_lng'], $input['secondi_lng'], $input['direzione_lng']);
    
    // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
    // creo la query per l'inserimento di un cinguettio di luogo
    $sql =  queryInsLuogo($latitudine, $longitudine);
    
    //controllo se l'inserimento è andato a buon fine  
     if(mysqli_query($conn, $sql)){
         
      // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina bacheca.php
        redirect('bacheca.php');
        
     }
     else {
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina error.php
        redirectError(ERROR);
        
    }