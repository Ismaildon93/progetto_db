/****************************************************************
*
* Nome progetto: CINGUETTIO
*                 File: style.css
*              Scopo: definizione delle funzioni per la modal
*         Creato da: Donà Ismail, Urso Francesco
*               Anno: 2017/2018
*       	
* Ultima modifica: Venerdì 16 Giugno 2017
*
*      
*****************************************************************/


/**
 * Mostra la modal e nasconde gli altri elementi
 * 
 * @param {type} idModal
 * @param {type} elementoDaNascondere
 * @returns {undefined}
 */

function showModal (idModal,elementoDaNascondere) {
    document.getElementById(idModal).style.display='block';
    document.getElementById(elementoDaNascondere).style.display='none';   
}

/**
 * Nasconde la modal e mostra gli altri elementi
 * 
 * @param {type} idModal
 * @param {type} elementoDaMostrare
 * @returns {undefined}
 */

function hideModal (idModal, elementoDaMostrare) {
    document.getElementById(idModal).style.display='none';
    document.getElementById(elementoDaMostrare).style.display='table';   
}

/**
 * Chiude la modal mostra gli altri elementi
 * 
 * @param {string} idModal
 * @param {string} elementoDaMostrare
 * @returns {undefined}
 */

function closeModal (idModal,elementoDaMostrare) {
    
            // Quando l'utente clicca in un qualsiasi punto dell'elemento modale chiudila 
            window.onclick = function(event) {
                if (event.target === document.getElementById(idModal)) {
                    document.getElementById(idModal).style.display = "none";
                    document.getElementById(elementoDaMostrare).style.display='table';  
                }
            };
}
