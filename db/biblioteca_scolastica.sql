-- ==========================================================
-- DATABASE
-- ==========================================================
DROP DATABASE IF EXISTS Biblioteca_DB;
CREATE DATABASE Biblioteca_DB;
USE Biblioteca_DB;

-- ==========================================================
-- TABELLA UTENTI
-- ==========================================================
CREATE TABLE Utenti (
    ID_Utente INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Pw VARCHAR(255) NOT NULL,
    Genere ENUM('M', 'F', 'Altro') NOT NULL,
    Data_Nascita DATE NOT NULL,
    Tipo_Utente ENUM('Studente', 'Docente', 'Altro') NOT NULL,
    Indirizzo VARCHAR(100) NOT NULL,
    Citta VARCHAR(50) NOT NULL,
    N_Telefono VARCHAR(20) NOT NULL,
    Email VARCHAR(100) UNIQUE
);

-- ==========================================================
-- TABELLA AUTORI
-- ==========================================================
CREATE TABLE Autori (
    ID_Autore INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Nazionalita VARCHAR(50),
    Data_Nascita DATE
);

-- ==========================================================
-- TABELLA CATEGORIE
-- ==========================================================
CREATE TABLE Categorie (
    Cod_Categoria INT PRIMARY KEY AUTO_INCREMENT,
    Genere_Libro ENUM(
        'Narrativa',
        'Saggio',
        'Manuale',
        'Storico',
        'Fantascienza',
        'Horror',
        'Giallo',
        'Altro'
    ) NOT NULL,
    Descrizione TEXT
);

-- ==========================================================
-- TABELLA LIBRI
-- ==========================================================
CREATE TABLE Libri (
    ID_Libro INT PRIMARY KEY AUTO_INCREMENT,
    Posizione VARCHAR(20) NOT NULL,
    Copie_Disponibili INT DEFAULT 1 CHECK (Copie_Disponibili >= 0),
    Titolo VARCHAR(100) NOT NULL,
    Descrizione TEXT,
    Anno_Pubblicazione INT NOT NULL,
    Numero_Pagine INT NOT NULL,
    Lingua_Originale VARCHAR(30) NOT NULL,
    ISBN CHAR(13) NOT NULL UNIQUE,
    Cod_Categoria INT,
    
    FOREIGN KEY (Cod_Categoria)
        REFERENCES Categorie(Cod_Categoria)
);

-- ==========================================================
-- TABELLA LIBRI_AUTORI
-- ==========================================================
CREATE TABLE Libri_Autori (
    ID_Libro INT,
    ID_Autore INT,

    PRIMARY KEY (ID_Libro, ID_Autore),

    FOREIGN KEY (ID_Libro)
        REFERENCES Libri(ID_Libro)
        ON DELETE CASCADE,

    FOREIGN KEY (ID_Autore)
        REFERENCES Autori(ID_Autore)
        ON DELETE CASCADE
);

-- ==========================================================
-- TABELLA PRESTITI
-- ==========================================================
CREATE TABLE Prestiti (
    ID_Prestito INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,

    Data_Prestito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Data_Scadenza DATE,
    Data_Restituzione DATETIME,

    FOREIGN KEY (ID_Utente)
        REFERENCES Utenti(ID_Utente),

    FOREIGN KEY (ID_Libro)
        REFERENCES Libri(ID_Libro)
);

-- ==========================================================
-- TABELLA RECENSIONI
-- ==========================================================
CREATE TABLE Recensioni (
    ID_Recensione INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,

    Testo_Recensione TEXT,

    Voto INT CHECK (Voto BETWEEN 1 AND 5),

    Data_Recensione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (ID_Utente)
        REFERENCES Utenti(ID_Utente),

    FOREIGN KEY (ID_Libro)
        REFERENCES Libri(ID_Libro)
);

-- ==========================================================
-- INSERT UTENTI
-- ==========================================================
INSERT INTO Utenti
(Nome, Cognome, Username, Pw, Genere, Data_Nascita,
 Tipo_Utente, Indirizzo, Citta, N_Telefono, Email)
VALUES

('Mario', 'Rossi', 'mrossi', 'pass123', 'M',
 '2000-05-10', 'Studente',
 'Via Roma 10', 'Roma',
 '3331112222', 'mario.rossi@email.com'),

('Laura', 'Bianchi', 'lbianchi', 'pass456', 'F',
 '1998-08-22', 'Docente',
 'Via Milano 20', 'Milano',
 '3332223333', 'laura.bianchi@email.com'),

('Giuseppe', 'Verdi', 'gverdi', 'pass789', 'M',
 '1995-11-15', 'Altro',
 'Via Napoli 5', 'Napoli',
 '3334445555', 'giuseppe.verdi@email.com');

-- ==========================================================
-- INSERT CATEGORIE
-- ==========================================================
INSERT INTO Categorie (Genere_Libro, Descrizione)
VALUES
('Narrativa', 'Romanzi e racconti'),
('Fantascienza', 'Futuro e tecnologia'),
('Saggio', 'Testi analitici'),
('Storico', 'Eventi storici e romanzi storici');

-- ==========================================================
-- INSERT AUTORI
-- ==========================================================
INSERT INTO Autori
(Nome, Cognome, Nazionalita, Data_Nascita)
VALUES

('Italo', 'Calvino', 'Italiana', '1923-10-15'),

('George', 'Orwell', 'Britannica', '1903-06-25'),

('Umberto', 'Eco', 'Italiana', '1932-01-05');

-- ==========================================================
-- INSERT LIBRI
-- ==========================================================
INSERT INTO Libri
(Posizione, Copie_Disponibili, Titolo, Descrizione,
 Anno_Pubblicazione, Numero_Pagine,
 Lingua_Originale, ISBN, Cod_Categoria)
VALUES

('A1', 3, 'Il Barone Rampante',
 'Classico italiano',
 1957, 250,
 'Italiano', '9780000000001', 1),

('B2', 5, '1984',
 'Distopia politica',
 1949, 328,
 'Inglese', '9780000000002', 2),

('C3', 1, 'Lezioni Americane',
 'Saggio letterario',
 1988, 150,
 'Italiano', '9780000000003', 3),

('D1', 2, 'I Promessi Sposi',
 'Romanzo storico ambientato nel 1600',
 1827, 720,
 'Italiano', '9780000000004', 4),

('D2', 4, 'Il Nome della Rosa',
 'Mistero medievale in un monastero',
 1980, 500,
 'Italiano', '9780000000005', 4),

('D3', 3, 'La Storia',
 'Romanzo sulla Seconda Guerra Mondiale',
 1974, 600,
 'Italiano', '9780000000006', 4);

-- ==========================================================
-- INSERT LIBRI_AUTORI
-- ==========================================================
INSERT INTO Libri_Autori
(ID_Libro, ID_Autore)
VALUES

(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 3),
(6, 3);

-- ==========================================================
-- INSERT PRESTITI
-- ==========================================================
INSERT INTO Prestiti
(ID_Utente, ID_Libro, Data_Scadenza, Data_Restituzione)
VALUES

(1, 1, '2024-03-25', '2024-03-20'),

(1, 2, '2024-04-01', NULL),

(3, 2, '2024-04-05', NULL);

-- ==========================================================
-- INSERT RECENSIONI
-- ==========================================================
INSERT INTO Recensioni
(ID_Utente, ID_Libro, Voto, Testo_Recensione)
VALUES

(1, 1, 5, 'Bellissimo!'),

(2, 1, 4, 'Molto interessante'),

(3, 2, 5, 'Capolavoro');
