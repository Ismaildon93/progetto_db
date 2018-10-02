<?php
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    
    // avvio della sessione
    session_start();
   
   //controllo l'esistenza della sessione 
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }

    //elimino la sessione
    session_unset();
    session_destroy();

    // redirigo l'utente verso la pagina loginRegistrazione.php
    redirect('loginRegistrazione.php');