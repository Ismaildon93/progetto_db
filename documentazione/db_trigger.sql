/****************************************************************
*
*   Nome progetto: CINGUETTIO
*            File: db_trigger.sql
*           Scopo: creazione dei trigger
*       Creato da: Donà Ismail, Urso Francesco
*            Anno: 2017/2018
* 
*   Nome database: db_cinguettio
*       Tipo DBMS: MariaDB
*   Versione DBMS: 10.1.9	
* 	
*      Web server: Apache 2.4.17
* 
* Ultima modifica: Lunedì 12 Giugno 2017
*
*      
*****************************************************************/

-- seleziono il database
USE db_cinguettio;

/*
* ========= SOLUZIONE VINCOLI V12, V13, V14, V36, V37 =========== 
*/

-- inserimento cinguettio di tipo testo
DELIMITER //
CREATE TRIGGER vincolo_cinguettio_testo 
BEFORE INSERT ON testo
FOR EACH ROW
	BEGIN

		DECLARE max_id_cinguettio INTEGER(11);
	
		-- massimo id_cinguettio da cinguettio
		SET max_id_cinguettio = ( 
			SELECT MAX(id_cinguettio)
			FROM cinguettio
			WHERE email_utente = NEW.email_utente
		);				
		
		-- caso in cui nessun cinguettio sia stato pubblicato
		-- dall'utente				
		IF (max_id_cinguettio IS NULL) THEN
			SET NEW.id_cinguettio = 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio = NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, -- data corrente
				tipo_cinguettio = 'T';												
				 
		-- caso in cui almeno un cinguettio è stato pubblicato
		-- dall'utente
		ELSEIF (max_id_cinguettio IS NOT NULL) THEN
			SET NEW.id_cinguettio = max_id_cinguettio + 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio = NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, 
				tipo_cinguettio = 'T';		
		
		END IF;

	END //
DELIMITER ;

-- inserimento cinguettio di tipo luogo
DELIMITER //
CREATE TRIGGER vincolo_cinguettio_luogo 
BEFORE INSERT ON luogo
FOR EACH ROW
	BEGIN

		DECLARE max_id_cinguettio INTEGER(11);
		
		-- massimo id_cinguettio da cinguettio
		SET max_id_cinguettio = ( 
			SELECT MAX(id_cinguettio)
			FROM cinguettio
			WHERE email_utente = NEW.email_utente
		);				
		
		-- caso in cui nessun cinguettio sia stato pubblicato
		-- dall'utente	
		IF (max_id_cinguettio IS NULL) THEN
			SET NEW.id_cinguettio = 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio =  NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, -- data corrente
				tipo_cinguettio = 'L';												
				 
		-- caso in cui almeno un cinguettio è stato pubblicato
		-- dall'utente
		ELSEIF (max_id_cinguettio IS NOT NULL) THEN
			SET NEW.id_cinguettio = max_id_cinguettio + 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio = NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, 
				tipo_cinguettio = 'L';		
		
		END IF;

	END //
DELIMITER ;

-- inserimento cinguettio di tipo foto
DELIMITER //
CREATE TRIGGER vincolo_cinguettio_foto 
BEFORE INSERT ON foto
FOR EACH ROW
	BEGIN

		DECLARE max_id_cinguettio INTEGER(11);
	
		-- massimo id_cinguettio da cinguettio
		SET max_id_cinguettio = ( 
			SELECT MAX(id_cinguettio)
			FROM cinguettio
			WHERE email_utente = NEW.email_utente
		);				
		
		-- caso in cui nessun cinguettio sia stato pubblicato
		-- dall'utente
		IF (max_id_cinguettio IS NULL) THEN
			SET NEW.id_cinguettio = 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio = NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, -- data corrente
				tipo_cinguettio = 'F';												
				 
		-- caso in cui almeno un cinguettio è stato pubblicato
		-- dall'utente
		ELSEIF (max_id_cinguettio IS NOT NULL) THEN
			SET NEW.id_cinguettio = max_id_cinguettio + 1;
			INSERT INTO cinguettio
			SET 
				email_utente = NEW.email_utente,
				id_cinguettio = NEW.id_cinguettio,
				data_ora_cinguettio = DEFAULT, 
				tipo_cinguettio = 'F';		
		
		END IF;

	END //
DELIMITER ;

/*
* ========= SOLUZIONE VINCOLO V16, V17 ========================== 	 	
*/

-- vincolo per un cinguettio di testo segnalato come 
-- inappropriato
DELIMITER //
CREATE TRIGGER vincolo_cinguettio_inappropriato_oscurato
AFTER INSERT ON segnala_testo
FOR EACH ROW

	label_uscita:
	BEGIN 
		
		DECLARE msg_gia_oscurato BOOLEAN;
		DECLARE msg_gia_inappropriato BOOLEAN;
		DECLARE numero_di_segnalazioni INTEGER(11);
		
		-- setto la variabile msg_gia_oscurato al valore 
		-- di oscurato
		SET msg_gia_oscurato = (
			SELECT oscurato
			FROM testo 
			WHERE 
				email_utente =  NEW.utente_segnalato AND
				id_cinguettio =	NEW.id_cinguettio
		);
		
		-- se il messaggio di testo è già oscurato
		-- non continuo 
		IF(msg_gia_oscurato = TRUE) THEN
			LEAVE label_uscita;
		END IF;
		
		-- setto la variabile msg_gia_segnalato al valore di inappropriato
		-- di testo
		SET msg_gia_inappropriato = (
			SELECT inappropriato
			FROM testo 
			WHERE 
				email_utente =  NEW.utente_segnalato AND
				id_cinguettio =	NEW.id_cinguettio
		);

		-- caso in cui il messaggio di testo sia stato già segnalato 
		IF(msg_gia_inappropriato = TRUE) THEN
			
			-- calcolo il numero di segnalazioni
			SET numero_di_segnalazioni = (
				SELECT COUNT(*)
				FROM segnala_testo
				WHERE 
					utente_segnalato = NEW.utente_segnalato AND	
					id_cinguettio = NEW.id_cinguettio					
			);

			-- aggiorno oscurato di utente se la condizione 
			-- è verificata
			IF (numero_di_segnalazioni > 3) THEN
				UPDATE testo
				SET 
					oscurato = TRUE
				WHERE 
					email_utente = NEW.utente_segnalato AND
					id_cinguettio = NEW.id_cinguettio
				;
			END IF;
			
			-- termino l'esecuzione
			LEAVE label_uscita;
			
		END IF;
			
		-- aggiorno il valore di inappopriato
		UPDATE testo
		SET
			inappropriato = TRUE
		WHERE
			email_utente = NEW.utente_segnalato AND
			id_cinguettio = NEW.id_cinguettio;
	
	END //
DELIMITER ;

/*
* ========= SOLUZIONE VINCOLI V23, V24, V25, V38 ================ 	
*/

-- vincolo per l'utente che diventa esperto
DELIMITER //
CREATE TRIGGER vincolo_utente_diventa_esperto
AFTER UPDATE ON seguaci_seguiti
FOR EACH ROW

	label_uscita:
	BEGIN 
		
		DECLARE numero_seguaci INTEGER(11); 
		DECLARE esperto BOOLEAN;
		
		-- considero solo il caso in cu una richiesta appesa
		-- sia stata accettata 
		IF(NEW.richiesta_accettata = TRUE AND OLD.richiesta_accettata = FALSE) THEN
			
			-- verifico se l'utente è già un utente esperto
			SET esperto = (
				SELECT utente_esperto 
				FROM utente
				WHERE email_utente = NEW.utente_seguito
			);
			
			-- nel caso l'utente sia già esperto non continuo 
			IF (esperto = TRUE) THEN
				LEAVE label_uscita;
			END IF;
			
			-- conto il numero di utenti seguaci	
			SET numero_seguaci = (
				SELECT COUNT(*)
				FROM seguaci_seguiti
				WHERE 
					utente_seguito = NEW.utente_seguito AND
					richiesta_accettata = TRUE	
			);
			
			-- aggiorno i valori di utente_esperto e data_esperto 
			-- se la condizione è verificata
			IF (numero_seguaci >= 3) THEN
				UPDATE utente 
				SET 
					utente_esperto = TRUE,
					data_esperto = (CURDATE())
				WHERE email_utente = NEW.utente_seguito;
			END IF;
			
		END IF;
	
	END //
DELIMITER ;

-- vincolo per l'utente che non è più esperto
CREATE TRIGGER vincolo_utente_non_piu_esperto
AFTER DELETE ON seguaci_seguiti 
FOR EACH ROW 
		
	-- aggiorno utente_esperto e data_esperto nel caso l'utente 
	-- non sia più esperto 
	UPDATE utente
	SET
		utente_esperto = FALSE,
		data_esperto = NULL
	WHERE email_utente = OLD.utente_seguito AND 
		(
			SELECT COUNT(*) -- se l'utente non esiste COUNT(*) restituisce 0
			FROM seguaci_seguiti
			WHERE 
				utente_seguito = OLD.utente_seguito AND 
				richiesta_accettata = TRUE -- conto solo le richieste accettate
		) < 3
;
	
/*
* ========= SOLUZIONE VINCOLO V39 =============================== 	
*/

-- vincolo che garantisce ad ogni utente di avere una pagina 
-- info_utente all'atto dell'iscrizione (*vedere schema er ristrutturato) 	
CREATE TRIGGER vincolo_inserimento_utente_in_info_utente
AFTER INSERT ON utente
FOR EACH ROW
	
	-- inserimento di email_utente in info_utente
	-- tutti gli altri valori sono impostati al valore di 
	-- default ovvero NULL 
	INSERT INTO info_utente(email_utente)
	VALUES (NEW.email_utente) 
							 	
;

