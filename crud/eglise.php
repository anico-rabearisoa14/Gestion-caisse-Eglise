<?php
require __DIR__ . '/../db/databasehelper.php';

// EGLISE

// CREATE TABLE EGLISE (
//     ideglise VARCHAR(15) PRIMARY KEY,
//     Design VARCHAR(30),
//     Solde INT DEFAULT 0
// );

function createEglise($ideglise, $Design, $Solde): bool
{
    global $pdo;
    try {
        $sql = "INSERT INTO eglise(ideglise, Design, Solde) VALUES (:id, :design, :solde)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $ideglise, ':design' => $Design, ':solde' => $Solde]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function listeInfoEglise() : ?array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM eglise";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rows ?: null;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

function misAJourEglise($ideglise, $Design, $Solde): array
{
    global $pdo;
    try {
        $sql = 'UPDATE eglise
                SET Design = :design,
                    Solde  = :solde
                WHERE ideglise = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':id' => $ideglise, ':design' => $Design, ':solde' => $Solde])) {
            return ['success' => false, 'message' => 'Erreur de mise à jour'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Mise à jour réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de mise à jour : ' . $e->getMessage()];
    }
}

function supprimerEglise($ideglise): array
{
    global $pdo;
    try {
        $sql = 'DELETE FROM eglise WHERE ideglise = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':id' => $ideglise])) {
            return ['success' => false, 'message' => 'Erreur de suppression'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Suppression réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de suppression : ' . $e->getMessage()];
    }
}

function searchEglise(string $query): array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM eglise WHERE Design LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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


 // creer une nouvelle enregistrement
function ajouterEntre($ideglise, $motif, $montantEntre, $dateEntre): bool
{
    global $pdo;
    try {
        $sql = "INSERT INTO entre (ideglise, motif, montantEntre, dateEntre)
                VALUES (:ideglise, :motif, :montantEntre, :dateEntre)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':ideglise'     => $ideglise,
            ':motif'        => $motif,
            ':montantEntre' => $montantEntre,
            ':dateEntre'    => $dateEntre,
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}


 // lister tous les enregistrements
function listeInfoEntre(): ?array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM entre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: null;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}


 // mettre a jour
function misAJourEntre($id, $ideglise, $motif, $montantEntre, $dateEntre): array
{
    global $pdo;
    try {
        $sql = 'UPDATE entre
                SET ideglise     = :ideglise,
                    motif        = :motif,
                    montantEntre = :montantEntre,
                    dateEntre    = :dateEntre
                WHERE identre = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([
            ':id'           => $id,
            ':ideglise'     => $ideglise,
            ':motif'        => $motif,
            ':montantEntre' => $montantEntre,
            ':dateEntre'    => $dateEntre,
        ])) {
            return ['success' => false, 'message' => 'Erreur de mise à jour'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Mise à jour réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de mise à jour : ' . $e->getMessage()];
    }
}

// supprimer
function supprimerEntre($id): array
{
    global $pdo;
    try {
        $sql = 'DELETE FROM entre WHERE identre = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':id' => $id])) {
            return ['success' => false, 'message' => 'Erreur de suppression'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Suppression réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de suppression : ' . $e->getMessage()];
    }
}

 // recherche d'une enregistrement
function searchEntre(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantEntre', 'dateEntre', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("SELECT * FROM entre WHERE $category LIKE :query");
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


 // creer une nouvelle enregistrement
function ajouterSortie($ideglise, $motif, $montantSortie, $dateSortie): bool
{
    global $pdo;
    try {
        $sql = "INSERT INTO sortie (ideglise, motif, montantSortie, dateSortie)
                VALUES (:ideglise, :motif, :montantSortie, :dateSortie)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':ideglise'      => $ideglise,
            ':motif'         => $motif,
            ':montantSortie' => $montantSortie,
            ':dateSortie'    => $dateSortie,
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

 // lire tous
function listeInfoSortie(): ?array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM sortie";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: null;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}
 
 // mis ajour
function misAJourSortie($id, $ideglise, $motif, $montantSortie, $dateSortie): array
{
    global $pdo;
    try {
        $sql = 'UPDATE sortie
                SET ideglise      = :ideglise,
                    motif         = :motif,
                    montantSortie = :montantSortie,
                    dateSortie    = :dateSortie
                WHERE idsortie = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([
            ':id'            => $id,
            ':ideglise'      => $ideglise,
            ':motif'         => $motif,
            ':montantSortie' => $montantSortie,
            ':dateSortie'    => $dateSortie,
        ])) {
            return ['success' => false, 'message' => 'Erreur de mise à jour'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Mise à jour réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de mise à jour : ' . $e->getMessage()];
    }
}

 // supprimer une sortie
function supprimerSortie($id): array
{
    global $pdo;
    try {
        $sql = 'DELETE FROM sortie WHERE idsortie = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':id' => $id])) {
            return ['success' => false, 'message' => 'Erreur de suppression'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'message' => 'Suppression réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de suppression : ' . $e->getMessage()];
    }
}


// recherche d'une enregistrement
function searchSortie(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantSortie', 'dateSortie', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("SELECT * FROM sortie WHERE $category LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
