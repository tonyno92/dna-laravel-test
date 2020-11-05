# dna-laravel-test

Ciao ragazzi ho svolto come d'accordo l'esercizio laravel fino alle features PRO plus.
Vi elenco qui il processo per avviare tutto lo stack, in modo da replicare il mio stesso ambiente in quanto ho applciato delle piccole aggiunte e modifiche per migliorare il plug and play, da parte vostra per verificare le funzionalità richieste.


Dentro z-doc, trovate il docker-composer.yml pronto all'uso in cui ho inserito un nuovo servizio, chiamato ftp, per simulare l'update in ftp del backup di laravel, oltre tutto ho anche esteso il .env del relativo compose, in modo che i container non vedano i volumi fisici degli altri, nonostante siano montati nello stesso archivio.

# N.B
Mi sono permesso di aggiungere un piccolo script di shell da lanciare una volta tirata sula struttura docker, che serve ad aggionrare il composer,
in quanto il package di laravel-backup necessitava della versione 2 di composer, mentre quella presente nella vostra "macchine" è la 1.
Lo script è situato sotto la directory ```rootDir->dna->updateComposer.sh``` e va lanciato da dentro il container.

# 1 - Iniziamo

Recarsi sotto la dir ```rootDir -> z-doc -> docker-entrance-837239```
Dare il comando
```
    docker-compose up -d
```
Entrare nel container "macchine" con il comando
```
    docker exec -it <id_container_service_macchine> bash
```
Lanciare l'update del composer
```
    cd html/
    ./updateComposer.sh
```
Dopo di che installare le dipendenze necessarie con il comando
```
    composer install
```

# 2 - Laravel
il file ```.env``` è gia predisposto per puntare ai servizi dello stack docker.

### 2.1 Migrations
Lanciare il comando 
```
    php artisan migrate
```
Il quale creerà le tabelle relative al Model e alla coda per gestire jobA e jobB

### 2.2 Schedule
Per poter verificare l'esatta schedulazione del task di generazione dei file csv dobbiamo attivare il Task Scheduling e le Queues di laravel, essendo  sotto ambiente di sviluppo, utilizziamo per comodità lo Scheduler locale, ma lo utilizziamo in background in modo da vederne anche l'output.

*Giusto una piccola precisazione per evitare fraintendimenti, per la frase in email "Dato un path sul server di una cartella", ho creato un comando con questa firma:*
```
    protected $signature = 'csv:generate {path=pairs}';
```
*e successivamente ho creato anche un nuovo disk con questa configurazione.*
```
    'csv' => [
            'driver' => 'local',
            'root' => storage_path('csv')
        ],
```
*In modo da evitare che possano essere dati in input percorsi errati o ad aree non sicure del filesystem.* (SPERO DI AVER CAPITO BENE IL PUNTO😅)

Impartiamo il comando per avviare la coda
```
    php artisan queue:work --queue=csv,default &
```
Impartiamo il comando per avviare la schedulazione dei task
```
    php artisan schedule:work &
```
# 3 - Phpmetric
Per generare le metriche del progetto, dare il seguente comando dalla root dell'app
```
    /var/www/html# vendor/bin/phpmetrics -h --report-html=metric ./
```
Questo genererà sotto la dir ```rootDir-> dna -> metric``` le metriche.

Questo è tutto!