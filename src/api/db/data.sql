USE root_db;

INSERT INTO `Account` (`username`, `email`, `password`, `id_persona`) VALUES
('antonio.conti', 'antonio.conti@gruppoMI12.it', 'Password5!', 5),
('elena.ferrari', 'elena.ferrari@gruppoMI12.it', 'Password4!', 4),
('francesca.neri', 'francesca.neri@gruppoMI12.it', 'Password2!', 8),
('giorgio.ferrari', 'giorgio.ferrari@gruppoMI12.it', 'Password3!', 3),
('riccardo.conti', 'riccardo.conti@gruppoMI12.it', 'Password6!', 14),
('roberto.sala', 'roberto.sala@gruppoMI12.it', 'Password1!', 7);

INSERT INTO `Attivita` (`id_attivita`, `nome`, `descrizione`, `luogo_partenza`, `luogo_arrivo`, `data`, `id_persona`) VALUES
(1, 'Campo Estivo Lupetti', 'Campo di una settimana in montagna per i lupetti', 'Milano, sede gruppo', 'Aprica, Val Camonica', '2025-07-05', 7),
(2, 'Uscita Guide Autunno', 'Uscita di un giorno per attività di orientamento', 'Milano, sede gruppo', 'Parco del Ticino', '2025-10-18', 3),
(3, 'Route Esploratori', 'Percorso a piedi di 3 giorni sulle Prealpi', 'Lecco', 'Piani Resinelli', '2025-09-27', 4),
(4, 'Servizio Mensa Caritas', 'Servizio alla mensa della Caritas diocesana', 'Milano, sede gruppo', 'Milano, Caritas Diocesi', '2025-11-02', 14),
(5, 'Giornata Mondiale Scout', 'Celebrazione WOSM con tutte le unità del gruppo', 'Milano, sede gruppo', 'Parco Sempione', '2025-02-22', 5);

INSERT INTO `Branca` (`id_branca`, `nome_branca`, `min_eta`, `max_eta`) VALUES
(1, 'Lupetti', 8, 11),
(2, 'Coccinelle', 8, 11),
(3, 'Guide', 12, 16),
(4, 'Esploratori', 12, 16),
(5, 'Rover', 16, 20),
(6, 'Scolte', 16, 20),
(7, 'RS', 21, 150);

INSERT INTO `Iscrizione` (`anno_associativo`, `approvazione_capo`, `id_persona`, `id_pagamento`, `id_unita`, `id_iter`) VALUES
(2025, 1, 9, 1, 2, 6),
(2025, 1, 10, 2, 1, 3),
(2025, 1, 11, 3, 3, 10),
(2025, 1, 12, 4, 4, 14),
(2025, 0, 13, 5, 6, 21),
(2025, 1, 14, 6, 7, 23);

INSERT INTO `Iter` (`id_iter`, `nome`, `descrizione`, `id_branca`) VALUES
(1, 'Cucciolo', NULL, 1),
(2, 'Zampa tenera', NULL, 1),
(3, '1° stella', NULL, 1),
(4, '2° stella', NULL, 1),
(5, 'Lupo anziano', NULL, 1),
(6, 'Cocci', NULL, 2),
(7, 'Coccinella', NULL, 2),
(8, 'Mughetto', NULL, 2),
(9, 'Genziana', NULL, 2),
(10, 'Gui', NULL, 3),
(11, 'Guida', NULL, 3),
(12, '1° classe', NULL, 3),
(13, '2° classe', NULL, 3),
(14, 'Novizio', NULL, 4),
(15, 'Piede tenero', NULL, 4),
(16, '2° classe', NULL, 4),
(17, '1° classe', NULL, 4),
(18, 'Esploratore scelto', NULL, 4),
(19, 'Novizio', NULL, 5),
(20, 'Rover', NULL, 5),
(21, 'Scolta viandante', NULL, 6),
(22, 'Scolta semplice', NULL, 6),
(23, 'Responsabile', NULL, 7);

INSERT INTO `Pagamento` (`id_pagamento`, `importo`, `metodo`, `data`) VALUES
(1, 120.00, 'Bonifico', '2025-09-10'),
(2, 120.00, 'Contanti', '2025-09-12'),
(3, 120.00, 'Bonifico', '2025-09-15'),
(4, 120.00, 'Carta', '2025-09-18'),
(5, 120.00, 'Contanti', '2025-09-20'),
(6, 120.00, 'Bonifico', '2025-09-22');

INSERT INTO `Partecipa` (`id_attivita`, `id_unita`) VALUES
(1, 1),
(5, 1),
(5, 2),
(2, 3),
(5, 3),
(3, 4),
(5, 4),
(4, 5),
(5, 5),
(5, 6),
(4, 7),
(5, 7);

INSERT INTO `Persona` (`id_persona`, `nome`, `cognome`, `data_nascita`, `luogo_nascita`, `citta_residenza`, `via_residenza`, `cap_residenza`, `telefono`, `id_tutore1`, `id_tutore2`) VALUES
(1, 'Marco', 'Bianchi', '1975-03-12', 'Milano', 'Milano', 'Via Dante 5', '20121', '3331122330', 1, NULL),
(2, 'Laura', 'Bianchi', '1977-07-22', 'Torino', 'Milano', 'Via Dante 5', '20121', '3471122440', 2, NULL),
(3, 'Giorgio', 'Ferrari', '1970-11-05', 'Bergamo', 'Milano', 'Via Manzoni 18', '20121', '3289988771', 3, NULL),
(4, 'Elena', 'Ferrari', '1972-04-30', 'Brescia', 'Milano', 'Via Manzoni 18', '20121', '3388877665', 4, NULL),
(5, 'Antonio', 'Conti', '1968-09-18', 'Napoli', 'Milano', 'Corso Buenos Aires 3', '20124', '3201234567', 5, NULL),
(6, 'Chiara', 'Conti', '1971-02-14', 'Roma', 'Milano', 'Corso Buenos Aires 3', '20124', '3497654321', 6, NULL),
(7, 'Roberto', 'Sala', '1982-06-20', 'Milano', 'Milano', 'Via Torino 22', '20123', '3351234567', 7, NULL),
(8, 'Francesca', 'Neri', '1985-11-08', 'Monza', 'Milano', 'Via Garibaldi 14', '20121', '3361234567', 8, NULL),
(9, 'Sofia', 'Bianchi', '2016-06-10', 'Milano', 'Milano', 'Via Dante 5', '20121', '3331122330', 1, 2),
(10, 'Matteo', 'Bianchi', '2014-08-23', 'Milano', 'Milano', 'Via Dante 5', '20121', '3331122330', 1, 2),
(11, 'Giulia', 'Ferrari', '2011-01-17', 'Milano', 'Milano', 'Via Manzoni 18', '20121', '3289988771', 3, 4),
(12, 'Lorenzo', 'Ferrari', '2008-05-03', 'Milano', 'Milano', 'Via Manzoni 18', '20121', '3289988771', 3, 4),
(13, 'Alessia', 'Conti', '2006-12-29', 'Milano', 'Milano', 'Corso Buenos Aires 3', '20124', '3201234567', 5, 6),
(14, 'Riccardo', 'Conti', '2003-09-11', 'Milano', 'Milano', 'Corso Buenos Aires 3', '20124', '3201234567', 5, 6);

INSERT INTO `Servizio` (`descrizione`, `anno_associativo`, `id_persona`, `id_tipologia`, `id_unita`) VALUES
('Capo riparto guide', 2026, 3, 1, 3),
('Capo reparto esploratori', 2026, 4, 1, 4),
('Tesoriere gruppo Milano 12', 2026, 5, 3, 7),
('Segretario clan RS', 2026, 6, 4, 7),
('Capo branco lupetti Milano 12', 2026, 7, 1, 1),
('Assistente cerchio coccinelle', 2026, 8, 2, 2);

INSERT INTO `Tipologia` (`id_tipologia`, `nome`, `descrizione`) VALUES
(1, 'Capo Unità', 'Responsabile della conduzione dell unità scout'),
(2, 'Assistente', 'Supporto alla conduzione delle attività'),
(3, 'Tesoriere', 'Gestione economica del gruppo'),
(4, 'Segretario', 'Gestione documentale e amministrativa');

INSERT INTO `Unita` (`id_unita`, `nome_unita`, `id_branca`) VALUES
(1, 'Branco Akela — Milano 12', 1),
(2, 'Cerchio Coccinelle — Milano 12', 2),
(3, 'Riparto Guide — Milano 12', 3),
(4, 'Reparto Esploratori — Milano 12', 4),
(5, 'Fuoco Rover — Milano 12', 5),
(6, 'Clan Scolte — Milano 12', 6),
(7, 'Clan RS — Milano 12', 7);


