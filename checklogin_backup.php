<? 
ob_start();
include("connect.php");  ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis</title>
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


	
	
	

	function checkenter(event){
		 var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {
       // alert('You pressed a enter key in somewhere'); 
		// window.location='stock_mng.php?status=barcode&boxcode='+document.getElementById('hdboxcode').value+'&txtsearch='+document.getElementById('barcode_search').value;   
		$.post( "getajax.php", { 
	
	status: "showbarcode", 
	codebox_ipack: $("#hdboxcode").val(),
		txtsearch:$("#barcode_search").val(),
	
	sid: Math.random() 
	
	})
  .done(function( data ) {
	  $("#ans2").html(data);
	  
    
  });
    }
		}
		
			
</script>
</head>

<body class=" ">


   <?
	
	

$Username = $_REQUEST['Username'];
$Password = $_REQUEST['Password'];
$checkc = $_REQUEST['checkc'];

$sql_select="select * from tbadmin where admin_userid='$Username' and admin_password='$Password'";
//echo $sql_select;
$result=mssql_query($sql_select);
$num=mssql_num_rows($result);
$row=mssql_fetch_array($result);

if($num!=0){
	
	if ($check == true) //ถ้าเช็คบ๊อคเข้ามา
	{
	setcookie('admin_userid', $row['admin_userid'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
	//setcookie('admin_site', $row['admin_site'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
	$_SESSION['admin_userid'] = $row['admin_userid'];
	//$_SESSION['admin_site'] = $row['admin_site'];
	}
	else
	{
	setcookie('admin_userid', $row['admin_userid']);
	//setcookie('admin_site', $row['admin_site']);
	$_SESSION['admin_userid'] = $row['admin_userid'];
	//$_SESSION['admin_site'] = $row['admin_site'];
	}
	
	
	
	?>
   						 <div class="panel-heading" style="width:400px">
							
						</div>
                        <div class="panel-body">
							<div class="alert alert-dismissable alert-success">
								 Successfully login please wait a sec to redirect.
							
							</div>
						</div>
  							 
       <meta http-equiv='refresh' CONTENT='1;URL=import_text.php'>
          
	<?
	}else{
		header("Location: default.php");
		?>
       
        
		<?
		}




?>

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