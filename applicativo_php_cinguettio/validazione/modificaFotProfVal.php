<?php

/**
* 
* Questo file contiene gli script per la validazione dei cinguettii di tipo foto
*  
*/
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../function/funBacheca.php';
    require_once '../query/queryProfilo.php';
    require_once '../query/queryBacheca.php';
     
    // avvio della sessione
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
 
    //memorizziamo il contenuto della variabile superglobale $_FILES all'interno di una variabile 
    $foto = $_FILES['file'];
    
    // memorizzo il nome del file e l'estensione in un array  
    $nome_file = explode('.',$foto['name']);
       
    // verifico che la foto sia stata inviata in un formato corretto e che non contenga errori 
    // atrimenti redirigo a error.php
    if(!fileChecker($nome_file) || $foto['error'] != 0){
        if($foto['error'] != 0){
            redirectError(FAIL_FILE_CORRUPT);
        }
        else{
            redirectError(FAIL_UPLOAD);
        }
    }
    
    // creo un nuovo nome univoco per la foto memorizzo i dati all'interno di input per l'inserimento 
    // nel database 
    $input['img_profilo']= $_SESSION['email_utente'] . '_' . trim(uniqid(' ', true) . '.' . strtolower(end($nome_file)));
            
    // creo il path della nuova foto
    $path_foto = $input['path_img_profilo']  = 'img/utenti/profilo/' . $input['img_profilo'];
    

     // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
    //estraggo il path dell'imagine profilo dell'utente 
    $sql = "SELECT path_img_profilo FROM utente WHERE email_utente =" . 
            "'" .  $_SESSION['email_utente'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    // se il path risultante è uguale all'immagine di default significa che l'utente è la prima volta che 
    // aggiorna la propria immagine profilo quindi non ho bisogno di eliminare alcuna immagine
    // se invece avviene un riscontro l'immagine deve essere eliminata 
    if(!preg_match('/^img\/utenti\/profilo\/default.png$/', $row['path_img_profilo'])){
        if(file_exists( '../' . $row['path_img_profilo'])){
            unlink('../' . $row['path_img_profilo']);
        }
    }
    
    // preparo i dati i dati di input prima della creazione della query 
    prepareInputToQuery($input, $conn);
    
    // creo la query per l'inserimento della foto
    $sql = queryUpdateFotoProfilo($input);
 
    //controllo se l'inserimento è andato a buon fine
    if(mysqli_query($conn, $sql)){
        
        // effettuo lo spostamento 
        move_uploaded_file($foto['tmp_name'], '../' . $path_foto);

        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina bacheca.php
        redirect('profilo.php');
     }
     else {
        
        // chiudo la connessione al database 
        mysqli_close($conn);
        
        // redirigo l'utente verso la pagina error.php
        redirectError(ERROR);    
    }