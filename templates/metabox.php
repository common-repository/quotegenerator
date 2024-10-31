<?php
function showitem(){
 $dirname =  dirname(__FILE__);
 $file_data = sprintf("%s/datatable.xml", $dirname);
 
 $fields_name = array("Item name","Description","Unit Price","Maximum Quantity","Taxable","Image","Quantity Discount #1","Quantity Discount #2","Quantity Discount #3","Order Total Discount if Total Amount more than");

 $dom = new DomDocument();
 $data = file_get_contents($file_data);
 $dom->loadXML($data); 
 $s = simplexml_import_dom($dom);  
 $i = 0;
 $count_items = $dom->getElementsByTagName('ListItem')->length;
 

 //if(isset($_GET['itemsnum'])){
    if($_GET['itemsnum']=="add"){
        $meta = '<style>#buttn1{display:none;}#buttn2{display:none;}</style><table class="tbl1"><tr><td colspan="2"><div style="font-family: Arial;font-size: 12px; background:#ff991d; padding:3px; color:#ffffff; text-align:center;"> Items </div></td></tr>';
        $meta .= '<tr><td style="width:160px;">New Item</td><td></td></tr>';
        for($y=0; $y<6; $y++){
            $nod = "c".$y;
            $meta.= '<tr><td>'.$fields_name[$y].'</td><td><input type="text" name="'.$nod.'" id="'.$nod.'" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;" /></td></tr>';
            
        }
        $fy = 6;
        for($y=6; $y<15; $y=$y+3){
            $nod = "c".$y;
            $nod2 = "c".($y+1);
            $nod3 = "c".($y+2);
            $meta.= '<tr><td>'.$fields_name[$fy].'</td><td>from QTY <input type="text" name="'.$nod.'" id="'.$nod.'" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:40px;" /> to QTY <input type="text" name="'.$nod2.'" id="'.$nod2.'" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:60px;" /> discount <input type="text" name="'.$nod3.'" id="'.$nod3.'" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:25px;" />%</td></tr>';
            $fy++;
        }
            $meta.= '<tr><td>'.$fields_name[9].'</td><td>'.get_option("setting_qg17", $default ).'<input type="text" name="c15" id="c15" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:70px;" /> discount <input type="text" name="c16" id="c16" value="" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:30px;" />%</td></tr>';
            $meta .= '<tr><td colspan="2" style="text-align:center;border:none;"><input type="button" class="but" onClick="save_item();" value="Save New Item"></td></tr>';

           $meta .= '</table>!!!!0';
           return $meta;
     
    }else if('delete'==substr($_GET['itemsnum'],0,6)){
           $delitem = explode("XXX",$_GET['itemsnum']);
           $nitem = intval($delitem[1]);
           $meta = '<style>#buttn1{display:none;}#buttn2{display:none;}</style><table class="tbl1"><tr><td colspan="2"><div style="font-family: Arial;font-size: 12px; background:#ff991d; padding:3px; color:#ffffff; text-align:center;"> Items </div></td></tr>';
           $meta .= '<tr><td colspan="2" style="text-align:center;border:none;color:red;">Delete Item # '.($nitem+1).' ('.$s->ListItem[$nitem]->c0.') ?</td></tr>';
           $meta .= '<tr><td colspan="2" style="text-align:center;border:none;"><input type="button" class="but" onClick="del_item('.$nitem.');" value="Yes"> <input type="button" class="but" onClick="ret_item();" value="No"></td></tr>';
           $meta .= '</table>!!!!'.$nitem;
           
           return $meta;
     
    }else{
        $i = intval($_GET['itemsnum']);
        $meta = '<table class="tbl1"><tr><td colspan="2"><div style="font-family: Arial;font-size: 12px; background:#ff991d; padding:3px; color:#ffffff; text-align:center;"> Items </div></td></tr>';
        $meta .= '<tr><td style="width:160px;">Item number</td><td>'.($i+1).'/'.$count_items.'</td></tr>';
        for($y=0; $y<6; $y++){
            $nod = "c".$y;
            $meta.= '<tr><td>'.$fields_name[$y].'</td><td><input type="text" name="'.$nod.'" id="'.$nod.'" value="'.$s->ListItem[$i]->$nod.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;" /></td></tr>';
            
        }
        $fy = 6;
        for($y=6; $y<15; $y=$y+3){
            $nod = "c".$y;
            $nod2 = "c".($y+1);
            $nod3 = "c".($y+2);
            $meta.= '<tr><td>'.$fields_name[$fy].'</td><td>from QTY <input type="text" name="'.$nod.'" id="'.$nod.'" value="'.$s->ListItem[$i]->$nod.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:40px;" /> to QTY <input type="text" name="'.$nod2.'" id="'.$nod2.'" value="'.$s->ListItem[$i]->$nod2.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:60px;" /> discount <input type="text" name="'.$nod3.'" id="'.$nod3.'" value="'.$s->ListItem[$i]->$nod3.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:25px;" />%</td></tr>';
            $fy++;
        }
            $meta.= '<tr><td>'.$fields_name[9].'</td><td>'.get_option("setting_qg17", $default ).'<input type="text" name="c15" id="c15" value="'.$s->ListItem[$i]->c15.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:70px;" /> discount <input type="text" name="c16" id="c16" value="'.$s->ListItem[$i]->c16.'" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;width:30px;" />%</td></tr>';
            
            
            
            
      $i++;
      $meta .= '</table>!!!!'.$i.'!!!!'.$count_items;
      return $meta;
    }
 //} 
   
}

?>