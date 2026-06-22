<?php
require __DIR__ . '/../db/databasehelper.php';

// EGLISE

// CREATE TABLE EGLISE (
//     ideglise VARCHAR(15) PRIMARY KEY,
//     Design VARCHAR(30),
//     Solde INT DEFAULT 0
// );

// creer une eglise
function createEglise($ideglise, $Design, $Solde): bool
{
    global $pdo;
    try {
        $sql = "INSERT INTO eglise(ideglise, Design, Solde) VALUES (:id ,:design ,:solde)";
        $result = $pdo->prepare($sql);
        $result->execute([':id' => $ideglise, ':design' => $Design, ':solde' => $Solde]);
        return true;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// afficher lse informations d'une eglise
function listeInfoEglise(): ?array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM eglise";
        $result = $pdo->prepare($sql);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return $row;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}

// ENTRE

// CREATE TABLE ENTRE (
//     identre INT AUTO_INCREMENT PRIMARY KEY,
//     ideglise VARCHAR(15),
//     motif VARCHAR(50) NOT NULL,
//     montantEntre INT,
//     dateEntre DATE DEFAULT (CURRENT_DATE),
//     FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
// )

// ajout d'une enregistrement dans l'ENTRE ()
function ajouterEntre($ideglise, $motif, $montantEntre, $dateEntre): bool
{
    global $pdo;
    try {
        $sql = "INSERT INTO entre (ideglise, motif, montantEntre, dateEntre)
                VALUES (:ideglise, :motif, :montantEntre, :dateEntre)";
        $result = $pdo->prepare($sql);
        return $result->execute([
            ':ideglise'    => $ideglise,
            ':motif'       => $motif,
            ':montantEntre' => $montantEntre,
            ':dateEntre'   => $dateEntre,
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Lister toute les enregistrements
function listeInfoEntre()
{
    global $pdo;
    try {
        $sql = "SELECT * FROM entre";
        $result = $pdo->prepare($sql);
        $result->execute();
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return $row;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}

function searchEntre(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantEntre', 'dateEntre', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("
        SELECT * FROM ENTRE 
        WHERE $category LIKE :query
    ");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// SORTIE

// CREATE TABLE SORTIE (
//     idsortie INT AUTO_INCREMENT PRIMARY KEY,
//     ideglise VARCHAR(15),
//     motif VARCHAR(50) NOT NULL,
//     montantSortie INT,
//     dateSortie DATE DEFAULT (CURRENT_DATE),
//     FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
// );


// ajout d'une enregistrement dans la SORTIE ()
function ajouterSortie($ideglise, $motif, $montantSortie, $dateSortie) :bool {
    global $pdo;
    try {
        $sql = "INSERT INTO sortie (ideglise, motif, montantSortie, dateSortie)
                VALUES (:ideglise, :motif, :montantSortie, :dateSortie)";
        $result = $pdo->prepare($sql);
        return $result->execute([
            ':ideglise'    => $ideglise,
            ':motif'       => $motif,
            ':montantSortie' => $montantSortie,
            ':dateSortie'   => $dateSortie,
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}


// lister tous les enregistrements
function listeInfoSortie()
{
    global $pdo;
    try {
        $sql = "SELECT * FROM sortie";
        $result = $pdo->prepare($sql);
        $result->execute();
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return $row;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}

function searchSortie(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantSortie', 'dateSortie', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("
        SELECT * FROM SORTIE 
        WHERE $category LIKE :query
    ");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}