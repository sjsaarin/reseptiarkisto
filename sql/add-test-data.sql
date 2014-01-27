
INSERT INTO kategoriat (nimi)
VALUES ('Pääruoka');
INSERT INTO kategoriat (nimi)
VALUES ('Jälkiruoka');

INSERT INTO raakaaineet (nimi, kalorit, hiilarit, proteiinit, rasvat, hinta)
VALUES ('Vesi',0,0,0,0,0);
INSERT INTO raakaaineet (nimi)
VALUES ('Jauho');
INSERT INTO raakaaineet (nimi)
VALUES ('Hiiva');
INSERT INTO raakaaineet (nimi)
VALUES ('Suola');

INSERT INTO kayttajat (etunimi, sukunimi, kayttajatunnus, salasana, rooli) 
VALUES ('Foo','Bar','admin','qwertyui',1);

INSERT into reseptit (nimi, valmistusohje)
VALUES('Leipä','Sekoita aineet, paista uunissa');

INSERT into reseptin_raakaaineet
VALUES(1,1,1,'dl');

INSERT into reseptin_raakaaineet
VALUES(1,2,1,'dl');

INSERT into reseptin_raakaaineet
VALUES(1,3,20,'g');

INSERT into reseptin_raakaaineet
VALUES(1,4,1,'tl');