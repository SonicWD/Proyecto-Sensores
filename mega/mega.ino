#include <DHT.h>
#include <SoftwareSerial.h>

#define DHT_PIN_1 2
#define DHT_PIN_2 3
#define DHT_PIN_3 4
#define DHT_PIN_4 5

#define POWER_PIN_1 6
#define POWER_PIN_2 7
#define POWER_PIN_3 8
#define POWER_PIN_4 9
#define FAN_POWER_PIN_1 10
#define FAN_POWER_PIN_2 11

DHT dht1(DHT_PIN_1, DHT11);
DHT dht2(DHT_PIN_2, DHT11);
DHT dht3(DHT_PIN_3, DHT11);
DHT dht4(DHT_PIN_4, DHT11);

SoftwareSerial espSerial(14, 15); // RX, TX

void setup() {
  Serial.begin(9600);
  espSerial.begin(9600);  // Inicia la comunicación serial con el ESP8266
  dht1.begin();
  dht2.begin();
  dht3.begin();
  dht4.begin();

  pinMode(POWER_PIN_1, OUTPUT);
  pinMode(POWER_PIN_2, OUTPUT);
  pinMode(POWER_PIN_3, OUTPUT);
  pinMode(POWER_PIN_4, OUTPUT);
  pinMode(FAN_POWER_PIN_1, OUTPUT);
  pinMode(FAN_POWER_PIN_2, OUTPUT);

  // Apagar inicialmente los ventiladores
  digitalWrite(FAN_POWER_PIN_1, LOW);
  digitalWrite(FAN_POWER_PIN_2, LOW);

  // Encender los sensores
  digitalWrite(POWER_PIN_1, HIGH);
  digitalWrite(POWER_PIN_2, HIGH);
  digitalWrite(POWER_PIN_3, HIGH);
  digitalWrite(POWER_PIN_4, HIGH);
}

void loop() {
  float temp1 = dht1.readTemperature();
  float hum1 = dht1.readHumidity();
  float temp2 = dht2.readTemperature();
  float hum2 = dht2.readHumidity();
  float temp3 = dht3.readTemperature();
  float hum3 = dht3.readHumidity();
  float temp4 = dht4.readTemperature();
  float hum4 = dht4.readHumidity();

  if (!isnan(temp1) && !isnan(hum1) && !isnan(temp2) && !isnan(hum2)
      && !isnan(temp3) && !isnan(hum3) && !isnan(temp4) && !isnan(hum4)) {

    Serial.print("SENSOR1: ");
    Serial.print("Temperatura = ");
    Serial.print(temp1);
    Serial.print("°C, Humedad = ");
    Serial.println(hum1);

    Serial.print("SENSOR2: ");
    Serial.print("Temperatura = ");
    Serial.print(temp2);
    Serial.print("°C, Humedad = ");
    Serial.println(hum2);

    Serial.print("SENSOR3: ");
    Serial.print("Temperatura = ");
    Serial.print(temp3);
    Serial.print("°C, Humedad = ");
    Serial.println(hum3);

    Serial.print("SENSOR4: ");
    Serial.print("Temperatura = ");
    Serial.print(temp4);
    Serial.print("°C, Humedad = ");
    Serial.println(hum4);

    // Enviar datos al ESP8266
    espSerial.print("DATA,");
    espSerial.print(temp1);
    espSerial.print(",");
    espSerial.print(hum1);
    espSerial.print(",");
    espSerial.print(temp2);
    espSerial.print(",");
    espSerial.print(hum2);
    espSerial.print(",");
    espSerial.print(temp3);
    espSerial.print(",");
    espSerial.print(hum3);
    espSerial.print(",");
    espSerial.print(temp4);
    espSerial.print(",");
    espSerial.println(hum4);
  } else {
    Serial.println("Error al leer los sensores.");
  }

  delay(2000);  // Espera 2 segundos antes de leer los sensores nuevamente
}
