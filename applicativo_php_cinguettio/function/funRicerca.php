<?php

/* 
* Questo file contiene le funzioni per la ricerca degli utenti
* 
* 1) ricercaVuota -> verifica che tutti se tutti gli input sono vuoti
* 2) tipoRicerca -> verifica il tipo di ricerca
* 3) autoSearch -> verifica se l'utente ha provato a fare una ricerca su se stesso
* 4) printUtente -> stampa degli utenti
* 5) printUtenteEsperto -> stampa degli utenti esperti
 * 
*/

/**
  * 1) Questa funzione prende in ingresso un array che rappresenta l'input inserito dall utente  
  * e verifica che tutti campi siano vuoti.   
  * 
  * @param array $input
  * @return boolean 
  */
function ricercaVuota($input){
    
    foreach ($input as $value) {
        if(strlen($value) != 0){
            return false;
        }
    }
    
    return true;
}

/**
  * 2) Questa funzione prende in ingresso un array che rappresenta l'input inserito dall'utente  
  * e stampa il tipo di ricerca scelto.   
  * 
  * @param array $input
  * @return int 
  */
function tipoRicerca($input){
    
    if(ricercaVuota($input)){
        return RICERCA_TUTTI_GLI_UTENTI;
    }
    
    else if(!empty($input['email_nickname'])){
        return RICERCA_EMAIL_NICK;
    }
    
    return RICERCA_AVANZATA;
}


/**
 * 3) questa funzione prende in ingresso un array che rappresenta l'input inserito dall'utente
 * e verifica se l'utente abbia inserito nella barra di ricerca del email o del nickname la propria email
 * o il proprio neickname
 * 
 * @param array $input 
 * @return boolean 
 */
function autoSearch($input){
    if(!empty($input['nickname']) && ($input['nickname'] == $_SESSION['nickname'])){
        return true;
    } 
    else if(!empty($input['email_utente']) && ($input['email_utente'] == $_SESSION['email_utente'])){
        return true;
    }
    
    return false;
}

/** 
 * 4) Questa funzione prende ingresso un array che rappresenta una tupla estratta dai risultati 
 * dell'interrogazione e stampa l'img_profilo il nickname dell'utente e i pulsanti per: iniziare a seguire 
 * l'utente o  smettere di seguirlo o le informazioni sulla data in cui la richiesta è stata accettata
 *
 * @param array $row
 * @retrun no return      
 */
function printUtente ($row) {
       
      // inizializzo le variabili  
      $ris_stampa = '';
      $button = '';
    
     // pulsante per iniziare a seguire per utenti non ancora seguiti
    if($row['data_ora_richiesta'] == NULL){
        $button = '<form  action="../validazione/seguiVal.php" method="POST">' .
                       '<button type="submit" class="button-segui">' .
                       '<input type="hidden" name="utente_seguito" value="' . $row['email_utente'] . '">' .
                       'Inizia a seguire</button></form>';
        
        // risultato della stampa 
       $ris_stampa = '<div class="profilo-img-container" style="display: inline-block; margin: 0 50px 50px 0;">' . 
                          '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .
                          '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                          $button .
                          '</div>';
    }
    // pulsante smetti di seguire per utenti gìà seguiti
    else if(($row['data_ora_richiesta'] != NULL) && ($row['richiesta_accettata'] == TRUE)){
        $button = '<form  action="../validazione/smettiDiSeguireVal.php" method="POST">' .
                       '<button type="submit" class="button-smetti-di-seguire">' .
                       '<input type="hidden" name="utente_seguito" value="' . $row['email_utente'] . '">' .
                       'Smetti di seguire </button>' .
                       '</form>';
        
       // risultato della stampa 
       $ris_stampa = '<div class="profilo-img-container" style="display: inline-block; margin: 0 50px 50px 0;">' . 
                          '<a href="datiUtente.php?email_utente=' . $row['email_utente'] .  '">' . 
                          '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .
                          '</a>' .
                          '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                          $button .
                          '</div>';
    }
    
    // stampa nel caso di richieste inviate
    else if(($row['data_ora_richiesta'] != NULL) && ($row['richiesta_accettata'] == FALSE)){
       $ris_stampa = '<div class="profilo-img-container" style="display: inline-block; margin: 0 50px 50px 0">' .
                            '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .
                            '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                            '<div class="richiesta-attesa"> Richiesta inviata </div>' . 
                            '</div>';
    }
    
    echo $ris_stampa;
    
}

/** 
* 4) Questa funzione prende ingresso un array che rappresenta una tupla estratta dai risultati 
* dell'interrogazione e stampa se l'utente è esperto l'img_profilo il nickname dell'utente e i pulsanti per: iniziare a seguire 
* l'utente o  smettere di seguirlo o le informazioni sulla data in cui la richiesta è stata accettata.
*  
*
* @param array $row
* @retrun no return      
*/
function printUtenteEsperto ($row) {
    
    // inizializzo le variabili  
    $ris_stampa = '';
    $button = '';
    
    // ** INIZIA A SEGUIRE **
    // pulsante per iniziare a seguire per utenti non ancora seguiti
    if($row['data_ora_richiesta'] == NULL){
        $button = '<form  action="../validazione/seguiVal.php" method="POST">' .
                       '<button type="submit" class="button-segui">' .
                       '<input type="hidden" name="utente_seguito" value="' . $row['email_utente'] . '">' .
                       'Inizia a seguire</button></form>';
        
        // risultato della stampa 
       $ris_stampa = '<div class="tooltip-esperto">'.
                            '<span class="tooltip-testo-esperto">Utente esperto</span>'.
                            '<div class="profilo-img-container profilo-esperto" style="display: inline-block; margin: 0 50px 50px 0;">' . 
                            '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .
                            '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                            $button .
                            '</div>' .
                            '</div>';
    } 
    
    // ** SEGUI ** 
    // pulsante smetti di seguire per utenti gìà seguiti
    else if(($row['data_ora_richiesta'] != NULL) && ($row['richiesta_accettata'] == TRUE)){
        $button = '<form  action="../validazione/smettiDiSeguireVal.php" method="POST">' .
                       '<button type="submit" class="button-smetti-di-seguire">' .
                       '<input type="hidden" name="utente_seguito" value="' . $row['email_utente'] . '">' .
                       'Smetti di seguire </button>' .
                       '</form>';
        
       // risultato della stampa 
       $ris_stampa = '<div class="tooltip-esperto">'.
                            '<span class="tooltip-testo-esperto">Utente esperto</span>'.
                            '<div class="profilo-img-container profilo-esperto" style="display: inline-block; margin: 0 50px 50px 0;">' . 
                            '<a href="datiUtente.php?email_utente=' . $row['email_utente'] .  '">' . 
                            '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .
                            '</a>' .
                            '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                            $button .
                            '</div>' .
                            '</div>';
     }
     
     // ** RICHIESTA INVIATA ** 
     // stampa nel caso di richieste inviate
    else if(($row['data_ora_richiesta'] != NULL) && ($row['richiesta_accettata'] == FALSE)){
       $ris_stampa = '<div class="tooltip-esperto">'.
                            '<span class="tooltip-testo-esperto">Utente esperto</span>'.
                            '<div class="profilo-img-container profilo-esperto" style="display: inline-block; margin: 0 50px 50px 0;">' . 
                            '<img class="img-profilo-dim " src="' . '../' . $row['path_img_profilo'] . '" alt="img profilo"/>' .   
                            '<div class="aside-testo">' . $row['nickname'] . '</div>' .
                            '<div class="richiesta-attesa"> Richiesta inviata </div>' . 
                            '</div></div>';                      
    }
    
    echo $ris_stampa;
}

