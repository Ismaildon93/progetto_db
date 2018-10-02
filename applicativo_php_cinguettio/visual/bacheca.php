<?php

    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    require_once '../function/funBacheca.php';
    require_once '../query/queryBacheca.php';

    // avvio la sessione
    session_start();

    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
    
    // creo la connessione al database 
    $conn = dbConnection();
    
    // verifico la connessione se fallisce redirigo l'utente in error.php
    if(!$conn){
        redirectError(FAIL_DB_CONN);
    }
    
 ?>

<!-- INIZIO CONTENUTO PRINCIPALE-->

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
            <div id="div-ricerca-avanzata" onclick="showModal('ricerca-avanzata', 'post-container')">
                <span id="ricerca-avanzata-scritta"> Ricerca avanzata </span>
                <img id="header-logo-ricerca-avanzata"src="../img/icone/logo_ricerca_avanzata.jpg">
            </div>
            <a class="header-link" href="profilo.php" > Profilo </a>
            <a class="header-link" href="bacheca.php" > Home </a>
        </header>
        <div class="clear-float-left"></div>
        
        <!---------------------------------- FORM RICERCA AVANZATA MODALE -------------------------------------->       
       
        <div id="ricerca-avanzata" class="modal" onclick="closeModal('ricerca-avanzata','post-container')">
            <div id="login-registrazione-container" style="margin-top: 50px;">
                <h1 class="modal-titolo"> Ricerca avanzata </h1>
                <span style="margin-left:92px;" onclick="hideModal('ricerca-avanzata','post-container')" 
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
                
        <!-- ====================  SEZIONE ASIDE  =======================-->
        
        <?php
            /* Questa sezione contiene gli script per la stampa dell'aside */

            // query per l'estrazione dell info di profilo ovvero se l'utente è esperto e l'immagine del profilo
            // dell utente
            $sql = queryInfoProfilo();

            //eseguo la query
            $result = mysqli_query($conn, $sql);

            //controllo quante tuple sono state trovate 
            if(mysqli_num_rows($result) == 1){

                 // estraggo il risultato dell'interrogazione 
                $row = mysqli_fetch_assoc($result);

                //memorizzo il fatto se l'utente è esperto o meno e il path dell'immagine profilo
                $utente_esperto = $row ['utente_esperto'];
                $img_profilo = '../' . $row['path_img_profilo'];

                if($utente_esperto == true){
                    // stampa l'aside dell'utente esperto in caso l'utente sia esperto
                    printAsideEsperto($img_profilo);
                }else{
                    // stampa l'aside dell'utente non esperto
                    printAside($img_profilo);
                }

            }
            else {
                // chiudo la connessione al database 
                mysqli_close($conn);

                // redirigo l'utente verso la pagina error.php
                redirectError(ERROR);
            }
                
           ?>     
        
        <!-- ----------------------------- FORM MODALE PUBBLICA FOTO ---------------------------------------->
        
        <div id="pubblica-foto" class="modal" onclick="closeModal('pubblica-foto','post-container')">
            <div id="cinguettio-container">
                <h1 class="modal-titolo">Inserisci una foto</h1>
                <span style="margin-left:85px;" onclick="hideModal('pubblica-foto','post-container')" 
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/pubblicaFotoVal.php" method="POST" enctype="multipart/form-data">
                    <input name='descrizione_foto' class="login-registrazione-input" type="text" maxlength="20" 
                           placeholder="Descrizione foto">
                    <input name='file' class="login-registrazione-input" type="file" required> 
                    <input class="login-registrazione-submit" type="submit" value="Pubblica foto" >
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>
        
        <!------------------------------------ FORM MODALE PUBBLICA TESTO ---------------------------------------->     
        <div id="pubblica-testo" class="modal" onclick="closeModal('pubblica-testo','post-container')">
            <div id="cinguettio-container">
                <h1 class="modal-titolo" style="margin-left: 73.04px">Inserisci un messaggio</h1>
                <span style="margin-left:40px;" onclick="hideModal('pubblica-testo','post-container')" 
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/pubblicaTestoVal.php" method="POST">
                    <textarea name='messaggio' class="textarea" placeholder="Scrivi qualcosa ..." 
                              required maxlength="50"></textarea>
                    <input class="login-registrazione-submit" type="submit" value="Pubblica" >
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>
        
         <!------------------------------------  FORM MODALE PUBBLICA LUOGO ------------------------------------>
         
        <div id="pubblica-luogo" class="modal" onclick="closeModal('pubblica-luogo','post-container')">
            <div id="cinguettio-container">
                <h1 class="modal-titolo">Inserisci un luogo</h1>
                <span style="margin-left:70px;" onclick="hideModal('pubblica-luogo','post-container')"
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/pubblicaLuogoVal.php" method="POST">
                    <fieldset class="fildset-style">
                        <legend> Latitudine </legend>
                        <select class="select-style" name="gradi_lat" required >
                            <?php
                                // valore di default
                                echo '<option value=""> Gradi </option>';
                                //gradi tra 0 e 180
                                for($i = 0; $i <= 90; $i++) {
                                    echo "<option value=" . $i . ">"  . $i . "°" . '</option>';
                                } 
                           ?>
                        </select>
                        <select class="select-style" name="minuti_lat" required>
                            <?php
                                // valore di default
                                echo '<option value=""> Primi </option>';
                                //minuti tra 0 e 59
                                for($i = 0; $i <= 59; $i++) {
                                    echo "<option value=" . $i . ">"  . $i . "'" . '</option>';
                                }   
                           ?>
                        </select>
                        <select class="select-style" name="secondi_lat" required>
                            <?php
                                // valore di default
                                echo '<option value=""> Secondi </option>';
                                //secondi tra 0 e 59
                                for($i = 0; $i <= 59; $i++) {
                                    echo "<option value=" . $i . ">"  . $i . "''" . '</option>';
                                }
                           ?>
                        </select>
                        <select class="select-style" name="direzione_lat" required>
                            <option value="n"> N </option>
                            <option value="s"> S </option>
                        </select>
                    </fieldset>
                    <fieldset class="fildset-style">
                        <legend> Longitudine </legend>
                        <select class="select-style" name="gradi_lng" required>
                            <?php
                                // valore di default
                                echo '<option value=""> Gradi </option>';
                                //gradi tra 0 e 180
                                for($i = 0; $i <= 180; $i++) {
                                    echo "<option value=" . $i . ">"  . $i . "°" . '</option>';
                                }
                            ?>
                        </select>
                        <select class="select-style" name="minuti_lng" required>
                            <?php
                                // valore di default
                                echo '<option value=""> Primi </option>';
                                //minuti tra 0 e 59
                                for($i = 0; $i <= 59; $i++) {
                                    echo "<option value=" . $i . ">"  . $i . "'" . '</option>';
                                 }   
                            ?>
                        </select>
                        <select class="select-style" name="secondi_lng" required>
                            <?php
                                // valore di default
                                echo '<option value=""> Secondi </option>';
                                //secondi tra 0 e 59
                                for($i = 0; $i <= 59; $i++) {
                                      echo "<option value=" . $i . ">"  . $i . "''" . '</option>';
                                }       
                                ?>
                        </select>
                        <select class="select-style" name="direzione_lng" required>
                            <option value="e"> E </option>
                            <option value="w"> W </option>
                        </select>
                    </fieldset>
                    <input class="login-registrazione-submit" type="submit" value="Pubblica" >
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>       
        
        <!-- ==================== SEZIONE DEI POST ==========================-->
             <?php
             
             /* Questa sezione contiene gli script per la stampa dei post */
             
             //creo la query per l'elenco dei post
             $sql = queryPostList();
             // eseguo la query e memorizzo il risultato
             $result = mysqli_query($conn, $sql);
              
             //memorizzio il numero di risultati
            $num_ris = mysqli_num_rows($result);
            
            
            // se non è presente nessun post in bacheca stampo un messaggio 
            if($num_ris == 0){
                echo '<div>';
                echo '<h1 class="no-post"> Non hai nessun post in bacheca </h1>';
                echo '</div>';
                
            }
            // se la ricerca ha prodotto risultati
            else{
                
                // contenitore degli utenti
                echo '<div id="post-container">';
                
                // stampo elementi solo se ci il numero di risultati è maggiore di 0 e non stampo nel caso
                // dell'utente stesso
                while(($row = mysqli_fetch_assoc($result)) && $num_ris > 0){
                       
                        // verifico se si tratta di un cinguettio di tipo foto in caso posito chiamo
                        // la funzione per la stampa dell cinguettio di tipo foto
                        if($row['tipo_cinguettio'] == 'F'){
                             // contenitore dei post degli utenti
                             echo '<div class="post-foto-container">';
                             printFoto($row, $conn, $utente_esperto);
                             echo '</div>';
                        }
                        // verifico se si tratta di un cinguettio di tipo luogo in caso posito chiamo
                        // la funzione per la stampa dell cinguettio di tipo luogo
                        else if($row['tipo_cinguettio'] == 'L'){
                            echo '<div class="post-luogo-container">';
                            printLuogo($row, $conn);
                            echo '</div>';
                        }
                        // nel caso in cui il messaggio sia un cinguettio di tipo testo
                        else if($row['tipo_cinguettio'] == 'T'){
                            echo '<div class="post-testo-container">';
                            printTesto($row, $conn);
                            echo '</div>';
                        }
                }
                echo '</div>';
                
                //creo la query per l'elenco dei post per la stampa delle form modali per l'inserimento dei 
                //commenti
                $sql = queryPostList();
                
                // eseguo la query e memorizzo il risultato
                $result = mysqli_query($conn, $sql);
                
                // stampa dell form modali per l'inserimento dei commenti
                while($row_modal = mysqli_fetch_assoc($result)){
                    if($row_modal['tipo_cinguettio'] =='F'){
                        printModal($row_modal['id_cinguettio'], $row_modal['email_utente']);
                    }
                }
                
                // chiudo la connessione al database
                mysqli_close($conn);
            }  

       ?>
        
        <!--=============== FORM MODALI ERRORI ===============>
        
        <!--------------------------------- errore numero massimo di 3 commenti ---------------------------------->
        <div id="ins-errore-max-commenti" class="modal" onclick="closeModal('ins-errore-max-commenti','post-container')">
            <div id="cinguettio-container" style="padding:20px; display:table; text-align:left; height: 0px;">
                <h1  style="font-family: Helvetica; color: #DC2C46; margin:0 10px;">
                    Hai raggiunto il limite massimo di 3 commenti per questo post </h1>
            </div>
        </div>   
        
        <!--------------------------------- errore non sei un utente esperto non puoi commentare ----------------> 
        <div id="ins-errore-no-esperto" class="modal" onclick="closeModal('ins-errore-no-esperto','post-container')">
            <div id="cinguettio-container" style="padding:20px; display:table; text-align:left; height: 0px;">
                <h1  style="font-family: Helvetica; color: #DC2C46; margin:0 10px;">
                    Non sei un utente esperto non puoi commentare il post </h1>
            </div>
        </div>                        
       
       <!----------------------------- errore testo già segnalato  -------------------------------------->
        <div id="testo-errore-max-segnalazioni" class="modal" onclick="closeModal('testo-errore-max-segnalazioni','post-container')">
            <div id="cinguettio-container" style="padding:20px; display:table; text-align:left; height: 0px;">
                <h1  style="font-family: Helvetica; color: #DC2C46; margin:0 10px;">
                    Hai già segnalato il messaggio </h1>
            </div>
        </div>   
       
       <!----------------------------- errore luogo già indicato come preferito  -------------------------------------->
       <div id="luogo-errore" class="modal" onclick="closeModal('luogo-errore','post-container')">
            <div id="cinguettio-container" style="padding:20px; display:table; text-align:left; height: 0px;">
                <h1  style="font-family: Helvetica; color: #DC2C46; margin:0 10px;">
                    Hai già indicato il luogo come preferito </h1>
            </div>
        </div>   
       
    </body>
</html>
