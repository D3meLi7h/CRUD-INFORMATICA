-- ==========================================================
-- PREPARAZIONE DATABASE
-- ==========================================================
DROP DATABASE IF EXISTS Biblioteca_DB;
CREATE DATABASE Biblioteca_DB;
USE Biblioteca_DB;

-- ==========================================================
-- FASE 1: ARCHITETTURA (DDL)
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
    Email VARCHAR(100),
    Pw VARCHAR(20)
);

CREATE TABLE Autori (
    ID_Autore INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Nazionalita VARCHAR(50),
    Data_Nascita DATE
);

CREATE TABLE Categorie (
    Cod_Categoria INT PRIMARY KEY AUTO_INCREMENT,
    Nome_Categoria ENUM('Narrativa', 'Saggio', 'Manuale', 'Storico', 'Fantascienza', 'Horror', 'Giallo', 'Altro') NOT NULL,
    Descrizione TEXT
);

CREATE TABLE Libri (
    ID_Libro INT PRIMARY KEY AUTO_INCREMENT,
    Posizione VARCHAR(20) NOT NULL,
    Copie_disponibili INT DEFAULT 1 CHECK (Copie_disponibili >= 0),
    Titolo VARCHAR(100) NOT NULL,
    Descrizione TEXT NOT NULL,
    Anno_Pubblicazione INT NOT NULL,
    Numero_Pagine INT NOT NULL,
    Lingua_Originale VARCHAR(30) NOT NULL,
    ISBN VARCHAR(17) NOT NULL UNIQUE
);

-- Tabelle di Relazione
CREATE TABLE Libri_Autori (
    ID_Libro INT,
    ID_Autore INT,
    PRIMARY KEY (ID_Libro, ID_Autore),
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro) ON DELETE CASCADE,
    FOREIGN KEY (ID_Autore) REFERENCES Autori(ID_Autore) ON DELETE CASCADE
);

CREATE TABLE Prestiti (
    ID_Prestito INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,
    Data_Prestito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Data_Restituzione DATETIME,
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID_Utente) ON DELETE CASCADE,
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro) ON DELETE CASCADE
);

CREATE TABLE Recensioni (
    ID_Recensione INT PRIMARY KEY AUTO_INCREMENT,
    ID_Utente INT,
    ID_Libro INT,
    Testo_Recensione TEXT,
    Voto INT DEFAULT 1 CHECK (Voto BETWEEN 1 AND 5),
    Data_Recensione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID_Utente) ON DELETE CASCADE,
    FOREIGN KEY (ID_Libro) REFERENCES Libri(ID_Libro) ON DELETE CASCADE
);

-- ==========================================================
-- FASE 2: EVOLUZIONE (ALTER TABLE)
-- ==========================================================
ALTER TABLE Utenti ADD COLUMN Stato_Account ENUM('Attivo', 'Sospeso') DEFAULT 'Attivo';
ALTER TABLE Libri RENAME COLUMN Posizione TO Collocazione;
ALTER TABLE Utenti ADD CONSTRAINT UC_Email UNIQUE (Email);

-- ==========================================================
-- FASE 3: POPOLAMENTO DATI (DML)
-- ==========================================================

-- Utenti
INSERT INTO Utenti (Nome, Cognome, Genere, Data_Nascita, Tipo_Utente, Cod_Fis, Indirizzo, Citta, N_Telefono, Email, N_Carta_Identita) VALUES
('Marco', 'Rossi', 'M', '2005-05-20', 'Studente', 'RSSMRC05E20H501A', 'Via Roma 1', 'Milano', '333111', 'marco@mail.it', 'ID001'),
('Anna', 'Verdi', 'F', '1985-10-10', 'Docente', 'VRDNNA85R10F205B', 'Via Dante 10', 'Roma', '333222', 'anna@mail.it', 'ID002'),
('Luca', 'Santi', 'M', '2006-02-15', 'Studente', 'SNTLCU06B15L111C', 'Piazza Duomo 5', 'Milano', '333333', 'luca@mail.it', 'ID003'),
('Sofia', 'Neri', 'F', '1990-12-25', 'Altro', 'NRESFO90T25H501D', 'Via Liberta 3', 'Napoli', '333444', 'sofia@mail.it', 'ID004');

-- Autori e Categorie
INSERT INTO Autori (Nome, Cognome, Nazionalita) VALUES ('Italo', 'Calvino', 'Italiana'), ('George', 'Orwell', 'Britannica');
INSERT INTO Categorie (Nome_Categoria) VALUES ('Narrativa'), ('Fantascienza'), ('Saggio');

-- Libri (ID 1, 2, 3)
INSERT INTO Libri (Collocazione, Copie_disponibili, Titolo, Descrizione, Anno_Pubblicazione, Numero_Pagine, Lingua_Originale, ISBN) VALUES
('A1', 3, 'Il Barone Rampante', 'Classico', 1957, 250, 'Italiano', 'ISBN001'),
('B2', 5, '1984', 'Distopia', 1949, 328, 'Inglese', 'ISBN002'),
('C3', 1, 'Lezioni Americane', 'Saggio letterario', 1988, 150, 'Italiano', 'ISBN003');

-- Prestiti
INSERT INTO Prestiti (ID_Utente, ID_Libro, Data_Restituzione) VALUES 
(1, 1, '2024-03-20'), 
(1, 2, NULL),  -- Prestito attivo
(3, 2, NULL);  -- Prestito attivo

-- Recensioni
INSERT INTO Recensioni (ID_Utente, ID_Libro, Voto, Testo_Recensione) VALUES 
(1, 1, 5, 'Bellissimo!'), 
(2, 1, 4, 'Molto interessante'),
(3, 2, 5, 'Un capolavoro assoluto');

-- Operazioni DML aggiuntive richieste
UPDATE Libri SET Copie_disponibili = Copie_disponibili + 2 WHERE Titolo = '1984';
DELETE FROM Recensioni WHERE Voto < 2;

-- ==========================================================
-- FASE 4: ANALISI DATI (LE 15 QUERY)
-- ==========================================================

-- --- SEZIONE A: FILTRI ---
-- 1.
SELECT * FROM Libri WHERE Anno_Pubblicazione BETWEEN 2010 AND 2024;
-- 2.
SELECT Nome, Cognome FROM Utenti WHERE Tipo_Utente <> 'Studente' AND Citta = 'Roma';
-- 3.
SELECT Titolo FROM Libri WHERE Numero_Pagine > 400;
-- 4.
SELECT Titolo FROM Libri WHERE Lingua_Originale IN ('Inglese', 'Francese');
-- 5.
SELECT * FROM Autori WHERE Cognome LIKE 'S%';

-- --- SEZIONE B: JOIN ---
-- 6.
SELECT L.Titolo, A.Cognome FROM Libri_Autori LA JOIN Libri L ON LA.ID_Libro = L.ID_Libro JOIN Autori A ON LA.ID_Autore = A.ID_Autore;
-- 7.
SELECT U.Cognome, L.Titolo FROM Prestiti P JOIN Utenti U ON P.ID_Utente = U.ID_Utente JOIN Libri L ON P.ID_Libro = L.ID_Libro WHERE P.Data_Restituzione IS NULL;
-- 8.
SELECT U.Nome, L.Titolo, R.Voto FROM Recensioni R JOIN Utenti U ON R.ID_Utente = U.ID_Utente JOIN Libri L ON R.ID_Libro = L.ID_Libro;
-- 9. (Nota: Assumendo legame logico o tabella Libri_Categorie se presente)
SELECT L.Titolo, C.Nome_Categoria FROM Libri L, Categorie C WHERE L.ID_Libro = 1 AND C.Cod_Categoria = 1; 
-- 10.
SELECT U.Nome, L.Titolo, P.Data_Prestito FROM Prestiti P JOIN Utenti U ON P.ID_Utente = U.ID_Utente JOIN Libri L ON P.ID_Libro = L.ID_Libro WHERE U.Tipo_Utente = 'Studente';

-- --- SEZIONE C: AGGREGAZIONI ---
-- 11.
SELECT L.Titolo, AVG(R.Voto) FROM Recensioni R JOIN Libri L ON R.ID_Libro = L.ID_Libro GROUP BY L.Titolo;
-- 12.
SELECT L.Titolo, COUNT(R.ID_Recensione) FROM Recensioni R JOIN Libri L ON R.ID_Libro = L.ID_Libro GROUP BY L.Titolo HAVING COUNT(R.ID_Recensione) >= 1;
-- 13.
SELECT C.Nome_Categoria, COUNT(L.ID_Libro) FROM Libri L, Categorie C GROUP BY C.Nome_Categoria;
-- 14.
SELECT ID_Utente, COUNT(*) FROM Prestiti GROUP BY ID_Utente ORDER BY COUNT(*) DESC LIMIT 1;
-- 15.
SELECT SUM(Copie_disponibili) AS Totale_Copie FROM Libri;
