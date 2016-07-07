/*Datenbank user in der Kuenstler-DB*/
GRANT USAGE ON *.* 
TO kueawi4_gast@"%" IDENTIFIED BY "awi_gast_ALL";
GRANT USAGE ON *.* 
TO kueawi4_gast@"localhost" IDENTIFIED BY "awi_gast_ALL";
--Berechtigugnen für Gast
GRANT SELECT ()
ON awi4_kuenstler_db.bilder