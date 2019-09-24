<?php
header("Access-Control-Allow-Origin: *\r\n");
//
?>
<html>
   <head>
    <title>Example</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v5.2.0/css/ol.css" type="text/css">
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
	<!-- jQuery -->
    <script src="jquery/jquery-1.10.1.min.js"></script>
	<script src="ol/ol.js"></script>
	<link rel="stylesheet" href="ol/ol.css" />
	<!-- node_modules/ol-layerswitcher/src -->
	
	 <!-- layerSwitcher -->
	 <script src="node_modules/ol-layerswitcher/dist/ol-layerswitcher.js"></script>
	 <link rel="stylesheet" href="node_modules/ol-layerswitcher/src/ol-layerswitcher.css" />
	 <!-- -->
	 	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  <style>
	input:first-of-type {
		  display: none;
		}
	#Sel_Check{
		 display: inline;
	}
  
	html, body, #map{
			width:50%; 
			height:50%;
			overflow: hidden;
	}
	#map{
			position:absolute;
			z-index:1;
			top:0; bottom:0;
			width: 100%; height: 100%;
	}
	.ol-popup {
			position: absolute;
			min-width: 200px;
			background-color: white;
			-webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
			filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
			padding: 15px;
			border-radius: 10px;
			border: 1px solid #ccc;
			bottom: 12px;
			left: -50px;
	}
	.ol-popup:after, .ol-popup:before {
			top: 100%;
			border: solid transparent;
			content: " ";
			height: 0;
			width: 0;
			position: absolute;
			pointer-events: none;
	}
	.ol-popup:after {
			border-top-color: white;
			border-width: 10px;
			left: 48px;
			margin-left: -10px;
	}
	.ol-popup:before {
			border-top-color: #cccccc;
			border-width: 11px;
			left: 48px;
			margin-left: -11px;
	}
	.ol-popup-closer {
			text-decoration: none;
			position: absolute;
			top: 2px;
			right: 8px;
	}
	.ol-popup-closer:after {
			content: "✖";
	}				
	.layer{
			font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
	}	
	
#featured_image {
  z-index:5;
  top: 80px;
  right: 20px;
  width: 70px;
  height: 70px;
  //background: no-repeat url('http://openlayers.org/en/latest/examples/resources/logo-70x70.png')
}
</style>
 <div id="map" class="map" tabindex="0"></div>
  <div id="popup" class="ol-popup">
            <a href="#" id="popup-closer" class="ol-popup-closer"></a>
            <div id="popup-content"></div>
        </div>
	<!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
	<!-- -->
  <script>
  
var allSubstrings = [];

 var overlayGroup = new ol.layer.Group({
						title: '<input type="checkbox" id="Sel_Check" onclick="checkAll()" ></input><a id="selectAll">Select/Deselect All</a>',
						layers: [ ]
				});

//WMS Group
 var wmsGroup = new ol.layer.Group({
						title: '<input type="checkbox" id="Sel_Check" onclick="checkAllWMS()" ></input><a id="selectAll">Select/Deselect All</a>',
						layers: [ ]
				});
  //Tentativo di ChecKall
  
function checkAll(){
if ($('#Sel_Check').is(":checked")){
		 var inputs = document.getElementsByTagName("input");
			var livelli = overlayGroup.getLayers().getArray();
				for (var i = 2; i < inputs.length; i++) { 
						var j=i-2;
						inputs[i].checked = true;								
								layer01= livelli[j];
								layer01.setVisible(true);
						} 
		}else{
			//do nothing
			var inputs = document.getElementsByTagName("input");
			var livelli = overlayGroup.getLayers().getArray();
				for (var i = 2; i < inputs.length; i++) { 
						var j=i-2;
						inputs[i].checked = false;								
								layer01= livelli[j];
								layer01.setVisible(false);
						} 
				//
		}					
}					
  
			var xmlText = '';
			 var result;
			 var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
				  
				if (this.readyState == 4 && this.status == 200) {
				  result = this.responseText;				  
					//var allSubstrings = [];
					
					var count = (result.match('<wfs:Title>')).length;
					var valore = result.split("<wfs:Title>");					
					  for ( var i = 1; i < valore.length; i++  ) {
						  var indexI = valore[i];
						  var valore2 = indexI.split("</wfs:Title>");
							allSubstrings.push(valore2[0]); 
					  }
					var raster = new ol.layer.Group({
							layers:[
									new ol.layer.Tile({
									source: new ol.source.OSM({
									  imagerySet: 'Aerial',
									  type: 'base',
										})
									})
								]
				  });
				  						 
					
				  		  
					var map = new ol.Map({
										layers: [raster, overlayGroup],
										target: document.getElementById('map'),
										view: new ol.View({
												  center: ol.proj.transform( [12.335848, 45.438025], 'EPSG:4326', 'EPSG:3857'),
												  maxZoom: 19,
												  zoom: 13
												})
									});
										
									
					var layerSwitcher = new ol.control.LayerSwitcher();
					map.addControl(layerSwitcher);
					map.showPanel;
					var list_style = ["#9D2EA1","#529C74","#70D6B2","#B80710","#AA3939","#EE8313","#FED273","#F7ED14","#F7A803","#D46A6A","#AA6C39","#5D7578","#5B8C0B","#96CB3F","#655091"];

							  for(var j=0; j<allSubstrings.length; j++){						   
										var allShapes = [];
										var y = j;
										if (y < list_style.length){
											color_style = list_style[y];
										}else{
											var n = Math.floor(Math.random() * (+list_style.length - +0)) ;
											color_style = list_style[n];
										}
										var feature_url = 'https://arcgis.km4city.org/arcgisserver/services/VeneziaMapService2/MapServer/WFSServer/?service=wfs&version=1.1.0&request=GetFeature&typeNames='+allSubstrings[j];
										var feature_description = 'https://arcgis.km4city.org/arcgisserver/services/VeneziaMapService2/MapServer/WFSServer/?service=wfs&version=1.1.0&request=DescribeFeatureType&typeNames='+allSubstrings[j];
										var shape = 'fa fa-circle';
										var vectorSource = new ol.source.Vector({
											url: feature_url,	
											format: new ol.format.WFS({
											srsName: 'EPSG:4326'
											}),
											projection: 'EPSG:4326'
										});
										/**/
											var return_first = function () {
												$.ajax({
													url: feature_description,
													async: false,
													success: function (data) {
														xmlText = new XMLSerializer().serializeToString(data);
														if(xmlText.indexOf('gml:MultiSurfacePropertyType') !== -1){
																			shape = 'fa fa-square';
																}else if(xmlText.indexOf('gml:PointPropertyType') !== -1){
																			shape = 'fa fa-circle';
																}else if (xmlText.indexOf('gml:MultiCurvePropertyType') !== -1){
																			shape = 'fa fa-minus';
																}else{
																	shape = 'fa fa-circle';
																}
														}
												});
											}();
											
											
										//WMS
										var new_lev = new ol.layer.Tile({
													  extent: [-13884991, 2870341, -7455066, 6338219],
													  source: new ol.source.TileWMS({
														url: 'https://ahocevar.com/geoserver/wms',
														params: {'LAYERS': 'topp:states', 'TILED': true},
														serverType: 'geoserver'
													  })
													});
													
													
										 //wmsGroup.getLayers().push(new_lev);
										//
								
									overlayGroup.getLayers().push(
										 new ol.layer.Vector({
											source: vectorSource,
											title: '<i class="'+shape+'" style="font-size:12px;color:'+color_style+';"></i>	'  + allSubstrings[j],
											style: [ new ol.style.Style({
														image: new ol.style.Circle({
																fill: new ol.style.Fill({
																	color: color_style
																}),
																radius: 5,
																stroke: new ol.style.Stroke({
																	color: '#00f',
																	width: 1
																	})
																})
														}),
													new ol.style.Style({
														fill: new ol.style.Fill({
																	color: color_style
																}),
																radius: 5,
																stroke: new ol.style.Stroke({
																	color: '#00f',
																	width: 1
																})
													}),
													new ol.style.Style({
																stroke: new ol.style.Stroke({
																color: color_style,
																width: 1
																})
															})]
											})
									);	

							}
			
	//MOSTRA JOB TYPE
				/**	Popup	**/		
				var	container = document.getElementById('popup');
				var	content_element = document.getElementById('popup-content');
				var	closer = document.getElementById('popup-closer');

				closer.onclick = function() {
					overlay.setPosition(undefined);
					closer.blur();
					return false;
				};
				var overlay = new ol.Overlay({
					element: container,
					autoPan: true,
					offset: [0, -10]
				});
				map.addOverlay(overlay);
				var fullscreen = new ol.control.FullScreen();
				map.addControl(fullscreen);

				map.on('click', function(evt){
					var feature = map.forEachFeatureAtPixel(evt.pixel,
					  function(feature, layer) {
						return feature;
					  });
					if (feature) {
						var geometry = feature.getGeometry();
						var coord = geometry.getCoordinates();
						//
						var content = '';
						if(feature.get('nome_park')){
							content += '<b>Nome:</b>	'+feature.get('nome_park')+'<br />';
						}
						if (feature.get('descr')){
							content += '<b>Descrizione:</b>	'+feature.get('descr')+'<br />';
						}
						if (feature.get('descrizion')){
							content += '<b>Descrizione:</b>	'+feature.get('descrizion')+'<br />';
						}
						if (feature.get('indirizzo')){
							content += '<b>Indirizzo:</b>	'+feature.get('indirizzo')+'<br />';
						}
						if (feature.get('sub_codice')){
							content += '<b>sub_codice:</b>	'+feature.get('sub_codice')+'<br />';
						}
						if (feature.get('num_civico')){
							content += '<b>num_civico:</b>	'+feature.get('num_civico')+'<br />';
						}
						if (feature.get('ente')){
							content += '<b>ente:</b>	'+feature.get('ente')+'<br />';
						}
						if (feature.get('categoria')){
							content += '<b>Categoria:</b>	'+feature.get('categoria')+'<br />';
						}
						if (feature.get('url')){
							content += '<b>Url:</b>	'+feature.get('url')+'<br />';
						}
						if (feature.get('codice')){
							content += '<b>Codice:</b>	'+feature.get('codice')+'<br />';
						}
						if (feature.get('ambito')){
							content += '<b>Ambito:</b>	'+feature.get('ambito')+'<br />';
						}
						if (feature.get('tipo')){
							content += '<b>Tipo:</b>	'+feature.get('tipo')+'<br />';
						}
						if (feature.get('giacitura')){
							content += '<b>Giacitura:</b>	'+feature.get('giacitura')+'<br />';
						}
						if (feature.get('superficie')){
							content += '<b>Superficie:</b>	'+feature.get('superficie')+'<br />';
						}
						if (feature.get('descriz')){
							content += '<b>Descrizione:</b>	'+feature.get('descriz')+'<br />';
						}
						if (feature.get('fermata')){
							content += '<b>Fermata:</b>	'+feature.get('fermata')+'<br />';
						}
						if (feature.get('localizz')){
							content += '<b>Localizzione:</b>	'+feature.get('localizz')+'<br />';
						}
/******/
						content_element.innerHTML = content;
									if (Array.isArray(coord[0])){
										var poin = coord[0].length;
										var lun = poin/2;
										if (!(coord[0][lun])){
											overlay.setPosition(coord[0][0][0]);
										}else{
											overlay.setPosition(coord[0][lun]);
										}
									}else{
										overlay.setPosition(coord);
									}
							}
				});
				map.on('pointermove', function(e) {
					if (e.dragging) return;					   
					var pixel = map.getEventPixel(e.originalEvent);
					var hit = map.hasFeatureAtPixel(pixel);					
					map.getTarget().style.cursor = hit ? 'pointer' : '';
				});	 
						
		}
	  };
	  xhttp.open("GET", "https://arcgis.km4city.org/arcgisserver/services/VeneziaMapService2/MapServer/WFSServer/?service=wfs&version=1.1.0&request=GetCapabilities", true);
	  xhttp.send();	
			  	  

    </script>
  </body>
</html>