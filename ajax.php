<?php
header('content-type: text/html; charset=ISO-8859-1');
    # vereinfachte Datei, aufpassen!
    # (Scriptschutz, Zugriff auf Serverdateien verhindern ;)
    //echo file_get_contents ($_GET['src']);
    global $POST;
    global $POST_DATA;
    $input = file_get_contents("php://input");
    $POST_DATA = substr($input, strpos($input, "data://")+7);
    parse_str(substr($input, 0, strpos($input, "data://")), $POST);
    require_once($POST['src'].'.php');
?>
