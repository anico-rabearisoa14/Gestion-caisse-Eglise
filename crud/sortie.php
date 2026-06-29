<?php
require __DIR__ . '/../db/databasehelper.php';
require __DIR__ . '/../init.php';


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

    $sql = "SELECT * FROM eglise";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $montantTotal = $rows['Solde'];

    if ($montantSortie > $montantTotal) {
        return false;
    } else {
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

// mis a jour
function misAJourSortie($id, $ideglise, $motif, $montantSortie, $dateSortie): array
{
    global $pdo;
    $sql = "SELECT * FROM eglise";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $montantTotal = $rows['Solde'];

    if ($montantSortie > $montantTotal) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Echec , Solde insuffisante'
        ];
    } else {
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
                return [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Erreur de mise à jour'
                ];
            }
            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'status' => 'info',
                    'message' => 'Aucun enregistrement trouvé'
                ];
            }
            return [
                'success' => true,
                'status' => 'success',
                'message' => 'Mise à jour réussie'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Erreur de mise à jour : ' . $e->getMessage()
            ];
        }
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
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Erreur de suppression'
            ];
        }
        if ($stmt->rowCount() === 0) {
            return [
                'success' => false,
                'status' => 'info',
                'message' => 'Aucun enregistrement trouvé'
            ];
        }
        return [
            'success' => true,
            'status' => 'success',
            'message' => 'Suppression réussie'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Erreur de suppression : ' . $e->getMessage()
        ];
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
