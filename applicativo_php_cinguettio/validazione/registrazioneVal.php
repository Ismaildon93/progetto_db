<?php

    /**
     * Questo file contiene gli script per la validazione della registrazione dell'utente
     * 
     */
    
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../query/queryLoginRegistrazione.php';
     
    // avvio della sessione
    session_start();
    
    // controllo se le variabili di sessione sono settate in caso positivo
    // l'utente vie rediretto nella pagina bacheca.php 
    if(sessionControll()){ 
        redirect('bacheca.php');
    }
    
?>

<?php
    
    // verifico che l'input dell'utente sia stato inviato in post  e che email_utente nickname e password siano
    // settate altrimenti redirigo a error.php
    if(!correctMethodInput('POST') || empty($_POST['email_utente']) || empty($_POST['nickname']) ||
       empty($_POST['password']) || empty($_POST['password_conferma']) 
       ){
        redirectError(FAIL_INPUT);
    }
    
    //pulisco da eventuale codice pericoloso l'input inserito dall' utente 
    $input = cleanInput($_POST);
       
    // verifico che l'input inserito dall'utente sia un formato corretto altrimenti redirigo a error.php
    if(!inputChecker($input)){
        redirectError(FAIL_INPUT);
    }
    
    //verifico la password di conferma
    if($input['password'] != $input['password_conferma']){
        redirectError(FAIL_PWD_CONF_REG);
    }
    
    // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
    // memorizzo le variabili per utilizzate per la sessione;
    $session_email_utente = $input['email_utente'];
    $session_nickname = $input['nickname'];
    
    // preparo i dati i dati di input prima della creazione della query 
    prepareInputToQuery($input, $conn);
    
    // memorizzo i dati per la registrazione
    $email_utente = $input['email_utente'];
    $nickname = $input['nickname'];
    $password = $input['password'];
    
    // creo la query per la registrazione dell'utente
    $sql = queryInsertUtente ($email_utente,$nickname,$password);
   
    //controllo se l'inserimento è andato a buon fine  
    if(mysqli_query($conn, $sql)){
    
         //inizializzo la sessione 
        $_SESSION['email_utente'] = $session_email_utente;
        $_SESSION['nickname'] = $session_nickname;
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // e redirigo l'utente verso la pagina di completamento profilo
        redirect('completaProfilo.php');
    }    
    
    else {
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina error.php
        redirectError(ERROR);
        
    }
    