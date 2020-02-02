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