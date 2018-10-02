<?php

    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    require_once '../function/funCheckInput.php';
    require_once '../function/funRicerca.php';
    require_once '../query/queryRicercaUtente.php';

    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
?>

<?php 
       
    /* Questa sezione contiene gli script per il recupero dei dati iniviati dall'utente 
     * e il recupero delle informazioni per la visualizzazione 
     */

    // verifico che l'input dell'utente sia stato inviato in post altrimenti redirigo a error.php
    if(!correctMethodInput('GET')){
        redirectError(FAIL_INPUT);
    }
    
    // memorizzo il tipo di ricerca scelto
    $tipo_ricerca = tipoRicerca($_GET);
    
    // considero il caso della ricerca di tutti gli utenti
    if($tipo_ricerca == RICERCA_TUTTI_GLI_UTENTI){
        
        // creo la connessione al database 
        $conn = dbConnection();
    
        // verifico la connessione se fallisce redirigo l'utente in error.php
        if(!$conn){
            redirectError(FAIL_DB_CONN);
        }
    
        // creo la query per la ricerca di tutti gli utenti
        $sql = queryRicercaTuttiGliUtenti();
        
    }
    
    // condidero il caso della ricerca per nickname o email_utente
    else if ( $tipo_ricerca == RICERCA_EMAIL_NICK){
                
        // verifico se l'input inserito dall'utente sia riconducibile ad una mail o a un nickname
        if(preg_match('/^.+@.+$/', $_GET['email_nickname'])){ // assumo che la @ sia associata ad una mail
            $_GET['email_utente'] = $_GET['email_nickname'];
            unset($_GET['email_nickname']); // elimino la variabile in modo da gestire più facilmente il controllo dell'input
        }else{
            $_GET['nickname'] = $_GET['email_nickname'];
            unset($_GET['email_nickname']);
        }
        
        //pulisco da eventuale codice pericoloso l'input inserito dall' utente 
        $input = cleanInput($_GET);
       
        // verifico che l'input inserito dall'utente sia un formato corretto altrimenti redirigo a error.php
        if(!inputChecker($input)){
            redirectError(FAIL_INPUT);
        }
        
        // verifico che l'utente non abbia ricercato se stesso in caso postivo redirigo l'utente verso
        // il proprio profilo
        if(autoSearch($input)){           
           redirect('profilo.php');
        }
        
        // creo la connessione al database 
        $conn = dbConnection();
    
        // verifico la connessione se fallisce redirigo l'utente in error.php
        if(!$conn){
            redirectError(FAIL_DB_CONN);
        }
        
        // preparo i dati i dati di input prima della creazione della query 
        prepareInputToQuery($input, $conn);
        
        // creo la query
        $sql = queryRicercaEmailNickname($input);
    }
    
    // considero il caso della ricerca avanzata
    else if($tipo_ricerca == RICERCA_AVANZATA) {
        
         //pulisco da eventuale codice pericoloso l'input inserito dall' utente 
        $input = cleanInput($_GET);

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

        // creo la connessione al database 
        $conn = dbConnection();

        // verifico la connessione se fallisce redirigo l'utente in error.php
        if(!$conn){
            redirectError(FAIL_DB_CONN);
        }
        
        // preparo i dati i dati di info_utente prima della creazione della query 
        prepareInputToQuery($info_utente, $conn);
        
        // elimino eventuali hobby ripetuti
        deleteRepeatedHobby($hobby);
        
        // preparo i dati i dati di hobby prima della creazione della query 
        prepareInputToQuery($hobby, $conn);
              
        // creo la query per la ricerca
        $sql = queryRicercaAvanzata($info_utente, $hobby);
        
    }
        
    // eseguo la query e memorizzo il risultato memorizzo il numero di risultati
    $result = mysqli_query($conn, $sql);
    $num_ris = mysqli_num_rows($result);

    // verifico che il risultato della ricerca non sia l'utente stesso in caso positivo
    // ridirigo l'utente nella propria pagina di profilo
    $row_utente = mysqli_fetch_assoc($result);
    if($num_ris == 1 && $row_utente['email_utente'] == $_SESSION['email_utente']){
        redirect('profilo.php');
    }
        
?>

<!DOCTYPE html>
<html lang="it">
        
    <!-- stampa dell'head -->
    <?php printHead() ?>
    
    <body>
       
<!-- ==================== SEZIONE HEADER =========================== -->  
        <header id="header-barra">           
            <img id="header-logo-bandiera" src="../img/icone/logo_bandiera.jpg">            
            <form action="ricercaUtente.php" method="GET">
                <input name="email_nickname" id="header-input-ricerca" type="search"
                       maxlength="70" placeholder="email o nickname">
                <input id="header-submit-ricerca" type="submit" value="Ricerca">
            </form>
            <div id="div-ricerca-avanzata" onclick="showModal('ricerca-avanzata', 'ricerca-utenti-container')">
                <span id="ricerca-avanzata-scritta"> Ricerca avanzata </span>
                <img id="header-logo-ricerca-avanzata"src="../img/icone/logo_ricerca_avanzata.jpg">
            </div>
             <a class="header-link" href="profilo.php" > Profilo </a>
            <a class="header-link" href="bacheca.php" > Home </a>
        </header>
        <div class="clear-float-left"></div>
        
        <!---------------------------------- FORM RICERCA AVANZATA MODALE -------------------------------------->       
       
        <div id="ricerca-avanzata" class="modal" onclick="closeModal('ricerca-avanzata','ricerca-utenti-container')">
            <div id="login-registrazione-container" style="margin-top: 50px;">
                <h1 class="modal-titolo"> Ricerca avanzata </h1>
                <span style="margin-left:92px;" onclick="hideModal('ricerca-avanzata','ricerca-utenti-container')" 
                      class="close" title="Close Modal">×</span>
                <form action="ricercaUtente.php" method="GET">
                <input name="nome" class="login-registrazione-input" type="text" 
                       maxlength="20" placeholder="Nome">                    
                <input name="cognome" class="login-registrazione-input" type="text" 
                       maxlength="20" placeholder="Cognome">
                <fieldset class="fildset-style">
                    <legend> Sesso </legend>
                    <input name="sesso" class="radio-input" type="radio" value="m"/>
                    <label for="sesso">Uomo</label><br> 
                    <input name="sesso" class="radio-input" type="radio" value="f"/> 
                    <label for="sesso">Donna</label><br> 
                </fieldset>
                <fieldset class="fildset-style">
                        <legend> Data di nascita </legend>
                            <select class="select-style" name="giorno">
                                <?php
                                    // valore di default 
                                    echo '<option value=>Giorno</option>';
                                    //giorni dell'anno
                                    for($i = 1; $i <= 31; $i++) {
                                        if($i < 10){
                                            echo '<option value='. "0$i" . '>' . '0' . $i . '</option>';
                                        }
                                        else{
                                            echo '<option value='. "$i" . '>' . $i . '</option>';
                                        }        
                                    }   
                                ?>
                            </select>
                            <select class="select-style" name="mese">
                                <?php
                                    // valore di default 
                                    echo '<option value=>Mese</option>';
                                    //mesi dell'anno
                                    for($i = 1; $i <= 12; $i++) {
                                        if($i < 10){
                                            echo '<option value='. "0$i" . '>' . '0' . $i . '</option>';
                                        }
                                        else{
                                            echo '<option value='. "$i" . '>' . $i . '</option>';
                                        }                            
                                    }   
                                ?>
                            </select>
                            <select class="select-style" name="anno">
                                <?php
                                    // valore di default 
                                    echo '<option value=>Anno</option>';
                                    //anni 
                                    for($i = date('Y'); $i >= 1900; $i--) {
                                        echo '<option value='. "$i" . '>' . $i . '</option>';
                                    }   
                                ?>
                            </select>
                    </fieldset>
                    <input name="nazione_nascita" class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Nazione di nascita">
                    <input name="regione_nascita"  class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Regione di nascita">
                    <input name="citta_residenza" class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Citta di residenza">
                    <fieldset class="fildset-style">
                        <legend>Hobby</legend>
                            <table>
                                <tr>    		
                                    <td>
                                        <input class="checkbox-input" type="checkbox" name="hobby_1" 
                                               value="sport">
                                        <label class="checkbox-label" for="hobby_1">Sport</label>
                                    </td>    
                                    <td>
                                        <input class="checkbox-input" type="checkbox"  name="hobby_2" 
                                               value="musica">  
                                        <label class="checkbox-label" for="hobby_2">Musica</label>
                                    </td>       
                                    <td> 
                                        <input class="checkbox-input" type="checkbox"  name="hobby_3" 
                                               value="arte">
                                        <label class="checkbox-label" for="hobby_3">Arte</label>
                                    </td>
                                </tr>
                                <tr>    		
                                    <td>
                                        <input class="checkbox-input" type="checkbox"  name="hobby_4" 
                                               value="tecnologia">
                                        <label class="checkbox-label" for="hobby_4">Tecnologia</label>
                                    </td>    
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_5" 
                                               value="film e serie tv">
                                        <label class="checkbox-label" for="hobby_5">Film e serie TV</label>
                                    </td>       
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_6" 
                                               value="fotografia">
                                        <label class="checkbox-label" for="hobby_6">Fotografia</label>
                                    </td>
                                </tr>
                                <tr>    		
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_7" 
                                               value="moda e design">
                                        <label class="checkbox-label" for="hobby_7">Moda e design</label>
                                    </td>    
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_8" 
                                               value="videogames">
                                        <label class="checkbox-label" for="hobby_8">Videogames</label>
                                    </td>       
                                    <td>
                                        <input  class="checkbox-input" type="checkbox"  name="hobby_9" 
                                                value="viaggiare">
                                        <label class="checkbox-label"  for="hobby_9">Viaggiare</label>
                                    </td>
                                </tr>
                            </table>	
                        <input class="login-registrazione-input" type="text" name="hobby_10" 
                               maxlength="20" placeholder="Hobby aggiuntivo">
                    </fieldset>
                    <input class="login-registrazione-submit" type="submit" value="Avvia ricerca">
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>
        
       <!-- ==================== ELENCO DEGLI UTENTI TROVATI ==================-->
        
        <?php
             /* Questa sezione contiene gli script per la stampa degli utenti ricercati */ 
            
             // eseguo la query e memorizzo il risultato
            $result = mysqli_query($conn, $sql);
        
            // memorizzo il numero di risultati
            $num_ris = mysqli_num_rows($result);
                
            if($num_ris == 0){
                echo '<div>';
                echo '<h1 class="no-ris"> La ricerca non ha prodotto risultati </h1>';
                echo '</div>';
            }
            else{
                
                // contenitore degli utenti
                echo '<div id="ricerca-utenti-container">';
            
                // stampo elementi solo se ci il numero di risultati è maggiore di 0 e non stampo nel caso
                // dell'utente stesso
                while($row = mysqli_fetch_assoc($result)){
                    if(($row['utente_esperto'] == TRUE) && ($row['email_utente'] != $_SESSION['email_utente'])){
                           printUtenteEsperto($row);
                    }
                    else if (($row['utente_esperto'] == FALSE) && ($row['email_utente'] != $_SESSION['email_utente'])){
                        print printUtente($row);
                    }
                }
                 echo '</div>';
            }
            
            //chiudo la connessione al database
            mysqli_close($conn);
        ?>
       
      </body>
</html>
