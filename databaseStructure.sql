CREATE TABLE EGLISE (
    ideglise VARCHAR(15) PRIMARY KEY,
    Design VARCHAR(30),
    Solde INT DEFAULT 0
);

CREATE TABLE ENTRE (
    identre INT AUTO_INCREMENT PRIMARY KEY,
    ideglise VARCHAR(15),
    motif VARCHAR(50) NOT NULL,
    montantEntre INT,
    dateEntre DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
);

CREATE TABLE SORTIE (
    idsortie INT AUTO_INCREMENT PRIMARY KEY,
    ideglise VARCHAR(15),
    motif VARCHAR(50) NOT NULL,
    montantSortie INT,
    dateSortie DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
);

DELIMITER $$
-- update solde after all actions

CREATE TRIGGER ajouter_dans_solde
AFTER INSERT ON ENTRE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde + NEW.montantEntre
    WHERE ideglise = NEW.ideglise;
END$$

CREATE TRIGGER retirer_du_solde
AFTER INSERT ON SORTIE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde - NEW.montantSortie
    WHERE ideglise = NEW.ideglise;
END$$

CREATE TRIGGER modifier_solde_entre
AFTER UPDATE ON ENTRE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde - OLD.montantEntre + NEW.montantEntre
    WHERE ideglise = NEW.ideglise;
END$$

CREATE TRIGGER modifier_solde_sortie
AFTER UPDATE ON SORTIE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde + OLD.montantSortie - NEW.montantSortie
    WHERE ideglise = NEW.ideglise;
END$$

CREATE TRIGGER supprimer_dans_solde
AFTER DELETE ON ENTRE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde - OLD.montantEntre
    WHERE ideglise = OLD.ideglise;
END$$

CREATE TRIGGER supprimer_du_solde
AFTER DELETE ON SORTIE
FOR EACH ROW
BEGIN
    UPDATE EGLISE
    SET Solde = Solde + OLD.montantSortie
    WHERE ideglise = OLD.ideglise;
END$$

DELIMITER ;