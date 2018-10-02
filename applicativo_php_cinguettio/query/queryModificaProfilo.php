<?php


    // query per l'update delle info utente 
    function queryUpdateInfoUtente ($info_utente){
   
        $sql = 'UPDATE info_utente SET ';
        
        foreach ($info_utente as $key => $value){
            $sql .= $key . '=' . $value . ', ';  
        }
        
        $sql = trim($sql, ', ') . ' WHERE email_utente =' . "'{$_SESSION['email_utente']}'";
        
        return $sql;
		
    }
    
    // query per la cancellazione degli hobby
    function queryDeleteHobby (){
        
        $sql = "DELETE FROM hobby WHERE email_utente=" . "'" . $_SESSION['email_utente'] . "'";
        
        return $sql;
    }

    //query per l'inserimento degli hobby
    function queryInsertHobby ($hobby) {
        
        $sql = 'INSERT INTO hobby (email_utente, tipo_hobby) VALUES';
        
        foreach($hobby as  $value){
                $sql .= '(' . "'" . $_SESSION['email_utente'] . "'" . ', ' . $value . '),';
        }
        
        return trim($sql,',');
        
   }   
    