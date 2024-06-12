<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sensor_DHT";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
}
echo "rr";

if (isset($_POST["data"])) {
    $data = $_POST["data"]; // Obtener la cadena completa de datos

    // Dividir la cadena de datos en partes para cada sensor
    $sensorData = explode(",", $data);

    // Verificar si hay datos suficientes para cada sensor
    if (count($sensorData) == 9) {
        $temperatura1 = $sensorData[1];
        $humedad1 = $sensorData[2];
        $temperatura2 = $sensorData[3];
        $humedad2 = $sensorData[4];
        $temperatura3 = $sensorData[5];
        $humedad3 = $sensorData[6];
        $temperatura4 = $sensorData[7];
        $humedad4 = $sensorData[8];

        $sql_sensor_1 = "INSERT INTO mq135 (temperatura, humedad) VALUES ('$temperatura1', '$humedad1')";
        $sql_sensor_2 = "INSERT INTO sensor2 (temperatura, humedad) VALUES ('$temperatura2', '$humedad2')";
        $sql_sensor_3 = "INSERT INTO sensor3 (temperatura, humedad) VALUES ('$temperatura3', '$humedad3')";
        $sql_sensor_4 = "INSERT INTO sensor4 (temperatura, humedad) VALUES ('$temperatura4', '$humedad4')";

        if (mysqli_query($conn, $sql_sensor_1) && mysqli_query($conn, $sql_sensor_2) &&
            mysqli_query($conn, $sql_sensor_3) && mysqli_query($conn, $sql_sensor_4)) {
            echo "Datos de los cuatro sensores insertados correctamente";
        } else {
            echo "Error: " . $sql_sensor_1 . "<br>" . mysqli_error($conn);
            echo "Error: " . $sql_sensor_2 . "<br>" . mysqli_error($conn);
            echo "Error: " . $sql_sensor_3 . "<br>" . mysqli_error($conn);
            echo "Error: " . $sql_sensor_4 . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: Datos insuficientes para procesar.";
    }
}
?>
