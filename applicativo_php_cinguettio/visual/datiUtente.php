<?php

require_once '../config/config.php';
require_once '../function/funComuni.php';
require_once '../function/funCheckInput.php';
require_once '../function/funError.php';
require_once '../query/queryModificaProfilo.php';

//avvio la sessione
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

$utente = $_GET['email_utente']; 

//query
$num_seguaci = "SELECT count(*) as conteggio FROM seguaci_seguiti WHERE utente_seguito = '{$utente}' "
. " AND richiesta_accettata = TRUE";
$num_seguiti = "SELECT count(*) as conteggio FROM seguaci_seguiti WHERE utente_seguace = '{$utente}' "
. " AND richiesta_accettata =TRUE ";
$info_utente_sql = "SELECT * FROM info_utente NATURAL JOIN utente WHERE email_utente ='{$utente}' ";
$hobby_utente_sql = "SELECT tipo_hobby FROM hobby WHERE email_utente ='{$utente}' ";
$img_profilo_sql = "SELECT path_img_profilo FROM utente WHERE email_utente ='{$utente}' ";

// query per il luogo 
$utente_luogo = "SELECT * FROM (luogo_preferito JOIN cinguettio "
                      . "ON luogo_preferito.id_cinguettio = cinguettio.id_cinguettio AND luogo_preferito.utente_luogo=cinguettio.email_utente) "
                      . " JOIN utente ON utente.email_utente = luogo_preferito.utente_luogo WHERE luogo_preferito.email_utente = '{$utente}'";

//informazioni del utente                      
$info_utente = mysqli_query($conn, $info_utente_sql);
$result_info_utente = mysqli_fetch_assoc($info_utente);
$info_utente_esperto = $result_info_utente['utente_esperto'];

?>


<!DOCTYPE html>
<html lang="it">
    
    <?php printHead() ?>
    
    <!-- stampa dell'head -->
    <body>
        <!-- ==================== HEADER  ================================ -->
        <header id="header-barra">
            <img id="header-logo-bandiera" src="../img/icone/logo_bandiera.jpg">
            <h1 id="header-logo-scritta"> Dati utente seguito </h1>
            <a class="header-link" href="bacheca.php" > Home </a>
            <a class="header-link" href="profilo.php" > Profilo </a>
            <button class="header-registrazione-bottone" 
	onclick="showModal('info-utente','post-container')"> Info utente </button>
        </header>
        <div class="clear-float-left"></div>
        
        <!-- ==================== SEZIONE ASIDE  =======================-->
        <aside id="aside"> 
            <div class="profilo-img-container<?php echo ($info_utente_esperto == true)? ' profilo-esperto' : '' ?>">
        <?php 
            $result = mysqli_query($conn, $img_profilo_sql);
            $img_profilo =  mysqli_fetch_assoc($result);
            $img_profilo['path_img_profilo'] = "../" . $img_profilo['path_img_profilo'];
        ?>
                <img class="img-profilo-dim" src="<?php echo $img_profilo['path_img_profilo'] ?>" alt="Immagine del profilo"/>
                <div class="aside-testo"><?php echo $result_info_utente['nickname']; ?></div> 
            </div>
            <div class="numero-seguaci"> Seguaci
                   <span class="valore-numero">
        <?php
            $utenti_seguaci = mysqli_query($conn, $num_seguaci);
            $utenti_seguaci = mysqli_fetch_assoc($utenti_seguaci);
            echo $utenti_seguaci['conteggio'];
        ?>
                   </span>
            </div>
            <div class="numero-seguiti"> Seguiti
                   <span class="valore-numero">   	
        <?php
            $utenti_seguiti = mysqli_query($conn, $num_seguiti);
            $utenti_seguiti = mysqli_fetch_assoc($utenti_seguiti);
            echo $utenti_seguiti['conteggio'];
        ?>
                   </span>
            </div> 	
        </aside>
        
        <!-- ================= FORM MODALE INFO UTENTE  =======================-->  
        
        <div id="info-utente" class="modal" onclick="closeModal('info-utente','post-container');">
            <div id="login-registrazione-container" style="margin-top: 50px;">
                <h1 class="modal-titolo" style="margin-left:81.11px;"> Informazioni dell'utente </h1>
                <span style="margin-left:30px;" onclick="hideModal('info-utente','post-container')" 
                      class="close" title="Close Modal">×</span>
                    <legend style="margin: 20px 0 -20px 0"> Email </legend>
                    <input  class="login-registrazione-input" type="email" value="<?php echo $result_info_utente['email_utente'] ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Nickname </legend>
                    <input  class="login-registrazione-input" type="text" value="<?php echo $result_info_utente['nickname']; ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Nome </legend>
                    <input  class="login-registrazione-input" type="text" value="<?php echo ucfirst ($result_info_utente['nome']); ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Cognome </legend>
                    <input  class="login-registrazione-input" type="text" value="<?php echo ucfirst ($result_info_utente['cognome']); ?>"  readonly>
                    <legend style="margin: 20px 0 -20px 0"> Sesso </legend>
                    <input  class="login-registrazione-input" type="text"  value="<?php echo printSex($result_info_utente['sesso']); ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Data di nascita </legend>
                    <input  class="login-registrazione-input" type="text" value="<?php echo printData($result_info_utente['data_nascita'], 'd/m/Y');?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Nazione di nascita </legend>
                    <input class="login-registrazione-input" type="text" value="<?php echo ucfirst($result_info_utente['nazione_nascita']); ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Regione di nascita </legend>
                    <input class="login-registrazione-input"  type="text" value="<?php echo ucfirst($result_info_utente['regione_nascita']); ?>" readonly>
                    <legend style="margin: 20px 0 -20px 0"> Citta residenza </legend>               
                    <input  class="login-registrazione-input" type="text" value="<?php echo ucfirst($result_info_utente['citta_residenza']); ?>" readonly>
                    <fieldset class="fildset-style">
                        <legend>Hobby</legend>
                        <ul>
                        <?php 
                            $hobby = mysqli_query($conn, $hobby_utente_sql);
                            if (mysqli_num_rows($hobby) > 0) {
                                while($row = mysqli_fetch_assoc($hobby)) {
                                echo  "<li> {$row['tipo_hobby']} </li>";
                                }
                            }
                        ?>
                        </ul>
                    </fieldset>                    
            </div>
        </div>
        
        <!-- ==================== SEZIONE DEI LUOGHI PREFERITI =================-->
                 
            <?php

                $result = mysqli_query($conn, $utente_luogo);

                if (mysqli_num_rows($result) > 0) {
                    echo '<div id="post-container">';
                    while($row = mysqli_fetch_assoc($result)){
                        $utente1 = $row['utente_luogo'];

                        $utente_lat_long = "SELECT * FROM luogo JOIN luogo_preferito ON luogo_preferito.utente_luogo= luogo.email_utente and luogo_preferito.id_cinguettio = luogo.id_cinguettio 
                                                    WHERE luogo_preferito.utente_luogo = '{$utente1}'
                                                    and luogo.id_cinguettio = '{$row['id_cinguettio']}'";
                        $result01 = mysqli_query($conn, $utente_lat_long);

                        if (mysqli_num_rows($result01) > 0){

                            $row1 = mysqli_fetch_assoc($result01);

                            // utente esperto // 
                            if  ($row['utente_esperto'] == true ){ 
                                $lat = decimalToGMS($row1['latitudine'], 'lat');
                                $lng = decimalToGMS($row1['longitudine'], 'lng');

                                echo "<div class='post-luogo-container'>
                                <div class='post-profilo-container utente-esperto'> 
                                <img class='post-profilo-img' src=" . "'../" . $row['path_img_profilo'] . "'" ."alt=''/>
                                <div class='tooltip-esperto'>"; 
                                echo '<a href="ricercaUtente.php?email_nickname='  . $row['email_utente'] .  '">'
                                 . '<div class="post-profilo-scritta">' . 
                                 $row['nickname'] . '</div></a>';
                                echo "<span class='tooltip-testo-esperto'> Utente esperto </span> 
                                </div> 
                                <div class='post-profilo-data'> {$row['data_ora_cinguettio']}</div>
                                </div>";
                                echo printLinkMaps($row1['latitudine'], $row1['longitudine']) . 
                                "<h1 class='post-luogo-latitudine-longitudine'> Latitudine  {$lat} </h1>
                                <h1 class='post-luogo-latitudine-longitudine'> Longitudine  {$lng}</h1>
                                </div></a>";
                            }
                            // utente non esperto //    
                            else  {
                                $lat = decimalToGMS($row1['latitudine'], 'lat');
                                $lng = decimalToGMS($row1['longitudine'], 'lng');

                                echo "<div class='post-luogo-container'>
                                <div class='post-profilo-container'>
                                <img class='post-profilo-img' src=" . "'../" . $row['path_img_profilo'] . "'" ."alt=''/>";
                                echo '<a href="ricercaUtente.php?email_nickname='  . $row['email_utente'] .  '">'
                                 . '<div class="post-profilo-scritta">' . 
                                 $row['nickname'] . '</div></a>';
                                echo "<div class='post-profilo-data'> {$row['data_ora_cinguettio']}</div>
                                </div>";
                                echo printLinkMaps($row1['latitudine'], $row1['longitudine']) . 
                                "<h1 class='post-luogo-latitudine-longitudine'> Latitudine  {$lat} </h1>
                                <h1 class='post-luogo-latitudine-longitudine'> Longitudine  {$lng}</h1>
                                </div></a>";
                            }
                        }
                    }
                    echo '</div>';
                }
                // altrimenti stampo un messaggio per indicare l'assenza di luoghi preferiti
                else{
                    echo '<div>';
                    echo '<h1 class="no-post">Non ci sono luoghi preferiti</h1>';
                    echo '</div>';
                }
                
                // chiudo la connessione al database
                mysqli_close($conn);
                
            ?>

    </body>
</html>

