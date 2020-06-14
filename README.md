# Magic Boulevard Cinema — Manuale d'uso

## Requisiti di installazione

Per poter installare correttamente MBC il server deve soddisfare i seguenti requisiti:

- Server *Apache* versione ≥ 2.4
- PHP versione ≥ 7.4
- MySQL che supporti il motore InnoDB, quindi versione ≥ 5.5.5
- **[OPZIONALE — CONSIGLIATO]** Certificato SSL per abilitare *HTTPS*

## Requisiti d'uso

Per poter visitare le pagine web bisogna necessariamente avere cookie e Javascript abilitati.

## Installazione sul server

L'installazione richiederà pochi e semplici passi:

1. Copiare la cartella *MagicBoulevardCinema* e il file *.htaccess* del pacchetto fornito all'interno di

   **Windows:** *C:\xampp\htdocs*

   **Linux/Mac:** */opt/lampp/htdocs*

2. **[OPZIONALE — CONSIGLIATO]** Per maggior sicurezza degli utenti, abilitare i cookie *httponly* e *secure* (necessario certificato SSL) e cambiargli nome, modificando il file *php.ini* in posizione

   **Windows:** *C:\xampp\php\php.ini*

   **Linux/Mac:** */opt/lampp/etc/php.ini*

   Modificare le seguenti righe

   ```php
   ;session.cookie_secure=
   ;session.cookie_httponly=
   session.name=PHPSESSID
   ```

   In

   ```php
   session.cookie_secure=1
   session.use_only_cookies=1
   session.name=MBC
   ```

3. Avviare l'installatore web inserendo nel browser il dominio del server web, sia esso *localhost* o l'IP della macchina virtuale.

4. Il primo passo sarà inserire il nome del database e username e password per accedervi. L'opzione *popola film* può essere scelta per trovarsi nel database alcuni dati di film, utenti, proiezioni, ecc.
![image-20200614131748234](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614131748234.png)

5. Comparirà quindi una nuova schermata per inserire i prezzi di ogni giorno e il sovrapprezzo per la prenotazione.
    ![image-20200614131917029](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614131917029.png)

6. Come ultimo passaggio bisognerà impostare le credenziali del primo account, nonché primo admin.
    ![image-20200614132308385](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614132308385.png)

7. Buon Magic Boulevard Cinema — Il cinema dei tuoi sogni!
    ![image-20200614132451336](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614132451336.png)



## Uso admin

L'amministratore potrà gestire a 360 gradi il portale. Dal menù a tendina in alto a destra potrà fare le seguenti azioni:
<img src="/Users/gianluca/Library/Application Support/typora-user-images/image-20200614132819694.png" alt="image-20200614132819694" style="zoom:25%;" align="center"/>

### Il mio profilo

Esso fornisce una schermata riassuntiva sull'utente.

![image-20200614133651557](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614133651557.png)

Mentre l'utente potrà vedere anche i giudizi che ha posto sotto ai film, l'admin potrà solamente modificare o eliminare (previo consenso) il proprio profilo.

Se si cliccherà *modifica*, uscirà fuori una classica schermata di modifica.

![image-20200614134053986](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614134053986.png)



### Gestione film

Da qui si potrà gestire l'aggiunta di film e attori/registi: la schermata è divisa in tre: *aggiungi film*, *aggiungi attore/regista* e *modifica attore/regista*.

#### Aggiunta film

I campi necessari per l'aggiunta del film sono il titolo, la descrizione, la durata e la data di rilascio. I restanti parametri sono opzionali, tuttavia si consiglia di inserirli per fornire un'esperienza utente migliore. Importante sottolineare che per poter fruire del trailer sulla pagina del film esso dev'essere in forma `https://www.youtube.com/watch?v=aabbccddeeff`.

![image-20200614190734348](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614190734348.png)

Gli attori e i registi verranno consigliati tramite un menù a tendina e si potranno scegliere solamente quelli presenti in elenco.

![image-20200614135455287](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614135455287.png)

Una volta aggiunto si verrà reindirizzati sulla schermata del film.

![image-20200614135019237](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614135019237.png)

#### Modifica film

Dalla schermata precedente si dovrà cliccare su *modifica film*. Si accederà ad una schermata analoga a quella di *aggiungi film* con il quale si potranno modificare i parametri.

#### Elimina film

Sempre dalla schermata precedente si dovrà cliccare su *elimina film*. Dopo la richiesta di conferma, in caso di esito positivo, il film verrà eliminato.

#### Aggiunta attore/regista

Per aggiungere un attore o regista bisognerà indicare nome, cognome, il suo riferimento al sito *imdb.com* e se esso è un attore o regista. Verrà confermata l'operazione in caso di successo.

![image-20200614190755973](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614190755973.png)

#### Modifica attore/regista

Cliccando sulla schermata *modifica attore/regista* si vedrà l'elenco di attori e registi salvati. Basterà quindi cliccare *modifica* su quello scelto.

![image-20200614190917330](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614190917330.png)

![image-20200614190933714](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614190933714.png)

### Gestione programmazione

Da qui sarà possibile aggiungere, modificare o cancellare la programmazione di un film. La schermata è divisa in due: *gestione programmazione* e *aggiungi programmazione*.

#### Aggiunta programmazione

Bisognerà completare i dati essenziali quali film, sala, ora, data di inizio e data di fine.

![image-20200614135536871](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614135536871.png)

Verranno quindi create proiezioni nell'intervallo di date alla stessa ora. Il sistema avvertirà se ci saranno sovrapposizioni.

#### Modifica programmazione

Dalla schermata *gestione programmazione* si dovrà cliccare *modifica* sul film di cui si vuole cambiare la programmazione.

![image-20200614135722035](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614135722035.png)

Comparirà quindi l'elenco di tutte le proiezioni e di ognuna verranno indicate sala, data e ora. Si dovrà cliccare modifica su quella da cambiare.

![image-20200614135846989](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614135846989.png)

Si potranno quindi cambiare ora e sala della proiezione (**quest'ultima solo se nessun biglietto è presente nella sala**). In caso si voglia cambiare il film o la data, bisognerà cancellare la proiezione e riaggiungerla.

![image-20200614144235740](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614144235740.png)

#### Elimina programmazione

In riferimento alle schermate precedenti, bisognerà premere il tasto *cancella* in corrispondenza di una proiezione.



### Gestione utenti

Da qui sarà possibile porre o rimuovere il ban su un utente. La schermata è divisa in due: *utenti bananti* e *banna utente*.

#### Bannare utente

All'interno della schermata *banna utente* è presente un campo di testo. Inserire all'interno l'username dell'utente da bannare oppure la sua mail.

![image-20200614144738555](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614144738555.png)

Il sistema avvertità se l'username o email  non corrisponde ad alcun utente. In caso di successo si verrà reindirizzato nella schermata *utenti bannati*.

#### Rimuovere ban utente

Dalla schermata *utenti bannati*, in corrispondenza dell'utente da bannare, premere il tasto *rimuovi ban* in basso a destra.

![image-20200614144826136](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614144826136.png)



### Gestione prezzi

Da qui sarà possibile modificare i prezzi. Per la schermata si fa rimento alla schermata di inserimento prezzi dell'installatore web.



### Gestione sale

Da qui sarà possibile aggiungere e cambiare la disponibilità di una sala. La schermata è divisa in due: *gestione sale* e *aggiungi sala*.

#### Aggiunta sala

Dalla schermata *aggiungi sala* inserire il numero della sala, il numero di file e il numero di posti per fila. Indicare infine se essa è disponibile o meno.

![image-20200614145506153](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614145506153.png)

#### Cambiare disponibilità

Dalla schermata *gestione sale* sarà possibile vedere un riepilogo di tutte le sale e cambiare la loro disponibilità selezionando la checkbox e premendo il tasto conferma.

![image-20200614150221337](/Users/gianluca/Library/Application Support/typora-user-images/image-20200614150221337.png)
