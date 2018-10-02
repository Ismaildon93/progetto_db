<?php

     /**
     * Questo file contiene gli script per la validazione dell'aggiornamento 
     * delle informazioni personali degli utenti
     * 
     */
    
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../query/queryModificaProfilo.php';

    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
    
 ?>

<?php

    /* Questa sezione contiente gli script per la validazione della modifica delle informazioni dell'utente*/

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
    
    //verifico che tutti i campi della data di nascita siano tutti settati o siano tutti nulli
    if(($input['giorno'] && $input['mese'] && $input['anno']) || 
       (!$input['giorno'] && !$input['mese'] && !$input['anno'])){
        // creo la data di nascita nel formato YYYY/MM/DD
        $data_nascita = createData($input['giorno'], $input['mese'], $input['anno']);
    }
    // restituisco un messaggio di errore di input non valido 
    else{
        redirectError(FAIL_INVALID_DATA);
    }
    
    
    // verifico che la data di nascita non sia superiore alla data corrente in caso negativo
    // redirigo l'utente verso la pagina error.php in caso positivo memorizzo la data nell'input
    if(!checkDataNascita($data_nascita)){
        redirectError(FAIL_DATA_NASCITA);
    }else{
        $info_utente['data_nascita'] = $data_nascita;
    }
    
    // separo le info utente dagli hobby
    foreach ($input as $key => $value){
        if(preg_match('/^hobby[_]/',$key)){
            if($input[$key] != null){
                $hobby[$key] = $value;
            }
        }
        else if($key != 'giorno' && $key != 'mese' && $key != 'anno'){
           $info_utente[$key] = $value;
        }        
    }
    
    /*******************************************************************
     *                                     SEZIONE DELLE INFO UTENTE 
     *******************************************************************/
    
    // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
    // preparo i dati i dati di info_utente prima della creazione della query 
    prepareInputToQuery($info_utente, $conn);
    
     // creo la query per l'update delle info utente
     $sql = queryUpdateInfoUtente ($info_utente);
    
     // verifico che l'update delle info utente sia andato a buon fine
    if (!mysqli_query($conn, $sql)) {
        // chiudo la connessione al database 
        mysqli_close($conn);        
        // redirigo l'utente verso la pagina error.php
        redirectError(ERROR);
    }
    
    /*********************************************************************
     *                              SEZIONE DEGLI HOBBY 
     *********************************************************************/
    
    // se l'utente ha inserito degli hobby cancello gli hobby precedentemente inseriti e inserisco i nuovi 
    // hobby e redirigo l'utente verso la pagina precedente o la bacheca
    if(!empty($hobby)){
        
        // creazione della query per l'eliminazione degli hobby precedenti 
        $sql = queryDeleteHobby();
        
        // verifico che l'eliminazione sia andata a buon fine
        if(!mysqli_query($conn, $sql)){
            
            // chiudo la connessione al database 
            mysqli_close($conn);        
    
            // redirigo l'utente verso la pagina error.php
            redirectError(ERROR); 
        }
        
        // elimino eventuali hobby ripetuti
        deleteRepeatedHobby($hobby);
        
        // preparo i dati i dati di info_utente prima della creazione della query 
        prepareInputToQuery($hobby, $conn);
        
        // creazione della query per l'inserimento dei nuovi hobby
        $sql = queryInsertHobby($hobby);
        
        // verifico che l'inserimento sia andato a buon fine
        if(!mysqli_query($conn, $sql)){
            
            // chiudo la connessione al database 
            mysqli_close($conn);        
    
            // redirigo l'utente verso la pagina error.php
            edirectError(ERROR);
            
        }
        
        // chiudo la connessione al database 
        mysqli_close($conn);        
    
       // verifico quale era la pagina precedente e redirigo l'utente in quella pagina
        $pag_precedente = $_SERVER['HTTP_REFERER'];
        echo $pag_precedente;
        
        if(preg_match('/.profilo.php$/', $pag_precedente)){
            redirect('profilo.php');
        }
        else{
            redirect('bacheca.php');
        }
    }

    // se l'utente non ha selezionato alcun hobby elimino tutti gli hobby gia esistenti
    // e redirigo l'utente verso la pagina precedente o verso la bacheca
    else {
        
        // creazione della query per l'eliminazione degli hobby 
        $sql = queryDeleteHobby();
        
        // verifico che l'eliminazione sia andata a buon fine
        if(!mysqli_query($conn, $sql)){
            
            // chiudo la connessione al database 
            mysqli_close($conn);        
    
            // redirigo l'utente verso la pagina error.php
            redirectError(ERROR);
        
        }
        
        // chiudo la connessione al database 
        mysqli_close($conn);        
    
       // verifico quale era la pagina precedente e redirigo l'utente in quella pagina
        $pag_precedente = $_SERVER['HTTP_REFERER'];
        echo $pag_precedente;
        
        if(preg_match('/.profilo.php$/', $pag_precedente)){
            redirect('profilo.php');
        }
        else{
            redirect('bacheca.php');
        }
      
    }
    
   