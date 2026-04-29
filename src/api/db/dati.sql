-- ============================================
-- POPOLAMENTO root_db — Gruppo Scout AGESCI
-- ============================================

-- UNITA
INSERT INTO `Unita` (`id_unita`, `nome_unita`, `id_branca`) VALUES
(1, 'Branco Akela — Milano 12', 1),
(2, 'Cerchio Coccinelle — Milano 12', 2),
(3, 'Riparto Guide — Milano 12', 3),
(4, 'Reparto Esploratori — Milano 12', 4),
(5, 'Fuoco Rover — Milano 12', 5),
(6, 'Clan Scolte — Milano 12', 6),
(7, 'Clan RS — Milano 12', 7);

-- PERSONE (tutori prima, poi ragazzi)
INSERT INTO `Persona` (`id_persona`, `nome`, `cognome`, `data_nascita`, `luogo_nascita`, `citta_residenza`, `via_residenza`, `cap_residenza`, `telefono`, `id_tutore1`, `id_tutore2`) VALUES
(2,  'Marco',    'Bianchi',   '1975-03-12', 'Milano',  'Milano',  'Via Dante 5',            '20121', '3331122330', 2, NULL),
(3,  'Laura',    'Bianchi',   '1977-07-22', 'Torino',  'Milano',  'Via Dante 5',            '20121', '3471122440', 3, NULL),
(4,  'Giorgio',  'Ferrari',   '1970-11-05', 'Bergamo', 'Milano',  'Via Manzoni 18',         '20121', '3289988771', 4, NULL),
(5,  'Elena',    'Ferrari',   '1972-04-30', 'Brescia', 'Milano',  'Via Manzoni 18',         '20121', '3388877665', 5, NULL),
(6,  'Antonio', 'Conti',     '1968-09-18', 'Napoli',  'Milano',  'Corso Buenos Aires 3',   '20124', '3201234567', 6, NULL),
(7,  'Chiara',   'Conti',     '1971-02-14', 'Roma',    'Milano',  'Corso Buenos Aires 3',   '20124', '3497654321', 7, NULL),
(8,  'Sofia',    'Bianchi',   '2016-06-10', 'Milano',  'Milano',  'Via Dante 5',            '20121', '3331122330', 2, 3),
(9,  'Matteo',   'Bianchi',   '2014-08-23', 'Milano',  'Milano',  'Via Dante 5',            '20121', '3331122330', 2, 3),
(10, 'Giulia',   'Ferrari',   '2011-01-17', 'Milano',  'Milano',  'Via Manzoni 18',         '20121', 4, 5),
(11, 'Lorenzo',  'Ferrari',   '2008-05-03', 'Milano',  'Milano',  'Via Manzoni 18',         '20121', 4, 5),
(12, 'Alessia',  'Conti',     '2006-12-29', 'Milano',  'Milano',  'Corso Buenos Aires 3',   '20124', 6, 7),
(13, 'Riccardo', 'Conti',     '2003-09-11', 'Milano',  'Milano',  'Corso Buenos Aires 3',   '20124', 6, 7);

-- PAGAMENTI
INSERT INTO `Pagamento` (`id_pagamento`, `importo`, `metodo`, `data`) VALUES
(1,  120.00, 'Bonifico',  '2025-09-10'),
(2,  120.00, 'Contanti',  '2025-09-12'),
(3,  120.00, 'Bonifico',  '2025-09-15'),
(4,  120.00, 'Carta',     '2025-09-18'),
(5,  120.00, 'Contanti',  '2025-09-20'),
(6,  120.00, 'Bonifico',  '2025-09-22');

-- ISCRIZIONI 2025
INSERT INTO `Iscrizione` (`anno_associativo`, `approvazione_capo`, `id_persona`, `id_pagamento`, `id_unita`, `id_iter`) VALUES
(2025, 1, 8,  1, 2, 6),
(2025, 1, 9,  2, 1, 3),
(2025, 1, 10, 3, 3, 10),
(2025, 1, 11, 4, 4, 14),
(2025, 0, 12, 5, 6, 21),
(2025, 1, 13, 6, 7, 23);

-- TIPOLOGIE
INSERT INTO `Tipologia` (`id_tipologia`, `nome`, `descrizione`) VALUES
(1, 'Capo Unità',  'Responsabile della conduzione dell unità scout'),
(2, 'Assistente',  'Supporto alla conduzione delle attività'),
(3, 'Tesoriere',   'Gestione economica del gruppo'),
(4, 'Segretario',  'Gestione documentale e amministrativa');

-- SERVIZI
INSERT INTO `Servizio` (`descrizione`, `anno_associativo`, `id_persona`, `id_tipologia`, `id_unita`) VALUES
('Capo branco lupetti Milano 12', 2025, 2, 1, 1),
('Assistente cerchio coccinelle', 2025, 3, 2, 2),
('Capo riparto guide',            2025, 4, 1, 3),
('Capo reparto esploratori',      2025, 5, 1, 4),
('Tesoriere gruppo Milano 12',    2025, 6, 3, 7),
('Segretario clan RS',            2025, 7, 4, 7);

-- ATTIVITÀ
INSERT INTO `Attivita` (`id_attivita`, `nome`, `descrizione`, `luogo_partenza`, `luogo_arrivo`, `data`, `id_persona`) VALUES
(1, 'Campo Estivo Lupetti',   'Campo di una settimana in montagna per i lupetti',    'Milano, sede gruppo', 'Aprica, Val Camonica',   '2025-07-05', 2),
(2, 'Uscita Guide Autunno',   'Uscita di un giorno per attività di orientamento',     'Milano, sede gruppo', 'Parco del Ticino',       '2025-10-18', 4),
(3, 'Route Esploratori',      'Percorso a piedi di 3 giorni sulle Prealpi',           'Lecco',               'Piani Resinelli',        '2025-09-27', 5),
(4, 'Servizio Mensa Caritas',  'Servizio alla mensa della Caritas diocesana',          'Milano, sede gruppo', 'Milano, Caritas Diocesi', '2025-11-02', 13),
(5, 'Giornata Mondiale Scout', 'Celebrazione WOSM con tutte le unità del gruppo',     'Milano, sede gruppo', 'Parco Sempione',         '2025-02-22', 6);

-- PARTECIPA
INSERT INTO `Partecipa` (`id_attivita`, `id_unita`) VALUES
(1, 1),(2, 3),(3, 4),(4, 5),(4, 7),
(5, 1),(5, 2),(5, 3),(5, 4),(5, 5),(5, 6),(5, 7);

-- ACCOUNT
INSERT INTO `Account` (`username`, `email`, `password`, `id_persona`) VALUES
('marco.bianchi',   'marco.bianchi@gruppoMI12.it',   '$2y$10$hash_capo_branco',     2),
('laura.bianchi',   'laura.bianchi@gruppoMI12.it',   '$2y$10$hash_ass_cerchio',    3),
('giorgio.ferrari', 'giorgio.ferrari@gruppoMI12.it', '$2y$10$hash_capo_riparto',   4),
('elena.ferrari',   'elena.ferrari@gruppoMI12.it',   '$2y$10$hash_capo_reparto',  5),
('antonio.conti',   'antonio.conti@gruppoMI12.it',   '$2y$10$hash_tesoriere',      6),
('riccardo.conti',  'riccardo.conti@gruppoMI12.it',  '$2y$10$hash_rs_responsabile',13);