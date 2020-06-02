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
    `registi` TEXT,
    `paese` TEXT,
    `etaConsigliata` TEXT
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
    `occupato` BOOLEAN NOT NULL,
    PRIMARY KEY (`idProiezione`,`posizione`),
    FOREIGN KEY (`idProiezione`)
        REFERENCES Proiezione(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Utenti(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(15),
    `email` varchar(40) NOT NULL UNIQUE,
    `nome` TEXT,
    `cognome` TEXT,
    `password` TEXT,
    `isAdmin` BOOLEAN DEFAULT FALSE,
    `isBanned` BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE Biglietto (
    `idProiezione` INTEGER NOT NULL,
    `posto` VARCHAR(4) NOT NULL,
    `idUtente` INTEGER NOT NULL,
    `costo` TEXT NOT NULL,
    `id` TEXT NOT NULL UNIQUE,
    PRIMARY KEY (`idProiezione`,`posto`),
    FOREIGN KEY (`idUtente`)
        REFERENCES Utenti(`id`)
    ON UPDATE CASCADE,
    FOREIGN KEY (`idProiezione`)
        REFERENCES Proiezione(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE Giudizio(
    `idUtente` INTEGER NOT NULL,
    `idFilm`  INTEGER NOT NULL,
    `commento` TEXT NOT NULL,
    `punteggio` TEXT NOT NULL,
    `titolo` TEXT NOT NULL,
    `datapubblicazione` DATE NOT NULL,
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
    `immagine` LONGBLOB NOT NULL,
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
    `immagine` LONGBLOB NOT NULL,
    FOREIGN KEY (`idFilm`)
        REFERENCES Film(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE Token(
    `value` VARCHAR(15) NOT NULL,
    `creationDate` DATE NOT NULL,
    `creationHour` TEXT NOT NULL,
    `idUtente` INTEGER NOT NULL,
    PRIMARY KEY (`value`),
    FOREIGN KEY (`idUtente`)
        REFERENCES Utenti(`id`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
