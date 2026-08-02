<?php
require __DIR__ . '/../db/databasehelper.php';

// listeInfoEglise();
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

function listeInfoEglise(): ?array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM eglise";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rows !== false) {
            $_SESSION['ID_EGLISE'] = $rows['ideglise'];
            return $rows;
        } else {
            $_SESSION['ID_EGLISE'] = null;
            return null;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}

function obtenirEglises(): ?array {

global $pdo;
    try {
        $sql = "SELECT * FROM eglise";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rows !== false) {
            return $rows;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }

}

// lire une eglise seulement
function obtenirEglise(string $ideglise): ?array {

global $pdo;
    try {
        $sql = "SELECT * FROM eglise WHERE ideglise = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['ID' => $ideglise]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rows !== false) {
            return $rows;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }

}

function getAllBilanEntre(): array
{
    global $pdo;

    if (!isset($_SESSION['ID_EGLISE'])) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Aucune église trouvée',
            'data' => []
        ];
    }

    try {
        $sql = "SELECT 
            MONTH(dateEntre) AS mo, 
            SUM(montantEntre) AS total_entre
            FROM ENTRE 
            WHERE ideglise = :ideglise AND YEAR(dateEntre) = YEAR(CURDATE())
            GROUP BY MONTH(dateEntre)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ideglise' => $_SESSION['ID_EGLISE']]);

        $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $data = [];
        for ($mo = 1; $mo <= 12; $mo++) {
            $data[] = isset($rows[$mo]) ? (int) $rows[$mo] : 0;
        }

        return [
            'success' => true,
            'status' => 'success',
            'message' => '',
            'data' => $data
        ];
    } catch (PDOException $e) {
        error_log('getAllBilanEntre error: ' . $e->getMessage());
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Erreur de chargement de graphique',
            'data' => []
        ];
    }
}

function getAllBilanSortie(): array
{
    global $pdo;

    if (!isset($_SESSION['ID_EGLISE'])) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Aucune église trouvée',
            'data' => []
        ];
    }

    try {
        $sql = "SELECT 
            MONTH(dateSortie) AS mo, 
            SUM(montantSortie) AS total_sortie
            FROM SORTIE 
            WHERE ideglise = :ideglise AND YEAR(dateSortie) = YEAR(CURDATE())
            GROUP BY MONTH(dateSortie)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ideglise' => $_SESSION['ID_EGLISE']]);

        $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $data = [];
        for ($mo = 1; $mo <= 12; $mo++) {
            $data[] = isset($rows[$mo]) ? (int) $rows[$mo] : 0;
        }

        return [
            'success' => true,
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data
        ];
    } catch (PDOException $e) {
        error_log('getAllBilanSortie error: ' . $e->getMessage());
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Erreur de chargement de graphique',
            'data' => []
        ];
    }
}

function misAJourEglise($ideglise, $Design): array
{
    global $pdo;
    try {
        $sql = 'UPDATE eglise SET Design =:design WHERE ideglise =:id';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([':design' => $Design, ':id' => $ideglise])) {
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
            'message' => 'Erreur de mise à jour'
        ];
    }
}

function supprimerEglise($ideglise): array
{
    global $pdo;
    //  delete all the informations linked to the table
    $sql = 'TRUNCATE entre;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $sql1 = 'TRUNCATE sortie;';
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();

    if ($stmt && $stmt1) {
        try {
            $sql = 'DELETE FROM eglise WHERE ideglise = :id';
            $stmt = $pdo->prepare($sql);
            if (!$stmt->execute([':id' => $ideglise])) {
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
            return ['success' => false, 'message' => 'Erreur de suppression : ' . $e->getMessage()];
        }
    } else {
        return [
            'success' => false,
            'status' => 'error',
            'message' => 'Echec de suppression'
        ];
    }
}

function searchEglise(string $query): array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM eglise WHERE Design LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
