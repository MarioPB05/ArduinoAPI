#include <SoftwareSerial.h>
SoftwareSerial wifiModule(10, 11); // RX, TX

//Configuracion de la red
String SSID = "redwifi";
String password = "pruebas909010";

//Configuracion del host
String server = "192.168.1.26";
String project = "/ArduinoAPI";
int maxChar = 2000;
int maxTimeResponse = 60000;

//Configuracion del programa
bool start = false;

void setup() {
  Serial.begin(9600);
  wifiModule.begin(9600);

  if (checkStatus()) {
    //El modulo nos responde, por lo que seguimos con la config
    if (configRed()) {
      //El modulo se ha conectado a internet
      // por lo que habilitamos el programa

      Serial.println("");
      Serial.println(" ____________________");
      Serial.println("/                   \\");
      Serial.println("!    Configuracion    !");
      Serial.println("!      Terminada      !");
      Serial.println("\\____________________/");
      Serial.println("         !  !");
      Serial.println("         L_ !");
      Serial.println("        / _)!");
      Serial.println("       / /__L");
      Serial.println(" _____/ (____)");
      Serial.println("        (____)");
      Serial.println(" _____  (____)");
      Serial.println("     \\_(____)");
      Serial.println("         !  !");
      Serial.println("         !  !");
      Serial.println("        \\__/");
      Serial.println("");

      delay(1000);
      getUserName();
      start = true;
    }
  } else {
    //El modulo no responde, por lo que el programa no hara nada
    start = false;
  }
}

void loop() {
  if (start) {
    // PROGRAMA EN FUNCIONAMIENTO
  }
  if (wifiModule.available()) {
    Serial.write(wifiModule.read());
  }
  if (Serial.available()) {
    wifiModule.write(Serial.read());
  }
}

/**
   Comprueba si el modulo esta operativo
*/
bool checkStatus() {
  Serial.println("");
  Serial.println("-----------------------------------");
  Serial.println("Comprobando el estado del modulo...");
  Serial.println("-----------------------------------");

  wifiModule.println("AT");
  if (wifiModule.find("OK")) {
    Serial.println("-(INFO)-> El modulo está operativo");
    return true;
  } else {
    Serial.println("-(ERROR)-> El modulo no esta operativo");
    return false;
  }
}

/**
   Configura el modulo para conectarlo a internet
*/
bool configRed() {

  Serial.println("");
  Serial.println("---------------------------------");
  Serial.println("Configurando la red del modulo...");
  Serial.println("---------------------------------");

  // Establecemos el modulo en modo cliente
  wifiModule.println("AT+CWMODE=3");
  if (wifiModule.find("OK")) {
    Serial.println("-(INFO)-> Modulo en modo cliente");

    //Nos desconectamos de la ultima red wifi
    // esto lo hacemos por si las configuraciones
    // de la red hubieran cambiado
    wifiModule.println("AT+CWQAP");

    delay(2000);

    //Nos conectamos a una red wifi
    wifiModule.println("AT+CWJAP=\"" + SSID + "\",\"" + password + "\"");
    Serial.println("-(INFO)-> Intentando conectarse a la red...");

    if (wifiModule.find("OK")) {
      Serial.println("-(INFO)-> Conectado a la red correctamente");

      wifiModule.setTimeout(5000);
      //Desabilitamos las conexiones multiples
      wifiModule.println("AT+CIPMUX=0");
      if (wifiModule.find("OK")) {
        Serial.println("-(INFO)-> Multiconexiones deshabilitadas");

        //Terminamos la configuracion de la red
        return true;
      } else {
        //Si no se ha desactivado las multiconexiones
        // no nos afecta para trabajar, por lo que
        // retornamos verdadero porque la configuracion
        // de red sigue siendo válida
        Serial.println("-(ERROR)-> No se ha podido deshabilitadar las multiconexiones");

        return true;
      }
    } else {
      return false;
    }
  } else {
    return false;
  }
}

void getUserName() {

  Serial.println("");
  Serial.println("------------------------------------");
  Serial.println("Recuperando el nombre del usuario...");
  Serial.println("------------------------------------");

  //Nos conectamos con el servidor
  wifiModule.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");
  //Serial.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");
  if (wifiModule.find("OK")) {
    Serial.println("-(INFO)-> El modulo se ha conectado al servidor: " + server);

    //Creamos el encabezado de la peticion http
    String peticionHTTP = "GET /ArduinoAPI/user.php?getName HTTP/1.1\r\n";
    peticionHTTP = peticionHTTP + "Host: " + server + "\r\n\r\n";


    //Enviamos el tamaño en caracteres de la petecion http
    wifiModule.print("AT+CIPSEND=");
    wifiModule.println(peticionHTTP.length());

    //Esperamos a ">" para enviar la peticion http
    if (wifiModule.find(">")) {
      //El modulo nos indica que le podemos enviar la peticion http
      Serial.println("-(INFO)-> Enviando la peticion HTTP");

      wifiModule.println(peticionHTTP);

      if (wifiModule.find("SEND OK")) {

        Serial.println("");
        Serial.println("--------{INFO}-------");
        Serial.println("Peticion HTTP Enviada:");
        Serial.println(peticionHTTP);
        Serial.println("---------------------");

        //Ahora recuperamos la respuesta de la peticion
        Serial.println("-(INFO)-> Esperando respuesta...");

        bool fin_respuesta = false;
        long tiempo_inicio = millis();
        String cadena = "";

        while (fin_respuesta == false) {
          while (wifiModule.available() > 0) {
            char c = wifiModule.read();
            //Serial.write(c);
            cadena.concat(c);
          }

          //Finalizamos si la respuesta excede el limite de caracteres
          if (cadena.length() > maxChar) {
            Serial.println("-(WARNING)-> La respuesta a excedido el tamaño maximo");

            //Finalizamos la conexion
            wifiModule.println("AT+CIPCLOSE");

            if (wifiModule.find("OK")) {
              Serial.println("-(INFO)-> La conexion a finalizado correctamente");
            }

            fin_respuesta = true;
          }

          //Finalizamos si excede el tiempo de respuesta
          if ((millis() - tiempo_inicio) > maxTimeResponse) {
            Serial.println("-(WARNING)-> La respuesta a excedido el tiempo maximo de respuesta");

            //Finalizamos la conexion
            wifiModule.println("AT+CIPCLOSE");

            if (wifiModule.find("OK")) {
              Serial.println("-(INFO)-> La conexion a finalizado correctamente");
            }

            fin_respuesta = true;
          }

          //Finalizamos si recibimos un CLOSED
          if (cadena.indexOf("CLOSED") > 0) {
            Serial.println("");
            Serial.println("-(INFO)-> Respuesta recibida correctamente, conexion finalizada " + cadena.length());

            fin_respuesta = true;
          }
        }

        delay(1000);

        String resultado = cadena;
        resultado.remove(0,resultado.indexOf("{")+1);
        resultado.remove(resultado.indexOf("}"),resultado.length()-resultado.indexOf("}"));

        Serial.println("RESULTADO DATOS: " + resultado);

        //        Serial.println("");
        //        Serial.println("----------------{INFO}----------------");
        //        Serial.println("Respuesta de la peticion HTTP enviada:");
        //        Serial.println(cadena);
        //        Serial.println("Tiempo de respuesta: "+tiempo_inicio);
        //        Serial.println("--------------------------------------");
      }
    }
  } else {
    Serial.println("-(ERROR)-> El modulo no se ha podido conectar al servidor");
  }
}