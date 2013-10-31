
<div id="sortable">

	<?php echo $this->load->view('admin/charts/partials/title', array('title'=>'') ); ?>




	<div class="one_full" id="">

	    <section class="title">
	    	<h4><?php echo shop_lang('shop:charts:best_sellers');?> </h4>
	    </section>

	    <section class="item">
		    <section class="chart-tabs">
		        <ul class="tab-menu">
		            <li class="ui-state-active"><a href="admin/shop/charts/stats/best/5" class="chart-data"><span><?php echo shop_lang('shop:dashboard:top_5');?></span></a></li>
		            <li class=""><a href="admin/shop/charts/stats/best/10" class="chart-data"><span><?php echo shop_lang('shop:dashboard:top_10');?></span></a></li>
		            <li class=""><a href="admin/shop/charts/stats/best/15" class="chart-data"><span><?php echo shop_lang('shop:dashboard:top_15');?></span></a></li>
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
