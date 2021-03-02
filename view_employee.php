<?php 
	include("connect.php"); 
	include("library.php");
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	
$empno = $_REQUEST['empno'];
$tsite = $_REQUEST['tsite'];

$time = time();
		//$empno='59014';
		
		
	
		
		
		
	
	
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
     <link href="assets/css/ajaxmask.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 


<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> 

<script>

$(function() {
	noti_birthdate();
	
	
<?
	if($status=='viewdetail'){
		?>
		  var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
		// Datepicker
		    
			$("#birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2022"
            });
			$("#startdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2022"
            });
			$("#probationdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2022"
            });
			$("#father_birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2022"
            });
			$("#mother_birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2022"
            });
			$("#resigndate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true, 
                langTh:true,
                yearTh:true,
                yearRange: "1900:2020"
            });
	
			//  $("#datepicker-en").datepicker({ dateFormat: 'dd/mm/yy'});
			//  $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });
			  
			  /*$("#startdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
              $("#probationdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
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
			  
			  
			    $("#resigndate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],yearRange: "2450:2560"});
			   */
			  
			  
		
		 // $("#mother_birthdate").datepicker({
//		  format: 'dd/mm/yyyy',
//		    weekStart:1,
//			 changeMonth: true,
//            changeYear: true,
//			yearRange: "-100:+0"
//		  });
        /*$.post("getajax_emp_control.php",{
            status:"show_header_control",
            empno : <?=$empno?>
        }).done(function(data){	
           // alert(data)	;
            $("#emp_control").html(data);
        })
        */
        $('#emp_control').multiSelect({
            //selectableOptgroup: true,
            selectableHeader: "<div class='custom-header' style='font-weight:bold;'>Employee</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
            selectionHeader: "<div class='custom-header' style='font-weight:bold;'>Header</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                if (e.which === 40){
                    that.$selectableUl.focus();
                    return false;
                }
                });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                if (e.which == 40){
                    that.$selectionUl.focus();
                    return false;
                }
                });
            },
            afterSelect: function(values){
                //alert(values);
                $.post("getajax_emp_control.php",{
                    status:"add_emp_control",
                    emp_control : values,
                    emp_under : <?=$empno?>
                }).done(function(data){			
                    //alert(data);
                })
                
            },
            afterDeselect: function(values){
                $.post("getajax_emp_control.php",{
                    status:"del_emp_control",
                    emp_control : values,
                    emp_under : <?=$empno?>
                }).done(function(data){			

                })
               
            }
        });
        
        $('#emp_under').multiSelect({
            //selectableOptgroup: true,
            selectableHeader: "<div class='custom-header' style='font-weight:bold;'>Employee</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
            selectionHeader: "<div class='custom-header' style='font-weight:bold;'>Underling</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                if (e.which === 40){
                    that.$selectableUl.focus();
                    return false;
                }
                });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                if (e.which == 40){
                    that.$selectionUl.focus();
                    return false;
                }
                });
            },
            afterSelect: function(values){
                $.post("getajax_emp_control.php",{
                    status:"add_emp_under",
                    emp_control : <?=$empno?>,
                    emp_under : values
                }).done(function(data){			
                    //alert(data);
                })
            },
            afterDeselect: function(values){
                $.post("getajax_emp_control.php",{
                    status:"del_emp_under",
                    emp_control : <?=$empno?>,
                    emp_under : values
                }).done(function(data){			

                })
            }
        });

        $.post("getajax_assethr.php",{
            status:"show_asset",
            empno : <?=$empno?>
        }).done(function(data){
            $("#show_asset").html(data);

            $('#asset_list').multiSelect({
            //selectableOptgroup: true,
                selectableHeader: "<div class='custom-header' style='font-weight:bold;'>Asset List</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
                selectionHeader: "<div class='custom-header' style='font-weight:bold;'>Owner</div></br><input type='text' class='search-input' autocomplete='off' placeholder='Name'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                    if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                    }
                    });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                    if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                    }
                    });
                },
                afterSelect: function(values){
                    $.post("getajax_assethr.php",{
                        status:"add_asset",
                        empno : <?=$empno?>,
                        asset_no : values
                    }).done(function(data){			
                        //alert(data);
                    })
                },
                afterDeselect: function(values){
                    $.post("getajax_assethr.php",{
                        status:"del_asset",
                        empno : <?=$empno?>,
                        asset_no : values
                    }).done(function(data){			

                    })
                }
            });
        });

        
		<?
	}
?>
	
	$("form#myform1").submit(function(event){
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
        //alert($("#emp_level_edit").val());
		if($("#emp_type").val()==""){
            alert("กรุณาเลือก Employee type");
            return false;
        }
		if($("#delstatus").val()=='1'){
				if(confirm('หากต้องการ set สถานะลาออก โปรดตรวจาอบข้อมูลเหล่านี้\n1.พนักงานได้ slip เงินเดือนล่าสุดหรือยัง \n2.รายการ asset ส่งคืนหมดหรือยัง \nหากครบถ้วนแล้ว คลิก OK')!=true){
						return false;
					}else{
						if($("#resigndate").val()==''){
								alert('กรุณาเลือกวันที่ลาออก');
								return false;
							}
						}
			}
		/*if($("#firstname").val() == ""){
			$("#firstname").focus();
			return false;
		}
		if($("#lastname").val() == ""){
			$("#lastname").focus();
			return false;
		}*/
		//if($("#birthdate").val() == ""){
			//$("#birthdate").focus();
			//return false;
	    ///	}
		//if($("#father_birthdate").val() == ""){
			//$("#father_birthdate").focus();
			//return false;
		//}
		//if($("#mother_birthdate").val() == ""){
			//$("#mother_birthdate").focus();
		//	return false;
		//}
		//if($("#startdate").val() == ""){
		//	$("#startdate").focus();
		//	return false;
		//}
		//if($("#personalid").val() == ""){
		//	$("#personalid").focus();
			//return false;
		//}
		///if($("#address").val() == ""){
		///	$("#address").focus();
			//return false;
		//}
		
		
		var formData = new FormData($(this)[0]);
		formData.append("status","updateemployee");
		//alert(formData);
		$.ajax({
				url: 'getajax_emp.php',
				type: "POST",
				//dataType: "json",
				contentType: false,
				processData: false,
				data   : formData,
				success: function(data) {
				//	alert(data);
					//$(".sql_error").html(data.sql);
					/*var rec = jQuery.parseJSON(data);
                    alert(rec.sql);*/
					if(data=='waitpaysalary'){
						alert("พนักงานยังไม่ได้ slip เงินเดือนล่าสุด นับจากวันที่ลาออก");
						}else{
						alert("บันทึกข้อมูลสำเร็จ");
						}
					//$(".sql_error").html(data);
					
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
	
function register_finger(){
	var loadingDiv = $('<div class="ajax-mask"><div class="loading"><img src="assets/img/loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + 'Please wait...' + '</span></div></div>')
		.css({
		  'position': 'absolute',
		  'top': 0,
		  'left':0,
		  'width':'100%',
		  'height':'100%',
		});
		 $('body').css({ 'position':'relative' }).append(loadingDiv);
	//$('body').ajaxMask();
	 setTimeout(function () { 
      location.reload();
    }, 16000);
	//window.location.reload();
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

 
function createreport(){
		
		var site = $("#site").val();
			
					window.open('popreport.php?status=employee&site='+site+'','width=842,height=600, scrollbar=yes');
				
			
			
			}
function set_probationdate(){
    var startdate = $("#startdate").val();
    //alert("ss");
    $.post("getajax_emp.php",{
        status:"set_probationdate",
        startdate : startdate
    }).done(function(data){			
        $("#probationdate").val(data);
    });
}

function noti_birthdate(){
    //alert("DD");
    $.post("getajax_emp.php",{
        status:"noti_birthdate"
    }).done(function(data){	
        //alert(data);
        var aa =data;					
	    var bb = aa.split("###",150);
        $("#noti1").html(bb[0]);
        $("#noti2").html(bb[1]);
        $("#noti3").html(bb[2]);
    });
}

/*function show_asset(){
    $.post("getajax_asset.php",{
        status:"show_asset"
    }).done(function(data){
        $("#show_asset").html(data);

    });
}*/
</script>
<style type="text/css">


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
        	
            <li class="dropdown">
				<a href="#" class="hasnotifications dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i><span class="badge" id="noti1"></span></a>
				<ul class="dropdown-menu notifications arrow">
					<li class="dd-header">
						<span id="noti2"></span>
						<span></span>
					</li>
					<div class="scrollthis" id="noti3" tabindex="5003" style="overflow-y: scroll; outline: none;">
                        <!--
                        <li><a href="#">test</a></li>
                        <li>test</li>
                        --> 
					</div>
					<!--<li class="dd-footer"><a href="#">View All Notifications</a></li>-->
				</ul>
			</li>
        	
         
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
        <td  align="center"><strong>ข้อมูล</strong></td>
        <td  align="center"><strong>View Detail</strong></td>
        <td  align="center"><strong>ลายนิ้วมือ</strong></td>         
                  
      </tr>
      <?
          $select="select convert(varchar, birthdate, 103)as  birthdate_date,
          convert(varchar, father_birthdate, 103)as  father_birthdate_date,
          convert(varchar, mother_birthdate, 103)as  mother_birthdat_date,* 
          from tbemployee where site='$tsite' and delstatus='0' order by empno ";
		
	$re=mssql_query($select);
	$num = mssql_num_rows($re);
	if($num>0){
		$i=0;
        while($row=mssql_fetch_array($re)){
            $empno = $row['empno'];
            $accountid = $row['accountid']==" " || $row['accountid']==NULL?"<span class='label label-danger'>เลขบัญชี</span>":"<span class='label label-success'>เลขบัญชี</span>";
            $birthdate = $row['birthdate_date']==" " || $row['birthdate_date']==NULL?"<span class='label label-danger'>วันเกิด</span>":"<span class='label label-success'>วันเกิด</span>";
            $father_birthdate = $row["father_birthdate_date"]==" " || $row['father_birthdate_date']==NULL?"<span class='label label-danger'>วันเกิดพ่อ</span>":"<span class='label label-success'>วันเกิดพ่อ</span>";
            $mother_birthdate = $row["mother_birthdat_date"]==" " || $row['mother_birthdat_date']==NULL?"<span class='label label-danger'>วันเกิดแม่</span>":"<span class='label label-success'>วันเกิดแม่</span>";
            $shirt_size = $row["shirt_size"]==" " || $row['shirt_size']==NULL?"<span class='label label-danger'>ไซต์เสื้อ</span>":"<span class='label label-success'>ไซต์เสื้อ</span>";
            $shoe_size = $row["shoe_size"]==" " || $row['shoe_size']==NULL?"<span class='label label-danger'>ไซต์รองเท้า</span>":"<span class='label label-success'>ไซต์รองเท้า</span>";
            $empname = get_full_name($empno);
            
            $positionid=$row['positionid'];
            $positionname = get_positionname($positionid);
            
            $finger_data = $row['finger_data'];
            
            $url_register		= base64_encode($base_path."register.php?empno=$empno");
            if($finger_data == ""){
                $btn_finger = "<a href='finspot:FingerspotReg;$url_register' class='btn btn-primary' onclick='register_finger()'>Register</a>";
            }else{
                $btn_finger = "<a href='finspot:FingerspotReg;$url_register' class='btn btn-warning' onclick='register_finger()'>Edit</a>";
            }
            
            
            $i++;
        ?>
            <tr>
                <td  align="center"><?=$i?>.</td>
                <td  align="center"><?=$empno?></td>
                <td  align="center"><?=$empname?></td>
                <td  align="center"><?=$positionname?></td>
                <td  align="center"><?
                if($row['delstatus']=='1'){
                    echo "ลาออก";
                }else{
                    echo "ทำงาน";
                }
                ?></td>
                <td  ><?=$accountid?><br><br><?=$birthdate?><br><br><?=$father_birthdate?><br><br><?=$mother_birthdate?><br><br><?=$shirt_size?><br><br><?=$shoe_size?></td>
                <td  align="center"><input type="button" value="View Detail" onClick="location='view_employee.php?status=viewdetail&empno=<?=$row['empno']?>'"></td>
                <td  align="center"><?=$btn_finger?></td>   
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
      	$select="select * from tbemployee where site='$tsite' and delstatus='1' order by empno ";
		
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
        convert(varchar, probationdate, 101)as  probationdate,
		convert(varchar, birthdate, 103)as  birthdate ,
		convert(varchar, probationdate, 103)as  probationdate,
		convert(varchar, father_birthdate, 103)as  father_birthdate,
		convert(varchar, mother_birthdate, 103)as  mother_birthdate,
		convert(varchar, resigndate, 103)as  resigndate
		
	
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
					//$firstname = $row['firstname'];
//					$lastname = $row['lastname'];
//					$nickname  = $row['nickname'];
//					$address=$row['address'];
//					$real_address= $row['real_address'];
//					$father_birthdate =$row['father_birthdate'];
//					$mother_birthdate = $row['mother_birthdate'];
					
					
					$firstname_en = $row['firstname_en'];
					$lastname_en = $row['lastname_en'];
				
					
					$probationdate = $row['probationdate'];
					$tsite  = $row['site'];
					$positionid  = $row['positionid'];
					$departmentid  = $row['departmentid'];
					$age= $row['age'];
					$education= $row['education'];
					$mstatus= $row['mstatus'];
				
				//	$address = iconv("tis-620", "utf-8", $row['address'] );
					
					$personalid= $row['personalid'];
				
					$mobile= $row['mobile'];
					$phone= $row['phone'];
					$shirt_size= lang_thai_from_database($row['shirt_size']);
					$shoe_size= $row['shoe_size'];
					$email= $row['email'];
					$accountid= $row['accountid'];
					$emptype = $row['emptype'];
					
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
					$emp_level = $row["emp_level"];
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
					if($emp_level>2){
						$skill_reward=0;
						}
						
					
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
					
					
                    $startdate = $row['startdate'];
                    $probationdate = $row['probationdate'];
					$birthdate = $row['birthdate'];
					$father_birthdate =$row['father_birthdate'];
					$mother_birthdate = $row['mother_birthdate'];
					$resigndate = $row['resigndate'];
					$display_att = $row['display_att'];
					
					if($birthdate!=''){
					$arrbirthdate = explode("/",$birthdate);
					$birthdate = $arrbirthdate[0]."/".$arrbirthdate[1]."/".((int)$arrbirthdate[2]+543);
					}
					if($startdate!=''){
					$arrstartdate = explode("/",$startdate);
					$startdate = $arrstartdate[0]."/".$arrstartdate[1]."/".((int)$arrstartdate[2]+543);
                    }
                    if($probationdate!=''){
                        $arrprobationdate = explode("/",$probationdate);
                        $probationdate = $arrprobationdate[0]."/".$arrprobationdate[1]."/".((int)$arrprobationdate[2]+543);
                    }
					if($father_birthdate!=''){
					$arrfather_birthdate = explode("/",$father_birthdate);
					$father_birthdate = $arrfather_birthdate[0]."/".$arrfather_birthdate[1]."/".((int)$arrfather_birthdate[2]+543);
					}
					if($mother_birthdate!=''){
					$arrmother_birthdate = explode("/",$mother_birthdate);
					$mother_birthdate = $arrmother_birthdate[0]."/".$arrmother_birthdate[1]."/".((int)$arrmother_birthdate[2]+543);
					}
					if($resigndate!=''){
					$arrresigndate = explode("/",$resigndate);
					$resigndate = $arrresigndate[0]."/".$arrresigndate[1]."/".((int)$arrresigndate[2]+543);
					}
					$select2="select positionname from tbposition where positionid ='".$row['positionid']."'  ";
					$re2=mssql_query($select2);
					$num2 = mssql_num_rows($re2);
					if($num2>0){
						$row2=mssql_fetch_array($re2);
						$positionname = $row2['positionname'];
						}
					$select_dep="select department from tbdepartment where departmentid ='".$row['departmentid']."'  ";
					$re_dep=mssql_query($select_dep);
					$num_dep = mssql_num_rows($re_dep);
					if($num_dep>0){
						$row_dep=mssql_fetch_array($re_dep);
						$department = $row_dep['department'];
						}
				}
	
	?>
	<div class="panel">
    <div class="panel-heading">
        <h4>ข้อมูลส่วนตัว</h4>
     
    </div>
     <div class="panel-heading" style="background-color:#CCC ">
        <h4>Site : <?=$tsite?></h4>
     
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
                             <input type="text" class="form-control" id="birthdate" name="birthdate" value="<?=$birthdate?>" readonly>
                            </div>
                             </div>
                             
                             
                              <div class="form-group">
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
                                       <strong> สาขา Department</strong>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="departmentid" id="departmentid">
                                            <option value="">Select</option>
                                                <?
                                                     $selectdepartment="select departmentid,department from  tbdepartment order by departmentid asc ";
                                                    $department=mssql_query($selectdepartment);
                                                    $nump_department=mssql_num_rows($department);
                                                    if($nump_department>0){
                                                        while($row_department=mssql_fetch_array($department)){
                                                            ?>
                                                    <option value="<?= $row_department['departmentid'] ?>" <? if($departmentid==$row_department['departmentid']){ ?> selected
                                                 <?
                                                                            }
                                                    ?>><?= $row_department['department'] ?>
                                                                    </option>
                                                                    <?
                                                                                }
                                                                            }
                                                                                    ?>
                                                              </select>
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
                        if($positionid == $rowp['positionid']){
                     echo '<option value="'.$rowp['positionid'].'" selected>'.$rowp['positionname'].'</option>';
						?> 
                        <?=$rowp['positionname']?></option><?
						}
					}
                }
						  ?>
                        </select> 
                            </div>
                             </div>
                             <script>
                             $("#departmentid").change(function() {
                                    let department = document.getElementById('departmentid').value;
                                    $.post("getajax_emp.php", {
                                        status: "getposition",
                                        department: department
                                    }).done(function(data) {
                                        //var aa =data;
                                        //var bb = aa.split("###",150);
                                        // var person = data;
                                        //   console.log(data);
                                        $('#positionid').html(data);
                                    });
                                });
                             </script>
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
                         <input type="text" class="form-control" id="startdate" name="startdate" value="<?=$startdate?>" onChange="set_probationdate()" readonly>
                          </div>
                          <div class="col-sm-3" style="text-align:center">
                     <strong>  วันที่ผ่านโปร </strong>
                          </div>
                           <div class="col-sm-3">
                         <input type="text" class="form-control" id="probationdate" name="probationdate" value="<?=$probationdate?>" readonly>
                          </div>
                           </div>
                           
                        <!--
                            <div class="form-group">
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
                             -->
                             
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
                           <input type="text" class="form-control" id="father_birthdate" name="father_birthdate" value="<?=$father_birthdate?>" readonly>
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
                           <input type="text" class="form-control" id="mother_birthdate" name="mother_birthdate" value="<?=$mother_birthdate?>" readonly>
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
                         <strong>Employee type</strong>
                            </div>
                             <div class="col-sm-2">
                           <select id="emp_type" name="emp_type" class="form-control" style="width:100px">
                           <option value="">เลือก</option>
                           <option value="employee"<?if($emptype=='employee'){?>selected<?}?>>employee</option>
                             <option value="temp" <?if($emptype=='temp'){?>selected<?}?> >temp</option>
                           </select>
                            </div>
							<div class="col-sm-2" style="width:12.455%">
                            </div>
							<div class="col-sm-3" style="text-align:center">
                          <strong> Employee level</strong>
                            </div>
                           
                            <div class="col-sm-2" style="width:20%">
                                <select class="form-control" name="emp_level_edit" id="emp_level_edit">
                                    <option value="1" <?php if($emp_level=="1"){echo "selected";}?>>1 (Operative)</option>
                                    <option value="2" <?php if($emp_level=="2"){echo "selected";}?>>2 (Leader)</option>
                                    <option value="3" <?php if($emp_level=="3"){echo "selected";}?>>3 (Supervisor)</option>
                                    <option value="4" <?php if($emp_level=="4"){echo "selected";}?>>4 (Ass.Manager)</option>
                                    <option value="5" <?php if($emp_level=="5"){echo "selected";}?>>5 (Manager)</option>
                                    <option value="6" <?php if($emp_level=="6"){echo "selected";}?>>6 (Senior.Manager)</option>
                                    <option value="7" <?php if($emp_level=="7"){echo "selected";}?>>7</option>
                                    <option value="8" <?php if($emp_level=="8"){echo "selected";}?>>8</option>
                                </select>
                            </div>
                             </div>   
                             
                             <div class="form-group">
                           
                            
                             <div class="col-sm-3" style="text-align:center">
                         <strong>สถานะการทำงาน</strong>
                            </div>
                             <div class="col-sm-3">
                             <?
                           if($_SESSION['admin_userid']=='56038'){
							   ?>
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
							   <?
							   }else{
								   ?>
								   <input type="hidden" name="delstatus" id="delstatus" value="<?=$delstatus?>">
								   <?
								    if($delstatus=='1'){
										echo "ลาออก";
										}
									if($delstatus=='0'){
										echo "ทำงาน";
										}
								   }
							 ?>
                            </div>
                            <div class="col-sm-3" style="text-align:center">
                         <strong>โชว์ที่หน้าจอลงเวลา</strong>
                            </div>
                            <div class="col-sm-3" style="text-align:center">
                          <select id="display_att" name="display_att" class="form-control" style="width:200px">
                           <option value="0" <?
                           if($display_att=='0'){
							   ?> selected<?
							   }
						   ?>>ไม่โชว์ที่หน้าจอลงเวลา</option>
                             <option value="1" <?
                           if($display_att=='1'){
							   ?> selected<?
							   }
						   ?>>โชว์ที่หน้าจอลงเวลา</option>
                          </select>
                            </div>
                             </div>
                             
                             <div class="form-group">
                           
                            
                             <div class="col-sm-3" style="text-align:center">
                         <strong>วันที่ลาออก</strong>
                            </div>
                             <div class="col-sm-9">
                               <input type="text" class="form-control" id="resigndate" name="resigndate" value="<?=$resigndate?>" style="width:220px" readonly>
                            </div>
                             </div>
                             
                             <div class="form-group">
                           
                                <div class="col-sm-3" style="text-align:center">
                                     <strong>  ไซต์เสื้อ </strong>
                                </div>
                                <div class="col-sm-3">
                                    
                                    <select name="shirt_size" id="shirt_size" class="form-control">
                                        <option value="">Select Shirt Size </option>
                                        <option value="S(ผู้ชาย)" <?php if($shirt_size=="S(ผู้ชาย)"){echo "selected";}?>>S (ผู้ชาย)</option>
                                        <option value="M(ผู้ชาย)"<?php if($shirt_size=="M(ผู้ชาย)"){echo "selected";}?>>M (ผู้ชาย)</option>
                                        <option value="L(ผู้ชาย)"<?php if($shirt_size=="L(ผู้ชาย)"){echo "selected";}?>>L (ผู้ชาย)</option>
                                        <option value="XL(ผู้ชาย)"<?php if($shirt_size=="XL(ผู้ชาย)"){echo "selected";}?>>XL (ผู้ชาย)</option>
                                        <option value="2XL(ผู้ชาย)"<?php if($shirt_size=="2XL(ผู้ชาย)"){echo "selected";}?>>2XL (ผู้ชาย)</option>
                                        <option value="3XL(ผู้ชาย)"<?php if($shirt_size=="3XL(ผู้ชาย)"){echo "selected";}?>>3XL (ผู้ชาย)</option>
                                        <option value="4XL(ผู้ชาย)"<?php if($shirt_size=="4XL(ผู้ชาย)"){echo "selected";}?>>4XL (ผู้ชาย)</option>
                                        <option value="S(ผู้หญิง)"<?php if($shirt_size=="S(ผู้หญิง)"){echo "selected";}?>>S (ผู้หญิง)</option>
                                        <option value="M(ผู้หญิง)"<?php if($shirt_size=="M(ผู้หญิง)"){echo "selected";}?>>M (ผู้หญิง)</option>
                                        <option value="L(ผู้หญิง)"<?php if($shirt_size=="L(ผู้หญิง)"){echo "selected";}?>>L (ผู้หญิง)</option>
                                        <option value="XL(ผู้หญิง)"<?php if($shirt_size=="XL(ผู้หญิง)"){echo "selected";}?>>XL (ผู้หญิง)</option>
                                        <option value="2XL(ผู้หญิง)"<?php if($shirt_size=="2XL(ผู้หญิง)"){echo "selected";}?>>2XL (ผู้หญิง)</option>
                                    </select>
                                </div>
                                <div class="col-sm-3" style="text-align:center">
                                    <strong>  ไซต์รองเท้า </strong>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="shoe_size" name="shoe_size" value="<?=$shoe_size?>">
                                </div>
                            </div>
                             
                            
                             <?
                             
							 if($_SESSION['admin_userid']=='56002' || $_SESSION['admin_userid']=='59011'){
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
								  
                   <input type="hidden" class="form-control" id="basic_salary"  name="basic_salary" value="<?=$basic_salary?>">
                     <input type="hidden" <?
                            if($emptype=='employee'){
								?> readonly<?
								}
						   ?> class="form-control" id="basic_wage" name="basic_wage" value="<?=$basic_wage?>">
                            <input type="hidden" class="form-control" id="position_val" name="position_val" value="<?=$position_val?>">
                               <input type="hidden" class="form-control" id="skill_reward" name="skill_reward" value="<?=$skill_reward?>">   <input type="hidden" class="form-control" id="travel_val" name="travel_val" value="<?=$travel_val?>">
                                <input type="hidden" class="form-control" id="mobile_val" name="mobile_val" value="<?=$mobile_val?>">
                           
                           
                             <input type="hidden" readonly class="form-control" id="att_reward" name="att_reward" value="<?=$att_reward?>">
                            
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
			$pic = $empno.".jpg?".$time;
		}else{
			$pic = "blank.jpg";
		}
		?><img src="emppic/<?=$pic?>" id="img_emp_show"></td>
        <td width="30%" align="center"><?
        if($tsite!='JWD LCB'){
				?><div class="demo" style="font-size:25px">*<?=$empno?>*</div><?
				}
		?></td>
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
             
             
           
           </form>
    </div>
    </div>
    <br>
    <div class="panel">
        <div class="panel-heading">
            <h4>HEADER UNDER</h4>
        </div>
        <div class="panel-body collapse in">
            <div class="col-sm-12" id="show_header" style="margin-bottom: 50px;">
                <h4>HEADER</h4>
                <select id='emp_control' class="searchable" multiple='multiple' ><?php
                    $sql = "select * from tbemployee where delstatus != 1 and empno !='$empno' order by site asc,empno asc ";
                    $res = mssql_query($sql);
                    while($row = mssql_fetch_array($res)){
                        $empno_query = $row["empno"];
                        $firstname = iconv("tis-620", "utf-8", $row['firstname']);
                        $lastname = iconv("tis-620", "utf-8", $row['lastname']);
                        $nickname = iconv("tis-620", "utf-8", $row['nickname']);
                        $site = $row["site"];
                        $full_name = "[$site] $firstname $lastname($nickname)";

                        $sql_control = "select * from tbleave_control where emp_control='$empno_query' and emp_under='$empno'";
                        $res_control = mssql_query($sql_control);
                        $num_control = mssql_num_rows($res_control);
                        if($num_control>0){
                            $selected_control = "selected";
                        }else{
                            $selected_control = "";
                        }
                        ?>
                        <option value="<?=$empno_query?>" <?=$selected_control?>><?=$full_name?></option>
                <?php } ?>
                </select>
            </div>
            
            <div class="col-sm-12">
                <h4>UNDER</h4>
                <select id='emp_under' class="searchable" multiple='multiple' ><?php
                    $sql = "select * from tbemployee where delstatus != 1 and empno !='$empno' order by site asc,empno asc ";
                    $res = mssql_query($sql);
                    while($row = mssql_fetch_array($res)){
                        $empno_query = $row["empno"];
                        $firstname = iconv("tis-620", "utf-8", $row['firstname']);
                        $lastname = iconv("tis-620", "utf-8", $row['lastname']);
                        $nickname = iconv("tis-620", "utf-8", $row['nickname']);
                        $site = $row["site"];
                        $full_name = "[$site] $firstname $lastname($nickname)";

                        $sql_control = "select * from tbleave_control where emp_control='$empno' and emp_under='$empno_query'";
                        $res_control = mssql_query($sql_control);
                        $num_control = mssql_num_rows($res_control);
                        if($num_control>0){
                            $selected_control = "selected";
                        }else{
                            $selected_control = "";
                        }
                        ?>
                        <option value="<?=$empno_query?>" <?=$selected_control?>><?=$full_name?></option>
                <?php } ?>
                </select>
            </div>

        
        </div>
    </div>

    <br>
    <div class="panel">
        <div class="panel-heading">
            <h4>Asset</h4>
        </div>
        <div class="panel-body collapse in">
            <div class="col-sm-12" id="show_asset" style="margin-bottom: 50px;">
                
            </div>

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
<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 
<script type="text/javascript" src="assets/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="assets/js/jquery.quicksearch.js"></script>


<script type='text/javascript' src='assets/js/jqueryui_datepicker_thai_min.js'></script> 


</body>
</html>