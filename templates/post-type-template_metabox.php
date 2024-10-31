<table>
            <?php
             $arrsize = 37;
     
             for($qx=1; $qx<$arrsize; $qx++){
                 $vall = @get_post_meta($post->ID, 'meta_qg'.$qx, true);
                 echo ('<tr valign="top"><td class="metabox_label_column"><label for="meta_qg'.$qx.'">Meta QG'.$qx.'</label></td>  <td><input type="text" id="meta_qg'.$qx.'" name="meta_qg'.$qx.'" value="'. $vall.'" /></td> </tr>');
    
             }
            ?>
</table>
