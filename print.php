<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'db/databasehelper.php';

function handleFilter($category, $dateBegin, $dateEnd): ?array
{
    global $pdo;

    switch ($category) {
        case 'entre':
            $sql = 'SELECT dateEntre AS date, motif, montantEntre AS montant 
                    FROM entre WHERE dateEntre BETWEEN :begin AND :end';
            break;
        case 'sortie':
            $sql = 'SELECT dateSortie AS date, motif, montantSortie AS montant 
                    FROM sortie WHERE dateSortie BETWEEN :begin AND :end';
            break;
        default:
            return null;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':begin' => $dateBegin, ':end' => $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = array_sum(array_column($rows , 'montant'));

    return [
        'data' => $rows,
        'total' => $total
    ];
}

$_category = $_GET['_category'];
$_date_begin = $_GET['date-to-print-begin'];
$_date_end = $_GET['date-to-print-end'];

$show_message = $_SESSION['show_message'] ?? 'false';
$message_type = $_SESSION['message_type'] ?? '';
$message_body = $_SESSION['message_body'] ?? '';

$flux = '';
switch($_category){
    case 'sortie' :
        $phrase_en_tete = 'Mouvement de sortie de caisse';
        $flux = 'sortant';
        break;

    case 'entre' :
        $phrase_en_tete = 'Mouvement d\'entre de caisse';
        $flux = 'entrant';
        break;
    default :
    $phrase_en_tete = '';
}

// <td style="text-align:right;">' . number_format($d['montant'], 0, ',', ' ') . ' MGA</td>
$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

$raw_data = handleFilter($_category , $_date_begin , $_date_end);
$data = $raw_data['data'];
$montant_total = $raw_data['total'];

$rows = '';
foreach ($data as $d) {
    $rows .= '
    <tr>
    <td>' . $d['date'] . '</td>
        <td>' . $d['motif'] . '</td>
        <td style="text-align:right;">' . $formatter->formatCurrency($d['montant'] , 'MGA') . '</td>
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

<h2> ' . $phrase_en_tete . ' </h2>
<p>Entre ' . ($_date_begin) . ' et ' . ($_date_end).  ' </p>

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
</table>' . '<p>Total montant '. $flux .' :'. $formatter->formatCurrency($montant_total , 'MGA') . '</p> <br>
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
$mpdf->Output('pdf-' . date('d/m/Y') .'-'. $phrase_en_tete .'-'. $_date_end .'-'. $_date_begin .'.pdf', 'I');
?>
