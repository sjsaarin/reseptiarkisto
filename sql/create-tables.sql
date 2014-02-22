
CREATE TABLE kayttajat
(
    id SERIAL PRIMARY KEY,
    etunimi varchar(30),
    sukunimi varchar(30),
    kayttajatunnus varchar(8) NOT NULL UNIQUE,
    salasana varchar(128) NOT NULL,
    rooli INTEGER NOT NULL
);

CREATE TABLE raakaaineet
(
    id SERIAL PRIMARY KEY,
    nimi varchar(30) NOT NULL,
    kalorit numeric(6,2),
    hiilarit numeric(6,2),
    proteiinit numeric(6,2),
    rasvat numeric(6,2),
    hinta numeric(6,2),
    tiheys numeric(6,2),
    kpl_paino numeric(6,2)
);

CREATE TABLE kategoriat
(
    id SERIAL PRIMARY KEY,
    nimi varchar(20) NOT NULL
);

CREATE TABLE reseptit
(
    id SERIAL PRIMARY KEY,
    nimi varchar(30) NOT NULL,
    kategoria INTEGER REFERENCES kategoriat(id),
    omistaja INTEGER REFERENCES kayttajat(id),
    paaraakaaine INTEGER REFERENCES raakaaineet(id),
    annoksia INTEGER,
    lahde varchar(100),
    juomasuositus varchar(100),
    valmistusohje varchar(3000)
);

CREATE TABLE reseptin_raakaaineet
(
    reseptin_id INTEGER REFERENCES reseptit(id) ON UPDATE CASCADE ON DELETE CASCADE,
    raakaaineen_id INTEGER REFERENCES raakaaineet(id) ON UPDATE CASCADE,
    maara INTEGER NOT NULL,
    yksikko varchar(10) NOT NULL,
    CONSTRAINT reseptin_raakaineet_pkey PRIMARY KEY (reseptin_id, raakaaineen_id)
);


CREATE TABLE kuvat
(
    id SERIAL PRIMARY KEY,
    reseptin_id INTEGER REFERENCES reseptit(id) NOT NULL,
    kuva bytea NOT NULL
);


CREATE TABLE menut
(
    id SERIAL PRIMARY KEY,
    nimi varchar(30) NOT NULL,
    alkuruoka INTEGER REFERENCES reseptit(id) ON DELETE CASCADE,
    valiruoka1 INTEGER REFERENCES reseptit(id) ON DELETE CASCADE,
    paaruoka INTEGER REFERENCES reseptit(id) ON DELETE CASCADE,
    valiruoka2 INTEGER REFERENCES reseptit(id) ON DELETE CASCADE,
    jalkiruoka INTEGER REFERENCES reseptit(id) ON DELETE CASCADE,
    kuvaus varchar(500)
);