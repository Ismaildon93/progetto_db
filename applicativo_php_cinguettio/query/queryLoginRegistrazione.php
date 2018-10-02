<?php

    //  query per l'autenticazione dell'utente in fase di login 
    function queryEmailPass ($email_utente, $password){
    
        $sql = "SELECT email_utente, password, nickname "
                . "FROM utente "
                . "WHERE email_utente = {$email_utente} AND password= {$password}"
        ;

        return $sql;
    }

    // query di registrazione di un nuovo utente
    function queryInsertUtente ($email_utente,$nickname,$password){
   
        $sql = "INSERT INTO utente "
                . "(email_utente,nickname,password,utente_esperto,data_esperto,img_profilo,path_img_profilo) "
                . "VALUES ({$email_utente}, {$nickname}, {$password},DEFAULT,DEFAULT,DEFAULT,DEFAULT)"
        ;

        return $sql;
		
    }
