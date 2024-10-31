<?php
$file_an = "datatable.xml";
$total_nods = 17;

if(isset($_REQUEST["delete_item"])){
   
   $del_item = intval($_POST["delete_item"]);
   
   if($del_item >= 0){
    $dom = new DomDocument();
    $data = file_get_contents($file_an);
    $dom->loadXML($data);
    $s = simplexml_import_dom($dom);  
    $i = 0; 
    $xml = new DomDocument('1.0','UTF-8');
    $xml->formatOutput = true;
    $dataout = $xml->appendChild($xml->createElement('myXMLList'));

    while ($s->ListItem[$i]) {
       if ($i!=$del_item) {
           $title = $dataout->appendChild($xml->createElement('ListItem'));
           for($xi=0;$xi<$total_nods;$xi++){
               $nod = 'c'.$xi;
               $c = $title->appendChild($xml->createElement($nod));
               $text = $c->appendChild($xml->createTextNode($s->ListItem[$i]->$nod));
           }
       }
     $i++;
    }
 
    $xml->save('myxml.xml');
    rename($file_an, "old/".$file_an);
    rename("myxml.xml", $file_an);
   }
}
?>