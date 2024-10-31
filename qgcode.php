<?php
/**
 * Quote Generator Plus
 * ====================
 * Quote Generator
 * Motto: "Our software will change your business life for the better."
 * The Quote Generator system allows your customer to conveniently receive instant quotes and place orders online.
 * @author      Original author: Vitaliy Zakhodylo <quotegeneratorplus@gmail.com>
 * @license     Code and contributions have Copyright (c) 2015
 *              More details: LICENSE.txt
 * @link        Homepage:     http://quotegeneratorplus.com
 * @version     1.0.0
 */

$arrsize = 37;
$bgrd = "#fefefe";
$textout='';
$nval = array();

  for($qx=1;$qx<=$arrsize;$qx++){
      $nval[$qx] = get_option( 'setting_qg'.$qx, $default );
      if(strtolower($nval[$qx])=='hide'){
        $nval[$qx] = 'display:none;';
      }
      if(strtolower($nval[$qx])=='show'){
        $nval[$qx] = '';
      }
  }
 
  if($nval[21]!='' && intval($nval[22])>0){
     $show_tax2 = '';
  }else{
     $show_tax2 = 'display:none;';
  }
  if($nval[23]!='' && intval($nval[24])>0){
     $show_tax3 = '';
  }else{
     $show_tax3 = 'display:none;';
  }
  
  function set_html_content_type() {
	return 'text/html';
  }
  
   // -------------- Submit Email -----------------
   if(isset($_POST['qgb10'])){
    
      $ip = $_SERVER['REMOTE_ADDR'];
      $todayDate = date("j M Y G:i:s");
      
      $textouts = '<table style="background:#f5f5f5;color:#555555;margin-bottom:10px;"><tr><td style="padding:5px;width:300px;">'.$nval[35].'</td><td style="padding:5px;">'.$_POST["qgb8"].'</td></tr>';
      if($nval[36]!=''){
         $textouts .= '<tr><td style="padding:5px;">'.$nval[36].'</td><td style="padding:5px;">'.$_POST["qgb9"].'</td></tr>';
      }
      $textouts .= '<tr><td style="padding:5px;">Email Address</td><td style="padding:5px;">'.$_POST["qgb10"].'</td></tr>';
      if($nval[37]!=''){
         $textouts .= '<tr><td style="padding:5px;">'.$nval[37].'</td><td style="padding:5px;">'.$_POST["qgb12"].'</td></tr>';
      }
      $textouts .= '<tr><td style="padding:5px;">Order Date</td><td style="padding:5px;">'.$todayDate.'</td></tr>';
      $textouts .= '<tr><td style="padding:5px;">IP</td><td style="padding:5px;">'.$ip.'</td></tr></table>';

      $textouts .= '<table style="text-align: center;width:'. $nval[1].';background: '. $nval[2].'; border:'.$nval[3].'; font-size: '. $nval[8].'; color: '. $nval[7].';"><tr>      <th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[25].'</th> <th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[26].'</th> <th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[27].'('. $nval[18].')</th> <th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[28].'</th><th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[29].'('. $nval[18].')</th><th style="color:'. $nval[4].'; font-size: '. $nval[5].'; background: '. $nval[6].';text-align: center;">'. $nval[30].'('. $nval[18].')</th></tr>';
       $vals = array('');
       $valnames = array('','Subtotal','Discount','Total before Tax',$nval[19],$nval[21],$nval[23],'Total');
       
       for($x=0; $x<$_POST['qgb11']; $x++){
           if ($x%2==0){ $bgr = "#ffffff";}else{ $bgr = "#f7f7f7";}
           if(intval($_POST['amnt'.$x])>0){
	      $textouts .= '<tr style="background: '.$bgr.'"><td>'.($x+1).'</td><td>'.$_POST['name'.$x].'</td><td>'.$_POST['price'.$x].'</td><td>'.$_POST['qty'.$x].'</td><td>'.$_POST['discnt'.$x].'</td><td>'.$_POST['amnt'.$x].'</td></tr>';
           }
           
       }
       
       for($x=1; $x<8; $x++){
           if ($x%2==0){ $bgr = "#f5f5f5";}else{ $bgr = "#f0f0f0";}
           if ($x==7)  { $bgr = $nval[6].';color:'. $nval[4].';';}
	   $nod = 'qgb'.$x;
	   $vals[$x] = $_POST[$nod];
           if(intval($vals[$x])>0){
               $textouts .= '<tr style="background: '.$bgr.'"><td colspan="5" style="text-align: right;">'.$valnames[$x].'</td><td>'.$vals[$x].'</td></tr>';
           }
       }
       
       $textouts .= '</table>';
       $textouts2 .= '<table><tr><td style="color:green;font-size:28px;text-align: center;width:'. $nval[1].';padding-top:10px;">Your Order has been Submited!</td></tr></table>';
       
       add_filter( 'wp_mail_content_type', 'set_html_content_type' );
       $body ='<html><head><title>Online Order</title></head><body>'.$textouts.'</body></html>';
       $subject = 'Online Order';
       $to = get_option( 'admin_email');
       //$to = $_POST['qgb10']; //email address
       wp_mail( $to, $subject, $body );
       remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
       
       echo $textouts.$textouts2;
       exit();

   } //--------------- End of Submit --------------------------------------
   
   
   //--------------- Read XML data file -----------------------------------
   $file_data = sprintf("%s/quotegenerator/templates/datatable.xml", plugins_url());
   $dom = new DomDocument();
   $data = file_get_contents($file_data);
   $dom->loadXML($data); 
   $s = simplexml_import_dom($dom);  
   $i = 0;
   $style_calc ='background: none;padding:5px 0px 5px 0px; width: 70px;border: none;text-align: right; font-size:'. $nval[8].';color:'. $nval[7].';';
   $style_qntt2 = 'width: 160px;text-align: center; font-size: '. $nval[8].'; color: '. $nval[7].'; margin-left:15px;';
   $style_but = ' background: '. $nval[33].'; height: 30px;color : '. $nval[34].';text-decoration: none;border-radius: 3px; -webkit-border-radius: 3px; -khtml-border-radius:3px;border:1px solid #999999;text-align: center;';
   
   while ($s->ListItem[$i]) {
    
          $bgr = $nval[9];
          if ($i%2==0){
            $bgr = $bgrd;
          }else{
            $bgr = "#f7f7f7";
          }
          
           $textout.='<tr style="background:'.$bgr.';"><td style="vertical-align: text-top;border:none;width: 10px;">'.($i+1).'</td> <td style="text-align: left;vertical-align: text-top;border:none;"><input name="name'.$i.'" type="text" value="'.$s->ListItem[$i]->c0.'" style="background: none;width: 100%; padding:0px; border: none; text-align: left; font-size: '. $nval[8].'; color: '. $nval[7].';" /><br><span style="font-size:10px;color:#666666;padding:0px;margin:0px;text-align: justify;text-decoration:none;line-height: 90%;font-family: Arial;width:100%;'.$nval[12].'">'.$s->ListItem[$i]->c1.'</span></td><td style="border: none;padding:0px;vertical-align: middle;'. $nval[13].'"><input name="price'.$i.'" type="text" value="'.$s->ListItem[$i]->c2.'" style="background: none; padding:5px 0px 5px 0px;width: 55px;  border: none; text-align: center;  font-size: '. $nval[8].'; color: '. $nval[7].';" /> <input name="taxb'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c4.'" /></td>';
           $textout.='  <td style="vertical-align: middle;border: none;text-align: center;padding:0px;">';
           
           $max_qty = intval($s->ListItem[$i]->c3);
           if($max_qty == 1){
               $textout.=' <input name="checkqty'.$i.'" id="checkqty'.$i.'" type="checkbox" style="width: 20px;height:20px;text-align: center;" onClick="calclat('.$i.');" onkeypress="handle(this,event)">';
               $textout.=' <input name="qty'.$i.'" type="hidden" value="" style="width: 55px;padding:5px 0px 5px 0px;text-align: center;font-size:'.$nval[8].';color:'.$nval[7].';" onchange="calclat(this)" onkeypress="handle(this,event)"/>';
           }else{
               $textout.=' <input name="qty'.$i.'" type="text" value="" style="width: 55px;padding:5px 0px 5px 0px;text-align: center;font-size:'. $nval[8].';color:'. $nval[7].';" onchange="calclat(this)" onkeypress="handle(this,event)"/>';
           }
                    
           $textout.=' </td>';
           $textout.='  <td style="vertical-align: middle;padding:0px;border: none;'. $nval[10].'"><input name="discnt'.$i.'" type="text" value="" style="background: none; width: 55px; padding:5px 0px 5px 0px; border: none; text-align: center;  font-size: '. $nval[8].'; color: '. $nval[7].';" /> <input name="disa'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c6.'" /> <input name="disb'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c7.'" /> <input name="disc'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c8.'" /> <input name="disd'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c9.'" /> <input name="dise'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c10.'" /> <input name="disf'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c11.'" /> <input name="disg'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c12.'" />  <input name="disj'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c13.'" /> <input name="dish'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c14.'" />  <input name="disprs'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c16.'" />  <input name="disord'.$i.'" type="hidden" value="'.$s->ListItem[$i]->c15.'" /></td><td style="vertical-align: middle;border: none;padding:0px;"><input name="amnt'.$i.'" type="text" value="0" style="background: none;       width: 70px; border: none;padding:5px 0px 5px 0px; text-align: right;font-size:'. $nval[8].'; color: '. $nval[7].';" /></td> </tr>';
      $i++;
   }
?>
<script type="text/javascript">
    var totalelements = "<?php echo $i; ?>";
    
    function handle(txt,e){
        if(e.keyCode === 13){
           calclat(txt);
        }
        return false;
    }
    
    function calclat(txt){
         var getent = txt.value;
        
         if (parseFloat(getent) > 0) {
            //value is OK
         }else{
            txt.value = "0";
         }
         
         if (totalelements>0) {
           document.quotegen.qgb11.value = totalelements;
           var pr = new Array;
           var qtty = new Array;
           var amt = new Array;
           var subtotal = 0;
           var ord_disc = new Array;
           var prs_disc = new Array;
           var qty_disc = new Array;
           
           var dss1 = new Array;
           var dss2 = new Array;
           var dss3 = new Array;
           var dss4 = new Array;
           var dss5 = new Array;
           var dss6 = new Array;
           var dss7 = new Array;
           var dss8 = new Array;
           var dss9 = new Array;
           var nods ='';
           
           for(var strt=0; strt<totalelements; strt++){
               pr[strt] = eval("document.quotegen.price"+strt+".value");
               qtty[strt] = eval("document.quotegen.qty"+strt+".value");
               
               nods = "checkqty"+strt;
                if (document.getElementById(nods)) {
                  if (document.getElementById(nods).checked) {
                      qtty[strt] = 1;
                      nods = "document.quotegen.qty"+strt+".value = 1;";
                      eval(nods);
                  }else{
                      qtty[strt] = 0;
                      nods = "document.quotegen.qty"+strt+".value = 0;";
                      eval(nods);
                  }
                }
               
               
               amt[strt] = 0;
               ord_disc[strt] = eval("document.quotegen.disord"+strt+".value");
               prs_disc[strt] = eval("document.quotegen.disprs"+strt+".value");
               
               dss1[strt] = eval("document.quotegen.disa"+strt+".value");
               dss2[strt] = eval("document.quotegen.disb"+strt+".value");
               dss3[strt] = eval("document.quotegen.disc"+strt+".value");
               dss4[strt] = eval("document.quotegen.disd"+strt+".value");
               dss5[strt] = eval("document.quotegen.dise"+strt+".value");
               dss6[strt] = eval("document.quotegen.disf"+strt+".value");
               dss7[strt] = eval("document.quotegen.disg"+strt+".value");
               dss8[strt] = eval("document.quotegen.disj"+strt+".value");
               dss9[strt] = eval("document.quotegen.dish"+strt+".value");
               qty_disc[strt] = 0;
               
               if (parseFloat(pr[strt])>0 && parseFloat(qtty[strt])>0) {
                
                   if (parseFloat(qtty[strt])>=parseFloat(dss1[strt]) && parseFloat(qtty[strt])<=parseFloat(dss2[strt]) && parseFloat(dss3[strt])>0 && !isNaN(qtty[strt]) && !isNaN(dss1[strt]) && !isNaN(dss2[strt]) && !isNaN(dss3[strt])) {
                       qty_disc[strt] = (parseFloat(pr[strt])*parseFloat(qtty[strt]))*dss3[strt]/100;
                   }else if (parseFloat(qtty[strt])>=parseFloat(dss4[strt]) && parseFloat(qtty[strt])<=parseFloat(dss5[strt]) && parseFloat(dss6[strt])>0 && !isNaN(qtty[strt]) && !isNaN(dss4[strt]) && !isNaN(dss5[strt]) && !isNaN(dss6[strt])) {
                       qty_disc[strt] = (parseFloat(pr[strt])*parseFloat(qtty[strt]))*dss6[strt]/100;
                   }else if (parseFloat(qtty[strt])>=parseFloat(dss7[strt]) && parseFloat(qtty[strt])<=parseFloat(dss8[strt]) && parseFloat(dss9[strt])>0 && !isNaN(qtty[strt]) && !isNaN(dss7[strt]) && !isNaN(dss8[strt]) && !isNaN(dss9[strt])) {
                       qty_disc[strt] = (parseFloat(pr[strt])*parseFloat(qtty[strt]))*dss9[strt]/100;
                   }
                   
                   amt[strt] = (parseFloat(pr[strt])*parseFloat(qtty[strt])) - qty_disc[strt];
               }
               
            var fnkd = "document.quotegen.discnt"+strt+".value = qty_disc["+strt+"].toFixed(2);";
            eval(fnkd);   
            var fnk = "document.quotegen.amnt"+strt+".value = amt["+strt+"].toFixed(2);";
            eval(fnk);
           }
           
           subtotal = amt.reduce(function(pv, cv) { return pv + cv; }, 0);
           document.quotegen.qgb1.value = subtotal.toFixed(2);
           
           var discount = 0;
           var order_discount = new Array;
           for(strt=0; strt<totalelements; strt++){
              if (parseFloat(ord_disc[strt]) <= subtotal) {
                  order_discount[strt] = amt[strt] * parseFloat(prs_disc[strt])/100;
              }
            
           }
           discount = order_discount.reduce(function(pv, cv) { return pv + cv; }, 0);
           document.quotegen.qgb2.value = discount.toFixed(2);
           
           var t_befor_tax = 0;
           
           var tax1a = '<?php echo $nval[20]; ?>';
           if (parseFloat(tax1a)>=0) { }else{tax1a =0;}
           var tax1 = 0;
           var tax2a = '<?php echo $nval[22]; ?>';
           if (parseFloat(tax2a)>=0) { }else{tax2a =0;}
           var tax2 = 0;
           var tax3a = '<?php echo $nval[24]; ?>';
           if (parseFloat(tax3a)>=0) { }else{tax3a =0;}
           var tax3 = 0;
           
           var total_amount = 0;
           
           t_befor_tax = subtotal - discount;
           document.quotegen.qgb3.value = t_befor_tax.toFixed(2);
           
           tax1 = t_befor_tax * parseFloat(tax1a)/100;
           document.quotegen.qgb4.value = tax1.toFixed(2);
           tax2 = t_befor_tax * parseFloat(tax2a)/100;
           document.quotegen.qgb5.value = tax2.toFixed(2);
           tax3 = t_befor_tax * parseFloat(tax3a)/100;
           document.quotegen.qgb6.value = tax3.toFixed(2);
           
           total_amount = t_befor_tax + tax1 + tax2 + tax3;
           document.quotegen.qgb7.value = total_amount.toFixed(2);
         }
         
 
    }
    
    function submitf() {
       if( parseFloat(document.quotegen.qgb7.value)>0 ) {
           document.getElementById("subord").style.display = "block";
           document.getElementById("buttn1").style.display = "none";
           return true;
       }else{
           alert("Please fill out this form.");
           return false;
       }
    }
    function submitform() {

       var mmm = document.quotegen.qgb10.value;
       if (document.quotegen.qgb8.value==""){
	    alert("Please enter your <?php echo $nval[35]; ?>!");
	    return false;

        } else if ((mmm.indexOf("@") == -1)||(mmm.indexOf(".") == -1)){ 
	     alert("Please enter valid Email Address!");
	     return false;
        }

       document.quotegen.method = "POST";
       document.quotegen.submit();
       return true;
    }
</script>
<div style="color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>;">
    Instant Quote
</div>

<form method="post" id="quotegen" name="quotegen" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
 <table style="text-align: center;padding: 0px;border-spacing: 0;border-collapse: collapse;width:<?php echo $nval[1]; ?>;background: <?php echo $nval[2]; ?>; border:<?php echo $nval[3]; ?>; font-size: <?php echo $nval[8]; ?>; color: <?php echo $nval[7]; ?>;">
    <tr>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;"><?php echo $nval[25]; ?></th>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;"><?php echo $nval[26]; ?></th>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;<?php echo $nval[13]; ?>"><?php echo $nval[27]; ?>(<?php echo $nval[18]; ?>)</th>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;"><?php echo $nval[28]; ?></th>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;<?php echo $nval[10]; ?>"><?php echo $nval[29]; ?>(<?php echo $nval[18]; ?>)</th>
        <th style="border:none;color:<?php echo $nval[4]; ?>; font-size: <?php echo $nval[5]; ?>; background: <?php echo $nval[6]; ?>;text-align: center;"><?php echo $nval[30]; ?>(<?php echo $nval[18]; ?>)</th>
    </tr>
    
    <?php echo $textout; ?>

    <tr style="background: <?php echo $nval[9]; ?>;<?php echo $nval[14]; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;">Subtotal(<?php echo $nval[18]; ?>)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb1" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>    
    <tr style="background: <?php echo $bgrd; ?>;<?php echo $nval[11]; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;">Discount(<?php echo $nval[18]; ?>)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb2" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>        
    <tr style="background: <?php echo $nval[9]; ?>;<?php echo $nval[15]; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;">Total before Tax</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb3" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>
    
    <tr style="background: <?php echo $bgrd; ?>;<?php echo $nval[16]; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;"><?php echo $nval[19]; ?> (<?php echo $nval[20]; ?>%)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb4" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>      
    <tr style="background: <?php echo $bgrd; ?>;<?php echo $nval[16]; ?><?php echo $show_tax2; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;"><?php echo $nval[21]; ?> (<?php echo $nval[22]; ?>%)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb5" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>
    <tr style="background: <?php echo $bgrd; ?>;<?php echo $nval[16]; ?><?php echo $show_tax3; ?>">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;"><?php echo $nval[23]; ?> (<?php echo $nval[24]; ?>%)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;"><input name="qgb6" type="text" style="<?php echo $style_calc; ?>" value="0" /></td>
    </tr>    
    
    <tr style="background: <?php echo $nval[9]; ?>;">
        <td style="border:none;"></td>
        <td style="border:none;<?php echo $nval[13]; ?>"></td>
        <td style="border:none;"></td>
        <td style="border:none;text-align: right;padding-right: 7px;font-weight: bold;">Total(<?php echo $nval[18]; ?>)</td>
        <td style="border:none;<?php echo $nval[10]; ?>"></td>
        <td style="border:none;">
            <input name="qgb7" type="text" style="<?php echo $style_calc; ?>" value="0" />
            <input name="qgb11" type="hidden" value="" />
        </td>
    </tr>
    
    <tr style="background: none;">
        <td colspan="6" style="border:none;padding: 10px;text-align: center;">
            <input type="button" id="buttn1" style="<?php echo $style_but; ?>" onClick="submitf();" value="<?php echo $nval[31]; ?>">
        </td>
    </tr>
    <tr style="background: none;">
        <td colspan="6" style="border:none;text-align: center;padding:15px;">
            <div id="subord" style="display:none;text-align: center; background: #eeeeee;padding:15px;">
                <table style="text-align: center;">
                    <tr>
                        <td><?php echo $nval[35]; ?></td>
                        <td><input name="qgb8" type="text" style="<?php echo $style_qntt2; ?>" value="" /></td>
                    </tr>
                    <tr>
                        <td><?php
                               echo $nval[36];
                               if($nval[36]!=''){
                                $ttype='text';
                              }else{
                                $ttype='hidden';
                              }
                            ?>
                        </td>
                        <td><input name="qgb9" type="<?php echo $ttype; ?>" style="<?php echo $style_qntt2; ?>" value="" /></td>
                    </tr>
                    
                    <tr>
                        <td>Email Address</td>
                        <td><input name="qgb10" type="text" style="<?php echo $style_qntt2; ?>" value="" /></td>
                    </tr>
                    
                    <tr>
                        <td><?php
                              echo $nval[37];
                              if($nval[37]!=''){
                                $ttype2='text';
                              }else{
                                $ttype2='hidden';
                              }
                            ?>
                        </td>
                        <td><input name="qgb12" type="<?php echo $ttype2; ?>" style="<?php echo $style_qntt2; ?>" value="" /></td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="2" style="padding:10px;text-align: center;">
                            <input type="button" style="<?php echo $style_but; ?>" onClick="submitform();" value="<?php echo $nval[32]; ?>">
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    
 </table>
</form>