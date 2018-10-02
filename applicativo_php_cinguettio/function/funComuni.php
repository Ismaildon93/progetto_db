<?php

/*
 * Questo file contiene funzioni di uso comune quali:
 * 
 * 1) dbConnection ->  per la connessione al database
 * 2) printHead  ->  per la stampa dell'Head
 * 3) sessionControll -> per il controllo della sessione 
 * 4) redirect -> per la redirezione dell'utente in una pagina del sito
 * 5) correctMethodInput -> che verifica l'effettivo e corretto invio dei dati secondo un metodo
 * 6) cleanInput -> per la pulizia dell' input
 * 7) prepareInputToQuery -> prepara la stringa prima di essere inserita nella query
 * 8) createData -> per la creazione di un data da inserire nel database
 * 9) checkDataNascita -> controlla se la data sia minore o maggiore della data corrente
 * 10) printData -> stampa la data in un formato scelto
 * 11) deleteRepeatedHobby -> elimina eventuali hobby ripetuti
 * 12) GMStoDecimal -> converte una coordinata espressa in GMS(gradi minuti e secondi) in decimali
 * 13) decimalToGMS -> converte una coordinata espressa in decimali in GMS(gradi minuti e secondi)
 * 14) printSex -> per la stampa del sesso di un utente
 * 15) printLinkMaps -> per la stampa dei link a google maps
 */

/***************************************************************************************
***************************************************************************************/

/**
 * 1) Questa funzione esegue la connessione al database.
 * Nel caso la connessione vada a buon fine viene restistuita la connessione
 * altrimenti viene restituito false.
 * 
 * @param no parameters 
 * @return mixed Object/boolean 
 *  
 */
function dbConnection ()    {

    // Creazione della connessione 
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // gestione dell'errore nel caso di connessione fallita
    if($conn == false){
        return false;
    } else { 
        return $conn;
    }    
}    

/**
 * 2) Questa funzione stampa il codice html dell'head presente in tutte le pagine 
 * php. L'head contiene:
 *  - Il tipo di charset usato nella pagina
 *  - Il titolo 
 *  - Il link al css
 *  - Il link al file javascript
 *  
 * @param no parameters
 * @return no return 
 */
function printHead () {
    echo '
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css?'; echo time(); echo '">
        <title>Cinguettio</title>
        <script src="../javascript/modalFunction.js" charset="UTF-8"></script>       
    </head>
    ';
}   

/**
 * 3) Questa funzione controlla se la sessione è settata. In caso poitivo restituisce true  
 * altrimenti restituisce false
 * 
 * @param no parameters
 * @return boolean  true/false
 */
function sessionControll() {
    
    if (isset($_SESSION['email_utente']) && isset($_SESSION['nickname'])){
        return true;
    } 
    else { return false;}
}

/**
 * 4) Questa funzione prende in ingresso una una pagina e redirige l'utente verso quella pagina  
 * 
 * @param string $page una pagina del sito  
 * @return no return
 */
function redirect ($page){
    
    $page = "Location: ../visual/" . $page;
    header($page);
    exit(); // ci assicura che non venga eseguito nulla dopo il reindirizzamento
}

/**
 * 5) Questa funzione prende in ingresso un stringa che rappresenta un metodo per l'invio dei dati 
 * (POST, GET ...) e verifica che il corretto metodo che ci si aspetta venga usato per l'accesso alla pagina 
 * corrisponda al metodo effetivamente utilizzato.  
 * In caso positivo resituisce true altrimenti false      
 * 
 * @param string $correctMet 'POST' || 'GET' || 'HEAD' || 'PUT'(*indica il metodo previsto di invio dei dat)
 * @return boolean 
 *  
 */
function correctMethodInput ($correctMet){
    
    // metodo utilizzato per accedere alla pagina 
    $usedMet = strtoupper($_SERVER['REQUEST_METHOD']);
    
    
    if($usedMet == strtoupper($correctMet) ){
        return true;
    }
    
    return false;
}

/**
 * 6) Questa funzione prende in ingresso un array associativo e ripulisce tutti i campi da eventuali 
 * caratteri pericolosi e codifica in modo appropriato i vari campi
 * 
 * @param array $input  
 * @return array $ar  
 */
function cleanInput ($input) {
    
    foreach ($input as $key => $value) {
        
        // pulizia dei caratteri se si tratta di una password o di un nickname 
        if($key == 'password' || $key == 'nickname'){
            // effettua il trim e codifica i caratteri speciali
            $cleanValue = trim(htmlspecialchars($value, ENT_NOQUOTES));
            // rimuove spazi aggiuntivi tra le parole
            $input[$key] = preg_replace('/\s\s+/', ' ', $cleanValue); 
        }
        
        // pulizia dei caratteri nel caso di un commento a una foto, della descrizione di una foto 
        // o nel caso di un messaggio di testo
        elseif ($key == 'commento' || $key == 'descrizione_foto' || $key == 'messaggio' ) {
            $cleanValue = htmlspecialchars($value, ENT_QUOTES);
            $input[$key] = trim(preg_replace('/\s\s+/', ' ', $value)); // rimuove spazi aggiuntivi tra le parole
        }
        
        // pulizia dei caratteri in tutti gli altri casi
        else {
            // effettua il trim e codifica i caratteri speciali
            $cleanValue = trim(htmlspecialchars($value, ENT_NOQUOTES), BANNED_CHARS);
            // rimuove spazi aggiuntivi tra le parole e trasforma tutti i caratteri in minuscoli
            $input[$key] = strtolower(preg_replace('/\s\s+/', ' ', $cleanValue)); 
        }
        
    }
    
    return $input;
}

/**
 * 7) Questa funzione prende in ingresso un array associativo e una connessione al database e 
 * prepara l'input inserito dall'utente prima del creazione della query 
 * convertendo alcuni caratteri che potrebbero portare al fallimento della query stessa.
 * 
 * @param array $input l'input inserito dall'utente
 * @param mysqli $conn Description
 * @return ar$
 * 
 *  */
function prepareInputToQuery(&$input, $conn){
    
    if(!empty($input)){
        foreach ($input as $key => $value){

            if(strlen($value) == 0){
                $input[$key] = "NULL";
            }
            else if($key != 'id_cinguettio' && $key != 'latitudine' && $key !='longitudine'){ 
                $input[$key] = "'" . mysqli_real_escape_string($conn, $value) . "'";
            }   

        }
    }    
}

/**
* 8) Questa funzione prende in ingresso un giorno un mese e un anno e crea una data.
* Nel caso in cui uno dei campi fosse impostato restituisce una stringa vuota  
* @param string $day
* @param string $month
* @param string $year
* @return string $data
*  
*/
function createData($day, $month, $year){
    if ($day != null  && $month != null && $year != null){
        $data = $year . '/' . $month . '/' . $day;
        return $data;
    }
    else{
        $data = '';
        return $data;
    }    
}

/**
* 9) Questa funzione prende in ingresso una data di nascita e verifica che tutti i campi della data
 *  che siano a null minore della 
* data corrente in caso positivo restituisce true altrimenti false
* 
* @param string $data_nascita 
* @return boolean   
*/
function checkDataNascita($data_nascita){
    $current_data = date('Y/m/d');
    if($data_nascita > $current_data && $data_nascita != null){
        return false;
    }
    return true;
}

/**
* 10) Queste funzione prende una data e un formato e stampa la data nel formato scelto
* nel formato corretto in ingresso e la stampa nel formato desiderato
* 
* @param string $date rappresenta la data estratta dal database nel formato YYYY-MM-DD
* @param string $format rappresenta il formato della data ad es. 'j/m/Y' o 'j M Y'
* @return no return
* 
*/     
function printData ($date, $format){
    $timestamp = strtotime($date);
    echo date($format, $timestamp);
    
}

/**
 * 11) Questa funzione prende in ingresso un array associatio e verifica che l'hobby 
 * aggiuntivo inserito dall'utente sia diverso dai precedenti hobby in caso negativo lo 
 * elimina
 * 
 * @param $hobby 
 * @return no return 
 */
function deleteRepeatedHobby(&$hobby){
    
    if (!empty ($hobby['hobby_10'])){
        
        $hobby_agg = $hobby['hobby_10']; // hobby aggiuntivo inserito dall'utente
        
        foreach ($hobby as $key => $value){
            
            if( $value == $hobby_agg && $key != 'hobby_10'){
                unset($hobby['hobby_10']);
                break;
            }            
        }
    }
    
}

/**
 * 12) Questa funzione prende in ingresso un coordinata espressa in GMS(gradi minuti e secondi)
 * e la converte in decimali 
 * 
 * @param string $gradi
 * @param string $minuti
 * @param string $secondi
 * @param string $direzione
 * @return float
 */
function GMStoDecimal($gradi, $minuti, $secondi, $direzione){
    
    $decimal = $gradi + ($minuti / 60.0) + ($secondi / 3600.0);
    
    if($direzione == 's' || $direzione == 'w'){
        $decimal *= -1;
    }
    
    return $decimal;
}

/**
 * 13) Questa funzione prende in ingresso una coordinata espressa in decimali
 * e la converte in GMS (gradi minuti secondi)
 * 
 * @param string $coordinata una coordinata geografica espressa in decimali
 * @param string $type il tipo di coordinata 'lat' per la latitudine 'lng' per la longitudine
 * @return string coordinata espressa in GMS(gradi minuti secondi)
 */
function decimalToGMS($coordinata, $type ){
    
    // Verifico se si tratta della latitudine o della longitudine
    if($type == 'lat'){
        if($coordinata >= 0.0 ){
            $ris['direzione'] = 'N';
        }else{
            $ris['direzione'] = 'S';
        }
    }
    else{
        if($coordinata >= 0.0 ){
            $ris['direzione'] = 'E';
        }else{
            $ris['direzione'] = 'W';
        }
    }
    
    // converto la coordinata in float ed elimino il segno
    $coordinata = (float) abs($coordinata);
    
    // estrazione dei gradi
    $ris['gradi'] = (int) $coordinata;
    $coordinata = $coordinata - $ris['gradi'];
    
    // estrazione dei minuti
    $ris['minuti'] = (int) $coordinata = $coordinata * 60.0;
    $coordinata = $coordinata - $ris['minuti']; 
    
    // estrazione dei secondi
    $ris['secondi']= (int) $coordinata = $coordinata * 60.0;
    $coordinata = $coordinata - $ris['secondi'];
    
    
    $ris['secondi'] += round($coordinata);
     
    return ($ris['gradi']  . '° ' . $ris['minuti'] . "' " . $ris['secondi'] . '" ' .  $ris['direzione']);
}

/**
 * 14) Questa funzione stampa il sesso di un utente
 * @param string $sex
 */
function printSex($sex){
    
    if($sex == 'm'){
        echo 'Uomo';
    }else if($sex == 'f'){
        echo 'Donna';
    }else{
        echo '';
    }
}

/**
 * 15) Questa funzione prende in ingresso una latitudine e una longitudine 
 * e stampa un link per google maps
 * @param string $lat 
 * @param string  $lng
 */


function printLinkMaps($lat, $lng){
    
    // coordinate per google maps
   $zoom = '9z';
   $tipo_vista = '/data=!3m1!1e3';
   $lat_lng = $lat . ',' . $lng;
   $marker = '/@' . $lat_lng . ',' . $zoom;
   $googleMapsRef = 'https://www.google.it/maps/place/' . $lat_lng .  $marker  . $tipo_vista;
   $style_a = 'style="text-decoration: none;"';
   
   echo '<a class="maps"' . $style_a . 'href="' . $googleMapsRef . '" target="_blank">';
}

/**
 * 16) Questa funzione prende in ingresso una stringa che rappresenta un nome di persona o luogo 
 * estratto dal database e lo stampa nel formato corretto
 * @param string $name 
 * 
 */
function printName($name){
    
    $name = strtoupper($name);
    
    for($i = 0; $i < strlen($name); $i++){
        if(($name[$i] >= 'A' && $name[$i] <= 'Z') || ($name[$i] >= 'a' && $name[$i] <= 'z')){
            $name[$i] = strtolower($name[$i]);
        }
    }
    
    echo ucfirst($name);
    
}