<?php
require_once __DIR__ . '/shield.php';
require __DIR__ . '/vendor/autoload.php';
require_once 'db/databasehelper.php';

function fetchMovements($pdo, $table, $dateCol, $montantCol, $dateBegin, $dateEnd): array
{
    $sql = "SELECT $dateCol AS date, motif, $montantCol AS montant 
            FROM $table WHERE $dateCol BETWEEN :begin AND :end";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':begin' => $dateBegin, ':end' => $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = array_sum(array_column($rows, 'montant'));

    return ['data' => $rows, 'total' => $total];
}

//  get eglise name
function getName($id , $pdo) : ?array {
try{
$sql = "SELECT Design FROM eglise WHERE ideglise = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$row = $stmt->fetch();
return ['result' => $row['Design']];
}
catch(ErrorException $e){
    return null;
}
}

$dateBegin = $_GET['date-to-print-begin'];
$dateEnd   = $_GET['date-to-print-end'];

$show_message  = $_SESSION['show_message'] ?? 'false';
$message_type  = $_SESSION['message_type'] ?? '';
$message_body  = $_SESSION['message_body'] ?? '';

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

// Nom eglise
$nomEglise = getName($_SESSION['ID_EGLISE'] , $pdo);

// Entrée
$raw1 = fetchMovements($pdo, 'entre', 'dateEntre', 'montantEntre', $dateBegin, $dateEnd);
$data1 = $raw1['data'];
$totalMontant1 = $raw1['total'];

// Sortie
$raw2 = fetchMovements($pdo, 'sortie', 'dateSortie', 'montantSortie', $dateBegin, $dateEnd);
$data2 = $raw2['data'];
$totalMontant2 = $raw2['total'];

// Build rows for entrée table
$rows1 = '';
foreach ($data1 as $d) {
    $rows1 .= '
    <tr>
        <td>' . htmlspecialchars($d['date']) . '</td>
        <td>' . htmlspecialchars($d['motif']) . '</td>
        <td style="text-align:right;">' . htmlspecialchars($formatter->formatCurrency($d['montant'], 'MGA')) . '</td>
    </tr>';
}

// Build rows for sortie table
$rows2 = '';
foreach ($data2 as $d) {
    $rows2 .= '
    <tr>
        <td>' . htmlspecialchars($d['date']) . '</td>
        <td>' . htmlspecialchars($d['motif']) . '</td>
        <td style="text-align:right;">' . htmlspecialchars($formatter->formatCurrency($d['montant'], 'MGA')) . '</td>
    </tr>';
}
// th >> background-color: #3b4a6b; color: white;
$html = '
<style>
    body  { font-family: Arial, sans-serif; font-size: 12px; }
    h2, p.title { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th    { border: 1px solid #ccc; padding: 8px 10px; text-align: left; }
    td    { border: 1px solid #ccc; padding: 7px 10px; }
    tr:nth-child(even) { background-color: #f2f2f2; }
</style>

<h1>' .$nomEglise['result']. '</h1>
<h2>Mouvement de caisse</h2>
<p>Entre ' . htmlspecialchars($dateBegin) . ' et ' . htmlspecialchars($dateEnd) . '</p>

<br>
<p><b>Mouvement d\'entrée en caisse</b></p>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Motif</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        ' . ($rows1 ?: '<tr><td colspan="3" style="text-align:center;">Aucune donnée</td></tr>') . '
    </tbody>
</table>
<p><b>Total montant entrant : ' . htmlspecialchars($formatter->formatCurrency($totalMontant1, 'MGA')) . '</b></p>

<br>
<p><b>Mouvement de sortie de caisse</b></p>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Motif</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        ' . ($rows2 ?: '<tr><td colspan="3" style="text-align:center;">Aucune donnée</td></tr>') . '
    </tbody>
</table>
<p><b>Total montant sortant : ' . htmlspecialchars($formatter->formatCurrency($totalMontant2, 'MGA')) . '</b></p>

<br>
<p style="text-align:center; color:#666;">Imprimé le ' . date('d/m/Y') . '</p>';

$mpdf = new \Mpdf\Mpdf([
    'format'        => 'A4',
    'margin_top'    => 20,
    'margin_bottom' => 20,
    'margin_left'   => 15,
    'margin_right'  => 15,
]);

$mpdf->SetHTMLFooter('<p style="text-align:center; font-size:9px; color:#999;">Page {PAGENO} / {nb}</p>');
$mpdf->WriteHTML($html);
$mpdf->Output('pdf-' . date('d/m/Y') . '-mouvement-' . $dateEnd . '-' . $dateBegin . '.pdf', 'I');