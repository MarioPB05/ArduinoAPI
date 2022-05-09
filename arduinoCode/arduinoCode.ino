#include <SoftwareSerial.h>
SoftwareSerial wifiModule(10, 11); // RX, TX

//Configuracion de la red
String SSID = "redwifi";
String password = "pruebas909010";

//Configuracion del host
String server = "192.168.1.26";
String project = "/ArduinoAPI";
int maxChar = 2000;
int maxTimeResponse = 100000;

//Configuracion del programa
bool start = false;
int delayTime = 8000;

#include <LiquidCrystal.h>
LiquidCrystal lcd(12, 13, 5, 4, 3, 2);

#define COLS 16 // Columnas del LCD
#define ROWS 2 // Filas del LCD

void setup() {
  Serial.begin(9600);
  wifiModule.begin(9600);
  lcd.begin(COLS, ROWS);

  boot();
}

void loop() {
  if (start) {
    // PROGRAMA EN FUNCIONAMIENTO

    pantallaBienvenida();
    delay(delayTime);
    pantallaLastFollower();
    delay(delayTime);
    pantallaFollowerCount();
    delay(delayTime);
    pantallaLastSubscriber();
    delay(delayTime);
    pantallaSubscriberCount();
    delay(delayTime);
  } else {
    delay(delayTime);
    boot();
  }
  if (wifiModule.available()) {
    Serial.write(wifiModule.read());
  }
  if (Serial.available()) {
    wifiModule.write(Serial.read());
  }
}

/**
  Rutina de inicio para cargar el proyecto
*/
void boot() {
  // Presentacion del proyecto
  presentacionInicial();

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

      if (validateUserSession()) {
        start = true;
      } else {
        pantallaError("001");
        start = false;
      }
    }
  } else {
    //El modulo no responde, por lo que el programa no hara nada
    start = false;
    pantallaError("003");
  }
}

/**
   Muestra una presentacion en la pantalla LCD
*/
void presentacionInicial() {
  lcd.clear();
  lcd.print("     XOR APP");
  lcd.setCursor(0, 1);
  delay(500);
  lcd.print("       .");
  delay(500);
  lcd.setCursor(0, 1);
  lcd.print("       ..");
  delay(500);
  lcd.setCursor(0, 1);
  lcd.print("       ...");
  delay(1000);

  lcd.setCursor(0, 1);
  lcd.print("          ");
  delay(1000);

  lcd.setCursor(0, 1);
  delay(500);
  lcd.print("       .");
  delay(500);
  lcd.setCursor(0, 1);
  lcd.print("       ..");
  delay(500);
  lcd.setCursor(0, 1);
  lcd.print("       ...");
  delay(500);
}

/**
  Pantalla de Bienvenida (Pantalla Numero 1)
*/
void pantallaBienvenida() {

  //Indicamos al usuario el proceso de obtencion de sus datos
  //lcd.print("Cargando Usuario");
  //lcd.setCursor(0,1);
  //lcd.print("-> Trabajando...");

  //Obtenemos el nombre del usuario
  String name = getUserName();

  //Lo mostramos por pantalla
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Bienvenido,");
  lcd.setCursor(0, 1);
  lcd.print(name);
}

/**
   Pantalla Ultimo Seguidor
*/
void pantallaLastFollower() {

  //Obtenemos el nombre del seguidor
  String followerName = getLastFollower();

  //Lo mostramos por pantalla
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Ult. Seguidor:");
  lcd.setCursor(0, 1);
  lcd.print(followerName);
}

/**
   Pantalla que muestra la cantidad de Seguidores
*/
void pantallaFollowerCount() {

  //Obtenemos la cantidad de seguidores del usuario
  String count = getFollowerCount();

  //Lo mostramos por pantalla
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Seguidores:");
  lcd.setCursor(0, 1);
  lcd.print(count);
}

/**
   Pantalla Ultimo Suscriptor
*/
void pantallaLastSubscriber() {

  //Obtenemos el nombre del seguidor
  String subscriberName = getLastSubscriber();

  //Lo mostramos por pantalla
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Ult. Sub:");
  lcd.setCursor(0, 1);
  if(subscriberName == "0") {
    lcd.print(":(");
  }else {
    lcd.print(subscriberName);
  }
}

/**
   Pantalla que muestra la cantidad de Suscriptores
*/
void pantallaSubscriberCount() {

  //Obtenemos la cantidad de seguidores del usuario
  String count = getSubscriberCount();

  //Lo mostramos por pantalla
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Suscriptores:");
  lcd.setCursor(0, 1);
  lcd.print(count);
}

/**
  Pantalla de errores
*/
void pantallaError(String codeError) {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Error " + codeError);
  lcd.setCursor(0, 1);
  lcd.print("/error-codes.php");
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
        Serial.println("-(WARNING)-> No se ha podido deshabilitadar las multiconexiones");

        return true;
      }
    } else {
      return false;
    }
  } else {
    return false;
  }
}

/**
   Funcion que crea y envia una peticion HTTP
*/
String createHTTPRequest(String ruta) {
  //Nos conectamos con el servidor
  wifiModule.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");
  //Serial.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");
  if (wifiModule.find("OK")) {
    Serial.println("-(INFO)-> El modulo se ha conectado al servidor: " + server);

    //Creamos el encabezado de la peticion http
    String peticionHTTP = "GET " + ruta + " HTTP/1.1\r\n";
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
        resultado.remove(0, resultado.indexOf("{") + 1);
        resultado.remove(resultado.indexOf("}"), resultado.length() - resultado.indexOf("}"));

        //Devolvemos la respuesta de la peticion
        return resultado;
      }
    }
  } else {
    Serial.println("-(ERROR)-> El modulo no se ha podido conectar al servidor");
    pantallaError("002");
  }
}

/**
   Funcion que retorna si hay un usuario logeado en la API
*/
bool validateUserSession() {
  Serial.println("");
  Serial.println("------------------------------------");
  Serial.println("Verificando la sesion del usuario...");
  Serial.println("------------------------------------");

  String resultado = createHTTPRequest("/ArduinoAPI/auth.php?validateArduino");

  //En funcion del valor que nos devuelva la API sabremos si hay un usuario logado en la API
  if (resultado == "true") {
    return true;
  } else if (resultado == "false") {
    return false;
  }
}

/**
   Funcion que retorna el nombre del usuario
*/
String getUserName() {
  Serial.println("");
  Serial.println("------------------------------------");
  Serial.println("Recuperando el nombre del usuario...");
  Serial.println("------------------------------------");

  return createHTTPRequest("/ArduinoAPI/user.php?getName");
}

/**
   Funcion que retorna el nombre del ultimo seguidor
*/
String getLastFollower() {
  Serial.println("");
  Serial.println("--------------------------------------------");
  Serial.println("Recuperando el nombre del ultimo seguidor...");
  Serial.println("--------------------------------------------");

  return createHTTPRequest("/ArduinoAPI/user.php?getLastFollower");
}

/**
   Funcion que retorna la cantidad total de seguidores
*/
String getFollowerCount() {
  Serial.println("");
  Serial.println("----------------------------------------");
  Serial.println("Recuperando la cantidad de seguidores...");
  Serial.println("----------------------------------------");

  return createHTTPRequest("/ArduinoAPI/user.php?getFollowerCount");
}

/**
   Funcion que retorna el ultimo suscriptor
*/
String getLastSubscriber() {
  Serial.println("");
  Serial.println("----------------------------------------------");
  Serial.println("Recuperando el nombre del ultimo suscriptor...");
  Serial.println("----------------------------------------------");

  return createHTTPRequest("/ArduinoAPI/user.php?getLastSubscriber");
}

/**
   Funcion que retorna la cantidad de suscriptores
*/
String getSubscriberCount() {
  Serial.println("");
  Serial.println("------------------------------------------");
  Serial.println("Recuperando la cantidad de suscriptores...");
  Serial.println("------------------------------------------");

  return createHTTPRequest("/ArduinoAPI/user.php?getSubscriberCount");
}
