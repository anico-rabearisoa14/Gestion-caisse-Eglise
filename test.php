<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'db/databasehelper.php';

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

$data = listeInfoEntre() ?? [];

$rows = '';
foreach ($data as $d) {
    $rows .= '
    <tr>
    <td>' . $d['dateEntre'] . '</td>
        <td>' . $d['motif'] . '</td>
        <td style="text-align:right;">' . number_format($d['montantEntre'], 0, ',', ' ') . ' MGA</td>
    </tr>';
}

$html = '
<style>
    body  { font-family: Arial, sans-serif; font-size: 12px; }
    h2    { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th    { background-color: #3b4a6b; color: white; padding: 8px 10px; text-align: left; }
    td    { border: 1px solid #ccc; padding: 7px 10px; }
    tr:nth-child(even) { background-color: #f2f2f2; }
</style>

<h2>Liste des Entrées</h2>
<p style="text-align:center; color:#666;">Imprimé le ' . date('d/m/Y') . '</p>

<table>
    <thead>
        <tr>
        <th>Date</th>
            <th>Motif</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        ' . ($rows ?: '<tr><td colspan="4" style="text-align:center;">Aucune donnée</td></tr>') . '
    </tbody>
</table>';

$mpdf = new \Mpdf\Mpdf([
    'format'        => 'A4',
    'margin_top'    => 20,
    'margin_bottom' => 20,
    'margin_left'   => 15,
    'margin_right'  => 15,
]);

$mpdf->SetHTMLFooter('<p style="text-align:center; font-size:9px; color:#999;">Page {PAGENO} / {nb}</p>');
$mpdf->WriteHTML($html);
$mpdf->Output('entrees.pdf', 'D');
?>
