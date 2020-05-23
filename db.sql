SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE Persona(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `nome` TEXT NOT NULL,
    `cognome` TEXT NOT NULL,
    `imdbURL` TEXT NOT NULL,
    `isAttore` BOOLEAN NOT NULL,
    `isRegista` BOOLEAN NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE Film(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `nome` TEXT NOT NULL,
    `descrizione` TEXT,
    `durata` TIME NOT NULL,
    `trailerURL` TEXT,
    `votoCritica` FLOAT(3),
    `dataRilascio` DATE,
    `genere` TEXT,
    `attori` TEXT,
    `registi` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE SalaFisica(
    `nSala` INTEGER PRIMARY KEY,
    `nFile` INTEGER NOT NULL,
    `nPostiFila` INTEGER NOT NULL,
    `disponibile` BOOLEAN NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Proiezione(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `data` DATE NOT NULL,
    `ora` TEXT NOT NULL,
    `numerosala` INTEGER NOT NULL,
    `idFilm` INTEGER NOT NULL,
    FOREIGN KEY (`numerosala`)
        REFERENCES SalaFisica(`nSala`)
    ON UPDATE CASCADE,
    FOREIGN KEY (`idFilm`)
        REFERENCES Film(`id`)
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE Posti(
    `idProiezione` INTEGER NOT NULL,
    `posizione` varchar(4) NOT NULL,
    `libero` BOOLEAN NOT NULL,
    PRIMARY KEY (`idProiezione`,`posizione`),
    FOREIGN KEY (`idProiezione`)
        REFERENCES Proiezione(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Biglietto (
    `idProiezione` INTEGER NOT NULL,
    `posto` VARCHAR(4) NOT NULL,
    `idUtente` INTEGER NOT NULL,
    `costo` TEXT NOT NULL,
    PRIMARY KEY (`idProiezione`,`posto`),
    FOREIGN KEY (`idUtente`)
        REFERENCES Utenti(`id`)
    ON UPDATE CASCADE,
    FOREIGN KEY (`idProiezione`)
        REFERENCES Proiezione(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Utenti(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(15) NOT NULL UNIQUE,
    `email` varchar(40) NOT NULL UNIQUE,
    `nome` TEXT NOT NULL,
    `cognome` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `isAdmin` BOOLEAN NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE Giudizio(
    `idUtente` INTEGER NOT NULL,
    `idFilm`  INTEGER NOT NULL,
    `commento` TEXT NOT NULL,
    `punteggio` TEXT NOT NULL,
    PRIMARY KEY (`idUtente`,`idFilm`),
    FOREIGN KEY (`idUtente`)
        REFERENCES Utenti(`id`)
    ON UPDATE CASCADE,
    FOREIGN KEY (`idFilm`)
        REFERENCES Film(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE MediaUtente(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `fileName` TEXT NOT NULL,
    `mimeType` TEXT NOT NULL,
    `idUtente` INTEGER NOT NULL,
    `date` DATE NOT NULL,
    `immagine` BLOB NOT NULL,
    FOREIGN KEY (`idUtente`)
        REFERENCES Utenti(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE MediaLocandina(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `fileName` TEXT NOT NULL,
    `mimeType` TEXT NOT NULL,
    `idFilm` INTEGER NOT NULL,
    `date` DATE NOT NULL,
    `immagine` BLOB NOT NULL,
    FOREIGN KEY (`idFilm`)
        REFERENCES Film(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO `Film` (`id`, `nome`, `dataRilascio`, `trailerURL`, `descrizione`, `durata`, `votocritica`, `genere`) VALUES
(1, 'LA SOTTILE LINEA ROSSA', '1998-12-22', 'https://www.youtube.com/watch?v=qOiTMswFkD8', 'La sottile linea rossa (The Thin Red Line) è un film del 1998 scritto e diretto da Terrence Malick, con un ricchissimo cast di star che hanno accettato anche ruoli secondari e minori pur di apparirvi. Si tratta del terzo lungometraggio del cineasta statunitense, che in 25 anni di carriera prima di quest''opera aveva realizzato solo altre due pellicole.\r\n\r\nIl film è tratto dall''omonimo romanzo di James Jones (1962), vero reduce della guerra nel Pacifico. Il titolo si riferisce a un verso di Rudyard Kipling dal suo poema "Tommy", tratto dalla collezione Barrack-Room Ballads, nel quale Kipling descrive i soldati come "una sottile linea rossa di eroi". Il poema di Kipling è a sua volta basato sull''azione dei soldati britannici nel 1854 durante la guerra di Crimea, chiamata "The Thin Red Line (Battle of Balaclava)".', '2:50', '8', 'GUERRA'),
(2, 'L''ORA PIU'' BUIA', '2017-11-22', 'https://www.youtube.com/watch?v=owOKnpsc_WI', 'Nel 1940 Winston Churchill, da pochi giorni Primo ministro della Gran Bretagna dopo le dimissioni di Neville Chamberlain, deve affrontare una delle sue prove più turbolente e definitive: decidere se negoziare un trattato di pace con la Germania nazista o continuare la guerra per difendere gli ideali e la libertà della propria nazione.\r\n\r\nQuando le inarrestabili forze naziste iniziano a conquistare tutta l''Europa occidentale e la minaccia di invasione diventa imminente, con un''opinione pubblica non preparata, Churchill dovrà sopportare la sua ora più buia, con re Giorgio VI scettico e il suo partito che trama contro di lui, mobilitando l''intera nazione e tentando di cambiare il corso della storia mondiale.', '2:05', '7.0', 'BIOGRAFICO'),
(3, 'CLOUD ATLAS', '2012-09-26', 'https://www.youtube.com/watch?v=6Fi3fNmSvso', 'Cloud Atlas è un film del 2012 scritto e diretto da Lana e Lilly Wachowski e da Tom Tykwer.\r\n\r\nTratto dal romanzo L''atlante delle nuvole di David Mitchell, è un film di fantascienza che intreccia sei storie ambientate in luoghi e tempi diversi. I temi ricorrenti nel film, così come nel romanzo, sono la reincarnazione e il destino, elementi che legano indissolubilmente i personaggi e le situazioni dei sei episodi attraverso numerosi richiami e citazioni interne.\r\n\r\nCon un budget di oltre 100 milioni di dollari, è stato uno dei film indipendenti più costosi mai realizzati e il più costoso prodotto in Germania.', '2:52', '6.6', 'SCI-FI'),
(4, 'NO TIME TO DIE', '2020-11-12', 'https://www.youtube.com/watch?v=_BvD0n8cch8', 'Cinque anni dopo gli eventi di Spectre, James Bond, ormai ritiratosi dal MI6, si gode una vita tranquilla in Giamaica. Quando un suo vecchio amico, l''agente della CIA Felix Leiter, si presenta da lui con una richiesta d''aiuto, Bond decide di intraprendere una missione per salvare uno scienziato rapito; essa si rivelerà tuttavia più complicata del previsto e porterà l''uomo sulle tracce di Safin, un misterioso criminale che possiede armi estremamente distruttive.', '2:43', '0.0', 'AZIONE');
