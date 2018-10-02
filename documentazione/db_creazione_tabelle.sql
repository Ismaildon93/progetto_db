/****************************************************************
*
*   Nome progetto: CINGUETTIO
*            File: db_creazione_tabelle.sql
*           Scopo: creazione database e tabelle database
*       Creato da: Donà Ismail, Urso Francesco
*            Anno: 2017/2018
* 
*   Nome database: db_cinguettio
*       Tipo DBMS: MariaDB
*   Versione DBMS: 10.1.9	
* 	
*      Web server: Apache 2.4.17
* 
* Ultima modifica: Domenica 11 Giugno 2017
*
*      
*****************************************************************/

/*
* ===================== CREAZIONE DATABASE ======================
*/

-- creazione database db_cinguettio 
CREATE DATABASE IF NOT EXISTS db_cinguettio;

-- seleziono database db_cinguettio
USE db_cinguettio;

/*
* ===================== CREAZIONE TABELLE =======================
*/

-- tabella utente 
CREATE TABLE IF NOT EXISTS utente(

	email_utente     VARCHAR(70),
	nickname         VARCHAR(20) NOT NULL UNIQUE,
	password         VARCHAR(50) NOT NULL,
	utente_esperto   BOOLEAN NOT NULL DEFAULT FALSE,
	data_esperto     DATE DEFAULT NULL,
	img_profilo      VARCHAR (255) NOT NULL DEFAULT 'default.png',
	path_img_profilo VARCHAR (255) NOT NULL DEFAULT 'img/utenti/profilo/default.png',

	PRIMARY KEY(email_utente)
);

-- tabella info_utente  
CREATE TABLE IF NOT EXISTS info_utente(

	email_utente    VARCHAR (70),
	nome            VARCHAR (20) DEFAULT NULL,
	cognome         VARCHAR (20) DEFAULT NULL,
	sesso           CHAR (1) DEFAULT NULL,
	data_nascita    DATE DEFAULT NULL,
	nazione_nascita VARCHAR (50) DEFAULT NULL,
	regione_nascita VARCHAR (50) DEFAULT NULL,
	citta_residenza VARCHAR (50) DEFAULT NULL,

	PRIMARY KEY (email_utente),

	FOREIGN KEY (email_utente)
		REFERENCES utente (email_utente)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- tabella hobby  
CREATE TABLE IF NOT EXISTS hobby(

	email_utente VARCHAR(70),
	tipo_hobby   VARCHAR(20),

	PRIMARY KEY(email_utente, tipo_hobby),
	
	FOREIGN KEY (email_utente)
		REFERENCES utente (email_utente)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- tabella cinguettio 
CREATE TABLE IF NOT EXISTS cinguettio(

	email_utente        VARCHAR(70),
	id_cinguettio		INTEGER(11),
	data_ora_cinguettio TIMESTAMP NOT NULL DEFAULT NOW(),
	tipo_cinguettio     CHAR(1) NOT NULL, 	

	PRIMARY KEY(email_utente, id_cinguettio),

	FOREIGN KEY (email_utente)
		REFERENCES utente (email_utente)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- tabella testo  
CREATE TABLE IF NOT EXISTS testo(

	email_utente  VARCHAR(70),
	id_cinguettio INTEGER(11) DEFAULT 0,
	messaggio     VARCHAR(50) NOT NULL,
	inappropriato BOOLEAN NOT NULL DEFAULT FALSE,
	oscurato      BOOLEAN NOT NULL DEFAULT FALSE,
	
	PRIMARY KEY(email_utente, id_cinguettio),

	FOREIGN KEY (email_utente, id_cinguettio)
		REFERENCES cinguettio(email_utente, id_cinguettio)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- tabella luogo  
CREATE TABLE IF NOT EXISTS luogo(

	email_utente  VARCHAR (70),
	id_cinguettio INTEGER (11) DEFAULT 0,
	latitudine    FLOAT (10,6) NOT NULL,
	longitudine   FLOAT (10,6) NOT NULL,

	PRIMARY KEY (email_utente, id_cinguettio),

	FOREIGN KEY (email_utente, id_cinguettio)
		REFERENCES cinguettio (email_utente, id_cinguettio)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- tabella foto  
CREATE TABLE IF NOT EXISTS foto(

	email_utente  	 VARCHAR(70),
	id_cinguettio    INTEGER(11) DEFAULT 0,
	nome_foto        VARCHAR(255) NOT NULL, 
	path_foto        VARCHAR(255) NOT NULL,
	descrizione_foto VARCHAR(20) DEFAULT NULL,
	
	PRIMARY KEY(email_utente, id_cinguettio),

	FOREIGN KEY(email_utente, id_cinguettio)
		REFERENCES cinguettio (email_utente, id_cinguettio)
		ON DELETE CASCADE
		ON UPDATE CASCADE		
);

-- tabella giudizio_foto  
CREATE TABLE IF NOT EXISTS giudizio_foto(

	email_utente 	  VARCHAR(70),
	utente_giudicato  VARCHAR(70),
	id_cinguettio 	  INTEGER (11),
	data_ora_commento TIMESTAMP DEFAULT NOW(),
	commento          VARCHAR(50) NOT NULL,

	PRIMARY KEY (email_utente, utente_giudicato, id_cinguettio, data_ora_commento),

	FOREIGN KEY (email_utente)
	REFERENCES utente (email_utente)
	ON UPDATE CASCADE
	ON DELETE CASCADE,

	FOREIGN KEY (utente_giudicato, id_cinguettio)
	REFERENCES foto (email_utente, id_cinguettio)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);

-- tabella segnala_testo  
CREATE TABLE IF NOT EXISTS segnala_testo(

	email_utente 	 VARCHAR(70),
	utente_segnalato VARCHAR(70),
	id_cinguettio	 INTEGER(11),

	PRIMARY KEY (email_utente, utente_segnalato, id_cinguettio),

	FOREIGN KEY (email_utente)
	REFERENCES utente (email_utente)
	ON DELETE CASCADE
	ON UPDATE CASCADE,

	FOREIGN KEY (utente_segnalato, id_cinguettio)
	REFERENCES testo (email_utente, id_cinguettio)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

-- tabella luogo_preferito 
CREATE TABLE IF NOT EXISTS luogo_preferito(

	email_utente  VARCHAR(70),
	utente_luogo  VARCHAR(70),
	id_cinguettio INTEGER(11),

	PRIMARY KEY (email_utente, utente_luogo, id_cinguettio),

	FOREIGN KEY (email_utente)
	REFERENCES utente (email_utente)
	ON UPDATE CASCADE
	ON DELETE CASCADE,

	FOREIGN KEY (utente_luogo, id_cinguettio)
	REFERENCES luogo (email_utente, id_cinguettio)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);

-- tabella seguaci_seguiti  
CREATE TABLE IF NOT EXISTS seguaci_seguiti(

	utente_seguace      VARCHAR(70),
	utente_seguito      VARCHAR(70),
	data_ora_richiesta  TIMESTAMP NOT NULL DEFAULT NOW(),
	richiesta_accettata BOOLEAN NOT NULL DEFAULT FALSE,
	data_ora_risposta   TIMESTAMP NULL DEFAULT NULL,

	PRIMARY KEY (utente_seguace, utente_seguito),

	FOREIGN KEY (utente_seguace)
	REFERENCES utente(email_utente)
	ON UPDATE CASCADE
	ON DELETE CASCADE,

	FOREIGN KEY (utente_seguito)
	REFERENCES utente (email_utente)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);


