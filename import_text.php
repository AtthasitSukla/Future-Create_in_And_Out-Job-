<? include("connect.php");  ?>
<?
	
	
	$status = $_REQUEST['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Import Text File</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
   <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->

<script>

$(function() {

	
	});
	

	
	
	

	function checkenter(event){}
		
		function upfile(){
	var chkfile=document.getElementById('filename').value;
	if(chkfile==""){
		alert("กรุณาเลือกไฟล์ที่ต้องการ Upload");
		return false;
		}
	document.forms["upload"].submit();
	}
	
	function confirmdelete(owner){
	if(confirm("Delete all temp?")==true){
		window.location='import_text.php?status=deletetemp';
	}else{
		return false;
	}
}
function confirmsave(owner){
	if(confirm("Save all data to DB?")==true){
		window.location='import_text.php?status=savedata';
	}else{
		return false;
	}
}
	
</script>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-brown">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Create Post
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-grape">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-group"></i></div>
                            <div class="pull-right"><span class="badge">2</span></div>
                        </div>
                        <div class="tiles-footer">
                            Contacts
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-primary">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                            <div class="pull-right"><span class="badge">10</span></div>
                        </div>
                        <div class="tiles-footer">
                            Messages
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-inverse">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-camera"></i></div>
                            <div class="pull-right"><span class="badge">3</span></div>
                        </div>
                        <div class="tiles-footer">
                            Gallery
                        </div>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-midnightblue">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-cog"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-orange">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-wrench"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Plugins
                        </div>
                    </a>
                </div>
                            
            </div>
        </div>
    </div>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
       

        <div class="navbar-header pull-left">
           
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	
        	
        	
         
            
		</ul>
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
             <? include("menu.php");  ?>
            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->
        <div id="page-rightbar">

            
        </div>
        <!-- END RIGHTBAR -->
<div id="page-content">
	<div id='wrap'>
		<div id="page-heading">
			

		
			
		</div>
		<div class="container">



			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
                        



<?
if($status==''){
	
	?>
	 <form method="post" enctype="multipart/form-data" action="uploadpartfile.php" id="upload">
<table border="0" width="40%">
	<tr >
    	<td colspan='3' id='dataagree' style="padding:5px;"><br/><br/>
          <strong>Upload Time Att Text File</strong></td>
    </tr>
	<tr>
    	<td></td>
        <td><input type="file" name="filename" id="filename" class="form-control"></td>
        <td ><button onClick="upfile();" id="btnbarcode" class="btn-primary btn">Upload File</button></td>
    </tr>
</table>
</form>
	<?
	
	}
?>

<?
if($status=='import_text'){
	
	$filename = $_REQUEST['filename'];
	$content = file_get_contents("textfile/".$filename);
//$arr = explode(" ", $content);
$arr1 = preg_split("/\\r\\n|\\r|\\n/", $content);
//$arr = preg_split('/\s+/', $content);
//print_r($arr1);
for($i=0;$i<count($arr1);$i++) 
{ 
    // calculations 
	$arr = preg_split('/\s+/', $arr1[$i]);
		if($i!=0){
		//echo $arr[0];echo ">>";
		$item = $arr[0];
		//echo $arr[1];echo ">>";
		$Mchn = $arr[1];
		$empno = substr($arr[2],3,5);
	//	echo $empno;echo ">>";
		
				$select1="select firstname,lastname,site from   tbemployee where  empno = '$empno' ";
				$re1=mssql_query($select1);
				$num1=mssql_num_rows($re1);
				if($num1>0){
					$row1=mssql_fetch_array($re1);
					$Name = $row1['firstname']." ".$row1['lastname'];
					$site = $row1['site'];
					}
		$Mode = $arr[3];
		$IOMd = $arr[4];
		$attDateTime = $arr[5]." ".$arr[6];
		
	
					
		//echo $arr[3];echo ">>";
//		echo $arr[4];echo ">>";
//		echo $arr[5];echo ">>";
//		echo $arr[6];echo ">>";
//		echo $arr[7];echo ">>";
		
	//	echo "<BR>";
		if($empno!=''){
			$select2="select empno from   tbatt where empno='$empno' and  attDateTime = '$attDateTime' and att_status is null ";
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2<=0){
					$insert="insert into  tbatt(item, Mchn, empno, Name, Mode, IOMd, attDateTime, site,shift,fl) values('$item', '$Mchn', '$empno', '$Name', '$Mode', '$IOMd', '$attDateTime','$site','Day',0)";
					
					mssql_query($insert);
					}
			}
		}
		
				
	
} 
	echo $i." rows insert completed.<HR>";
	//echo "<meta http-equiv='refresh' content='1; URL=import_text.php'>";
	

	}
?>				


				


	  

					  </div>
					</div>
				</div>
			</div>



			



		</div> <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline">
                <li>I-Wis</li>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </ul>
        </div>
    </footer>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 


</body>
</html>