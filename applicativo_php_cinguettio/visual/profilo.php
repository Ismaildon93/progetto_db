<?php

    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    require_once '../function/funBacheca.php';
    require_once '../function/funProfilo.php';
    require_once '../query/queryBacheca.php';
    require_once '../query/queryProfilo.php';

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
    
    //verifico se l'utente è esperto
    
 ?>

<!-- INIZIO CONTENUTO PRINCIPALE-->

<!DOCTYPE html>
<html lang="it">
    <!-- stampa dell'head -->
    <?php printHead() ?>
    
    <body>
        <header id="header-barra">
            <img id="header-logo-bandiera" src="../img/icone/logo_bandiera.jpg">
            <h1 id="header-logo-scritta"> Profilo </h1>
            <a class="header-link" href="../validazione/logoutVal.php" > Logout </a>
            <a class="header-link" href="bacheca.php" > Home </a>
            <a class="header-link" href="profilo.php" > Profilo </a>
            <button class="header-registrazione-bottone" 
	onclick="showModal('info-utente','post-container')"> Info utente </button>
        </header>
        <div class="clear-float-left"></div>
        
        <aside id="aside"> 
        <?php 
            
            /* Questa sezione contiene gli script per la stampa dell'aside e della form modale per la modifica  
            *  delle info utente 
            */ 
        
            // creo la query per l'estrazione delle informazioni dell'utente degli hobby e del numero di richieste ricevute
            // il numero di utenti seguiti e di seguaci e del numero di luoghi preferiti
            $sql_info_utente = queryInfoUtente ();
            $sql_hobby = queryHobbyUtente();
            $sql_richieste = queryRichieste();
            $sql_utenti_seguaci = querySeguaci();
            $sql_utenti_seguiti = querySeguiti();
            $sql_luoghi_preferiti = queryLuoghiPreferiti();

            // effettuo le interrogazioni per gli hobby e gli utenti
            $result_info_utente =  mysqli_query($conn, $sql_info_utente);
            $result_hobby = mysqli_query($conn, $sql_hobby);
          
            // effettuo le interrogazioni per stampare i links alle pagine 
            $result_richieste = mysqli_query($conn, $sql_richieste);
            $result_utenti_seguaci = mysqli_query($conn, $sql_utenti_seguaci);
            $result_utenti_seguiti = mysqli_query($conn, $sql_utenti_seguiti);
            $result_luoghi_preferiti = mysqli_query($conn, $sql_luoghi_preferiti);
             
            //estraggo il numero di richieste di essere seguito che ha ricevuto l'utente 
            $richieste = mysqli_fetch_assoc($result_richieste);
            
            // stampo il link per le richieste con il numero di richieste
            echo '<a href="richieste.php" class="link-aside"> Richieste'; 
            echo '<span class="link-numero">' . $richieste['num_richieste'] .  '</span></a>';
           
            //estraggo le informazioni dell'utente loggato in sessione
            $info_utente = mysqli_fetch_assoc($result_info_utente);
            
            //estraggo le informazioni sugli hobby dell'utente loggato nel sistema
            for($i = 0; ($row = mysqli_fetch_assoc($result_hobby)); $i++){
                $hobby[$i] = $row['tipo_hobby'];
            }
            
            // verifica se l'utente è esperto in caso lo sia stampa l'aside per l'utente esperto
            if($info_utente['utente_esperto' ] == TRUE){ 
                printAsideEspertoProfilo($info_utente['path_img_profilo']);
            }else{
                printAsideProfilo($info_utente['path_img_profilo']);
            }
            
            //estraggo il numero seguaci dell' utente 
            $seguaci = mysqli_fetch_assoc($result_utenti_seguaci);
            
            // stampo il link per la pagina dei seguaci con il numero di seguaci dell'utente
            echo '<a href="listaSeguaci.php" class="link-aside"> Seguaci'; 
            echo '<span class="link-numero">' . $seguaci['num_seguaci'] .  '</span></a>';
            
            //estraggo il numero utenti seguiti dall' utente 
            $seguiti = mysqli_fetch_assoc($result_utenti_seguiti);
            
            // stampo il link per la pagina dei seguiti con il numero di utenti seguiti
            echo '<a href="listaSeguiti.php" class="link-aside"> Seguiti'; 
            echo '<span class="link-numero">' . $seguiti['num_seguiti'] .  '</span></a>';
            
            // estraggo il numero di luoghi preferiti
            $luoghi_preferiti = mysqli_fetch_assoc($result_luoghi_preferiti);
            
            // stampo il link per la pagina dei luoghi preferiti con il numero di luoghi preferiti dall'utente
            echo '<a href="luogoPreferito.php" class="link-aside"> Luoghi Preferiti'; 
            echo '<span class="link-numero">' . $luoghi_preferiti['num_luogo_preferito'] .  '</span></a>';
            
            
        ?>
        </aside>
        
        <div id="info-utente" class="modal" onclick="closeModal('info-utente','post-container');">
            <div id="login-registrazione-container" style="margin-top: 50px;">
                <h1 class="modal-titolo" style="margin-left:81.11px;"> Modifica le info utente </h1>
                <span style="margin-left:50px;" onclick="hideModal('info-utente','post-container')" 
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/modificaProfiloVal.php" method="POST">
                <input name="nome" class="login-registrazione-input" type="text" 
                       maxlength="20" placeholder="Nome" value="<?php  printName($info_utente['nome'])?>">                    
                <input name="cognome" class="login-registrazione-input" type="text" 
                       value="<?php  printName($info_utente['cognome'])?>"
                       maxlength="20" placeholder="Cognome">
                <fieldset class="fildset-style">
                    <legend> Sesso </legend>
                    <?php                    
                        if($info_utente['sesso'] == 'm'){
                          echo '<input name="sesso" class="radio-input" type="radio" value="m" checked/>';
                          echo '<label for="sesso">Uomo</label><br>';
                          echo '<input name="sesso" class="radio-input" type="radio" value="f"/>'; 
                          echo '<label for="sesso">Donna</label><br>'; 
                        }
                        else if($info_utente['sesso'] == 'f'){
                           echo '<input name="sesso" class="radio-input" type="radio" value="m"/>';
                           echo '<label for="sesso">Uomo</label><br>';
                           echo '<input name="sesso" class="radio-input" type="radio" value="f"/ checked>'; 
                           echo '<label for="sesso">Donna</label><br>'; 
                        }
                        else{
                            echo'<input name="sesso" class="radio-input" type="radio" value="m"/>';
                            echo'<label for="sesso">Uomo</label><br>';
                            echo'<input name="sesso" class="radio-input" type="radio" value="f"/>'; 
                            echo'<label for="sesso">Donna</label><br>';
                        }
                    ?>    
                </fieldset>
                <fieldset class="fildset-style">
                        <legend> Data di nascita </legend>
                        <?php
                                    if($info_utente['data_nascita'] != NULL){
                                        $tstamp = strtotime($info_utente['data_nascita'] );
                                        $giorno['value'] = $giorno['option'] = date('d',$tstamp); 
                                        $mese['value'] = $mese['option'] = date('m',$tstamp); 
                                        $anno['value'] = $anno['option'] = date('Y',$tstamp); 
                                    }
                                    else{
                                        $tstamp = strtotime($info_utente['data_nascita'] );
                                        $giorno['value'] = ''; 
                                        $giorno['option'] = 'Giorno'; 
                                        $mese['value'] = '';
                                        $mese['option'] = 'Mese'; 
                                        $anno['value'] = '';
                                        $anno['option'] = 'Anno'; 
                                    }
                           ?>         
                            <select class="select-style" name="giorno">
                                <?php
                                    // valore inserito dall'utente
                                    echo "<option value='" . $giorno['value'] . "'>" . $giorno['option'] . "</option>";
                                    if($info_utente['data_nascita'] != NULL){
                                        // valore di default
                                        echo "<option value=''>Giorno</option>";
                                    }    
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
                                     echo "<option value='" . $mese['value'] . "'>" . $mese['option'] . "</option>";
                                     if($info_utente['data_nascita'] != NULL){
                                        // valore di default
                                        echo "<option value=''>Mese</option>";
                                    }    
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
                                    // valore inserito dall'utente
                                     echo "<option value='" . $anno['value'] . "'>" . $anno['option'] . "</option>";
                                     if($info_utente['data_nascita'] != NULL){
                                        // valore di default
                                        echo "<option value=''>Anno</option>";
                                    }    
                                    //anni 
                                    for($i = date('Y'); $i >= 1900; $i--) {
                                        echo '<option value='. "$i" . '>' . $i . '</option>';
                                    }   
                                ?>
                            </select>
                    </fieldset>
                    <input name="nazione_nascita" class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Nazione di nascita" 
                           value="<?php  printName($info_utente['nazione_nascita'])?>">
                    <input name="regione_nascita"  class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Regione di nascita" 
                           value="<?php  printName($info_utente['regione_nascita'])?>">
                    <input name="citta_residenza" class="login-registrazione-input" type="text" 
                           maxlength="50" placeholder="Citta di residenza"
                           value="<?php  printName($info_utente['citta_residenza'])?>">
                    <fieldset class="fildset-style">
                        <legend>Hobby</legend>
                            <table>
                                <tr>    		
                                    <td>
                                        <input class="checkbox-input" type="checkbox" name="hobby_1" 
                                               value="sport" <?php checkedHobby('sport', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_1">Sport</label>
                                    </td>    
                                    <td>
                                        <input class="checkbox-input" type="checkbox"  name="hobby_2" 
                                               value="musica" <?php checkedHobby('musica', $hobby)?>>  
                                        <label class="checkbox-label" for="hobby_2">Musica</label>
                                    </td>       
                                    <td> 
                                        <input class="checkbox-input" type="checkbox"  name="hobby_3" 
                                               value="arte" <?php checkedHobby('arte', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_3">Arte</label>
                                    </td>
                                </tr>
                                <tr>    		
                                    <td>
                                        <input class="checkbox-input" type="checkbox"  name="hobby_4" 
                                               value="tecnologia"<?php checkedHobby('tecnologia', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_4">Tecnologia</label>
                                    </td>    
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_5" 
                                               value="film e serie tv" <?php checkedHobby('film e serie tv', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_5">
                                            Film e serie TV</label>
                                    </td>       
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_6" 
                                               value="fotografia" <?php checkedHobby('fotografia', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_6">Fotografia</label>
                                    </td>
                                </tr>
                                <tr>    		
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_7" 
                                               value="moda e design" <?php checkedHobby('moda e design', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_7">Moda e design</label>
                                    </td>    
                                    <td>       
                                        <input class="checkbox-input" type="checkbox"  name="hobby_8" 
                                               value="videogames" <?php checkedHobby('videogames', $hobby)?>>
                                        <label class="checkbox-label" for="hobby_8">Videogames</label>
                                    </td>       
                                    <td>
                                        <input  class="checkbox-input" type="checkbox"  name="hobby_9" 
                                                value="viaggiare" <?php checkedHobby('viaggiare', $hobby)?>>
                                        <label class="checkbox-label"  for="hobby_9">Viaggiare</label>
                                    </td>
                                </tr>
                            </table>	
                        <input class="login-registrazione-input" type="text" name="hobby_10" 
                               maxlength="20" placeholder="Hobby aggiuntivo" 
                               value="<?php printName(hobbyAggiuntivo($hobby)) ?>">
                    </fieldset>
                    <input class="login-registrazione-submit" type="submit" value="Salva le modifiche">
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>
        
        <!-- ============== FORM DI MODIFICA IMMAGINE PROFILO ===================-->
         <div id="modifica-immagine-profilo" class="modal" onclick="closeModal('modifica-immagine-profilo','post-container')">
            <div id="cinguettio-container">
                <h1 class="modal-titolo" style="margin-left:58.86px;"> Cambia immagine profilo </h1>
                <span style="margin-left:20px;" onclick="hideModal('modifica-immagine-profilo','post-container')" 
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/modificaFotProfVal.php" method="POST" enctype="multipart/form-data">
                    <input name='file' class="login-registrazione-input" type="file" required>
                    <input class="login-registrazione-submit" type="submit" value="Salva le modifiche">
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
        </div>
        
 <!-- ==================== SEZIONE DEI POST ==========================-->
             <?php
             
             /* Questa sezione contiene gli script per la stampa dei post */
             
             // creo la query per sa sapere se l'utente è 
             $utente_esperto = $info_utente['utente_esperto'];
             
             //creo la query per l'elenco dei post
             $sql = queryPostListProfilo();
             
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
       
       <!----------------------------- errore luogo già indicato come preferito  ------------------------------------->
       <div id="luogo-errore" class="modal" onclick="closeModal('luogo-errore','post-container')">
            <div id="cinguettio-container" style="padding:20px; display:table; text-align:left; height: 0px;">
                <h1  style="font-family: Helvetica; color: #DC2C46; margin:0 10px;">
                    Hai già indicato il luogo come preferito </h1>
            </div>
        </div>   
       
    </body>
</html>