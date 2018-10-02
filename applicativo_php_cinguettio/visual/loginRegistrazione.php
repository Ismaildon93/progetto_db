<?php

    // inclusione dei file contenenti funzioni
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    
    // avvio la sessione
    session_start();
    
    // se esiste già una sessione redirigo l'utente in bacheca.php
    if(sessionControll()){
        redirect('bacheca.php');
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
            <h1 id="header-logo-scritta">inguettio</h1>
            <button class="header-registrazione-bottone" 
	onclick="showModal('registrati-modal','login-registrazione-container')"> Registrati </button>
        </header>
        <div class="clear-float-left"></div>
        
        <!-- ====================  FORM DI LOGIN ============================-->
        
        <div id="login-registrazione-container"> 
            <h1 class="titolo">Effettua il login</h1>
            <form action="../validazione/loginVal.php" method="POST">
                <input name="email_utente" class="login-registrazione-input" type="email" 
                       placeholder="Email" required maxlength="70">
                <input name="password" class="login-registrazione-input" type="password" 
                       placeholder="Password" required maxlength="50">
                <input class="login-registrazione-submit" type="submit" value="Login">
                <input class="login-registrazione-reset" type="reset" value="Reset" >
            </form>
       </div>

        <!-- ====================  FORM DI REGISTRAZIONE MODALE ===============--> 
        
         <div id="registrati-modal" class="modal" onclick="closeModal ('registrati-modal','login-registrazione-container');">
            <div id="login-registrazione-container"> 
                <h1 class="modal-titolo" style="margin-left: 93.74px">Iscriviti a cinguettio</h1>
                <span style="margin-left:75px;" onclick="hideModal('registrati-modal','login-registrazione-container')"
                      class="close" title="Close Modal">×</span>
                <form action="../validazione/registrazioneVal.php" method="POST">
                    <input name="email_utente" class="login-registrazione-input" type="email" 
                           placeholder="Email" required maxlength="70">
                    <input name="nickname" class="login-registrazione-input" type="text" 
                           placeholder="Nickname" required maxlength="20">
                    <input name="password" class="login-registrazione-input" type="password" 
                           placeholder="Password" required maxlength="50">
                    <input name="password_conferma" class="login-registrazione-input" type="password" 
                           placeholder="Ripeti nuovamente la password" required maxlength="50">
                    <input class="login-registrazione-submit" type="submit" value="Registrati">
                    <input class="login-registrazione-reset" type="reset" value="Reset">
                </form>
            </div>
         </div>
        
            
        <!-- ================== FINE MODALE ================================-->
        
    </body>
</html>
