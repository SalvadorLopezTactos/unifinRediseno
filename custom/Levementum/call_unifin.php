<?PHP
//Script que genera una llamada de salida mediante AMI de Asterisk
//Desde el CRM nos envian la llamada por URL y las variables enviadas son numero,userexten y idcrm
//

//Se setean las variables obtenidas del clic to call del CRM y las variables necesarias para la conexión de AMI
//Variables obtenidas del URL con GET
$number_pstn=$_GET["numero"];  //para recibir los parámetros por URL
$exten_issabel=$_GET["userexten"]; //para recibir los parámetros por URL
$id_call=$_GET["id_call"];

//$number_pstn="0445542384032";
//$exten_issabel="5581";
//$id_call="014c6b60-b82b-11e8-b869-3035add3ad60";

//Variables AMI
$strHost = "192.168.11.254";
$strUser = "admin";
$strSecret = "admin741852963.";
$strContext = "c2cunifin";
$strWaitTime = "30";
$strPriority = "1";
$strMaxRetry = "0";
$strCallerId="1";

        {
            $oSocket = fsockopen($strHost, 5038, $errnum, $errdesc) or die("Connection to host failed");
            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Events: off\r\n");
            fputs($oSocket, "Username: $strUser\r\n");
            fputs($oSocket, "Secret: $strSecret\r\n\r\n");
            fputs($oSocket, "Action: originate\r\n");
            fputs($oSocket, "Channel: SIP/$exten_issabel\r\n");
            fputs($oSocket, "WaitTime: $strWaitTime\r\n");
            fputs($oSocket, "Variable: id_call=$id_call\r\n" );//Enviamos ID de CRM en la variable IDCRM y es recibida por Asterisk
            fputs($oSocket, "Variable: userexten=$exten_issabel\r\n" );
            fputs($oSocket, "Variable: numero=$number_pstn\r\n" );
            fputs($oSocket, "CallerId: $strCallerId\r\n");
            fputs($oSocket, "Exten: $number_pstn\r\n");
            fputs($oSocket, "Context: $strContext\r\n");
            fputs($oSocket, "Priority: 1\r\n\r\n");
            fputs($oSocket, "Action: Logoff\r\n\r\n");
            sleep(3);
            fclose($oSocket);
                                }
?>