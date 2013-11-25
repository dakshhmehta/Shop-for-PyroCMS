<?php

?>



<button class="shopbutton button-flat-primary" value="save_exit" name="btnAction" type="submit">
	<span><?php echo lang('shop:buttons:save_and_exit');?></span>
</button>

<button class="shopbutton button-flat-primary" value="save" name="btnAction" type="submit">
	<span><?php echo lang('shop:buttons:save');?></span>
</button>	



<a href='admin/shop/products' class='shopbutton button-flat'><?php echo lang('shop:buttons:cancel');?></a>


<span style="color:#ddd">
||| 
</span>

<a href='admin/shop/product/delete/<?php echo $id;?>' class='confirm shopbutton button-flat red'><?php echo lang('shop:buttons:delete');?></a>