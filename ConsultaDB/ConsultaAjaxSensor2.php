<?php
header('Content-Type: application/json');
$dsn = 'mysql:host=localhost;dbname=sensor_dht';
$username = 'root';
$password = '';
$options = [];
$pdo = new PDO($dsn, $username, $password, $options);

switch ($_GET['q']) {
    case 1:
        $statement = $pdo->prepare("SELECT Temperatura, DATE_FORMAT(Fecha, '%H:%i:%s') AS Hora FROM sensor2 ORDER BY ID DESC LIMIT 0,15");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $lastStatement = $pdo->prepare("SELECT Temperatura FROM sensor2 ORDER BY ID DESC LIMIT 0,1");
        $lastStatement->execute();
        $lastResult = $lastStatement->fetch(PDO::FETCH_ASSOC);

        // Combinar los resultados
        $combinedResults = [
            'historicalData' => $results,
            'lastData' => $lastResult,
        ];

        // Enviar el JSON
        echo json_encode($combinedResults, JSON_NUMERIC_CHECK); 
        break;

    // Buscar Todos los datos (para casos futuros)
    default:
        $statement = $pdo->prepare("SELECT Temperatura, DATE_FORMAT(Fecha, '%H:%i:%s') AS Hora FROM sensor2 ORDER BY ID ASC");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Enviar el JSON
        echo json_encode($results, JSON_NUMERIC_CHECK);
        break;
}
?>
