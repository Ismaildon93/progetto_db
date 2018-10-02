<?php

    /**
     * Questo file contiene gli script per la validazione del login utente
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
    
    // verifico che l'input dell'utente sia stato inviato in post e che l'email e la paassword siano state settate 
    // altrimenti redirigo a error.php
    if(!correctMethodInput('POST') || empty($_POST['email_utente']) || empty($_POST['password'])){
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
    
    // creo la query per il login
    $sql = queryEmailPass($input['email_utente'], $input['password']);
   
    //eseguo la query
    $result = mysqli_query($conn, $sql);
    
    //controllo quante tuple sono state trovate 
    if(mysqli_num_rows($result) == 1){
        
        // estraggo il risultato dell'interrogazione 
        $row = mysqli_fetch_assoc($result);
    
        //inizializzo le variabili per la sessione 
        $_SESSION['email_utente'] = $row['email_utente'];
        $_SESSION['nickname'] = $row['nickname'];
    
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // e redirigo l'utente verso la pagina di completamento profilo
        redirect('bacheca.php');
        
    } else {
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina error.php
        redirectError(FAIL_LOGIN);
        
    }
    
