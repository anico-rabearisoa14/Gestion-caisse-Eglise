<?php
require __DIR__ . '/../db/databasehelper.php';
// require __DIR__ . '/../init.php';

function getTotalAmount()
{
    global $pdo;
    $sql = "SELECT * FROM eglise";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $montantTotal = $rows['Solde'];
    return $montantTotal;
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

function misAJourEntre($id, $ideglise, $motif, $ancienMontant, $montantEntre, $dateEntre): array
{
    global $pdo;

    $soldeActuel = getTotalAmount();
    $soldePrevu = $soldeActuel - $ancienMontant + $montantEntre;

    if ($soldePrevu < 10000) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Échec, le solde deviendrait insuffisant'
        ];
    }

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
            return ['success' => false, 'status' => 'error', 'message' => 'Erreur de mise à jour'];
        }
        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'status' => 'info', 'message' => 'Aucun enregistrement trouvé'];
        }
        return ['success' => true, 'status' => 'success', 'message' => 'Mise à jour réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'status' => 'error', 'message' => 'Erreur de mise à jour : ' . $e->getMessage()];
    }
}


// supprimer

function supprimerEntre($id): array
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT montantEntre FROM entre WHERE identre = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return ['success' => false, 'status' => 'info', 'message' => 'Aucun enregistrement trouvé'];
        }

        $montantEntre = $row['montantEntre'];
        $soldePrevu = getTotalAmount() - $montantEntre;

        if ($soldePrevu < 0) {
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Échec, la suppression rendrait le solde insuffisant '
                ];
        }

        $sql = 'DELETE FROM entre WHERE identre = :id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':id' => $id])) {
            return ['success' => false, 'status' => 'error', 'message' => 'Erreur de suppression'];
        }

        return ['success' => true, 'status' => 'success', 'message' => 'Suppression réussie'];
    } catch (PDOException $e) {
        return ['success' => false, 'status' => 'error', 'message' => 'Erreur de suppression : ' . $e->getMessage()];
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
