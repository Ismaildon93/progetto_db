/****************************************************************
*
*   Nome progetto: CINGUETTIO
*            File: popolamento_database.sql
*           Scopo: popolamento del database
*       Creato da: Donà Ismail, Urso Francesco
*            Anno: 2017/2018
* 
*   Nome database: db_cinguettio
*       Tipo DBMS: MariaDB
*   Versione DBMS: 10.1.9	
* 	
*      Web server: Apache 2.4.17
* 
* Ultima modifica: Mercoledì 21 Giugno 2017
*
*      
*****************************************************************/

/* seleziono il database */
USE db_cinguettio;

/****************************************************************
*                    POPOLAMENTO DEL DATABASE 
*****************************************************************/

/* inserimento degli utenti */
INSERT INTO utente (email_utente, nickname, password, utente_esperto, data_esperto,
					img_profilo, path_img_profilo)
VALUES 
    ('ismail@gmail.com', 'Iz', '1234', '1','2017-07-15 11:09:09','ismail@gmail.com_596a6e37ea3072.58272375.jpg', 
	'img/utenti/profilo/ismail@gmail.com_596a6e37ea3072.58272375.jpg'),
	('fra@gmail.com', 'IMPERATORE','1234' ,'1','2017-07-15 11:09:01','fra@gmail.com_596a6eb1e5a2f2.54667103.jpg',
	'img/utenti/profilo/fra@gmail.com_596a6eb1e5a2f2.54667103.jpg'),
	('lorenzo@gmail.com', 'lore89', '1234','1','2017-07-15 10:09:18','lorenzo@gmail.com_596a6ee79d3976.89444407.jpg',
	'img/utenti/profilo/lorenzo@gmail.com_596a6ee79d3976.89444407.jpg'),
	('gaia@gmail.com', 'gaGA','1234',DEFAULT,DEFAULT, 'gaia@gmail.com_596a6f4454bab3.45502232.jpg',
	'img/utenti/profilo/gaia@gmail.com_596a6f4454bab3.45502232.jpg'),
	('sissi@gmail.com', 'La boscaiola', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),
	('marcocasto@live.it', 'mark', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),
    ('franca@live.it', 'franz', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),
    ('sall@gmail.it', 'sall', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),
    ('carmen@live.it', 'caki', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),
    ('rossipaolo@libero.it', 'paolor', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT),    
    ('alex@live.it', 'lex', '1234', DEFAULT, DEFAULT, DEFAULT, DEFAULT)  
;

/* aggiornamento delle informazioni personali degli utenti */
UPDATE info_utente
SET nome='lorenzo', cognome='combatti', nazione_nascita ='italia', data_nascita = '1989-02-07'
WHERE email_utente = 'lorenzo@gmail.com';

UPDATE info_utente
SET nome='francesco', cognome='combatti', nazione_nascita ='sicilia', data_nascita = '1993-02-07'
WHERE email_utente = 'fra@gmail.com'; 

UPDATE info_utente
SET nome='sissi', sesso='f',nazione_nascita ='francia', data_nascita = '1989-02-07'
WHERE email_utente = 'sissi@gmail.com';

UPDATE info_utente
SET nome='gaia', cognome='combatti'
WHERE email_utente = 'gaia@gmail.com';

UPDATE info_utente
SET nome='franca', cognome='red', data_nascita='1987-11-02', sesso='f', nazione_nascita='italia', 
	regione_nascita = 'veneto', citta_residenza ='roma'
WHERE email_utente = 'franca@live.it';

UPDATE info_utente
SET nome='salvo', cognome='pollo', data_nascita='1978-11-02', sesso='m', nazione_nascita='italia', 
	regione_nascita = 'sicilia', citta_residenza ='milano'
WHERE email_utente = 'sall@gmail.it';

UPDATE info_utente
SET nome='carmen', cognome='los santos', data_nascita='1993-01-01', nazione_nascita='spagna', 
	citta_residenza ='roma'
WHERE email_utente = 'carmen@live.it';

UPDATE info_utente
SET nome='paolo', cognome='rossi', data_nascita='2000-01-01', sesso='m', nazione_nascita='italia', 
	regione_nascita = 'veneto', citta_residenza ='torino'
WHERE email_utente = 'rossipaolo@libero.it';

UPDATE info_utente
SET nome='alessia', cognome='ripoli', data_nascita='1993-01-01', sesso='f', nazione_nascita='italia', 
	regione_nascita = 'veneto', citta_residenza ='torino'
WHERE email_utente = 'alex@live.it';

/* inserimento delgi hobby */
INSERT INTO hobby (email_utente, tipo_hobby)
VALUES
	('lorenzo@gmail.com', 'film e serie tv'),
	('lorenzo@gmail.com', 'musica'),
	('lorenzo@gmail.com', 'pescare'),
	('lorenzo@gmail.com', 'tecnologia'),	
	('gaia@gmail.com', 'fotografia'),
	('sissi@gmail.com', 'musica'),
	('sissi@gmail.com', 'arte'),
	('sissi@gmail.com', 'tecnologia'),
	('fra@gmail.com', 'fotografia'),
	('alex@live.it', 'sport'),
	('alex@live.it', 'videogames'),
	('alex@live.it', 'arte'),
	('alex@live.it', 'film e serie tv'),
	('rossipaolo@libero.it', 'fotgrafia'),
	('rossipaolo@libero.it', 'moda e design'),
	('carmen@live.it', 'tecnologia'),
	('sall@gmail.it', 'pescare')
;		

/* inserimento dei cinguetii di tipo testo */
INSERT INTO testo (email_utente, id_cinguettio, messaggio, 
				  inappropriato, oscurato)
VALUES
	('lorenzo@gmail.com', DEFAULT, 'Vi odio tutti', DEFAULT, DEFAULT),
	('ismail@gmail.com', DEFAULT, 'I kasabian sono dei grandi', DEFAULT, DEFAULT),
	('sissi@gmail.com', DEFAULT, 'BuoNgiorno caffe1!1!', DEFAULT, DEFAULT),
	('fra@gmail.com', DEFAULT, 'ciao Mondo', DEFAULT, DEFAULT),
	('gaia@gmail.com', DEFAULT, 'Ho finito di studiare', DEFAULT, DEFAULT)
;

/* inserimento dei cinguetii di tipo luogo */
INSERT INTO luogo (email_utente, id_cinguettio, latitudine, longitudine)
VALUES
	('lorenzo@gmail.com', DEFAULT, -5.101944, -14.168611),
    ('ismail@gmail.com', DEFAULT, 56.235832, 10.070833),
	('fra@gmail.com', 'Milano Regna', 45.477222, 9.181389),
	('gaia@gmail.com', DEFAULT, -78.000000, 10.237222)
;

/* inserimento dei cinguettii di tipo foto */
INSERT INTO foto (email_utente, id_cinguettio, nome_foto, path_foto, 
				  descrizione_foto)
VALUES
	('fra@gmail.com', DEFAULT, '596a7df7ab5878.84853378.jpg',
	'../img/utenti/upload/fra@gmail.com/596a7df7ab5878.84853378.jpg','Il divino')
;

/* aggiorno le informazion relative alla data e all'orario dei cinguettii per avere orari diversi */
UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-17 07:13:18'
WHERE email_utente ='fra@gmail.com' AND id_cinguettio = 1;

UPDATE cinguettio
SET data_ora_cinguettio ='2016-07-17 18:10:18'
WHERE email_utente ='fra@gmail.com' AND id_cinguettio = 2;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-18 04:00:18'
WHERE email_utente ='gaia@gmail.com' AND id_cinguettio = 1;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-19 05:11:17'
WHERE email_utente ='gaia@gmail.com' AND id_cinguettio = 2;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-19 15:18:18'
WHERE email_utente ='ismail@gmail.com' AND id_cinguettio = 1;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-17 05:21:18'
WHERE email_utente ='ismail@gmail.com' AND id_cinguettio = 2;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-18 10:12:18'
WHERE email_utente ='lorenzo@gmail.com' AND id_cinguettio = 1;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-19 11:12:18'
WHERE email_utente ='lorenzo@gmail.com' AND id_cinguettio = 2;

UPDATE cinguettio
SET data_ora_cinguettio ='2017-07-19 06:13:18'
WHERE email_utente ='sissi@gmail.com' AND id_cinguettio = 1;

/* inserimento degli utenti segauci e seguiti*/ 
INSERT INTO seguaci_seguiti (utente_seguace, utente_seguito, data_ora_richiesta,richiesta_accettata,
							 data_ora_risposta) 
VALUES 
('fra@gmail.com', 'lorenzo@gmail.com', '2017-07-10 05:12:18', '1', '2017-07-13 06:09:15'),
('fra@gmail.com', 'gaia@gmail.com', '2017-07-09 18:12:18', '1', '2017-07-12 08:02:17'),
('fra@gmail.com', 'ismail@gmail.com', '2017-07-08 22:11:18', '1', '2017-07-11 13:09:15'),
('ismail@gmail.com', 'lorenzo@gmail.com', '2017-07-09 13:13:22', '1', '2017-07-13 18:09:11'),
('ismail@gmail.com', 'sissi@gmail.com', '2017-07-10 11:12:15', '1', '2017-07-14 00:09:10'),
('ismail@gmail.com', 'fra@gmail.com', '2017-07-08 16:12:17', '1', '2017-07-15 06:10:17'),
('ismail@gmail.com', 'gaia@gmail.com', '2017-07-09 05:10:18', '1','2017-07-15 01:09:14'),
('lorenzo@gmail.com', 'ismail@gmail.com','2017-07-08 23:17:18','1', '2017-07-15 08:09:11'),
('lorenzo@gmail.com', 'sissi@gmail.com','2017-07-09 06:09:18','1','2017-07-15 03:09:10'),
('lorenzo@gmail.com', 'fra@gmail.com','2016-07-10 02:18:18','1', '2017-07-15 08:19:11'),
('sissi@gmail.com', 'lorenzo@gmail.com', '2017-07-10 01:17:18', '1','2017-07-15 10:09:18'),
('sissi@gmail.com', 'ismail@gmail.com', '2017-07-09 04:17:18', '1','2017-07-15 11:09:09'),
('sissi@gmail.com', 'fra@gmail.com', '2017-07-07 18:15:18', '1', '2017-07-15 13:09:02'),
('gaia@gmail.com', 'fra@gmail.com', '2017-07-07 07:00:18', '1', '2017-07-15 11:09:01'),
('rossipaolo@libero.it', 'ismail@gmail.com', CURRENT_TIMESTAMP, '0', NULL),
('carmen@live.it', 'ismail@gmail.com', CURRENT_TIMESTAMP, '0', NULL),
('alex@live.it', 'ismail@gmail.com', CURRENT_TIMESTAMP, '0', NULL)
;

/* inserimento dei cinguetii segnalati*/
INSERT INTO segnala_testo (email_utente, utente_segnalato, id_cinguettio) 
VALUES 
('fra@gmail.com', 'sissi@gmail.com', '1'),
('lorenzo@gmail.com', 'sissi@gmail.com', '1'),
('gaia@gmail.com', 'sissi@gmail.com', '1')
;	

/* inserimento dei commenti alle foto pubblicate dagli utenti */
INSERT INTO 
giudizio_foto (email_utente, utente_giudicato, 
			   id_cinguettio, data_ora_commento, commento) 
VALUES ('lorenzo@gmail.com', 'fra@gmail.com', '3', CURRENT_TIMESTAMP, 'Sono venuto proprio bene');
;

/* inserimento dei luoghi preferiti */
INSERT INTO luogo_preferito (email_utente, utente_luogo, id_cinguettio) 
VALUES 
('fra@gmail.com', 'gaia@gmail.com', '2'),
('fra@gmail.com', 'lorenzo@gmail.com', '2'),
('fra@gmail.com', 'ismail@gmail.com', '2'),
('lorenzo@gmail.com', 'ismail@gmail.com', '2'),
('sissi@gmail.com', 'lorenzo@gmail.com', '2'),
('sissi@gmail.com', 'fra@gmail.com', '2'),
('gaia@gmail.com', 'fra@gmail.com', '2')
;












