<? include("connect.php");  ?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	
$empno = $_REQUEST['empno'];
$tsite = $_REQUEST['tsite'];

$time = time();
		//$empno='59014';
		
		
	
		
		
		
	
	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60  ); // 1 min =  60*60
	 }
?>

<html>
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Employee</title>
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
<link rel='stylesheet' type='text/css' href='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="DatePicker/js/jquery-1.4.4.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->
<script type="text/javascript" src="DatePicker/js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<!--<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> -->
<!--<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> -->
<script>

$(function() {
	
	
	
<?
	if($status=='viewdetail'){
		?>
		  var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
		// Datepicker
		    
			  $("#birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
			  yearRange: "2450:2560"
			  
			  });
			//  $("#datepicker-en").datepicker({ dateFormat: 'dd/mm/yy'});
			//  $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });
			  
			  $("#startdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
			  
			    $("#father_birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],yearRange: "2450:2560"});
			  
			   $("#mother_birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],yearRange: "2450:2560"});
			  
		
		 // $("#mother_birthdate").datepicker({
//		  format: 'dd/mm/yyyy',
//		    weekStart:1,
//			 changeMonth: true,
//            changeYear: true,
//			yearRange: "-100:+0"
//		  });
		<?
		}
?>
	
	$("form#myform1").submit(function(event){
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
		
		if($("#firstname").val() == ""){
			$("#firstname").focus();
			return false;
		}
		if($("#lastname").val() == ""){
			$("#lastname").focus();
			return false;
		}
		if($("#birthdate").val() == ""){
			$("#birthdate").focus();
			return false;
		}
		if($("#father_birthdate").val() == ""){
			$("#father_birthdate").focus();
			return false;
		}
		if($("#mother_birthdate").val() == ""){
			$("#mother_birthdate").focus();
			return false;
		}
		if($("#startdate").val() == ""){
			$("#startdate").focus();
			return false;
		}
		if($("#personalid").val() == ""){
			$("#personalid").focus();
			return false;
		}
		if($("#address").val() == ""){
			$("#address").focus();
			return false;
		}
		
		
		var formData = new FormData($(this)[0]);
		formData.append("status","updateemployee");
		//alert(formData);
		$.ajax({
				url: 'getajax_emp.php',
				type: "POST",
				dataType: "json",
				contentType: false,
				processData: false,
				data   : formData,
				success: function(data) {
					//$(".sql_error").html(data.sql);
					//alert(data.sql);
					alert("บันทึกข้อมูลสำเร็จ");
					//window.location='view_employee.php?status=viewdetail&empno='+$( "#id_emp" ).val();
					//return false;
				}
		});
		//return false;
	
	
	
	});
	
});
	

	
	
//function updateemployee(empno){
//	var firstname= $("#firstname").val();
//	var firstname_en= $("#firstname_en").val();
//	var lastname= $("#lastname").val();
//	var lastname_en= $("#lastname_en").val();
//	var nickname= $("#nickname").val();
//	var birthdate= $("#birthdate").val();
//	var age= $("#age").val();
//	var mobile= $("#mobile").val();
//	var email= $("#email").val();
//	var startdate= $("#startdate").val();
//	var mstatus= $("#mstatus").val();
//	var positionid= $("#positionid").val();
//	var personalid= $("#personalid").val();
//	var accountid= $("#accountid").val();
//	var father_name= $("#father_name").val();
//	var mother_name= $("#mother_name").val();
//	var father_birthdate= $("#father_birthdate").val();
//	var mother_birthdate= $("#mother_birthdate").val();
//	var address= $("#address").val();
//	var real_address= $("#real_address").val();
//	var delstatus = $("#delstatus").val();
//	
//		$.post( "getajax_emp.php", { 	
//	status: "updateemployee", 
//	empno : empno,
//	firstname:firstname,
//	firstname_en:firstname_en,
//	lastname:lastname,
//	lastname_en:lastname_en,
//	nickname:nickname,
//	birthdate:birthdate,
//	positionid:positionid,
//	age:age,
//	mobile:mobile,
//	email:email,
//	startdate:startdate,
//	mstatus:mstatus,
//	personalid:personalid,
//	accountid:accountid,
//	father_name:father_name,
//	mother_name:mother_name,
//	father_birthdate:father_birthdate,
//	mother_birthdate:mother_birthdate,
//	address:address,
//	real_address:real_address,
//	delstatus:delstatus,
//	sid: Math.random() 
//	})
//	.done(function( data ) {
//	bootbox.alert("Update Complete.");
//
// });
//	}
	
	
		function showemp(){
	
	var site = $("#site").val();
	var empno = $("#empno").val();
	window.location = 'view_employee.php?tsite='+site;
	}
</script>


	<script type="text/javascript">
 
		  function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#img_emp_show')
				.attr('src', e.target.result)
				.width(101)
				.height(108);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
 
    </script>
<script>
function createreport(){
		
		var site = $("#site").val();
			
					window.open('popreport.php?status=employee&site='+site+'','width=842,height=600, scrollbar=yes');
				
			
			
			}
</script>
<style type="text/css">
<!--

.demo
	{
		font-family:'Conv_free3of9',Sans-Serif;
		-webkit-transform: rotate(-90deg); 
		-moz-transform: rotate(-90deg);	
		color:#4F290F;
	}
.demo2
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;
		color:#4F290F;
		font-weight:bold
	}
.demo3
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;
		color:#eeeeee;
		font-weight:bold
	}
.demo4
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:3px;
		color:#eeeeee;
		
	}
div.p{
	page-break-after:always;
	}
div.last{
}
hr{border-top: 1px dashed #8c8b8b;}

-->
</style>
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
    
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr>
      <td width="6%" height="40" align="right"><strong>Site</strong></td>
     <td width="19%"><select id="site" class="form-control"  name="site"   style="width:200px;">
     <option value="">Select</option>
    <?
    	$select0="SELECT site from  tbsite ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['site']?>" <?
         if($tsite==$row0['site']){
			 ?> selected<?
			 }
		 ?>><?=$row0['site']?></option>
		<?
		}
	?>
     </select></td>
    <td width="13%" height="40" align="left"><input type="button" value="Select" onClick="showemp();"></td>
   <td width="30%" align="center"><a href="add_employee.php" target="_blank" class="btn btn-success" role="button">Add</a> <button onClick="createreport();" id="btnbarcode2" class="btn-primary btn">Export</button></td>
     <td width="24%"></td>
     <td width="8%" align="right"></td>
    </tr></table>
    
    <table width="100%"  cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
     
      <tr>
        <td  align="center"><strong>Item</strong></td>
      	  <td  align="center"><strong>Emp No</strong></td>
            <td  align="center"><strong>Emp Name</strong></td>
              <td  align="center"><strong>Position</strong></td>
              <td  align="center"><strong>สถานะการทำงาน</strong></td>
                <td  align="center"><strong>View Detail</strong></td>
                 
                  
      </tr>
      <?
      	$select="select * from tbemployee where site='$tsite' and delstatus='0' ";
	//	echo $select;
	$re=mssql_query($select);
	$num = mssql_num_rows($re);
	if($num>0){
		$i=0;
	while($row=mssql_fetch_array($re)){
		
	
	$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
	//$empname = $row['firstname']." ".$row['lastname'];
	
	$select2="select * from tbposition where positionid ='".$row['positionid']."'  ";
		
	$re2=mssql_query($select2);
	$num2 = mssql_num_rows($re2);
	if($num2>0){
		$row2=mssql_fetch_array($re2);
		$positionname = $row2['positionname'];
		}else{
			$positionname = '';
			}
		
		$i++;
	  ?>
       <tr>
        <td  align="center"><?=$i?>.</td>
      	  <td  align="center"><?=$row['empno']?></td>
            <td  align="center"><?=$empname?></td>
              <td  align="center"><?=$positionname?></td>
              <td  align="center"><?
              if($row['delstatus']=='1'){
				  echo "ลาออก";
				  }else{
					  echo "ทำงาน";
					  }
			  ?></td>
                <td  align="center"><input type="button" value="View Detail" onClick="location='view_employee.php?status=viewdetail&empno=<?=$row['empno']?>'"></td>
      </tr>
      <?
	  }
      }
	  ?>
     
      
    </table>
    
    <HR>
    <table width="100%"  cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
     
      <tr>
        <td  align="center"><strong>Item</strong></td>
      	  <td  align="center"><strong>Emp No</strong></td>
            <td  align="center"><strong>Emp Name</strong></td>
              <td  align="center"><strong>Position</strong></td>
              <td  align="center"><strong>สถานะการทำงาน</strong></td>
                <td  align="center"><strong>View Detail</strong></td>
                 
                  
      </tr>
      <?
      	$select="select * from tbemployee where site='$tsite' and delstatus='1'  ";
		
	$re=mssql_query($select);
	$num = mssql_num_rows($re);
	if($num>0){
		$i=0;
	while($row=mssql_fetch_array($re)){
		
	
	$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
	//$empname = $row['firstname']." ".$row['lastname'];
	
	$select2="select * from tbposition where positionid ='".$row['positionid']."'  ";
		
	$re2=mssql_query($select2);
	$num2 = mssql_num_rows($re2);
	if($num2>0){
		$row2=mssql_fetch_array($re2);
		$positionname = $row2['positionname'];
		}else{
			$positionname = '';
			}
		
		$i++;
	  ?>
       <tr>
        <td  align="center"><?=$i?>.</td>
      	  <td  align="center"><?=$row['empno']?></td>
            <td  align="center"><?=$empname?></td>
              <td  align="center"><?=$positionname?></td>
              <td  align="center"><?
              if($row['delstatus']=='1'){
				  echo "ลาออก";
				  }else{
					  echo "ทำงาน";
					  }
			  ?></td>
                <td  align="center"><input type="button" value="View Detail" onClick="location='view_employee.php?status=viewdetail&empno=<?=$row['empno']?>'"></td>
      </tr>
      <?
	  }
      }
	  ?>
     
      
    </table>
    <HR>
  
<?
}




if($status=='viewdetail'){
	
	
		$select="select *, 
		convert(varchar, startdate, 103)as  startdate,
		convert(varchar, startdate, 101)as  startdate2,
		convert(varchar, birthdate, 103)as  birthdate ,
		convert(varchar, probationdate, 103)as  probationdate,
		convert(varchar, father_birthdate, 103)as  father_birthdate,
		convert(varchar, mother_birthdate, 103)as  mother_birthdate
	
	from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					$delstatus =  $row['delstatus'];
					$firstname = iconv("tis-620", "utf-8", $row['firstname'] );
					$lastname =  iconv("tis-620", "utf-8", $row['lastname'] );
					$nickname  = iconv("tis-620", "utf-8", $row['nickname'] );
					$address=iconv("tis-620", "utf-8", $row['address'] );
					$real_address= iconv("tis-620", "utf-8", $row['real_address'] );
					
					$father_name= iconv("tis-620", "utf-8", $row['father_name'] );
					$mother_name= iconv("tis-620", "utf-8", $row['mother_name'] );
					$emptype =$row['emptype'];
				//	echo $emptype;
					//$firstname = $row['firstname'];
//					$lastname = $row['lastname'];
//					$nickname  = $row['nickname'];
//					$address=$row['address'];
//					$real_address= $row['real_address'];
//					$father_birthdate =$row['father_birthdate'];
//					$mother_birthdate = $row['mother_birthdate'];
					//echo $row['startdate2'];
				//	echo date('m/d/Y');
					//echo "work =".DateDiff($row['startdate2'],date('m/d/Y'));
					
					
					$startdate2 = $row['startdate2'];      //รูปแบบการเก็บค่าข้อมูลวันเกิด
					$today = date("m/d/Y");   //จุดต้องเปลี่ยน
					list($bmonth, $bday, $byear)= explode("/",$startdate2);       //จุดต้องเปลี่ยน
					list($tmonth, $tday, $tyear)= explode("/",$today);                //จุดต้องเปลี่ยน
					$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
					$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
					$mage = ($mnow - $mbirthday);
					$u_y=date("Y", $mage)-1970;
					$u_m=date("m",$mage)-1;
					$u_d=date("d",$mage)-1;
					//อายุงานครบ1ปีได้300บาท , 3 ปี 400 , 5 ปี 500 
					$skill_reward= $row['skill_reward']; 
					
					if($u_y>=1){
						$skill_reward=300;
						if($u_y>=3){
							$skill_reward=400;
							if($u_y>=5){
								$skill_reward=500;
								}
						}
					}else{
						$skill_reward=0;
						}
						
					
					
					
					$firstname_en = $row['firstname_en'];
					$lastname_en = $row['lastname_en'];
					
					
					$probationdate = $row['probationdate'];
					$site  = $row['site'];
					$positionid  = $row['positionid'];
					$age= $row['age'];
					$education= $row['education'];
					$mstatus= $row['mstatus'];
				
				//	$address = iconv("tis-620", "utf-8", $row['address'] );
					
					$personalid= $row['personalid'];
				
					$mobile= $row['mobile'];
					$phone= $row['phone'];
					$shirt_size= $row['shirt_size'];
					$shoe_size= $row['shoe_size'];
					$email= $row['email'];
					$accountid= $row['accountid'];
					
					$startdate = $row['startdate'];
					$birthdate = $row['birthdate'];
					$father_birthdate =$row['father_birthdate'];
					$mother_birthdate = $row['mother_birthdate'];
					
					$att_reward= $row['att_reward'];
					if($att_reward==''){
						$att_reward=0;
						}
					
					$basic_wage= $row['basic_wage'];
					if($basic_wage==''){
						$basic_wage=0;
						}
					$basic_salary= $row['basic_salary']; 
					if($basic_salary==''){
						$basic_salary=0;
						}
					$position_val= $row['position_val']; 
					if($position_val==''){
						$position_val=0;
						}
					$travel_val= $row['travel_val']; 
						if($travel_val==''){
						$travel_val=0;
						}
					$mobile_val= $row['mobile_val']; 
					if($mobile_val==''){
						$mobile_val=0;
						}
					
					
					$arrbirthdate = explode("/",$birthdate);
					$birthdate = $arrbirthdate[0]."/".$arrbirthdate[1]."/".((int)$arrbirthdate[2]+543);
					
					$arrstartdate = explode("/",$startdate);
					$startdate = $arrstartdate[0]."/".$arrstartdate[1]."/".((int)$arrstartdate[2]+543);
					
					$arrfather_birthdate = explode("/",$father_birthdate);
					$father_birthdate = $arrfather_birthdate[0]."/".$arrfather_birthdate[1]."/".((int)$arrfather_birthdate[2]+543);
					
					$arrmother_birthdate = explode("/",$mother_birthdate);
					$mother_birthdate = $arrmother_birthdate[0]."/".$arrmother_birthdate[1]."/".((int)$arrmother_birthdate[2]+543);
					
					$select2="select positionname from tbposition where positionid ='".$row['positionid']."'  ";
					$re2=mssql_query($select2);
					$num2 = mssql_num_rows($re2);
					if($num2>0){
						$row2=mssql_fetch_array($re2);
						$positionname = $row2['positionname'];
						}
						
					}
	
	?>
	<div class="panel">
    <div class="panel-heading">
        <h4>ข้อมูลส่วนตัว</h4>
     
    </div>
     <div class="panel-heading" style="background-color:#CCC ">
        <h4>Site : <?=$site?></h4>
     
    </div>
	<div class='sql_error'></div>
    <div class="panel-body collapse in">
           <form class="form-horizontal row-border" action="#" name="myform1" id="myform1" method="post" enctype="multipart/form-data">
           
               <div class="col-sm-8">
             <div class="panel panel-primary">
                            <div class="form-group">
                            <div class="col-sm-3" style="text-align:center">
                              <strong>รหัสพนักงาน Employee Number </strong></div>
                             <div class="col-sm-9">
                           <?=$empno?>  <input type="hidden" id="empno" name="empno" value="<?=$empno?>"  >
                           
                            <?
							
							
             		
				
				echo " | วันเริ่มงาน $startdate2";
				echo " | วันที่ปัจจุบัน $today";
				echo" | อายุงาน $u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";
				
				
				
				
			  ?>
                            </div>
                            
                             </div>
                          
                             <div class="form-group">
                            <div class="col-sm-3" style="text-align:center">
                           <strong> ชื่อ - นามสกุล</strong>
                            </div>
                             <div class="col-sm-2" style="width:12.455%">
                               <input type="text" class="form-control" id="firstname" name="firstname" value="<?=$firstname?>" >
                            </div>
                            <div class="col-sm-2" style="width:12.455%">
                               <input type="text" class="form-control" id="lastname" name="lastname" value="<?=$lastname?>">
                            </div>
                           
                             <div class="col-sm-3" style="text-align:center">
                          <strong> FirstName - LastName</strong>
                            </div>
                           
                            <div class="col-sm-2" style="width:12.455%">
                                <input type="text" class="form-control" id="firstname_en" name="firstname_en" value="<?=$firstname_en?>" >
                            </div>
                            <div class="col-sm-2" style="width:12.455%">
                                 <input type="text" class="form-control" id="lastname_en" name="lastname_en" value="<?=$lastname_en?>">
                            </div>
                             </div>
                             
                             
                             
                             
                             <div class="form-group">
                           
                             <div class="col-sm-3" style="text-align:center">
                          <strong> ชื่อเล่น NickName</strong>
                            </div>
                             <div class="col-sm-3">
                             <input type="text" class="form-control" id="nickname" name="nickname" value="<?=$nickname?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                        <strong> วันเกิด BirthDate</strong>
                            </div>
                             <div class="col-sm-3">
                             <input type="text" class="form-control" id="birthdate" name="birthdate" value="<?=$birthdate?>">
                            </div>
                             </div>
                             
                             
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         		<strong> อายุ Age</strong>
                            </div>
                             <div class="col-sm-3">
                           <input type="text" class="form-control" id="age" name="age" value="<?=$age?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                         <strong> ตำแหน่ง Position</strong>
                            </div>
                             <div class="col-sm-3">
                             <select class="form-control" name="positionid" id="positionid">
                          <option value="">Select</option>
                          <?
                 $selectp="select positionname,positionid from  tbposition order by positionid asc ";
				$rep=mssql_query($selectp);
				$nump=mssql_num_rows($rep);
				if($nump>0){
					while($rowp=mssql_fetch_array($rep)){
						?> <option value="<?=$rowp['positionid']?>" <?
                        if($positionid==$rowp['positionid']){
							?> selected<?
							}
						?>><?=$rowp['positionname']?></option><?
						}
					}
						  ?>
                           
                              
                         
                        </select> 
                            </div>
                             </div>
                             
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         	<strong>	เบอร์โทร  Mobile Number</strong>
                            </div>
                             <div class="col-sm-3">
                         <input type="text" class="form-control" id="mobile" name="mobile" value="<?=$mobile?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                      <strong>    อีเมล Email</strong>
                            </div>
                             <div class="col-sm-3">
                           <input type="text" class="form-control" id="email" name="email" value="<?=$email?>">
                            </div>
                             </div>
                             
                             
                             
                              <div class="form-group">
                           
                             <div class="col-sm-3" style="text-align:center">
                       <strong>  วันเริ่มงาน Start Date</strong>
                            </div>
                             <div class="col-sm-3">
                           <input type="text" class="form-control" id="startdate" name="startdate" value="<?=$startdate?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                      <strong>  สถานะสมรส Marital Status</strong>
                            </div>
                             <div class="col-sm-3">
                           <select class="form-control" name="mstatus" id="mstatus">
                          <option value="">Select</option>
                           <option value="Single" <?
                           if($mstatus=='Single'){
							   ?> selected<?
							   }
						   ?>>โสด Single</option>
                           <option value="Single2" <?
                           if($mstatus=='Single2'){
							   ?> selected<?
							   }
						   ?>>แต่งงานไม่จดทะเบียน</option>
                         
                            <option value="Married" <?
                           if($mstatus=='Married'){
							   ?> selected<?
							   }
						   ?>>แต่งงาน Married</option>
                          </select>
                            </div>
                             </div>
                             
                             
                              <div class="form-group">
                           
                             <div class="col-sm-3" style="text-align:center">
                       <strong>  รหัสบัตรประชาชน ID Card</strong>
                            </div>
                             <div class="col-sm-3">
                          <input type="text" class="form-control" id="personalid" name="personalid" value="<?=$personalid?>"> 
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                      <strong>    เลขที่บัญชี Account ID</strong>
                            </div>
                             <div class="col-sm-3">
                         <input type="text" class="form-control" id="accountid" name="accountid" value="<?=$accountid?>"> 
                            </div>
                             </div>
                             
                             
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         	<strong>	ชื่อบิดา Father Name</strong>
                            </div>
                             <div class="col-sm-3">
                         <input type="text" class="form-control" id="father_name"  name="father_name" value="<?=$father_name?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                      <strong>    วันเกิดบิดา Father BirthDate</strong>
                            </div>
                             <div class="col-sm-3">
                           <input type="text" class="form-control" id="father_birthdate" name="father_birthdate" value="<?=$father_birthdate?>">
                            </div>
                             </div>
                             
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         	<strong>	ชื่อมารดา Mother Name</strong>
                            </div>
                             <div class="col-sm-3">
                         <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?=$mother_name?>">
                            </div>
                             <div class="col-sm-3" style="text-align:center">
                      <strong>   วันเกิดมารดา Mother BirthDate</strong>
                            </div>
                             <div class="col-sm-3">
                           <input type="text" class="form-control" id="mother_birthdate" name="mother_birthdate" value="<?=$mother_birthdate?>">
                            </div>
                             </div>
                             
                             
                             <div class="form-group">
                           
                             <div class="col-sm-3" style="text-align:center">
                        <strong> ที่อยู่ตามทะเบียนบ้าน Address</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="address" name="address" value="<?=$address?>">
                            </div>
                            
                             </div>
                             
                               <div class="form-group">
                           
                            
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ที่อยู่ปัจจุบัน Present Address</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="real_address" name="real_address" value="<?=$real_address?>">
                            </div>
                             </div>
                             
                             
                             <div class="form-group">
                           
                            
                             <div class="col-sm-3" style="text-align:center">
                         <strong>สถานะการทำงาน</strong>
                            </div>
                             <div class="col-sm-9">
                           <select id="delstatus" name="delstatus" class="form-control" style="width:100px">
                           <option value="0" <?
                           if($delstatus=='0'){
							   ?> selected<?
							   }
						   ?>>ทำงาน</option>
                             <option value="1" <?
                           if($delstatus=='1'){
							   ?> selected<?
							   }
						   ?>>ลาออก</option>
                           </select>
                            </div>
                             </div>
                             
                             
                             <div class="form-group">
                           
                            
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ลักษณะการจ้างงาน</strong>
                            </div>
                             <div class="col-sm-9">
                           <select id="emptype" name="emptype" class="form-control" style="width:150px">
                           <option value="employee" <?
                           if($emptype=='employee'){
							   ?> selected<?
							   }
						   ?>>พนักงานประจำ</option>
                             <option value="temp" <?
                           if($emptype=='temp'){
							   ?> selected<?
							   }
						   ?>>พนักงานชั่วคราว</option>
                           </select>
                            </div>
                             </div>
                             
                             
                             
                             <?
                             if($_SESSION['admin_userid']=='56002'){
							 ?>
                        
                        
                    <HR>
                              
                             <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>เงินเดือน(พนักงานประจำ)</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="basic_salary" <?
                            if($emptype=='temp'){
								?> readonly<?
								}
						   ?> name="basic_salary" value="<?=$basic_salary?>">
                         
                            </div>
                             </div>
                             
                             <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ค่าจ้างรายวัน(พนักงานชั่วคราว)</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" <?
                            if($emptype=='employee'){
								?> readonly<?
								}
						   ?> class="form-control" id="basic_wage" name="basic_wage" value="<?=$basic_wage?>">
                         
                            </div>
                             </div>
                             
                             
                            
                             <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ค่าตำแหน่ง</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="position_val" name="position_val" value="<?=$position_val?>">
                         
                            </div>
                             </div>
                             
                          
                             
                             
                             <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ค่าทักษะ</strong>
                            </div>
                             <div class="col-sm-9">
                             *** อายุงานครบ1ปี ได้ 300 บาท , 3 ปี 400 บาท , 5 ปี 500 บาท 
                         <input type="text" class="form-control" id="skill_reward" name="skill_reward" value="<?=$skill_reward?>">
                            </div>
                             </div>
                             
                             
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ค่าเดินทาง</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="travel_val" name="travel_val" value="<?=$travel_val?>">
                         
                            </div>
                             </div>
                              <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>ค่าโทรศัพท์</strong>
                            </div>
                             <div class="col-sm-9">
                           <input type="text" class="form-control" id="mobile_val" name="mobile_val" value="<?=$mobile_val?>">
                         
                            </div>
                             </div>
                             
                             
                               <div class="form-group">
                             <div class="col-sm-3" style="text-align:center">
                         <strong>เบี้ยขยันล่าสุด</strong>
                            </div>
                             <div class="col-sm-9">
                              <input type="text" readonly class="form-control" id="att_reward" name="att_reward" value="<?=$att_reward?>">
                            </div>
                             </div>
                              
                             
                           <?
                           }else{
							   ?>
                               <input type="hidden" id="att_reward" name="att_reward" value="<?=$att_reward?>">
                                <input type="hidden" id="skill_reward" name="skill_reward" value="<?=$skill_reward?>">
                                 <input type="hidden" id="basic_wage" name="basic_wage" value="<?=$basic_wage?>">
                                  <input type="hidden" id="basic_salary" name="basic_salary" value="<?=$basic_salary?>">
                                   <input type="hidden" id="position_val" name="position_val" value="<?=$position_val?>">
                                    <input type="hidden" id="travel_val" name="travel_val" value="<?=$travel_val?>">
                                     <input type="hidden" id="mobile_val" name="mobile_val" value="<?=$mobile_val?>">
							   <?
							   }
						   ?>
                             
                             
                             
                             
             </div>
             </div>
               <div class="col-sm-4">
               <div class="form-group" style="text-align:center">
              
              <table width="212" align="center"  border="0" cellspacing="0" cellpadding="0" >
				  <tr>
					<td align="right" style="padding-right:18px"><input type="file" name="img_emp" accept="image/jpeg" onChange="readURL(this);"></td>
				  </tr>
				</table>
              
               <table width="212" align="center" height="330" border="0" cellspacing="0" cellpadding="0" background="images/empcard.png">
  <tr>
    <td height="30" align="right" style="padding-right:18px"><span class="demo2">ID : <?=$empno?></span></td>
  </tr>
  <tr>
    <td height="90" align="center"><img src="images/ipack_logo_big.png" ></td>
  </tr>
  <tr>
    <td height="120" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" align="right"><?
        if(file_exists("emppic/".$empno.".jpg")){
			$pic = $empno.".jpg?".$time ;
			}else{
				$pic = "blank.jpg";
				}
		?><img src="emppic/<?=$pic?>" id="img_emp_show"></td>
        <td width="30%" align="center"><div class="demo" style="font-size:25px">*<?=$empno?>*</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="60" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$firstname_en?>  <?=$lastname_en?></span></td>
      </tr>
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$firstname?>  <?=$lastname?></span></td>
      </tr>
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$positionname?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="center"><span class="demo4">บริษัท ไอแพ็ค โลจิสติกส์ จำกัด</span></td>
  </tr>
</table>

               </div>
                <div style="text-align:center">
                
               <button  type="submit" class="btn btn-success btn-label" style="width:270px" ><i class="fa fa-download"></i> CONFIRM SAVE (บันทึกรายการ)</button>
                
                  
                </div>
                 <div style="text-align:center; height:10px"></div>
                 <div style="text-align:center">
                
             <button  type="button"  class="btn btn-primary btn-label" style="width:270px" onClick="window.open('popempcard.php?empno=<?=$empno?>','pop','width=800,height=1000,scrollbars=yes');"><i class="fa fa-print"></i>  PRINT (พิมพ์บัตรพนักงาน)</button>
                
                </div>
             </div>
             <div style="text-align:center">
                
             
                
                  
                </div>
             
             
             
             
           
           </form>
    </div>
    </div>
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
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<!--<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> -->
<script type='text/javascript' src='assets/demo/demo.js'></script> 
<!--<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
<!--<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> -->
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 


</body>
</html>