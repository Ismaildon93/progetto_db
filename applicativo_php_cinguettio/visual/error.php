<?php

    // includo i file delle funzioni
    require_once '../config/config.php';
    require_once '../function/funComuni.php';
    require_once '../function/funError.php';
    
    // avvio la sessione
    session_start();
    
    
?> 

<!-- INIZIO CONTENUTO PRINCIPALE-->
<!DOCTYPE html>
<html lang="it">
        
    <!-- stampa dell'head -->
    <?php printHead() ?>
    
    <body>
        <header id="header-barra">
                <img id="header-logo-bandiera" src="../img/icone/logo_bandiera.jpg">
                <h1 id="header-logo-scritta">inguettio</h1>
        </header>
        <div class="clear-float-left"></div>
        <p class="msg-errore">
            <?php
               // Se $_GET non è settata restituisco un mesaggio di errore generico 
               // altrimenti restituisco un messaggio di errore specifico
                if(empty($_GET) || empty($_GET['error'])){
                     if(!sessionControll()){
                        printError(FAIL_SESSION);
                    }
                    else{
                        printError(ERROR);
                    }
                }
                else {
                    // memorizzo il codice dell'errore ed eseguo 
                    $codiceErrore = htmlspecialchars($_GET['error']);
                    // stampo il messaggio di errore e un link per tornare alla pagina iniziale
                    printError($codiceErrore);
                }
                ?>
        </p>
            
        
    </body>
</html>
    