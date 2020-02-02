/*
select pierwszeStudiaRokUkonczenia, count(pierwszeStudiaRokUkonczenia) 
from naukowiec
group by pierwszeStudiaRokUkonczenia
order by pierwszeStudiaRokUkonczenia 
*/

select ukonczoneStudiaCount, count(*) 
from naukowiec
group by ukonczoneStudiaCount
order by ukonczoneStudiaCount
;

select stopnieNaukoweCount, count(*) 
from naukowiec
group by stopnieNaukoweCount
order by stopnieNaukoweCount
;

select zatrudnienieCount, count(*) 
from naukowiec
group by zatrudnienieCount
order by zatrudnienieCount
;

--
-- Liczba profesorów (i innych stopni)
--
select count(*), profesuryCount
from naukowiec
where profesuryCount > 0
group by profesuryCount
;

select count(*), glownyStopienNaukowy
from naukowiec
group by glownyStopienNaukowy
order by glownyStopienNaukowy
;