<?php include "AgregarDatosBD/conexion.php";?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medidor calidad del aire</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <script type="text/javascript">
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChartSensor1);
        google.charts.setOnLoadCallback(drawChartSensor2);
        google.charts.setOnLoadCallback(drawChartSensor3);
        google.charts.setOnLoadCallback(drawChartSensor4);

        function drawChartSensor1() {
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperatura', 0],
            ]);

            var options = {
                width: 300,
                height: 300,
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

            var chart = new google.visualization.Gauge(document.getElementById('Reloj1'));

            chart.draw(data, options);

            setInterval(function() {
                var JSON = $.ajax({
                    url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor1.php?q=1",
                    dataType: 'json',
                    async: false
                }).responseText;
                var Respuesta = jQuery.parseJSON(JSON);

                var firstData = Respuesta.historicalData[0];
                data.setValue(0, 1, firstData.Temperatura);
                chart.draw(data, options);
                adjustGaugeFontSize('Reloj1'); // Llama a la función de ajuste de tamaño después de dibujar el gráfico
            }, 1300);
        }

        function drawChartSensor2() {
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperatura', 0],
            ]);

            var options = {
                width: 300,
                height: 300,
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

            var chart = new google.visualization.Gauge(document.getElementById('Reloj2'));

            chart.draw(data, options);

            setInterval(function() {
                var JSON = $.ajax({
                    url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor2.php?q=1",
                    dataType: 'json',
                    async: false
                }).responseText;
                var Respuesta = jQuery.parseJSON(JSON);

                var firstData = Respuesta.historicalData[0];
                data.setValue(0, 1, firstData.Temperatura);
                chart.draw(data, options);
                adjustGaugeFontSize('Reloj2'); // Llama a la función de ajuste de tamaño después de dibujar el gráfico
            }, 1300);
        }

        function drawChartSensor3() {
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperatura', 0],
            ]);

            var options = {
                width: 300,
                height: 300,
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

            var chart = new google.visualization.Gauge(document.getElementById('Reloj3'));

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
                adjustGaugeFontSize('Reloj3'); // Llama a la función de ajuste de tamaño después de dibujar el gráfico
            }, 1300);
        }

        function drawChartSensor4() {
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperatura', 0],
            ]);

            var options = {
                width: 300,
                height: 300,
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

            var chart = new google.visualization.Gauge(document.getElementById('Reloj4'));

            chart.draw(data, options);

            setInterval(function() {
                var JSON = $.ajax({
                    url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor4.php?q=1",
                    dataType: 'json',
                    async: false
                }).responseText;
                var Respuesta = jQuery.parseJSON(JSON);

                var firstData = Respuesta.historicalData[0];
                data.setValue(0, 1, firstData.Temperatura);
                chart.draw(data, options);
                adjustGaugeFontSize('Reloj4'); // Llama a la función de ajuste de tamaño después de dibujar el gráfico
            }, 1300);
        }

        function adjustGaugeFontSize(containerId) {
            var labels = document.querySelectorAll('#' + containerId + ' text');
            labels.forEach(function(label) {
                label.setAttribute('font-size', '15'); 
            });
        }
    </script>
        
<body>
    <h1 style="text-align: center;">Monitoreo del Circuito</h1>

    <div id="contenedor-Monitor" style="display: flex; flex-direction: row; justify-content: space-around;">

        <div style="text-align: center;">
            <div id="Reloj1" style="width: 300px; height: 300px;"></div>
            <p style="text-align: center; font-weight: bold;">Sensor 1</p>
            <a href="http://localhost/Comunicacion/Sensores/Sensor1.php?q=1" target="_blank">
                <button>Monitorear</button>
            </a>
        </div>

        <div style="text-align: center;">
            <div id="Reloj2" style="width: 300px; height: 300px;"></div>
            <p style="text-align: center; font-weight: bold;">Sensor 2</p>
            <a href="http://localhost/Comunicacion/Sensores/Sensor2.php?q=1" target="_blank">
                <button>Monitorear</button>
            </a>
        </div>

        <div style="text-align: center;">
            <div id="Reloj3" style="width: 300px; height: 300px;"></div>
            <p style="text-align: center; font-weight: bold;">Sensor 3</p>
            <a href="http://localhost/Comunicacion/Sensores/Sensor3.php?q=1" target="_blank">
                <button>Monitorear</button>
            </a>
        </div>

        <div style="text-align: center;">
            <div id="Reloj4" style="width: 300px; height: 300px;"></div>
            <p style="text-align: center; font-weight: bold;">Sensor 4</p>
            <a href="http://localhost/Comunicacion/Sensores/Sensor4.php?q=1" target="_blank">
                <button>Monitorear</button>
            </a>
        </div>

    </div>
   

</html>

