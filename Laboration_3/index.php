<?php
    $api_key = file_get_contents('src/api_key.txt');
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
 	<title>TrafficMapper</title>
 	<link href='//fonts.googleapis.com/css?family=Happy+Monkey' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/customStyle.css" media="screen">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
 	 	
</head>
    
    <body>
        <div class="container">
            <div class="page-header">
                <h1>TrafficMashup</h1>
            </div>
            <div class='col-md-4 pull-left messageListDiv'>
                <div class='pull-top panel panel-info' >
                    <div class="panel-heading">
                    <h3>Trafikrapporter</h3></div>
                        <div class="list-group" id="categoryType">
                            <a class="list-group-item" href="#" data-category-type="4"><i class="fa fa-home fa-fw"></i>&nbsp; Alla Kategorier</a>
                            <a class="list-group-item" href="#" data-category-type="0"><i class="fa fa-car fa-fw"></i>&nbsp; Vägtrafik</a>
                            <a class="list-group-item" href="#" data-category-type="1"><i class="fa fa-bus fa-fw"></i>&nbsp; Kollektivtrafik</a>
                            <a class="list-group-item" href="#" data-category-type="2"><i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp; Planerad störning</a>
                            <a class="list-group-item" href="#" data-category-type="3"><i class="fa fa-cube fa-fw"></i>&nbsp; övrigt</a>
                        </div>
                        <div id="trafficListing" class="panel-body"></div>
                    </div>
                </div>
            <div class="col-md-8 map">
                <div id="map-canvas"></div>
            </div>
            <footer>
                <div class='col-md-5 page-header pull-left'>
                    <h5>Created by Vivi Lam - vl222cu</h3>
                </div>
            </footer>
        </div>
        <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=<?= $api_key ?>&sensor=false">
        </script>
        <script src="script/map.js"></script>
        <script src="script/trafficInfo.js"></script>
    </body>
</html>