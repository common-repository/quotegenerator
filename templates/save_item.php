<?php
$file_an = "datatable.xml";
$total_nods = 17;

if(isset($_REQUEST["save_items"])){
   
   if($_REQUEST["save_items"]!=""){
   
   $del_item = intval($_POST["save_items"]);
   
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
       }else{
           $title = $dataout->appendChild($xml->createElement('ListItem'));
           for($xi=0;$xi<$total_nods;$xi++){
               $nod = 'c'.$xi;
               $c = $title->appendChild($xml->createElement($nod));
               $text = $c->appendChild($xml->createTextNode($_POST[$nod]));
           }
         
       }
       
     $i++;
    }
 
    $xml->save('myxml.xml');
    rename($file_an, "old/".$file_an);
    rename("myxml.xml", $file_an);
   }

   }else{
     if($_POST["c0"]!=''){
        $xmlz='<ListItem>';
        for($x=0; $x<$total_nods;$x++){
            $nod = 'c'.$x;
            $xmlz.='<c'.$x.'>'.htmlspecialchars($_POST[$nod], ENT_XML1, 'UTF-8').'</c'.$x.'>';
        }
   
        $xmlz.='</ListItem>     </myXMLList>';
        $filez=fopen($file_an, 'r+');
        fseek($filez, -13, SEEK_END);
        fputs($filez, $xmlz);
        fclose($filez);
     }
   }
}
?>