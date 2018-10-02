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

?>

<!DOCTYPE html>
<html lang="it">
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
        
        <aside id="aside"> 
            <?php 
        
            /* Questa sezione contiene gli script per la stampa dell'aside e della form modale per la modifica  
            *  delle info utente 
            */ 
 
            // creo la query per l'estrazione delle informazioni dell'utente e del numero di utenti seguiti e 
            // di seguaci e del numero di luoghi preferiti
            $sql_info_utente = queryInfoUtente ();
            $sql_richieste = queryRichieste();
            $sql_utenti_seguaci = querySeguaci();
            $sql_utenti_seguiti = querySeguiti();
            
            // effettuo le interrogazioni per gli utenti
            $result_info_utente =  mysqli_query($conn, $sql_info_utente);

            // effettuo le interrogazioni per stampare i links alle pagine
            $result_richieste = mysqli_query($conn, $sql_richieste);
            $result_utenti_seguaci = mysqli_query($conn, $sql_utenti_seguaci);
            $result_utenti_seguiti = mysqli_query($conn, $sql_utenti_seguiti);
            
            //estraggo il numero di richieste di essere seguito che ha ricevuto l'utente 
            $richieste = mysqli_fetch_assoc($result_richieste);
             
            // stampo il link per le richieste con il numero di richieste
            echo '<a href="richieste.php" class="link-aside"> Richieste'; 
            echo '<span class="link-numero">' . $richieste['num_richieste'] .  '</span></a>';
           
             //estraggo le informazioni dell'utente loggato in sessione
            $info_utente = mysqli_fetch_assoc($result_info_utente);
            
            // verifica se l'utente è esperto in caso lo sia stampa l'aside per l'utente esperto
            if($info_utente['utente_esperto' ] == TRUE){ 
                printAsideLinkEsperto($info_utente['path_img_profilo']);
            }else{
                printAsideLink($info_utente['path_img_profilo']);
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
            
            
            // stampo il link per la pagina dei luoghi preferiti con il numero di luoghi preferiti dall'utente
            echo '<a href="luogoPreferito.php" class="link-aside-luogo-preferito"> Luoghi Preferiti'; 
            echo '<a>';          
        ?>  
        </aside>
           <!-- STAMPA DEI LUOGHI PREFERITI --> 
          <div id="post-container">
          <?php
                 // query per il luogo 
                $utente = $_SESSION['email_utente'];
                $utente_luogo = "SELECT * FROM (luogo_preferito JOIN cinguettio ON "
                . "luogo_preferito.id_cinguettio = cinguettio.id_cinguettio AND "
                . "luogo_preferito.utente_luogo=cinguettio.email_utente) JOIN utente "
                . "ON utente.email_utente = luogo_preferito.utente_luogo "
                . "WHERE luogo_preferito.email_utente = '{$utente}'";

                $result = mysqli_query($conn, $utente_luogo);

                if (mysqli_num_rows($result) > 0) {

                    while($row = mysqli_fetch_assoc($result)){

                        $utente1 = $row['utente_luogo'];

                        $utente_lat_long = "SELECT * FROM luogo JOIN luogo_preferito " .
                                "ON luogo_preferito.utente_luogo= luogo.email_utente AND " . 
                                                "luogo_preferito.id_cinguettio = luogo.id_cinguettio " . 
                                                "WHERE luogo_preferito.utente_luogo = '{$utente1}' " .
                                                "AND luogo.id_cinguettio = '{$row['id_cinguettio']}'";
                        $result01 = mysqli_query($conn, $utente_lat_long);

                        if (mysqli_num_rows($result01) > 0)	{
                            $row1 = mysqli_fetch_assoc($result01);
                            $row['utente_luogo'] = $row1['utente_luogo'];
                            $lat = decimalToGMS($row1['latitudine'], 'lat');
                            $lng = decimalToGMS($row1['longitudine'], 'lng');
                            
                            echo '<div class="post-foto-container">';
                            // stampo l'header dei post
                            printHeaderPost($row);

                            //stampo la latitudine e la longitudine e aggiungo un riferimento a google maps per vedere la 
                            //mappa
                            echo printLinkMaps($row1['latitudine'], $row1['longitudine']);
                            echo '<h1 class="post-luogo-latitudine-longitudine">'; 
                            echo 'Latitudine ' . $lat . '</h1>';
                            echo '<h1 class="post-luogo-latitudine-longitudine">';
                            echo 'Longitudine ' . $lng . '</h1>';
                            echo '</a></div>';
                            
                        }
                    }
                }
                else{
                    echo '<div>';
                    echo '<h1 class="no-post">Non hai luoghi preferiti </h1>';
                    echo '</div>';
                }
                
                // chiudo la connessione al database
                mysqli_close($conn);
                
           ?>
         </div>     
     </body>
</html>
