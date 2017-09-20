#include <hidboot.h>
    #include <usbhub.h>
        #include <Wire.h>     
            #include <SPI.h>
                #include <Ethernet.h>
                    #include <Ethernet.h>
                        #include <SimpleSDAudio.h>
                            String code;
                            String codeant;
                            String codesvalid;
                            byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
                            char server[]="201.122.210.17";
                            IPAddress ip(192, 168, 1, 222);
                            IPAddress gateway(192, 168, 1, 254);
                            IPAddress subnet(255, 255, 255, 0);
                            boolean flagCon=0;
                            int OFFLINEMODE=0;
                            EthernetClient client;
                            volatile boolean paso=0;
                            unsigned long opentimes = 0;
                            unsigned long t_actualizado = 0;
                            IPAddress nodns(201,122,210,17);
                            //Se declara una variable que almacenará el tiempo que se desea que dure el delay.
                            unsigned long t_delay = 4000;

                            USB     Usb;
                            //USBHub     Hub(&Usb);
                            HIDBoot<USB_HID_PROTOCOL_KEYBOARD>    HidKeyboard(&Usb);



                                #define pinout 3  
                                #define pinin 2  
                                #define delayer 300  


                                class KbdRptParser : public KeyboardReportParser
                                {
                                protected:
                                void OnKeyDown  (uint8_t mod, uint8_t key);
                                void OnKeyPressed(uint8_t key);
                                };

                                void KbdRptParser::OnKeyDown(uint8_t mod, uint8_t key)
                                {
                                if(key!=88&&key!=40){
                                uint8_t c = OemToAscii(mod, key);
                                if (c)
                                OnKeyPressed(c);
                                }
                                }
                                void KbdRptParser::OnKeyPressed(uint8_t key)
                                {
                                Serial.print("ASCII: ");
                                code+=(char)key;
                                Serial.println((char)key);
                                };
                                KbdRptParser Prs;

                                void setup()
                                {
                                codesvalid= String("10,20,30");
                                Serial.begin( 115200 );
                                pinMode(pinout, OUTPUT);
                                pinMode(pinin, INPUT_PULLUP);
                                attachInterrupt( 0, ServicioBoton, FALLING );
                                Serial.println("Start");
                                code = String("");
                                codeant = String("");
                                if (Usb.Init() == -1)
                                Serial.println("OSC did not start.");

                                Serial.println("eth");
                                delay( 200 );
                                HidKeyboard.SetReportParser(0, &Prs);
                                // start the Ethernet connection:
                                Ethernet.begin(mac, ip, gateway, gateway, subnet);
                                // delay(2000);

                                Serial.println("Tordino v2.0");
                                Serial.println("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n");
                                Serial.print("IP Address        : ");
                                Serial.println(Ethernet.localIP());
                                Serial.print("Subnet Mask       : ");
                                Serial.println(Ethernet.subnetMask());
                                Serial.print("Default Gateway IP: ");
                                Serial.println(Ethernet.gatewayIP());
                                Serial.print("DNS Server IP     : ");
                                Serial.println(Ethernet.dnsServerIP()); 

                                Wire.begin();     

                                habla(8); 

                                }

                                void loop()
                                {
                                unsigned long time=millis();
                                //Serial.println("loop");    

                                Usb.Task();
                                if(paso==1&&(time-opentimes)>=t_delay) {   //si se acabo el tiempo y no se giro el torniquete    
                                habla(10);//noempuje
                                String cad="/montetaxco/ws/return2.php?numero="+codeant+"";
                                if(OFFLINEMODE==0){
                                if(httpRequest(cad)==1)
                                {
                                respuesta();
                                }
                                }
                                paso=0;        
                                }
                                if(code.length()==13){
                                Serial.println(code);  
                                Serial.println(digitalRead(pinin));
                                if(((opentimes>0&& (time-opentimes)<t_delay)||(digitalRead(pinin)==0))&&paso==1) {    //si no han pasado los 4 segundos o el boton  esta pulsado
                                    habla(6);//espera

                                    Serial.println(digitalRead(pinin));
                                    Serial.println("espera"); 
                                    }else{




                                    String cad="/montetaxco/ws/index2.php?numero="+code+"";
                                    if(OFFLINEMODE==0){
                                    if(httpRequest(cad)==1)
                                    {
                                    respuesta();
                                    }else{
                                    oflinemode(code);
                                    }
                                    }
                                    codeant=code;
                                    }

                                    code="";
                                    }    
                                    }
                                    void  oflinemode(String code){
                                    String sub=code.substring(10, 12);

                                    Serial.println(sub);
                                    if(codesvalid.indexOf(sub)!=-1){

                                    habla(2);
                                    paso=1;
                                    opentimes = millis();
                                    unsigned long  previousMillis= millis();
                                    unsigned long currentMillis = millis();


                                    while ((currentMillis - previousMillis) < delayer) {
                                    // save the last time you blinked the LED
                                    currentMillis = millis();
                                    //  previousMillis = currentMillis;
                                    digitalWrite(pinout, HIGH);
                                    Usb.Task();
                                    }
                                    digitalWrite(pinout, LOW);







                                    sendcode(code);
                                    }else{
                                    sendcode(code);
                                    habla(1);
                                    }

                                    }

                                    boolean httpRequest(String cad)
                                    {
                                    flagCon=0;

                                    Serial.println("connecting...");


                                    // if you get a connection, report back via serial:
                                    if (client.connect(nodns, 80)) { // CONECTAMOS AL SERVER

                                    client.println("GET http://"+String(server)+cad+"\r\n");

                                    client.println();
                                    client.println();
                                    Serial.println("finish");
                                    Serial.println("GET http://"+String(server)+cad+"\r\n"); 
                                    flagCon=1;
                                    }
                                    else {
                                    // kf you didn't get a connection to the server:
                                    Serial.println("connection failed");

                                    client.stop(); 

                                    }

                                    //Restore SPI mode of pins


                                    return flagCon;
                                    }

                                    void respuesta() // lee la respuesta del servidor que lo recibimos igual que la función serial
                                    { char c;

                                    String rx ; // Cadena de datos recibidos
                                    int result=-1;
                                    // Leemos la respuesta html del servidor, aca viene todo

                                    while(client.connected() && client.available()==0) delay(1); //waits for data
                                    while (client.available()>0) 
                                    {    
                                    c = client.read();
                                    rx+=c; // Concatenamos
                                    Serial.print(c);// A su vez vamos viendo en el monitor todo lo que recibimos caracter por vez
                                    } // while 

                                    result=rx.toInt();
                                    client.stop();   unsigned long currentMillis = millis();
                                    unsigned long  previousMillis= millis();


                                    //Serial.print("posicion de sal :");
                                    switch(result){
                                    case -2 :     
                                    Serial.println("no abrio")        ;
                                    break;
                                    case -1:                                  
                                    habla(1);
                                    break;
                                    case 0:
                                    habla(0);
                                    break;
                                    case 1:
                                    habla(1);
                                    break;
                                    case 2:

                                    habla(2);
                                    paso=1;
                                    opentimes = millis();                                         
                                    currentMillis = millis();
                                    previousMillis= millis();

                                    digitalWrite(pinout, HIGH);
                                    while (currentMillis - previousMillis < delayer) {
                                    // save the last time you blinked the LED
                                    currentMillis = millis();
                                    //     Serial.print("prende");  
                                    //  previousMillis = currentMillis;
                                    //  digitalWrite(pinout, HIGH);
                                    Usb.Task();
                                    }

                                    digitalWrite(pinout, LOW);

                                    break;
                                    case 3:
                                    habla(3);
                                    break;
                                    case 4:
                                    habla(0);
                                    break;
                                    case 5:
                                    habla(5);
                                    break;
                                    default:

                                    break; 
                                    }

                                    }
                                    void habla(int numero){
                                    sendslave(numero);

                                    }
                                    void sendslave(long data){
                                    Serial.println(data);


                                    unsigned int lectura;
                                    Wire.beginTransmission(1);  // Enviamos a la dirección del esclavo 1
                                    Wire.write((data+48));              // Enviamos un 1    
                                    Wire.endTransmission();     // Terminamos la transmision  

                                    // Imprimimos la lectura en el serial (podria ser un lcd tambien)

                                    }

                                    void sendcode(String data){
                                    Serial.println(data);
                                    char buffer[13];
                                    data.toCharArray(buffer, 13);
                                    unsigned int lectura;
                                    Wire.beginTransmission(1);  // Enviamos a la dirección del esclavo 1
                                    Wire.write(buffer);              // Enviamos un 1    
                                    Wire.endTransmission();     // Terminamos la transmision  

                                    // Imprimimos la lectura en el serial (podria ser un lcd tambien)

                                    }
                                    void ServicioBoton() 
                                    {   
                                    Serial.println(paso);
                                    paso=0;
                                    }