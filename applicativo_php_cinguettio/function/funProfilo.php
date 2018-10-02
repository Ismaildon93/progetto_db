
<?php

/*
 * Questo file contiene funzioni usate per la pagina di profilo:
 * 
 * 1) printAsideEspertoProfilo ->  per la stampa dell'aside dell'utente esperto 
 * 2) printAsideProfilo -> per la stampa dell'aside di un utente non esperto
 * 3) printAsideLinkEsperto -> per la stampa dell'aside di un utente esperto con un link alla pagina di profilo
 * 4) printAsideLink -> per la stampa dell'aside di un utente non esperto con un link alla pagina di profilo
 * 5) checkedHobby -> per segnare gli hobby preferiti dall'utente nella sezione di modifica del profilo 
 * 6) hobbyAggiuntivo -> per l'hobby aggiuntivo inserito dall'utente
 * 
 */

/***************************************************************************************
***************************************************************************************/

/**
 * 1) Questa funzione prende in ingresso un immagine e stampo l'aside del profilo di utente esperto
 * 
 * @param type $img_profilo
 * @return no return
 */
function printAsideEspertoProfilo($img_profilo) {
    
    $img_profilo = '../' . $img_profilo;
    
    echo '<div class="tooltip-esperto">';
    echo '<span class="tooltip-testo-esperto">Utente esperto</span>';
    echo '<div class="profilo-img-container profilo-esperto">' .
            '<img onclick="showModal(' . "'modifica-immagine-profilo','post-container'" . ')"' .
            'class="img-profilo-dim pointer" src="' . $img_profilo .'"' .
            'alt="Immagine del profilo"/>' . 
            '<div class="aside-testo">' . $_SESSION['nickname']  . '</div>' .
            '</div>';
    echo '</div>';
}

/**
 * 2) Questa funzione prende in ingresso un immagine e stampo l'aside del profilo di utente non esperto
 * 
 * @param type $img_profilo
 * @return no return
 */
function printAsideProfilo($img_profilo) {
    
    $img_profilo = '../' . $img_profilo;
    
    echo '<div class="profilo-img-container">' .
            '<img onclick="showModal(' . "'modifica-immagine-profilo','post-container'" . ')"' .
            'class="img-profilo-dim pointer" src="' . $img_profilo .'"' .
            'alt="Immagine del profilo"/>' . 
            '<div class="aside-testo">'  . $_SESSION['nickname']   . '</div>' .
            '</div>';
}

/**
 * 3) Questa funzione prende in ingresso un immagine e stampo l'aside del profilo di utente esperto
 * con il link per il profilo 
 * @param type $img_profilo
 * @return no return
 */
function printAsideLinkEsperto($img_profilo) {
    
    $img_profilo = '../' . $img_profilo;
    
    echo '<div class="tooltip-esperto">';
    echo '<span class="tooltip-testo-esperto">Utente esperto</span>';
    echo '<div class="profilo-img-container profilo-esperto">' .
            '<a href="profilo.php">' .
            '<img class="img-profilo-dim pointer" src="' . $img_profilo .'"' .'alt="Immagine del profilo"/>' . 
            '</a>' .
            '<div class="aside-testo">' . $_SESSION['nickname']  . '</div>' .
            '</div>';
    echo '</div>';
}
/**
 * 4) Questa funzione prende in ingresso un immagine e stampo l'aside del profilo di utente non esperto
 * con il link per per il profilo
 * 
 * @param type $img_profilo
 * @return no return
 */
function printAsideLink($img_profilo) {
    
    $img_profilo = '../' . $img_profilo;
    
    echo '<div class="profilo-img-container">' .
            '<a href="profilo.php">' .
            '<img class="img-profilo-dim pointer" src="' . $img_profilo .'"' .'alt="Immagine del profilo"/>' . 
            '</a>' .
            '<div class="aside-testo">'  . $_SESSION['nickname']   . '</div>' .
            '</div>';
    
}

/**
 * 5) Questa funzione prende in ingresso un stringa e un riferimento ad un array che contiene gli hobby inseriti dall'utente 
 * hobby e verifica se l'hobby è presente tra gli hobby inseriti  dall'utente se è presente stampa l'elemento
 * altrimenti stampa una stringa vuota
 * 
 * @param string $str
 * @param array $hobby
 * 
 */
function checkedHobby($str, &$hobby){
    
    if(!empty($hobby)){
        echo in_array($str, $hobby)? 'checked' : '';
    }
    
    echo '';
}

/**
 * 6)  un riferimento ad un array  un che contiene gli hobby inseriti dall'utente 
 * hobby e verifica se è stato inserito un hobby aggiuntivo in caso affermativo restituisce l'hobby aggiuntivo
 * 
 * @param string $str
 * @param array $hobby
 * 
 */
function hobbyAggiuntivo(&$hobby){
    
    $hobby_riferimento = array('sport', 'musica' , 'arte', 'tecnologia', 'film e serie tv', 
                                          'fotografia','videogames' ,'moda e design', 'viaggiare');
    
    if(empty($hobby)){
        return '';
    }
    
    
    for ($index = 0; $index < count($hobby); $index++) {
        if(!in_array($hobby[$index], $hobby_riferimento)){
            return $hobby[$index];
        }
    }    
}

