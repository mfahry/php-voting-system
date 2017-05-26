<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Pemilu Oasis</title>
        <link href="scripts/css/reseter.css" rel="stylesheet" type="text/css"/>
        <link href="scripts/css/style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="scripts/js/jquery.js"></script>
        <script type="text/javascript" src="scripts/js/modalwindow.js"></script>
        <script type="text/javascript" src="scripts/js/process.js"></script>
    </head>
    <body>
        <div id="ground">
            <div id="page">
            	<div id="header">
            		<h1>PEMILU RAYA POLITEKNIK TELKOM 2012</h1>
            	</div>
            	<div id="content">
            		<div id="form">
            			<input type="hidden" id="go" value="ajax/startvote.php"/>
            			<div style="float: left;width:450px;text-align: center;">
            				<span class="titlepage">Mulai Pemilihan</span>
            				<hr/>
		            		<div style="margin: 40px 0px 50px 0px">
		            			<p style="font-size: 18px;color:#777;font-weight:bold;margin: 5px 0px;">NIM ANDA</p>
		            			<p style="margin: 5px 0px;"><input type="text" id="nim" class="bigtext" /></p>
		            			<p style="margin: 5px 0px;"><input type="button" class="bigbutton" value="START VOTE" id="start" /></p>
		            		</div>
            			</div>
            			<div style="float: left;border-left: 1px solid #eee;padding:10px;margin-left:10px;width:300px;">
            					test test test test test test test test test test test test
            					test test test test test test test test test test test test
            					test test test test test test test test test test test test
            					test test test test test test test test test test test test
            					test test test test test test test test test test test test
            			</div>
            			<div style="clear: left;"></div>
            		</div>
            	</div>
            </div>
            <div id="mask">
	        </div>
            <div class="maskcontent" id="windowmodal">
	            <div id="titlemodal"></div>
	            <div id="messagemodal"></div>
	        </div>
        </div>
    </body>
</html>
