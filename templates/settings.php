<div class="wrap">
    <h2>Quote Generator Settings</h2>
    <form method="post" id="frmsave" action="options.php">
        <script type="text/javascript">
            function save_item(){            
                     jQuery(document).ready(function () {
                      jQuery(function ($) {
                        var folldd = '../wp-content/plugins/quotegenerator/templates/save_item.php';
                        $.post(folldd, $("#frmsave").serialize());
                       });
                      });
                     
                     alert("New Item has been saved!");
                     window.location.href = "options-general.php?page=quotegenerator&links=items";
            }
            function ret_item(){                   
                     window.location.href = "options-general.php?page=quotegenerator&links=items";
            }
            function del_item(nod){
                
                     document.getElementById('delete_item').value = nod;
                     jQuery(document).ready(function () {
                      jQuery(function ($) {
                        var folldd = '../wp-content/plugins/quotegenerator/templates/delete_item.php';
                        $.post(folldd, $("#frmsave").serialize());
                       });
                      });
                     //alert("The Item has been deleted!");
                     window.location.href = "options-general.php?page=quotegenerator&links=items";
            }
            function save_itm(nod){
                     document.getElementById('save_items').value = nod;
                     jQuery(document).ready(function () {
                      jQuery(function ($) {
                        var folldd = '../wp-content/plugins/quotegenerator/templates/save_item.php';
                        $.post(folldd, $("#frmsave").serialize());
                       });
                      });
                     alert("The Item has been saved!");
                     window.location.href = "options-general.php?page=quotegenerator&links=items";
            }
        </script>
        <style>
            .butn{
                color :#0093B8;
                font-size: 18px;
                padding: 4px;
                font-style: italic;
                
            } 
            .but{
                background: #00A6CF;
                height: 30px;
                color :#fff;
                padding: 4px 20px 4px 20px;
                text-decoration: none;
                border-radius: 3px; -webkit-border-radius: 3px; -khtml-border-radius:3px;
	        border:1px solid #999999;
            }
            .but:hover {color:#f0f0f0;background: #0093B8;}
            .tbl1 {width: 500px;font-size: 12px;}
            .tbl1 td{padding: 4px;border:1px solid #eee;}
        </style>
        
        <table>
            <tr>
            <td><?php $imageqg = sprintf("%s/quotegenerator/templates/images/quotegenerator.jpg", plugins_url()); ?>
                <img src="<?php echo $imageqg; ?>" width="30" height="30" alt="QuoteGeneratorPlus"></td>
            <td><a href="options-general.php?page=quotegenerator&links=style" class="butn">Style</a></td>
            <td><a href="options-general.php?page=quotegenerator&links=form" class="butn">Form</a></td>
            <td><a href="options-general.php?page=quotegenerator&links=items" class="butn">Items</a></td>
           </tr>
        </table>
        
          <table>
           <tr>
            <?php if($_GET["links"]=="style"){ ?> 
            <td style="width: 520px;background: #fefefe;padding: 5px;">
              <div style="height: 580px;overflow-y: scroll;text-decoration:none;line-height: normal;">
                        <?php @settings_fields("wp_plugin_template-group"); ?>
                        <?php @do_settings_fields("wp_plugin_template-group"); ?>
                        <?php do_settings_sections("quotegenerator"); ?>
              </div>
              <?php @submit_button(); ?>
            </td>
            
            <?php }else if($_GET["links"]=="form"){ ?>
            <td style="width: 520px;background: #f9f9f9;padding: 5px;">
               <div style="height: 580px;overflow-y: scroll;text-decoration:none;line-height: normal; ">  
                        <?php @settings_fields("wp_plugin_template-group2"); ?>
                        <?php @do_settings_fields("wp_plugin_template-group2"); ?>
                        <?php do_settings_sections("quotegenerator2"); ?>
               </div>
               <table style="font-size: 10px;margin-top:10px;text-align: justify;background: #fefefe;padding: 7px;">
                     <tr><td>* The input fields (Quantity Discounts, Order Total Discount, Description, Price, Subtotal, Total before tax, Tax) must have (show or hide) value. </td></tr>
               </table>
               <?php @submit_button(); ?>
            </td>
            
            <?php }else if($_GET["links"]=="items"){ ?>
            <td style="width: 520px;background: #f9f9f9;padding: 5px;">
               <div style="height: 580px;overflow-y: scroll; ">  
                        <?php
                            include "metabox.php";
                            $get_fun = showitem();
                            $gets = explode("!!!!",$get_fun);
                            echo $gets[0];
                            if(($gets[1]>$gets[2]-1)){$nexts = $gets[2]-1;}else{$nexts = $gets[1];}
                            $new_item = 'options-general.php?page=quotegenerator&links=items&itemsnum='.$nexts;
                            if(($gets[1]-2)<0){$privs = 0;}else{$privs = $gets[1]-2;}
                            $new_item2 = 'options-general.php?page=quotegenerator&links=items&itemsnum='.$privs;
                            $new_item3 = 'options-general.php?page=quotegenerator&links=items&itemsnum=deleteXXX'.($gets[1]-1);
                        ?>
               
                 <div id="buttn1" style="text-align: center;margin: 20px;">
                   <a href="options-general.php?page=quotegenerator&links=items&itemsnum=0" class="but"><<</a>
                   <a href="<?php echo $new_item2; ?>" class="but">< Previous</a>
                   <a href="javascript:save_itm(<?php echo ($gets[1]-1); ?>);" class="but">&nbsp; &nbsp; Save &nbsp; &nbsp;</a>
                   <a href="<?php echo $new_item; ?>" class="but">&nbsp; &nbsp; Next > &nbsp; &nbsp;</a>
                   <a href="options-general.php?page=quotegenerator&links=items&itemsnum=<?php echo ($gets[2]-1); ?>" class="but">>></a>
                 </div>
               
                <div id="buttn2" style="text-align: center;margin: 20px;">
                  <a href="options-general.php?page=quotegenerator&links=items&itemsnum=add" class="but">&nbsp; &nbsp; &nbsp; Add &nbsp; &nbsp; &nbsp;</a>&nbsp;
                  <a href="javascript:save_item();" class="but">Save as new</a>&nbsp;
                  <a href="<?php echo $new_item3; ?>" class="but">&nbsp; &nbsp; Delete &nbsp; &nbsp;</a>
                  <input type="hidden" id="delete_item" name="delete_item" value="" />
                  <input type="hidden" id="save_items" name="save_items" value="" />
                  
                  <table style="font-size: 10px;margin-top:10px;text-align: justify;background: #fefefe;padding: 7px;">
                     <tr><td>* If <strong>Maximum Quantity</strong> equal 1, then application will show checkbox otherwise input-box.</td></tr>

                     <tr><td>** There are two types of discount that you can offer to customers.<br>
                              &nbsp; 1. <strong>Quantity discounts</strong> give customers special pricing when they buy products in bulk. When you set up quantity discounts in your store, you can offer percent off discounts. For example, you might want to reduce the price by 5% if they buy more than 20 of a certain product, and 10% if they buy more than 50. To do this you need to set up a discount for each quantity range, Discount #1 "20 - 49" 5% and Discount #2 "50 and over" 10%.<br>
                              &nbsp; 2. <strong>Order total discounts</strong> deduct a percentage of the purchase total (e.g. 10% off). The order total discount is applied to the total price of all of the products being purchased. 
                         </td>
                     </tr>
                     <tr><td>&nbsp;</td></tr>
                     <tr><td>*** Calculations<br>
                             &nbsp; Amount = Price * Quantity<br>
                             &nbsp; When you set up quantity discounts:<br>
                             &nbsp; &nbsp; Amount = (Price * Quantity) - (Price * Quantity * % of Discount)<br>
                             &nbsp; Subtotal = <span style="font-size: 16px;">&Sigma;</span>(Amount)<br>
                             &nbsp; When you set up Order total discounts:<br>
                             &nbsp; &nbsp; Subtotal = <span style="font-size: 16px;">&Sigma;</span>(Amount) - <span style="font-size: 16px;">(&Sigma;</span>(Amount)* % of Discount<span style="font-size: 16px;">)</span>
                         </td>
                     </tr>
                  </table>
                </div>
               
               
               </div>
               
            </td>
            <?php }?>
           </tr>
           
          </table>
          <table style="margin-top:20px;font-size: 14px;">
            <tr>
                <td>* The following shortcode can now be added to any page or post: [quotegenerator file='qgcode']<br>
                    * Assuming file 'qgcode.php' exists in your theme's folder, it will be inserted at that point in the content.<br>
                    * Please note [Items] form has been set up as an example (cleaning service).<br>
                    * Now you can start making some general edits that will apply themselves to the whole form. 
                </td>
            </tr>
          </table>
          
    </form>
</div>