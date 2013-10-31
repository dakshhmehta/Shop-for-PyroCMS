
<div id="sortable">

	<?php echo $this->load->view('admin/charts/partials/title', array('title'=>'') ); ?>


	<div class="one_full" id="">

	    <section class="title">
	    <h4><?php echo shop_lang('shop:charts:all_orders');?> </h4>
	    </section>

	    <section class="item">
		    <section class="chart-tabs">
		        <ul class="tab-menu">
		            <li class=""><a href="admin/shop/charts/stats/orders/1" class="chart-data"><span><?php echo shop_lang('shop:dashboard:day');?></span></a></li>
		            <li class=""><a href="admin/shop/charts/stats/orders/7" class="chart-data"><span><?php echo shop_lang('shop:dashboard:week');?></span></a></li>
		            <li class="ui-state-active"><a href="admin/shop/charts/stats/orders/30" class="chart-data"><span><?php echo shop_lang('shop:dashboard:30_day');?></span></a></li>
		            <li class=""><a href="admin/shop/charts/stats/orders/180" class="chart-data"><span><?php echo shop_lang('shop:dashboard:180_day');?></span></a></li>
		        </ul>
		    </section>

		    <section class="item">
		        <div class="content">
		            <div class="tabs">
		                <div id="chart_div" style="width: 100%; height: 230px;"></div>
		            </div>            
		        </div>
		    </section>   
	    </section>




	</div>



	<?php echo $this->load->view('admin/charts/partials/more'); ?>


	
</div>	





