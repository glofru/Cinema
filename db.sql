CREATE TABLE film(
	filmID INTEGER PRIMARY KEY AUTOINCREMENT,
	nome TEXT NOT NULL,
	descrizione TEXT,
	durata TIME NOT NULL,
	trailerURL TEXT,
	votoCritica FLOAT(3),
	dataRilascio DATE,
	genere TEXT,
	attroi TEXT,
	registi TEXT
);

CREATE TABLE persone(
	personID INTEGER PRIMARY KEY AUTOINCREMENT,
	nome TEXT NOT NULL,
	cognome TEXT NOT NULL,
	imdbURL TEXT NOT NULL,
	isAttore BOOLEAN NOT NULL,
	isRegista BOOLEAN NOT NULL
);