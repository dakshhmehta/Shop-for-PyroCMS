
			
		
				<li><a class=""  data-load="" href="#start-tab"><span><?php echo shop_lang('shop:products:start'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="product" href="#product-tab"><span><?php echo shop_lang('shop:products:product'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="description" href="#description-tab"><span><?php echo shop_lang('shop:products:description'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="price" href="#price-tab"><span><?php echo shop_lang('shop:products:price'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="discounts" href="#discounts-tab"><span><?php echo shop_lang('shop:products:discounts'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="images" href="#images-tab"><span><?php echo shop_lang('shop:products:images'); ?></span></a></li>
				<li><a class="tab-loader"  data-load="attributes" href="#attributes-tab"><span><?php echo shop_lang('shop:products:attributes'); ?></span></a></li>
				



				<?php if(group_has_role('shop', 'admin_product_options')): ?>
					<li><a class="tab-loader"  data-load="options" href="#options-tab"><span><?php echo shop_lang('shop:products:options'); ?></span></a></li>
				<?php endif; ?>


				<li><a class="tab-loader"  data-load="inventory" href="#inventory-tab"><span><?php echo shop_lang('shop:products:inventory'); ?></span></a></li>
			

				<?php if(group_has_role('shop', 'admin_product_seo')): ?>
					<li><a class="tab-loader"  data-load="seo" href="#seo-tab"><span><?php echo shop_lang('shop:products:seo'); ?></span></a></li>
				<?php endif; ?>


				<?php if(group_has_role('shop', 'developer_fields')): ?>
					<li><a class=""  data-load="" href="#console-tab"><span><?php echo shop_lang('shop:products:console'); ?></span></a></li>
				<?php endif; ?>

		
			