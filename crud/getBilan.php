<?php
$sql = "
    SELECT 
        DATE_FORMAT(dateEntre, '%Y-%m') AS month,
        SUM(montantEntre) AS total_entre
    FROM ENTRE
    WHERE ideglise = :ideglise
        AND YEAR(dateEntre) = YEAR(CURDATE())
    GROUP BY DATE_FORMAT(dateEntre, '%Y-%m')
    ORDER BY month
";

$stmt = $pdo->prepare($sql);
$stmt->execute([':ideglise' => 'Eg-34383']);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
