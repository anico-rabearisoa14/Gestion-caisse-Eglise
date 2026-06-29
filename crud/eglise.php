<?php
require __DIR__ . '/../db/databasehelper.php';
require __DIR__ . '/../init.php';

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
        $_SESSION['ID_EGLISE'] = $rows['ideglise'];
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

function supprimerEglise($ideglise): array
{
    global $pdo;
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
}

function searchEglise(string $query): array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM eglise WHERE Design LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
