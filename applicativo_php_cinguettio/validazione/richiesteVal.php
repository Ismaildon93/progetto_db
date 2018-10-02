<?php

    /**
     * Questo file contiene gli script per la validazione per la validazione delle richieste che fa un utente
	 * per seguire un altro utente
     * 
     */
    
    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funError.php';
    require_once '../query/queryLoginRegistrazione.php';
     
    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }

    // creo la connessione al database 
    $conn = dbConnection();


     $utente_seguace =  $_GET['utente_seguace'];
     $richiesta = $_GET['richiesta_accettata'];
     $utente = $_SESSION['email_utente'];


      // per accetare la richiesta
      if ($richiesta == 1 ){

          $sql = "UPDATE seguaci_seguiti SET richiesta_accettata = 1 , data_ora_risposta = now()
                  WHERE utente_seguace = '{$utente_seguace}' and utente_seguito = '{$utente}'";

          mysqli_query($conn, $sql);
          $page = 'richieste.php';
          redirect($page);

      }
    // per rifiutare la richiesta
    else if ($richiesta == 0 ) {
       $sql1 = "DELETE  FROM seguaci_seguiti WHERE utente_seguace = '{$utente_seguace}' and utente_seguito = '{$utente}'";
       mysqli_query($conn, $sql1);
       $page = 'richieste.php';
       redirect($page);
    }

