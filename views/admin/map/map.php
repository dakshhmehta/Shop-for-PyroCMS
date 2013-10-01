	<div style="float:left">
	  <div id='mapDiv' style="position:relative; width:400px; height:400px;"></div>
	  <input id="txtQuery" type="text" value="<?php echo $address; ?>"/>
	  <input type="button" value="Locate" onclick="ClickGeocode()">
	 </div>
	  
	  <script>
			GetMap();
			ClickGeocode();
	</script>
	
	  <div id='mapDiv2' style="float:left; width:300px; height:400px;background-color:#eee">
		<div style="padding:10px;margin:5px;">
		   <input type="button" value="Find Business" onclick="LoadSearchModule();" />

		</div>
	  </div>