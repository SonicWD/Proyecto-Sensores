<?php include "C:/xampp/htdocs/Comunicacion/AgregarDatosBD/conexion.php";?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">   
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <style type="text/css" media="screen">
            :root {
                --color-green: #00a878;
                --color-red: #fe5e41;
                --color-button: #fdffff;
                --color-black: #000;
            }
            .switch-button {
                display: inline-block;
            }
            .switch-button .switch-button__checkbox {
                display: none;
            }
            .switch-button .switch-button__label {
                background-color: var(--color-red);
                width: 5rem;
                height: 3rem;
                border-radius: 3rem;
                display: inline-block;
                position: relative;
            }
            .switch-button .switch-button__label:before {
                transition: .2s;
                display: block;
                position: absolute;
                width: 3rem;
                height: 3rem;
                background-color: var(--color-button);
                content: '';
                border-radius: 50%;
                box-shadow: inset 0px 0px 0px 1px var(--color-black);
            }
            .switch-button .switch-button__checkbox:checked + .switch-button__label {
                background-color: var(--color-green);
            }
            .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
                transform: translateX(2rem);
            }
        </style>
    </head>
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
                    url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor1.php?q=1",
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
            function EncenderVentilador() {
            // Aquí va tu lógica para encender el ventilador

            // Envío de la señal "ON" al ESP8266
            fetch('http://tu-esp8266/direccion-endpoint', {
                method: 'POST', // Puedes ajustar esto según tus necesidades
                body: JSON.stringify({ comando: 'ON' }), // Datos que quieres enviar al ESP8266
                headers: {
                    'Content-Type': 'application/json'
                    // Puedes añadir más cabeceras según sea necesario
                }
            })
            .then(response => response.json())
            .then(data => {
                // Maneja la respuesta del ESP8266 si es necesario
                console.log(data);
            })
            .catch(error => {
                // Maneja los errores en caso de que ocurran
                console.error('Error:', error);
            });
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = $.ajax({
                url: "http://localhost/Comunicacion/ConsultaDB/ConsultaAjaxSensor1.php?q=1",  
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
    <script>
    // Función para encender/apagar el ventilador
    function encenderVentilador() {
        var ventilador = document.getElementById("estado-ventilador");
        var estadoVentilador = ventilador.checked; // true si está encendido, false si está apagado

        // Puedes hacer algo con el estado, por ejemplo, mostrar un mensaje
        if (estadoVentilador) {
            alert("Ventilador encendido");
        } else {
            alert("Ventilador apagado");
        }

        // Puedes devolver el estado si lo necesitas en tu lógica
        return estadoVentilador;
    }

    function manejarVentilador() {
        var ventilador = document.getElementById("estado-ventilador");
        var estadoVentilador = ventilador.checked;

        if (estadoVentilador) {
            enviarSenalON();
        } else {
            enviarSenalOFF();
        }
    }

    function enviarSenalON() {
        var esp8266URL = 'http://direccion-del-tu-esp8266/on';

        fetch(esp8266URL, {
            method: 'GET'
        })
        .then(response => {
            console.log('Señal enviada correctamente al ESP8266');
        })
        .catch(error => {
            console.error('Error al enviar la señal al ESP8266:', error);
        });
    }

    function enviarSenalOFF() {
        var esp8266URL = 'http://direccion-del-tu-esp8266/off';

        fetch(esp8266URL, {
            method: 'GET'
        })
        .then(response => {
            console.log('Señal enviada correctamente al ESP8266');
        })
        .catch(error => {
            console.error('Error al enviar la señal al ESP8266:', error);
        });
    }
</script>

</head>
<body>
    <h1 style="text-align: center;">Monitoreo del Circuito Sensor 1</h1>

    <!-- Contenedor para los gráficos -->
    <div id="contenedor-graficos" style="display: flex; justify-content: space-around;">
        <!-- Div para el gráfico de temperatura -->
        <div id="Reloj" style="width: 45%; height: 200px;"></div>

        <!-- Div para el gráfico de tiempo -->
        <div id="Control_de_Circuitos" style="width: 100%; height: 400px;"></div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <h2>Ventilador</h2>
        <div class="switch-button" style="display: inline-block; vertical-align: top;">
            <input type="checkbox" name="switch-button" id="estado-ventilador" class="switch-button__checkbox" onclick="encenderVentilador()">
             <label for="estado-ventilador" class="switch-button__label"></label>

        </div>
    </div>

</body>
</html>
