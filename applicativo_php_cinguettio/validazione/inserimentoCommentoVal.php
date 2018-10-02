<?php

    /**
     * Questo file contiene gli script per la validazione dei commenti inseriti dagli utenti 
     * per i cinguettii di tipo foto
     * 
     */
    
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../query/queryBacheca.php';
    
    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
    
?>    

<?php

     /* Questa sezione contiente gli script per la validazione dell'inserimento dei commenti*/

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
    
    // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
    // preparo i dati i dati di input prima della creazione della query 
    prepareInputToQuery($input, $conn);
    
    //creo la query per l'inserimento del commento
    $sql = queryInsCommento($input['utente_giudicato'], $input['id_cinguettio'], $input['commento']);
    
    //controllo se l'inserimento è andato a buon fine  
    if(mysqli_query($conn, $sql)){
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // e redirigo l'utente verso la pagina di completamento profilo
        redirect('bacheca.php');
    }
    else {
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina error.php
        redirectError(ERROR);
        
    }
    
