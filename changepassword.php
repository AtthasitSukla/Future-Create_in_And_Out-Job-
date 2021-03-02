<? include("connect.php"); 
	 
$status = $_REQUEST['status'];
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];

		if($empno!=''){
				$select="select firstname,lastname,empno,site from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$row=mssql_fetch_array($re);
				$empname = iconv("tis-620", "utf-8",$row['firstname'].' '.$row['lastname']);
				$site = $row['site'];
		}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ HRS : Change Password</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=140">

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<script>

function checkpassword(){
		var admin_userid = $("#admin_userid").val();
		var old_password = $("#old_password").val();
		var new_password = $("#new_password").val();
		var cnew_password = $("#cnew_password").val();	
				$.post( "getajax_changepassword.php", { 
				status: "checkpassword", 
				admin_userid: admin_userid,
				old_password: old_password,
				sid: Math.random() 
				})
			  .done(function( data ) {
				  if(data=='nodata'){
					  bootbox.alert('Old Password not correct.');
					  }else{
						  
						  if(new_password==''){
							  bootbox.alert('Please input new password.');
							  }else if(cnew_password==''){
							  	bootbox.alert('Please input confirm new password.');
							  }else if(new_password!=cnew_password){
								  bootbox.alert('New password and confirm password does not match');
								  }else{
									  
									  		$.post( "getajax_changepassword.php", { 
											status: "savenewpassword", 
											admin_userid: admin_userid,
											new_password: new_password,
											old_password: old_password,
											sid: Math.random() 
											})
											 .done(function( data ) {
				  									bootbox.alert('Change password complete.');
				  									});
									  
									  }
						  
						  }
				  
				  });
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
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
	 <input type="hidden" id="admin_userid" value="<?=$_SESSION['admin_userid']?>">
       <tr>
	   <td width="39%" height="30" align="right"><strong>Old Password</strong></td>
	   <td width="35%" style="padding-left:5px"><input type="password" class="form-control" value=""  maxlength="50" id="old_password" style="width:200px;"></td><td width="26%" ></td></tr>
       <tr>
	   <td width="39%" height="30" align="right"><strong>New Password</strong></td>
	   <td width="35%" style="padding-left:5px"><input type="password" class="form-control" value=""  maxlength="50" id="new_password" style="width:200px;"></td><td width="26%" ></td></tr>
       
        <tr>
	   <td width="39%" height="30" align="right"><strong>Confirm New Password</strong></td>
	   <td width="35%" style="padding-left:5px"><input type="password" class="form-control" value=""  maxlength="50" id="cnew_password" style="width:200px;"></td><td width="26%" ></td></tr>
         <tr>
	   <td width="39%" height="5" align="right"></td>
	   <td width="35%" style="padding-left:5px"> </td><td width="26%" ></td></tr>
          <tr>
	   <td width="39%" height="30" align="right"></td>
	   <td width="35%" style="padding-left:5px"> <button class="btn-primary btn" onClick="checkpassword();">Submit Change</button></td><td width="26%" ></td></tr>
       
      
	</table>
   <BR>

	
	

<?
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