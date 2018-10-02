<?php

    // inclusione dei file contenenti funzioni e query
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    
    // avvio la sessione
    session_start();
    
    // se la sessione non è settata redirigo l'utente verso la pagina error.php
    if(!sessionControll()){
        redirectError(FAIL_SESSION);
    }
    
?>

<!-- INIZIO CONTENUTO PRINCIPALE-->
<!DOCTYPE html>
<html lang="it">
        
    <!-- stampa dell'head -->
    <?php printHead() ?>
    
    <body>
        
        <!-- ==================== HEADER  ================================ -->
        
        <header id="header-barra">
            <img id="header-logo-bandiera" src="../img/icone/logo_bandiera.jpg">
            <h1 id="header-logo-scritta"> inguettio </h1>
            <a class="header-link" href="../validazione/logoutVal.php" > Logout </a>
            <a class="header-link" href="profilo.php" > Profilo </a>
            <a class="header-link" href="bacheca.php"> Home </a>
        </header>

        <div class="clear-float-left"></div>

        <!-- ============ FORM COMPLETAMENTO PROFILO ========================= -->

        
        <div id="login-registrazione-container" style="margin-top: 30px;">
            <div><h1 class="titolo"> Completa il tuo profilo </h1></div>
            <form action="../validazione/modificaProfiloVal.php" method="POST">
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
                    <input class="login-registrazione-submit" type="submit" value="Salva le informazioni">
                    <input class="login-registrazione-reset" type="reset" value="Reset">
            </form>
        </div>
        
        <!-- ====================FINE FORM COMPLETAMENTO PROFILO ============= -->
        
    </body>
</html>
