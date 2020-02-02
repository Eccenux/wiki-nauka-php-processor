/**
 * Author:  Maciej Nux Jaros
 * Created: 2020-02-02
 */

DROP TABLE IF EXISTS naukowiec;

CREATE TABLE naukowiec (
	np_id	bigint,
	pierwszeStudiaRokUkonczenia	varchar(10),
	imie1	varchar(100),
	imie2	varchar(100),
	nazwisko	varchar(200),
	glownyStopienNaukowy	varchar(100),
	pelenTytul	varchar(1000),
	specjalnosci	varchar(8000),
	klasyfikacjaKbn	varchar(1000),

	zatrudnienieCount int,
	pelnioneFunkcjeCount int,
	czlonkostwoCount int,
	ukonczoneStudiaCount int,
	profesuryCount int,
	praceBadawczeCount int,
	stopnieNaukoweCount int,
	publikacjeCount int,

	PRIMARY KEY (np_id)
);
/*
CREATE NONCLUSTERED INDEX edits_a ON admin_pre_edits (actor_id);
CREATE NONCLUSTERED INDEX edits_an ON admin_pre_edits (actor_id, page_namespace);
CREATE NONCLUSTERED INDEX edits_ean ON admin_pre_edits (edit_type, actor_id, page_namespace);
*/

--
-- Test
--
/*
INSERT INTO naukowiec (np_id
, pierwszeStudiaRokUkonczenia
, imie1, imie2, nazwisko
, glownyStopienNaukowy, pelenTytul
, specjalnosci, klasyfikacjaKbn
, zatrudnienieCount, pelnioneFunkcjeCount, czlonkostwoCount, ukonczoneStudiaCount, profesuryCount, praceBadawczeCount, stopnieNaukoweCount, publikacjeCount
) VALUES
(123, '123', 'Kaja', '', 'D''Artagnan', 'prof.', 'prof. dr hab. inż.', 'geofizyka stosowana', 'górnictwo i geologia inżynierska', 2, 4, 2, 2, 1, 19, 0, 2)
;
*/