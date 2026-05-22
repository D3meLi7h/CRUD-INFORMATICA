-- ==========================================================
-- DATABASE
-- ==========================================================
DROP DATABASE IF EXISTS Biblioteca_DB;
CREATE DATABASE Biblioteca_DB;
USE Biblioteca_DB;

-- ==========================================================
-- UTENTI
-- ==========================================================
CREATE TABLE Utenti (
    ID_Utente INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Genere ENUM('M', 'F', 'Altro') NOT NULL,
    Data_Nascita DATE NOT NULL,
    Tipo_Utente ENUM('Studente', 'Docente', 'Altro') NOT NULL,
    Indirizzo VARCHAR(100) NOT NULL,
    Citta VARCHAR(50) NOT NULL,
    N_Telefono VARCHAR(20) NOT NULL,
    Email VARCHAR(100) UNIQUE,
    Pw VARCHAR(20) NOT NULL,
    Nickname VARCHAR(50) NOT NULL,
);

-- ==========================================================
-- AUTORI
-- ==========================================================
CREATE TABLE Autori (
    ID_Autore INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Nazionalita VARCHAR(50),
    Data_Nascita DATE
);

-- ==========================================================
-- CATEGORIE (GENERI)
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
-- LIBRI (CON COLLEGAMENTO CATEGORIA FIXATO)
-- ==========================================================
CREATE TABLE Libri (
    ID_Libro INT PRIMARY KEY AUTO_INCREMENT,
    Posizione VARCHAR(20) NOT NULL,
    Copie_disponibili INT DEFAULT 1,
    Titolo VARCHAR(100) NOT NULL,
    Descrizione TEXT,
    Anno_Pubblicazione INT NOT NULL,
    Numero_Pagine INT NOT NULL,
    Lingua_Originale VARCHAR(30) NOT NULL,
    ISBN VARCHAR(17) NOT NULL UNIQUE,
    Cod_Categoria INT,
    FOREIGN KEY (Cod_Categoria) REFERENCES Categorie(Cod_Categoria)
);

-- ==========================================================
-- LIBRI-AUTORI
-- ==========================================================
CREATE TABLE Libri_Autori (
    ID_Libro INT,
    ID_Autore INT,
    PRIMARY KEY (ID_Libro, ID_Autore),
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro) ON DELETE CASCADE,
    FOREIGN KEY (ID_Autore) REFERENCES Autori(ID_Autore) ON DELETE CASCADE
);

-- ==========================================================
-- PRESTITI
-- ==========================================================
CREATE TABLE Prestiti (
    ID_Prestito INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,
    Data_Prestito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Data_Restituzione DATETIME,
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID_Utente),
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro)
);

-- ==========================================================
-- RECENSIONI
-- ==========================================================
CREATE TABLE Recensioni (
    ID_Recensione INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,
    Testo_Recensione TEXT,
    Voto INT CHECK (Voto BETWEEN 1 AND 5),
    Data_Recensione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID_Utente),
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro)
);

-- ==========================================================
-- Utenti INSERT
-- ==========================================================
INSERT INTO Utenti
(Nome,Cognome,Genere,Data_Nascita,Tipo_Utente,Indirizzo,Citta,N_Telefono,Email,Nickname,Pw) VALUES
('Mario','Rossi','M','2005-04-15','Studente','Via Roma 10','Roma','3331234567','mario.rossi@email.com','mario.rossi','123456');

-- ==========================================================
-- Categorie
-- ==========================================================
INSERT INTO Categorie (Genere_Libro, Descrizione) VALUES
('Narrativa', 'Romanzi e racconti'),
('Fantascienza', 'Futuro e tecnologia'),
('Saggio', 'Testi analitici'),
('Storico', 'Eventi storici e romanzi storici');

-- ==========================================================
-- AUTORI
-- ==========================================================
INSERT INTO Autori (Nome, Cognome, Nazionalita, Data_Nascita) VALUES
('Italo', 'Calvino', 'Italiana', '1923-10-15'),
('George', 'Orwell', 'Britannica', '1903-06-25'),
('Umberto', 'Eco', 'Italiana', '1932-01-05');

-- ==========================================================
-- LIBRI (INCLUSI 3 STORICI)
-- ==========================================================
INSERT INTO Libri
(Posizione, Copie_disponibili, Titolo, Descrizione, Anno_Pubblicazione, Numero_Pagine, Lingua_Originale, ISBN, Cod_Categoria)
VALUES

-- Narrativa
('A1', 3, 'Il Barone Rampante', 'Classico italiano', 1957, 250, 'Italiano', 'ISBN001', 1),

-- Fantascienza
('B2', 5, '1984', 'Distopia politica', 1949, 328, 'Inglese', 'ISBN002', 2),

-- Saggio
('C3', 1, 'Lezioni Americane', 'Saggio letterario', 1988, 150, 'Italiano', 'ISBN003', 3),

-- ==========================================================
-- LIBRI STORICI (NUOVI 3)
-- ==========================================================

('D1', 2, 'I Promessi Sposi', 'Romanzo storico ambientato nel 1600', 1827, 720, 'Italiano', 'ISBN004', 4),

('D2', 4, 'Il Nome della Rosa', 'Mistero medievale in un monastero', 1980, 500, 'Italiano', 'ISBN005', 4),

('D3', 3, 'La Storia', 'Romanzo sulla Seconda Guerra Mondiale', 1974, 600, 'Italiano', 'ISBN006', 4);

-- ==========================================================
-- RELAZIONE AUTORI-LIBRI
-- ==========================================================
INSERT INTO Libri_Autori VALUES
(1,1),
(2,2),
(3,3),
(4,1),
(5,3),
(6,3);

-- ==========================================================
-- PRESTITI
-- ==========================================================
INSERT INTO Prestiti (ID_Utente, ID_Libro, Data_Restituzione) VALUES
(1, 1, '2024-03-20'),
(1, 2, NULL),
(3, 2, NULL);

-- ==========================================================
-- RECENSIONI
-- ==========================================================
INSERT INTO Recensioni (ID_Utente, ID_Libro, Voto, Testo_Recensione) VALUES
(1, 1, 5, 'Bellissimo!'),
(2, 1, 4, 'Molto interessante'),
(3, 2, 5, 'Capolavoro');
