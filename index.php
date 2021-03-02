<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>I-Wis login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Avant">
    <meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
    <link rel="stylesheet" href="assets/css/styles.css">
  
    
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
</head>
<body class="focusedform">

<div class="verticalcenter">
	<div align="center" style=" margin-bottom:10px;"><img src="images/S__17784953.png" alt="Logo" /></div>
	<div class="panel panel-primary">
		<div class="panel-body">
			<h4 class="text-center" style="margin-bottom: 25px;">Log in to get started</h4>
				<form action="checklogin.php" class="form-horizontal" name="formlogin" method="post" style="margin-bottom: 0px !important;">
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" class="form-control" id="username" name="Username" placeholder="Username">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" id="password" name="Password" placeholder="Password">
                                    <input type="hidden" name="ipaddress" id="ipaddress">
								</div>
							</div>
						</div>
						<div class="clearfix">
							<div class="pull-right"><label><input type="checkbox" style="margin-bottom: 20px" checked=""> Remember Me</label></div>
						</div> 
					</form>
					
		</div>
		<div class="panel-footer">
			
			
			<div class="pull-right">
				
				<a href="javascript:void();" onClick="document.formlogin.submit();" class="btn btn-primary">Log In</a>
			</div>
		</div>
	</div>
   <div align="right"> <img src="images/powered.png" alt="Logo" /></div>
 </div>
       <script>
            //get the IP addresses associated with an account
            function getIPs(callback){
                var ip_dups = {};

                //compatibility for firefox and chrome
                var RTCPeerConnection = window.RTCPeerConnection
                    || window.mozRTCPeerConnection
                    || window.webkitRTCPeerConnection;
                var useWebKit = !!window.webkitRTCPeerConnection;

                //bypass naive webrtc blocking using an iframe
                if(!RTCPeerConnection){
                    //NOTE: you need to have an iframe in the page right above the script tag
                    //
                    //<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
                    //<script>...getIPs called in here...
                    //
                    var win = iframe.contentWindow;
                    RTCPeerConnection = win.RTCPeerConnection
                        || win.mozRTCPeerConnection
                        || win.webkitRTCPeerConnection;
                    useWebKit = !!win.webkitRTCPeerConnection;
                }

                //minimal requirements for data connection
                var mediaConstraints = {
                    optional: [{RtpDataChannels: true}]
                };

                var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};

                //construct a new RTCPeerConnection
                var pc = new RTCPeerConnection(servers, mediaConstraints);

                function handleCandidate(candidate){
                    //match just the IP address
                    var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
                    var ip_addr = ip_regex.exec(candidate)[1];

                    //remove duplicates
                    if(ip_dups[ip_addr] === undefined)
                        callback(ip_addr);

                    ip_dups[ip_addr] = true;
                }

                //listen for candidate events
                pc.onicecandidate = function(ice){

                    //skip non-candidate events
                    if(ice.candidate)
                        handleCandidate(ice.candidate.candidate);
                };

                //create a bogus data channel
                pc.createDataChannel("");

                //create an offer sdp
                pc.createOffer(function(result){

                    //trigger the stun server request
                    pc.setLocalDescription(result, function(){}, function(){});

                }, function(){});

                //wait for a while to let everything done
                setTimeout(function(){
                    //read candidate info from local description
                    var lines = pc.localDescription.sdp.split('\n');

                    lines.forEach(function(line){
                        if(line.indexOf('a=candidate:') === 0)
                            handleCandidate(line);
                    });
                }, 1000);
            }

            //insert IP addresses into the page
            getIPs(function(ip){
                var li = document.createElement("li");
                li.textContent = ip;

                //local IPs
                if (ip.match(/^(192\.168\.|169\.254\.|10\.|172\.(1[6-9]|2\d|3[01]))/)){
					document.getElementById('ipaddress').value=ip;
					}
                   // document.getElementsByTagName("ul")[0].appendChild(li);
				    

                //IPv6 addresses
             // else if (ip.match(/^[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7}$/))
                   // document.getElementsByTagName("ul")[2].appendChild(li);

                //assume the rest are public IPs
              //  else
                    //document.getElementsByTagName("ul")[1].appendChild(li);
            });
        </script>
</body>
</html>