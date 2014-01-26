
CREATE TABLE Kayttajat
(
    ID SERIAL PRIMARY KEY,
    EtuNimi varchar(30),
    SukuNimi varchar(30),
    Kayttajatunnus varchar(8) NOT NULL,
    Salasana varchar(128) NOT NULL,
    Rooli INTEGER NOT NULL
);

CREATE TABLE Raakaaineet
(
    ID SERIAL PRIMARY KEY,
    Nimi varchar(30) NOT NULL,
    Kalorit INTEGER,
    Hiilarit INTEGER,
    Proteiinit INTEGER,
    Rasvat INTEGER,
    Hinta INTEGER
);

CREATE TABLE Kategoriat
(
    ID SERIAL PRIMARY KEY,
    Nimi varchar(20) NOT NULL
);

CREATE TABLE Reseptit
(
    ID SERIAL PRIMARY KEY,
    Nimi varchar(30) NOT NULL,
    Kategoria INTEGER REFERENCES Kategoriat(ID),
    Omistaja INTEGER REFERENCES Kayttajat(ID),
    Juomasuositus varchar(50),
    Valmistusohje varchar(3000)
);

CREATE TABLE ReseptinRaakaaineet
(
    ReseptinID INTEGER REFERENCES Reseptit(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    RaakaaineenID INTEGER REFERENCES Raakaineet(ID) ON UPDATE CASCADE,
    CONSTRAINT ReseptinRaakaineetPK PRIMARY KEY (ReseptinID, RaakaaineenID)
);


CREATE TABLE Kuvat
(
    ID SERIAL PRIMARY KEY,
    Kuva bytea NOT NULL
);

CREATE TABLE ReseptinKuvat
(
    ReseptinID INTEGER REFERENCES Reseptit(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    KuvanID INTEGER REFERENCES Raakaineet(ID) ON UPDATE CASCADE,
    CONSTRAINT ReseptinKuvatPK PRIMARY KEY (ReseptinID, KuvanID)
);


CREATE TABLE Menut
(
    ID SERIAL PRIMARY KEY,
    Alkuruoka INTEGER REFERENCES Reseptit(ID),
    Valiruoka1 INTEGER REFERENCES Reseptit(ID),
    Paaruoka INTEGER REFERENCES Reseptit(ID),
    Valiruoka2 INTEGER REFERENCES Reseptit(ID),
    Jalkiruoka INTEGER REFERENCES Reseptit(ID)
);