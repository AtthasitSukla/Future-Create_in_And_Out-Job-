 <ul class="nav navbar-nav pull-right toolbar" style="padding-right:5px;margin: 10px 10px;">    
        <?
        	if($_SESSION['admin_userid']!=''){
				echo "<font color='#CCCCCC'>Welcome : ".$_SESSION['admin_userid']."</font>";
				echo "<font color='#CCCCCC'> | ".$_SESSION['admin_department']."</font>";
				 
				}
		?>  
		</ul>