INSERT INTO `Persona`(`id`, `nome`, `cognome`, `imdbURL`, `isAttore`, `isRegista`) VALUES
(1, 'Jim', 'Caviezel', 'https://www.imdb.com/name/nm0001029/', 1, 0),
(2, 'Sean Justin', 'Penn', 'https://www.imdb.com/name/nm0000576/', 1, 1),
(3, 'Terrence Frederick', 'Malick', 'https://www.imdb.com/name/nm0000517/', 0, 1),
(4, 'Woodrow Tracy', 'Harrelson', 'https://www.imdb.com/name/nm0000437/', 1, 0),
(5, 'Joe', 'Wright', 'https://www.imdb.com/name/nm0942504/', 0, 1),
(6, 'Gary', 'Oldman', 'https://www.imdb.com/name/nm0000198/', 1, 1),
(7, 'Kristin Scott', 'Thomas', 'https://www.imdb.com/name/nm0000218/', 0, 1),
(8, 'Ben', 'Mendelsohn', 'https://www.imdb.com/name/nm0578853/', 1, 0),
(9, 'Lana', 'Wachowski', 'https://www.imdb.com/name/nm0905154/', 0, 1),
(10, 'Lilly', 'Wachowski', 'https://www.imdb.com/name/nm0905152/', 0, 1),
(11, 'Tom', 'Hanks', 'https://www.imdb.com/name/nm0000158/', 1, 1),
(12, 'Hugh John Mungo', 'Grant', 'https://www.imdb.com/name/nm0000424/', 1, 0),
(13,'Maria Halle', 'Berry', 'https://www.imdb.com/name/nm0000932/', 1, 0),
(14, 'Cary Joji', 'Fukunaga', 'https://www.imdb.com/name/nm1560977/', 0, 1),
(15, 'Daniel Wroughton', 'Craig', 'https://www.imdb.com/name/nm0185819/', 1, 0),
(16, 'Rami', 'Malek', 'https://www.imdb.com/name/nm1785339/', 1, 0),
(17, 'Christoph', 'Waltz', 'https://www.imdb.com/name/nm0910607/', 1, 1),
(18, 'Cate', 'Shortland', 'https://www.imdb.com/name/nm0795153/', 0, 1),
(19, 'Scarlett', 'Johansson', 'https://www.imdb.com/name/nm0424060/', 1, 0),
(20, 'Florence', 'Pugh', 'https://www.imdb.com/name/nm6073955/', 1, 0),
(21, 'David', 'Harbour', 'https://www.imdb.com/name/nm1092086/', 1,0),
(22, 'Matthew', 'Vaughn', 'https://www.imdb.com/name/nm0891216/', 0, 1),
(23, 'Ralph', 'Fiennes', 'https://www.imdb.com/name/nm0000146/', 1, 1),
(24, 'Harris','Dickinson', 'https://www.imdb.com/name/nm6170168/', 1, 1),
(25, 'Daniel', 'Brühl', 'https://www.imdb.com/name/nm0117709/', 1, 0),
(26, 'Josh', 'Boone', 'https://www.imdb.com/name/nm1837748/', 0, 1),
(27,'Anya-Josephine', 'Taylor-Joy', 'https://www.imdb.com/name/nm5896355/', 1, 0),
(28, 'Maisie', 'Williams', 'https://www.imdb.com/name/nm3586035/', 1, 0),
(29, 'Charlie', 'Heaton', 'https://www.imdb.com/name/nm6390427/', 1, 0),
(30, 'Nicolas', 'Pesce', 'https://www.imdb.com/name/nm2073372/', 0, 1),
(31, 'Andrea Louise', 'Riseborough', 'https://www.imdb.com/name/nm2057859/', 1, 0),
(32, 'Demián', 'Bichir', 'https://www.imdb.com/name/nm0065007/', 1, 0),
(33, 'John', 'Cho', 'https://www.imdb.com/name/nm0158626/', 1, 0);




INSERT INTO `Film` (`id`, `nome`, `dataRilascio`, `trailerURL`, `descrizione`, `durata`, `votocritica`, `genere`, `attori`, `registi`, `paese`, `etaConsigliata`) VALUES
(1, 'LA SOTTILE LINEA ROSSA', '1998-12-22', 'https://www.youtube.com/watch?v=qOiTMswFkD8', 'La sottile linea rossa (The Thin Red Line) è un film del 1998 scritto e diretto da Terrence Malick, con un ricchissimo cast di star che hanno accettato anche ruoli secondari e minori pur di apparirvi. Si tratta del terzo lungometraggio del cineasta statunitense, che in 25 anni di carriera prima di quest''opera aveva realizzato solo altre due pellicole.\r\n\r\nIl film è tratto dall''omonimo romanzo di James Jones (1962), vero reduce della guerra nel Pacifico. Il titolo si riferisce a un verso di Rudyard Kipling dal suo poema "Tommy", tratto dalla collezione Barrack-Room Ballads, nel quale Kipling descrive i soldati come "una sottile linea rossa di eroi". Il poema di Kipling è a sua volta basato sull''azione dei soldati britannici nel 1854 durante la guerra di Crimea, chiamata "The Thin Red Line (Battle of Balaclava)".', '2:50', '8', 'GUERRA', '1;2;4', '3', 'USA', ''),
(2, 'L''ORA PIU'' BUIA', '2017-11-22', 'https://www.youtube.com/watch?v=owOKnpsc_WI', 'Nel 1940 Winston Churchill, da pochi giorni Primo ministro della Gran Bretagna dopo le dimissioni di Neville Chamberlain, deve affrontare una delle sue prove più turbolente e definitive: decidere se negoziare un trattato di pace con la Germania nazista o continuare la guerra per difendere gli ideali e la libertà della propria nazione.\r\n\r\nQuando le inarrestabili forze naziste iniziano a conquistare tutta l''Europa occidentale e la minaccia di invasione diventa imminente, con un''opinione pubblica non preparata, Churchill dovrà sopportare la sua ora più buia, con re Giorgio VI scettico e il suo partito che trama contro di lui, mobilitando l''intera nazione e tentando di cambiare il corso della storia mondiale.', '2:05', '7.0', 'BIOGRAFICO', '6;7;8', '5','UK',''),
(3, 'CLOUD ATLAS', '2012-09-26', 'https://www.youtube.com/watch?v=6Fi3fNmSvso', 'Cloud Atlas è un film del 2012 scritto e diretto da Lana e Lilly Wachowski e da Tom Tykwer.\r\n\r\nTratto dal romanzo L''atlante delle nuvole di David Mitchell, è un film di fantascienza che intreccia sei storie ambientate in luoghi e tempi diversi. I temi ricorrenti nel film, così come nel romanzo, sono la reincarnazione e il destino, elementi che legano indissolubilmente i personaggi e le situazioni dei sei episodi attraverso numerosi richiami e citazioni interne.\r\n\r\nCon un budget di oltre 100 milioni di dollari, è stato uno dei film indipendenti più costosi mai realizzati e il più costoso prodotto in Germania.', '2:52', '6.6', 'SCI-FI', '11;12;13', '9;10','USA', '+17'),
(4, 'NO TIME TO DIE', '2020-11-12', 'https://www.youtube.com/watch?v=_BvD0n8cch8', 'Cinque anni dopo gli eventi di Spectre, James Bond, ormai ritiratosi dal MI6, si gode una vita tranquilla in Giamaica. Quando un suo vecchio amico, l''agente della CIA Felix Leiter, si presenta da lui con una richiesta d''aiuto, Bond decide di intraprendere una missione per salvare uno scienziato rapito; essa si rivelerà tuttavia più complicata del previsto e porterà l''uomo sulle tracce di Safin, un misterioso criminale che possiede armi estremamente distruttive.', '2:43', '0.0', 'AZIONE', '15;16;17', '14','UK',''),
(5, 'Black Widow', '2020-11-06', 'https://www.youtube.com/watch?v=m26QpnmN1aU', 'Black Widow è un film supereroistico statunitense del 2020 diretto da Cate Shortland. Basato sul personaggio di Natasha Romanoff dei fumetti Marvel Comics, è il primo film dove lei è protagonista. Si tratta inoltre del ventiquattresimo film del Marvel Cinematic Universe e del primo della cosiddetta "Fase Quattro".', '2:05', '0.0', 'AZIONE', '19;20;21', '18', 'USA', ''),
(6, 'The King''s Man - Le origini', '2020-09-17', 'https://www.youtube.com/watch?v=d865SRSuRoQ&list=RDHqAmcMtOaVY&index=6', 'The King''s Man - Le origini (The King''s Man) è un film scritto e diretto da Matthew Vaughn in uscita nelle sale di tutto il mondo nel 2020. Si tratta nello specifico del prequel del film Kingsman - Secret Service.', '2:33', '0.0', 'AVVENTURA', '23;24;25', '22', 'UK', '+14'),
(7, 'The New Mutants', '2020-08-28', 'https://www.youtube.com/watch?v=_wDyenpOb68', 'The New Mutants è un film del 2020 diretto da Josh Boone. La pellicola è il tredicesimo film dell''universo X-Men e adattamento cinematografico della serie a fumetti Marvel Nuovi Mutanti.', '1:39', '0.0', 'HORROR', '27;28;29', '26', 'USA', '+13'),
(8, 'The Grudge', '2020-03-05', 'https://www.youtube.com/watch?v=O2NKzO-fxwQ', 'The Grudge è un film del 2020 diretto da Nicolas Pesce. La pellicola, reboot del remake statunitense del film Ju-on del 2000, è interpretato da Andrea Riseborough, Demián Bichir, John Cho, Betty Gilpin, Lin Shaye e Jacki Weaver. È il quarto film della serie The Grudge.', '1:34', '5.3', 'HORROR', '31;32;33', '30', 'USA', '+17');


/*INSERT INTO `medialocandina`(`id`, `fileName`, `mimeType`, `idFilm`, `date`, `immagine`) VALUES
(1, 'la_sottile_linea_rossa.jpg', 'image/jpg', 1, '2020-05-24', ),
(2, 'l_ora_piu_buia.jpg', 'image/jpg', 2, '2020-05-24', ),
(3, 'cloud_atlas.jpg', 'image/jpg', 3, '2020-05-24', ),
(4, 'no_time_to_die.jpg', 'image/jpg', 4, '2020-05-24', ),
(5, 'black_widow.jpg', 'image/jpg', 5, '2020-05-24', ),
(6, 'the_kings_man_le_origini.jpg', 'image/jpg', 6, '2020-05-24', ),
(7, 'the_new_mutants.jpg', 'image/jpg', 7, '2020-05-24', ),
(8, 'the_grudge.jpg', 'image/jpg', 8, '2020-05-24', );*/


INSERT INTO `SalaFisica`(`nSala`, `nFile`, `nPostiFila`, `disponibile`) VALUES (1,6,10,1), (2,5,9,1), (3,10,10,1), (4, 6, 11, 1);


INSERT INTO `Utenti`(`id`, `username`, `email`, `nome`, `cognome`, `password`, `isAdmin`) VALUES (1, 'bb3b', 'gianlucchio@mailer.com' , 'Gianluca', 'Lofrusanna', 'password', 0);


INSERT INTO `Proiezione`(`id`, `data`, `ora`, `numerosala`, `idFilm`) VALUES
(1, '2020-05-25', '16:00', 1, 8),
(2, '2020-05-25', '17:50', 1, 8),
(3, '2020-05-25', '21:00', 1, 8),
(4, '2020-05-26', '16:00', 1, 8),
(5, '2020-05-26', '17:50', 1, 8),
(6, '2020-05-26', '21:00', 1, 8),
(7, '2020-05-27', '16:00', 1, 8),
(8, '2020-05-27', '17:50', 1, 8),
(9, '2020-05-27', '21:00', 1, 8),
(10, '2020-05-28', '16:00', 1, 8),
(11, '2020-05-28', '17:50', 1, 8),
(12, '2020-05-28', '21:00', 1, 8),
(13, '2020-05-29', '16:00', 1, 8),
(14, '2020-05-29', '17:50', 1, 8),
(15, '2020-05-29', '21:00', 1, 8),
(16, '2020-05-30', '16:00', 1, 8),
(17, '2020-05-30', '17:50', 1, 8),
(18, '2020-05-30', '21:00', 1, 8),
(19, '2020-05-31', '16:00', 1, 8),
(20, '2020-05-31', '17:50', 1, 8),
(21, '2020-05-31', '21:00', 1, 8),
(22, '2020-05-25', '16:00', 2, 2),
(23, '2020-05-25', '17:50', 2, 2),
(24, '2020-05-25', '21:00', 2, 2),
(25, '2020-05-26', '16:00', 2, 2),
(26, '2020-05-26', '17:50', 2, 2),
(27, '2020-05-26', '21:00', 2, 2),
(28, '2020-05-27', '16:00', 2, 2),
(29, '2020-05-27', '17:50', 2, 2),
(30, '2020-05-27', '21:00', 2, 2),
(31, '2020-05-28', '16:00', 2, 2),
(32, '2020-05-28', '17:50', 2, 2),
(33, '2020-05-28', '21:00', 2, 2),
(34, '2020-05-29', '16:00', 2, 2),
(35, '2020-05-29', '17:50', 2, 2),
(36, '2020-05-29', '21:00', 2, 2),
(37, '2020-05-30', '16:00', 2, 2),
(38, '2020-05-30', '17:50', 2, 2),
(39, '2020-05-30', '21:00', 2, 2),
(40, '2020-05-31', '16:00', 2, 2),
(41, '2020-05-31', '17:50', 2, 2),
(42, '2020-05-31', '21:00', 2, 2);