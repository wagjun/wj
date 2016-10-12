<?php

/*
$Id: telnet.class.php,v 1.2 2004/03/22 10:01:35 mb Exp $
 
Originally written by Marc Ennaji (in french),
modified by Matthias Blaser <mb@adfinis.ch>
 
- translated most function- and variable names from french to english
- added get_buffer-method to get results of the last command
  sent to server
- added hack to get socket_strerror working on old systems
 
You can find the original class which this translation is based on
on this url: http://px.sklar.com/code.html?id=634
 
The original class includes a small documentation about using it
in your own applications, but be aware, all functions are in french there, this
one is partly translated.
*/
 
// hack to get socket_strerror working on old systems
if(!function_exists("socket_strerror")){
    function socket_strerror($sh){
        if(function_exists("strerror")){
            return strerror($sh);
        } else {
            return false;
        }
    }
}
 
// telnet class
define ("TELNET_ERROR", 0);
define ("TELNET_OK", 1);
define ("TELNET_ASK_CONFIRMATION", 2);
define ("LIBELLE_CONFIRMATION", "[confirm]");
 
class telnet {
 
    var $socket  = NULL;
    var $host = "";
    var $port = "23";
    var $error = "";
    var $codeError = "";
    var $prompt = "\$ ";
    var $log = NULL;  // file handle
    var $repertoireLog= "";
    var $nomFichierLog = "";
    var $test;
 
    var $buffer = "";
 
    //------------------------------------------------------------------------
    function connect(){
        $this->socket = fsockopen($this->host,$this->port);
 
        if (!$this->socket){
            $this->error = "unable to open a telnet connection: " . socket_strerror($this->socket) . "\n";
            return TELNET_ERROR;
        }
 
        socket_set_timeout($this->socket,10,0);
        return TELNET_OK;
    }
 
    //------------------------------------------------------------------------
    function read_to($chaine){
        $NULL = chr(0);
        $IAC = chr(255);
        $buf = '';
 
        if (!$this->socket){
            $this->error = "telnet socket is not open";
            return TELNET_ERROR;
        }
 
        while (1){
            $c = $this->getc();
 
            if ($c === false){
             // plus de caracteres a lire sur la socket
                if ($this->contientErreur($buf)){
                    return TELNET_ERROR;
                }
 
                $this->error = " Couldn't find the requested : '" . $chaine . "', it was not in the data returned from server : '" . $buf . "'" ;
                $this->logger($this->error);
                return TELNET_ERROR;
            }
 
            if ($c == $NULL || $c == "\021"){
                continue;
            }
 
            if ($c == $IAC){
                // Interpreted As Command
                $c = $this->getc();
 
                if ($c != $IAC){
                    // car le 'vrai' caractere 255 est doubl? pour le differencier du IAC
                    if (! $this->negocierOptionTelnet($c)){
                        return TELNET_ERROR;
                    } else {
                        continue;
                    }
                }
 
            }
 
            $buf .= $c;
 
            // append current char to global buffer
            $this->buffer .= $c;
 
            // indiquer ? l'utilisateur de la classe qu'il a une demande de confirmation
            if (substr($buf,strlen($buf)-strlen(LIBELLE_CONFIRMATION)) == LIBELLE_CONFIRMATION){
                $this->logger($this->getDernieresLignes($buf));
                return TELNET_ASK_CONFIRMATION;
            }
 
            if ((substr($buf,strlen($buf)-strlen($chaine))) == $chaine){
                // on a trouve la chaine attendue
 
                $this->logger($this->getDernieresLignes($buf));
 
                if ($this->contientErreur($buf)){
                    return TELNET_ERROR;
                } else {
                    return TELNET_OK;
                }
            }
        }
    }
 
    //------------------------------------------------------------------------
    function getc(){
        return fgetc($this->socket);
    }
 
    //------------------------------------------------------------------------
    function get_buffer(){
        $buf = $this->buffer;
 
        // cut last line (is always prompt)
        $buf = explode("\n", $buf);
        unset($buf[count($buf)-1]);
        $buf = join("\n",$buf);
        return trim($buf);
    }
 
    //------------------------------------------------------------------------
    function negocierOptionTelnet($commande){
        // on negocie des options minimales
 
        $IAC = chr(255);
        $DONT = chr(254);
        $DO = chr(253);
        $WONT = chr(252);
        $WILL = chr(251);
 
        if (($commande == $DO) || ($commande == $DONT)){
            $opt = $this->getc();
            //echo "wont ".ord($opt)."\n";
            fwrite($this->socket,$IAC.$WONT.$opt);
        } else if (($commande == $WILL) || ($commande == $WONT)) {
            $opt = fgetc($this->socket);
            //echo "dont ".ord($opt)."\n";
            fwrite($this->socket,$IAC.$DONT.$opt);
        } else {
            $this->error = "Error : unknown command ".ord($commande)."\n";
            return false;
        }
 
        return true;
    }
 
    //------------------------------------------------------------------------
    function write($buffer, $valeurLoggee = "", $ajouterfinLigne = true){
 
        // clear buffer from last command
        $this->buffer = "";
 
        if (! $this->socket){
            $this->error = "telnet socket is not open";
            return TELNET_ERROR;
        }
 
        if ($ajouterfinLigne){
            $buffer .= "\n";
        }
 
        if (fwrite($this->socket,$buffer) < 0){
            $this->error = "error writing to socket";
            return TELNET_ERROR;
        }
 
        if ($valeurLoggee != ""){
            // cacher les valeurs confidentielles dans la log (mots de passe...)
            $buffer = $valeurLoggee . "\n";
        }
 
        if (! $ajouterfinLigne){
            // dans la log (mais pas sur la socket), rajouter tout de meme le caractere de fin de ligne
            $buffer .= "\n";
        }
 
        $this->logger("> " .$buffer);
 
        return TELNET_OK;
    }
 
    //------------------------------------------------------------------------
    function disconnect(){
        if ($this->socket){
            if (! fclose($this->socket)){
                $this->error = "error while closing telnet socket";
                return TELNET_ERROR;
            }
 
            $this->socket = NULL;
        }
 
        $this->setLog(false,"");
        return TELNET_OK;
    }
 
    //------------------------------------------------------------------------
    function contientErreur($buf){
        $messagesErreurs[] = "nvalid";       // Invalid input, ...
        $messagesErreurs[] = "o specified";  // No specified atm, ...
        $messagesErreurs[] = "nknown";       // Unknown profile, ...
        $messagesErreurs[] = "o such file or directory"; // sauvegarde dans un repertoire inexistant
        $messagesErreurs[] = "llegal";       // illegal file name, ...
 
        foreach ($messagesErreurs as $erreur){
            if (strpos ($buf, $erreur) === false)
                continue;
 
                // une erreur est d?tect?e
                $this->error =  "Un message d'erreur a ?t? d?tect? dans la r?ponse de l'h?te distant : " .
                    "<BR><BR>" . $this->getDernieresLignes($buf,"<BR>") . "<BR>";
 
                return true;
            }
 
        return false;
    }
 
    //------------------------------------------------------------------------
    function wait_prompt(){
        return $this->read_to($this->prompt);
    }
 
    //------------------------------------------------------------------------
    function set_prompt($s){
        $this->prompt = $s;
        return TELNET_OK;
    }
 
    //------------------------------------------------------------------------
    function set_host($s){
        $this->host = $s;
    }
 
    //------------------------------------------------------------------------
    function set_port($s){
        $this->port = $s;
    }
 
    //------------------------------------------------------------------------
    function get_last_error(){
        return $this->error;
    }
 
    //------------------------------------------------------------------------
    function setLog($activerLog, $traitement){
 
        if ($this->log && $activerLog){
            return TELNET_OK;
        }
 
        if ($activerLog){
            $this->repertoireLog =  "/log/" . date("m");
 
            // repertoire mensuel inexistant ?
            if (! file_exists($this->repertoireLog)){
                if (mkdir($this->repertoireLog, 0700) === false){
                    $this->error = "Impossible de cr?er le repertoire de log " .  $this->repertoireLog;
                    return TELNET_ERROR;
                }
            }
 
            global $HTTP_SERVER_VARS;
 
            $this->nomFichierLog =     date("d") . "_" .
                date("H:i:s") . "_" .
 
            $traitement . "_" .
                $HTTP_SERVER_VARS["PHP_AUTH_USER"]
                . ".log";
 
            $this->log = fopen($this->repertoireLog . "/" . $this->nomFichierLog,"a");
 
            if (empty($this->log)){
                $this->error = "Impossible de cr?er le fichier de log " . $this->nomFichierLog;
                return TELNET_ERROR;
            }
 
            $this->logger("----------------------------------------------\r\n");
            $this->logger("D?but de la log de l'utilisateur " . $HTTP_SERVER_VARS["PHP_AUTH_USER"] .
                ", adresse IP " . $HTTP_SERVER_VARS["REMOTE_ADDR"] . "\r\n");
 
            $this->logger("Connexion telnet sur " . $this->host . ", port " . $this->port . "\r\n");
            $this->logger("Date : " . date("d-m-Y").  "  ? " . date("H:i:s") . "\r\n");
            $this->logger("Type de traitement effectu? : " . $traitement . "\r\n");
            $this->logger("----------------------------------------------\r\n");
            return TELNET_OK;
 
        } else {
            if ($this->log){
                $this->logger("----------------------------------------------\r\n");
                $this->logger("Fin de la log\r\n");
 
                fflush($this->log);
 
                if (! fclose($this->log)){
                    $this->error = "erreur a la fermeture du fichier de log";
                    return TELNET_ERROR;
                }
 
                $this->log = NULL;
            }
 
            return TELNET_OK;
        }
    }
 
    //------------------------------------------------------------------------
    function logger($s){
        if ($this->log){
            fwrite($this->log, $s);
        }
    }
 
    //------------------------------------------------------------------------
    function getDernieresLignes($s, $separateur="\n"){
        // une reponse telnet contient (en principe) en premiere ligne l'echo de la commande utilisateur.
        // cette methode renvoie tout sauf la premiere ligne, afin de ne pas polluer les logs telnet
 
        $lignes = split("\n",$s);
        $resultat = "";
        $premiereLigne = true;
 
        while(list($key, $data) = each($lignes)){
            if ($premiereLigne){
                $premiereLigne = false;
            } else {
                if ($data != ""){
                    $resultat .= $data . $separateur;
                }
            }
        }
 
        $resultat == substr($resultat,strlen($resultat)-1); // enlever le dernier caractere de fin de ligne
 
        return $resultat;
    }
 
    //------------------------------------------------------------------------
}   //    Fin de la classe

// 2009-11-23
// Este exemplo funcionou com a versão 5.2.10 do PHP
 
// incluindo uma classe para facilitar o trabalho com sessões telnet
 
$telnet = new Telnet();
 
 
// conectando na maquina 127.0.0.1
$telnet->set_host("127.0.0.1");
$telnet->connect();
 
// quando o servidor enviar 'login', fornecer o nome do usuario
$telnet->set_prompt("login: ");
$telnet->wait_prompt();
$telnet->write("administrador");
 
 
// quando o servidor enviar 'Password', fornecer a senha
$telnet->set_prompt("Password: ");
$telnet->wait_prompt();
$telnet->write("senha1234");
 
// quando o servidor indicar que o prompt está pronto para receber comandos
$telnet->set_prompt("$ ");
$telnet->wait_prompt();
 
 
// executar um comando para criar um diretorio 'testando-php' em /tmp
$telnet->write('mkdir /tmp/testando-php');
 
// fechando a conexao 
$telnet->disconnect();
 
?>