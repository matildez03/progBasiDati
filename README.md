da fare:
- rivedere vincoli e grandezze dei dati su db
- aggiornare business rules
- scrivere la traduzione del db sul file
- stabilire credenziali di accesso al db
- dare un nome al server per permettere connessioni remote
- AGGIUNGERE TRY/CATHCS
- assicurarsi che le query con dati utente siano eseguite con bind e prepare  


DEBUGS:
- logout quando si esce dall'homepage

SUGGERIMETI:
ha senso creare classi php relative alle tabelle del db?

RIPRENDI DA:
docente/validate.php
prepara la query + bind dei dati del docente per ricavare tutti i test creati dal docente e salvali in un array
in amministrazione.php mostra l'elenco dei test con echo <li><a per renderli premibili e reindirizzare alla gestione di ciascun test con pagina php basata sul db
