<?php

/*
 * Questo file contiene la definizione delle costanti 
 * 
 */

/***************************************************************************************
 *                                           COSTANTI PER LA CONESSIONE AL DATABASE 
 ***************************************************************************************/

define('DB_HOST', 'localhost'); // nome dell'host
define('DB_USER',  'root'); // nome dell'utente
define('DB_PASSWORD', ''); // password per l'accesso al database
define('DB_NAME', 'db_cinguettio'); // nome del database

/***************************************************************************************
 *                                           COSTANTI PER LA VALIDAZIONE DELL'INPUT
 ***************************************************************************************/

// definizione della regex per il corretto formato della mail
define('VALID_EMAIL_FORMAT','/^([A-Za-z0-9_\-.]+)@([A-Za-z0-9]+)[.]([A-Za-z]{2,4})$/');
// definizione della regex per il corretto formato della password
define('VALID_PWD_FORMAT','/^([A-Za-z0-9\p{L}\à\è\ù\ò\é\ì_\-!*.]{1,50})$/');
// definizione della regex per il corretto formato del nickname
define('VALID_NICK_FORMAT','/^([A-Za-z0-9\p{L}\à\è\ù\ò\é\ì_\-\'\"\s!*.]{1,20})$/');
// definizione della regex per il corretto formato di nome e cognome 
define('VALID_NAME_FORMAT','/^([A-Za-z\p{L}\à\è\ù\ì\ò\é\'\s]{1,20})$/');
// definizione della regex per il corretto formato di nazione_nascita, regione_nascita, citta_residenza
define('VALID_PLACE_FORMAT','/^([A-Za-z\p{L}\à\è\ù\ì\'\s]{1,50})$/');
// definizione della regex per il corretto formato degli hobby
define('VALID_HOBBY_1_FORMAT','/^sport$/');
define('VALID_HOBBY_2_FORMAT','/^musica$/');
define('VALID_HOBBY_3_FORMAT','/^arte$/');
define('VALID_HOBBY_4_FORMAT','/^tecnologia$/');
define('VALID_HOBBY_5_FORMAT','/^film e serie tv$/');
define('VALID_HOBBY_6_FORMAT','/^fotografia$/');
define('VALID_HOBBY_7_FORMAT','/^moda e design$/');
define('VALID_HOBBY_8_FORMAT','/^videogames$/');
define('VALID_HOBBY_9_FORMAT','/^viaggiare$/');
define('VALID_HOBBY_10_FORMAT','/^([A-Za-z\p{L}\à\è\ù\ò\é\ì\'\s]{1,20})$/');
// definizione della regex per il corretto formato del sesso
define('VALID_SEX_FORMAT','/^[mf]$/');
// definizione della regex per il corretto formato del giorno
define('VALID_DAY_FORMAT','/^0[1-9]$|^[12][0-9]$|^3[01]$|^[1-9]$/');
// definizione della regex per il corretto formato del mese
define('VALID_MONTH_FORMAT','/^0[1-9]$|^[1][012]$|^[1-9]$/');
// definizione della regex per il corretto formato dell'anno
define('VALID_YEAR_FORMAT','/^19[0-9][0-9]$|20[0-1][0-7]$/');
// definizione della regex per il corretto formato dei messaggi di testo e dei commenti alle foto
define('VALID_TEXT_FORMAT','/^(.|[\n]){1,50}$/');
// definizione della regex per il corretto formato della foto
define('VALID_DESCR_FORMAT','/^(.|[\n]){1,20}$/');
// definizione della regex per la latitudine
define('VALID_GRADI_LAT_FORMAT','/^[0-9]$|^[1-8][0-9]$|^90$/');
// definizione della regex per il corretto formato dei gradi per la longitudine
define('VALID_GRADI_LNG_FORMAT','/^[0-9]$|^[1-9][0-9]$|^1[0-7][0-9]$|^180$/');
// definizione della regex per il corretto formato dei minuti e dei secondi per la latitudine e la longitudine
define('VALID_SEC_MIN_FORMAT','/^[0-9]$|^[1-5][0-9]$$/');
// definizione della regex per il corretto formato della direzione della latitudine
define('VALID_DIR_LAT_FORMAT','/^[NSns]$/');
// definizione della regex per il corretto formato della direzione della longitudine
define('VALID_DIR_LNG_FORMAT','/^[EWew]$/');
// definizione della regex per il corretto formato degli interi come ad esempio l'id del cinguettio
define('VALID_INT_FORMAT','/^[0-9]$|^[1-9]\d+$/');
// definizione della regex per il corretto formato della direzione della latitudine
define('VALID_FLOAT_FORMAT','/^([0-9]|[1-9]\d+)[.]([0-9]+)$/');
// definizione della regex per il corretto formato delle foto
define('VALID_FILE_FORMAT','/^(jpeg|jpg|png)$/');
// definizione della costante per la funzione di trim per la pulizia dell'input
define('BANNED_CHARS'," \t\n\r\0\x0B\'\"");

/***************************************************************************************
 *                                  COSTANTI PER LA DEFINIZIONE DELLA RICERCA UTENTE
 ***************************************************************************************/
define('RICERCA_TUTTI_GLI_UTENTI',1);
define('RICERCA_EMAIL_NICK',2);
define('RICERCA_AVANZATA',3);

/***************************************************************************************
 *                                          COSTANTI PER LA DEFINIZIONE DEGLI ERRORI
 ***************************************************************************************/

define('FAIL_SESSION',1); //errore nel caso la sessione sia fallita
define('FAIL_DB_CONN',2); // errore nel caso di fallita connessione al database 
define('FAIL_INPUT',3); // errroe nel caso di input non valido
define('FAIL_LOGIN',4); // errore nel caso di login fallito
define('FAIL_PWD_CONF_REG',5); // errore nel caso di password di conferma non esatta
define('FAIL_REG', 6); // errore nel caso di registrazione fallita
define('FAIL_DATA_NASCITA',7); // errore nel caso in cui la data di nascita sia inesatta
define('FAIL_UPLOAD',8); // errore nel caricamento della foto
define('FAIL_FILE_CORRUPT',9); // errore file corrotto
define('FAIL_LAT',10); // errore valore di latitudine non consentito
define('FAIL_LNG', 11); // errore valore di longitudine non consentito
define('FAIL_INVALID_DATA', 12); // errore per il valore della data di nascita non valido
define('ERROR',0); // errore generico 

