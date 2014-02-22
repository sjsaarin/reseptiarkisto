
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