<?php include "C:/xampp/htdocs/Comunicacion/AgregarDatosBD/conexion.php";?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medidor calidad del aire</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <script type="text/javascript">
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperatura', 0],
            ]);

            var options = {
                width: 400,
                height: 400,
                redFrom: 80,
                redTo: 100,
                yellowFrom: 35,
                yellowTo: 80,
                minorTicks: 5,
                greenFrom: 0,
                greenTo: 35,
                animation: {
                    duration: 1300,
                    easing: 'out',
                },
                redColor: '#FF0000',
                yellowColor: '#FFFF00',
                greenColor: '#00FF00',
                majorTicks: ['0', '25', '50', '75', '100'],
                minorTicks: 5,
            };

            var chart = new google.visualization.Gauge(document.getElementById('Reloj'));

            chart.draw(data, options);

            setInterval(function() {
                var JSON = $.ajax({
                    url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor3.php?q=1",
                    dataType: 'json',
                    async: false
                }).responseText;
                var Respuesta = jQuery.parseJSON(JSON);

                var firstData = Respuesta.historicalData[0];
                data.setValue(0, 1, firstData.Temperatura);
                chart.draw(data, options);
                adjustGaugeFontSize(); // Llama a la función de ajuste de tamaño después de dibujar el gráfico
            }, 1300);

            function adjustGaugeFontSize() {
                var labels = document.querySelectorAll('#Reloj text'); // Ajusta el selector para el gráfico de Gauge
                labels.forEach(function(label) {
                    label.setAttribute('font-size', '15'); 
                });
            }
        }
               

    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = $.ajax({
                url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor3.php?q=1",  
                dataType: 'json',
                async: false
            }).responseText;

            var parsedData = JSON.parse(jsonData);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Fecha');
            data.addColumn('number', 'Temperatura');

            for (var i = 0; i < parsedData.historicalData.length; i++) {
                 var hora = parsedData.historicalData[i].Hora;
                  var temperatura = parseFloat(parsedData.historicalData[i].Temperatura);
               data.addRow([hora, temperatura]);
             }

            var options = {
                title: 'Control de Circuitos (Temperatura)',
                curveType: 'function',
                legend: { position: 'bottom' },
                colors: ['#3366cc'], // Color de la línea del gráfico
                backgroundColor: { fill:'transparent' }, // Fondo transparente
                hAxis: {
                    title: 'Hora',
                    titleTextStyle: { color: '#333', bold: true, fontSize: 14 }, // Ajustes de estilo para el título del eje horizontal
                    gridlines: { color: '#e5e5e5' }, // Color de las líneas de la cuadrícula
                    textStyle: { color: '#666', bold: true, fontSize: 12 } // Ajustes de estilo para el texto del eje horizontal
                },
                vAxis: {
                    title: 'Temperatura',
                    titleTextStyle: { color: '#333', bold: true, fontSize: 14 }, // Ajustes de estilo para el título del eje vertical
                    gridlines: { color: '#e5e5e5' }, // Color de las líneas de la cuadrícula
                    textStyle: { color: '#666', bold: true, fontSize: 12 } // Ajustes de estilo para el texto del eje vertical
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('Control_de_Circuitos'));
            chart.draw(data, options);
        }
        setInterval(drawChart, 2000);

    </script>
</head>
<body>
    <h1 style="text-align: center;">Monitoreo del Circuito Sensor 3</h1>

    <!-- Contenedor para los gráficos -->
    <div id="contenedor-graficos" style="display: flex; justify-content: space-around;">
        <!-- Div para el gráfico de temperatura -->
        <div id="Reloj" style="width: 45%; height: 200px;"></div>

        <!-- Div para el gráfico de tiempo -->
        <div id="Control_de_Circuitos" style="width: 100%; height: 400px;"></div>
    </div>
    <button onclick="EncenderVentilador()">Encender Ventilador</button>


</body>
</html>
