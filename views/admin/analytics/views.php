
<div id="sortable">


	<div class="one_full" id="">

	    <section class="title">
	    	<h4><?php echo lang('shop:analytics:most_viewed');?> </h4>
	    </section>

	    <section class="item">
		    <section class="chart-tabs">
		        <ul class="tab-menu">
		            <li class="ui-state-active"><a href="admin/shop/analytics/stats/views/5" class="chart-data"><span><?php echo lang('shop:analytics:top_5');?></span></a></li>
		            <li class=""><a href="admin/shop/analytics/stats/views/10" class="chart-data"><span><?php echo lang('shop:analytics:top_10');?></span></a></li>
		            <li class=""><a href="admin/shop/analytics/stats/views/15" class="chart-data"><span><?php echo lang('shop:analytics:top_15');?></span></a></li>
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


	<?php echo $this->load->view('admin/analytics/partials/more'); ?>

	
</div>	
