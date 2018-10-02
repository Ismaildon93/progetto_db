<?php

/*
 * Questo file contiene funzioni usate nella bacheca:
 * 
 * 1) printAsideEsperto ->  per la stampa dell'aside dell'utente esperto 
 * 2) printAside -> per la stampa dell'aside di un utente non esperto
 * 3) printHeaderPost -> per la stampa dell'header dei post
 * 4) printHeaderSegnOsc -> per la stampa degli header dei post di testo segnalati o oscurati
 * 5) printFoto -> per la stampa dei post di  foto
 * 6) printLuogo -> per la stampa dei post di luogo
 * 7) printTesto -> per la stampa dei post di testo
 * 8) printModal -> per la stampa delle form modali per l'inserimento dei commenti 
 */

/***************************************************************************************
***************************************************************************************/

/**
 * 1) Questa funzione prende in ingresso un stringa che contiene il path dell'imagine del profilo 
 * e stampa l'aside dell'utente esperto
 * 
 * @param string $img_profilo path name dell'immagine del profilo
 * @return no return 
 */
function printAsideEsperto ($img_profilo){    
    echo '<aside id="aside">';
    echo '<div class="tooltip-esperto">';
    echo '<span class="tooltip-testo-esperto">Utente esperto</span>';
    echo '<div class="profilo-img-container profilo-esperto ">';
    echo '<a href="profilo.php">';
    echo '<img class="img-profilo-dim" src="' . $img_profilo . '" alt="foto utente"/>';
    echo '</a>';
    echo '<div class="aside-testo">' . $_SESSION['nickname'] . '</div>'; 
    echo '</div>';
    echo '<div class="pubblica">';
    echo '<div class="aside-testo"> Pubblica </div>';
    echo '<button class="button" onclick="showModal' . "('pubblica-foto', 'post-container')" . '">'; 
    echo 'Foto </button>';
    echo '<button class="button" onclick="showModal' . "('pubblica-testo', 'post-container')" . '">'; 
    echo 'Testo </button>';
    echo '<button class="button" onclick="showModal' . "('pubblica-luogo', 'post-container')" . '">'; 
    echo 'Luogo </button>';
    echo '</div>';
    echo '</div>';
    echo '</aside>';   
}

/**
 * 2) Questa funzione prende in ingresso un stringa che contiene il path dell'imagine del profilo 
 * e stampa l'aside dell'utente
 * 
 * @param string $img_profilo path name dell'immagine del profilo
 * @return no return 
 */
function printAside ($img_profilo) {
    echo '<aside id="aside">';
    echo '<div class="profilo-img-container">';
    echo '<a href="profilo.php">';
    echo '<img class="img-profilo-dim" src="' . $img_profilo . '" alt="foto utente"/>';
    echo '</a>';
    echo '<div class="aside-testo">' . $_SESSION['nickname'] . '</div>';
    echo '</div>';
    echo '<div class="pubblica">';
    echo '<div class="aside-testo"> Pubblica </div>';
    echo '<button class="button" onclick="showModal' . "('pubblica-foto', 'post-container')" . '">';
    echo 'Foto </button>';
    echo '<button class="button" onclick="showModal' . "('pubblica-testo', 'post-container')" . '">'; 
    echo 'Testo </button>';
    echo '<button class="button" onclick="showModal' . "('pubblica-luogo', 'post-container')" . '">'; 
    echo 'Luogo </button>';
    echo '</div>';
    echo '</aside>';
}

/**
 * 3) Questa funzione prende in ingresso un riferimento ad un array che contiene le informazioni del post 
 * e stampa l'header del post
 * 
 * @param array $row
 * @return no return
 */
function printHeaderPost(&$row){
    
// verifico se l'utente è esperto o meno
    if($row['utente_esperto'] == TRUE){
        echo '<div class="post-profilo-container utente-esperto">';        
        echo '<img class="post-profilo-img" src="../' . $row['path_img_profilo'] .'" alt="foto profilo"/>';
        echo '<div class="tooltip-esperto">';
    }
    else if ($row['utente_esperto'] == FALSE){
        echo '<div class="post-profilo-container">'; 
        echo '<img class="post-profilo-img" src="../' . $row['path_img_profilo'] .'" alt="foto profilo"/>';
        
    }
    // verifico che sia un post dell'utente stesso
    if($row['nickname'] == $_SESSION['nickname']){
        echo '<a href="profilo.php"><div class="post-profilo-scritta">' . $row['nickname'] . '   </div></a>';
    }else{
        echo '<a href="datiUtente.php?email_utente='  . $row['email_utente'] .  '">'
                . '<div class="post-profilo-scritta">' . 
                $row['nickname'] . '</div></a>';
    }

    if($row['utente_esperto'] == TRUE){
        echo '<span class="tooltip-testo-esperto"> Utente esperto </span>'; 
        echo '</div>' ;
    }      
    
    echo '<div class="post-profilo-data">'; 
    printData($row['data_ora_cinguettio'], 'd/m/Y H:i');
    echo '</div>'; 
    echo '</div>';
        
    echo '<div class="clear-float-left"></div>';
}

/**
 * 4) Questa funzione prende in ingresso un riferimento ad un array contenente le informazioni su un post
 * di testo segnalato o oscurato e stampa l'header del post
 * 
 * @param array $row
 * @return no return
 */
function printHeaderSegnOsc (&$row){

    echo '<div class="post-profilo-container testo-segnalato">';
    echo '<img class="post-profilo-img" src="../' . $row['path_img_profilo'] .'" alt="foto profilo"/>';
    
    // verifico se è il post di un utente
    if($row['nickname'] == $_SESSION['nickname']){
        echo '<a href="profilo.php"><div class="post-profilo-scritta">' . $row['nickname'] . '   </div></a>';
    }else{
        echo '<a href="datiUtente.php?email_utente='  . $row['email_utente'] .  '">'
                . '<div class="post-profilo-scritta">' . 
                $row['nickname'] . '</div></a>';
    }
    echo '<div class="post-profilo-data">'; 
    printData($row['data_ora_cinguettio'], 'd/m/Y H:i');
    echo '</div>';
    echo '</div>';
    
}

/**
 * 5) Questa funzione prende in ingresso un riferimento ad un array e una connessione al database 
 * e stampa il post di foto
 * 
 * @param array $row
 * @param mixed $conn
 * @return no return
 */
function printFoto(&$row, $conn, $utente_esperto){
    
    //elenco dei commenti
    $sql = queryCommenti($row['email_utente'], $row['id_cinguettio']);
    
    //effettuo l'interrogazione per estrarre i commenti alla foto 
    // memorizzo il numero di commenti effettuati
    $commenti = mysqli_query($conn, $sql);
    $num_commenti = mysqli_num_rows($commenti);
    
    //query per il numero massimo di commenti di commenti effettuati dall'utente per il cinguettio
    $sql = queryNumeroMaxCommenti($row['email_utente'], $row['id_cinguettio']);
    
    //effettuo l'interrogazione e memorizzo il numero massimo di commenti effettuati dall utente 
    //per il cinguettio
    $result = mysqli_query($conn, $sql);
    $sql_result = mysqli_fetch_assoc($result);
    $max_commenti_utente = $sql_result['num_commenti'];
     
    // stampo l'header dei post
    printHeaderPost($row);

    // verifico che sia stata inserita una descrizione della foto
    if($row['descrizione_foto'] != NULL){
        echo '<div class="post-descrizione-foto">' . $row['descrizione_foto'] . '</div>';
    }

    // stampo la foto
    echo '<img class="post-foto" src="' . $row['path_foto']  . '" alt="cinguettio di foto"/>';                    

    // stampo il numero di commenti
    echo '<div class="commenti">'; 
    echo 'Commenti <span class="numero-commenti">' . $num_commenti . '</span>';
    echo '</div>';
    
    echo '<div class="lista-commenti">';
    if($num_commenti > 0){
        // stampo i commenti
        while($comm = mysqli_fetch_assoc($commenti)){
            echo '<a class="link-commenti" href="ricercaUtente.php?email_nickname=' . $comm['email_utente'] . '">';
            echo '<span class="nickname-commento">'. $comm['nickname'] . '</span>';
            echo '<span class="data-commento">';  
            printData($comm['data_ora_commento'], 'd/m/Y H:i');
            echo '</span>';    
            echo '<span class="testo-commento">' .  $comm['commento'] . '</span>';
            echo '</a>';
        }
    }    
    echo '</div>';

    // verifico se l'utente ha già inserito più di tre commenti
    if($max_commenti_utente >= 3){
       echo '<button onclick="showModal(' ."'ins-errore-max-commenti','post-container'" . ')" class="inserimento-commento">'; 
       echo 'Inserisci un commento </button>';
    }
    // verifico se l'utente è esperto
    else if($utente_esperto == FALSE){
        echo '<button onclick="showModal(' ."'ins-errore-no-esperto','post-container'" . ')" class="inserimento-commento">'; 
        echo 'Inserisci un commento </button>';
    }
    else{
        // creo l'id della modal
        $id_modal = $row['id_cinguettio'] . '_' . $row['email_utente'];
        echo '<button onclick="showModal(' ."'" . $id_modal . "'," . "'post-container'" . ')" class="inserimento-commento">'; 
        echo 'Inserisci un commento </button>';
    }
}

/**
 * 6) Questa funzione prende in ingresso un riferimento ad un array e una connessione al database 
 * e stampa il post di luogo
 * 
 * @param array $row
 * @param mixed $conn
 * @return no return 
 */
function printLuogo(&$row, $conn){
    
    //query per verificare se l'utente ha già segnalato il messaggio di testo
   $sql = queryLuogoPreferito($row['email_utente'], $row['id_cinguettio']);              
   $result = mysqli_query($conn, $sql);
   
   //memorizzo la latitudine
   $latitudine = decimalToGMS($row['latitudine'], 'lat');
   $longitudine = decimalToGMS($row['longitudine'], 'lng');
   
   
   // stampo l'header dei post
   printHeaderPost($row);
   
   //stampo la latitudine e la longitudine e aggiungo un riferimento a google maps per vedere la 
   //mappa
   echo printLinkMaps($row['latitudine'], $row['longitudine']);
   echo '<h1 class="post-luogo-latitudine-longitudine">'; 
   echo 'Latitudine ' . $latitudine . '</h1>';
   echo '<h1 class="post-luogo-latitudine-longitudine">';
   echo 'Longitudine ' .  $longitudine . '</h1>';
   echo '</a>';
   
   //verifico se l'utente ha già inserito il luogo come preferito inserisco un pulsante che se premuto
   // mostra un messaggio di errore
   if(mysqli_num_rows($result) == TRUE){
       echo '<button class="segnala-testo" onclick="showModal('; 
       echo "'luogo-errore','post-container'";
       echo ')">Luogo preferito</button>';
   }
   // inserisco un form per inserire indicare il luogo come preferito
   else{
       echo '<form class="luogo-preferito-form" action="../validazione/luogoPreferitoVal.php" method="POST">';
       echo '<input  type="hidden" name="utente_luogo" value="' . $row['email_utente'] . '"/>';
       echo '<input  type="hidden" name="id_cinguettio" value="' . $row['id_cinguettio'] . '"/>';
       echo '<input class="luogo-preferito" type="submit" value="Luogo preferito"/>';
       echo '</form>';
   }
}

/**
 * 7) Questa funzione prende in ingresso un riferimento ad un array e una connessione al database 
 * e stampa il post di testo
 * 
 * @param array $row
 * @param mixed $conn
 * @return no return
 */
function printTesto(&$row, $conn){
    
    // se il messaggio è stato oscurato stampo il post come oscurato
    if($row['oscurato'] == TRUE){
                
        // stampo l'header del post
        printHeaderSegnOsc($row);
        
        //stampo il messaggio
        echo '<h1 class="post-messaggio" style="color:grey; margin-left: 70px;">';
        echo 'MESSAGGIO OSCURATO';
        echo '</h1>';
    }
    
    // se il messaggio è stato segnalato ma non è oscurato
    else if ($row['inappropriato'] == TRUE){
        
        // stampo l'header del post      
        printHeaderSegnOsc($row);
        
        // stampo il messaggio
        echo '<h1 class="post-messaggio">'; 
        echo htmlspecialchars_decode($row['messaggio']); 
        echo '</h1>';
        
        // verifico se il post è stato pubblicato dall utente della sessione in caso non lo sia inserisco i pulsanti
        // per la segnalazione del testo
        if($row['email_utente'] != $_SESSION['email_utente']) {
            
            //query per verificare se l'utente ha già segnalato il messaggio di testo
            $sql = queryTestoSegnalato($row['email_utente'], $row['id_cinguettio']);     
            $result = mysqli_query($conn, $sql);
            
            // se il messaggio è stato già segnalato dall'utente stampo un bottone che se premuto
            // fa visualizzare un messaggio di errore 
            if(mysqli_num_rows($result) == TRUE){
                echo '<button class="segnala-testo" onclick="showModal('; 
                echo "'testo-errore-max-segnalazioni','post-container'";
                echo ')"> Segnala testo</button>';
            }
            // altrimenti stampo una form per la segnalazione del testo
            else{                
               echo '<form class="segnala-testo-form" action="../validazione/segnalaTestoVal.php" method="POST">';
               echo '<input  type="hidden" name="utente_segnalato" value="' . $row['email_utente'] . '"/>';
               echo '<input  type="hidden" name="id_cinguettio" value="' . $row['id_cinguettio'] . '"/>';
               echo '<input class="segnala-testo" type="submit" value="Segnala testo"/>';
               echo '</form>';
            }
            $drop_list = '<div class="segnalato-da">';
        }else{
            $drop_list = '<div class="segnalato-da" style="display: block; float:none; margin-left:510px;">';
        }
        
        // creo la query per l'elenco degli utenti che hanno segnalato il messaggio
        $sql = queryListaSegnalanti($row['email_utente'], $row['id_cinguettio']);
        //eseguo la query
        $result = mysqli_query($conn, $sql);
        
        // stampo il nickname degli utenti che hanno segnalato il messaggio
        echo $drop_list . 'Segnalato inappropriato da'; 
        echo '<div class="lista-utenti">';
        while($segnalanti = mysqli_fetch_assoc($result)){
            echo '<a class="link-utenti" style="text-align:center;">' . $segnalanti['nickname'] .  '</a>';
        }
       echo '</div>';
       echo '</div>'; 
    }
    // nel caso di un messaggio di testo non segnalato
    else{
        
        // stampo l'header del post
        printHeaderPost($row);
        
        //verifico se il post è stato pubblicato dall'utente attualmente in sessione
        if($row['email_utente'] == $_SESSION['email_utente']){
            // stampo il messaggio
            echo '<h1 class="post-messaggio">'; 
            echo htmlspecialchars_decode($row['messaggio']); 
            echo '</h1>';
        }
        // stampo il messaggio con bottone per la segnalazione
        else{
            // stampo il messaggio
            echo '<h1 class="post-messaggio">'; 
            echo htmlspecialchars_decode($row['messaggio']); 
            echo '</h1>';
            
            // stampo il pulsante per la seganlazione del testo
            echo '<form class="segnala-testo-form" action="../validazione/segnalaTestoVal.php" method="POST">';
            echo '<input  type="hidden" name="utente_segnalato" value="' . $row['email_utente'] . '"/>';
            echo '<input  type="hidden" name="id_cinguettio" value="' . $row['id_cinguettio'] . '"/>';
            echo '<input class="segnala-testo" type="submit" value="Segnala testo"/>';
            echo '</form>';
        }
    }
}
    
/**
 * 8) Questa funzione prende in ingresso l'id di un cinguettio e la email dell'utente che viene giudicato 
 * stampa la form modale con uno specifico id per l'iserimento del commento.
 * 
 * @param $id_cinguettio
 * @param $utente_giudicato
 * @return no return
 */

function printModal($id_cinguettio, $utente_giudicato){
    
    // definisco l'id della modal
    $id_modal = $id_cinguettio . '_' . $utente_giudicato;
    
    // stampo la form modale
    echo '<div id="' . $id_modal . '" class="modal" onclick="closeModal(';
    echo "'" . $id_modal . "'". ",'post-container')" . '">';
    echo '<div id="cinguettio-container">';
    echo '<h1 class="modal-titolo" style="margin-left:75.735px;">Inserisci un commento</h1>';
    echo '<span style="margin-left:45px;" onclick="hideModal(';
    echo "'" . $id_modal . "'". ",'post-container')" . '"';
    echo 'class="close" title="Close Modal">×</span>';
    echo '<form action="../validazione/inserimentoCommentoVal.php" method="POST">';
    echo "<textarea name='commento'" . 'class="textarea" placeholder="Scrivi qualcosa ..."'; 
    echo 'required maxlength="50"/></textarea>';
    echo '<input type="hidden" name="utente_giudicato" value="' . $utente_giudicato . '">';
    echo '<input type="hidden" name="id_cinguettio" value="' . $id_cinguettio . '">';
    echo '<input class="login-registrazione-submit" type="submit" value="Pubblica">';
    echo '<input class="login-registrazione-reset" type="reset" value="Reset">';
    echo '</form>';
    echo '</div>';
    echo '</div>';   
    
}