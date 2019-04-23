<?php 

// Set variables
$ticker      = 'redstone'; // Name of coin
$server_ip 	 = 'localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$api_port    = '38222'; // '37222'; << Mainnet 
$WalletName  = 'hot-wallet' ; // Hot wallet name
$AccountName = 'coldStakingHotAddresses' ; // special account for cold staking addresses
$scheme		 = 'http' ;// tcp protocol to access json on coin. [default]

$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';

//  Initiate curl
$ch = curl_init() ;
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result = curl_exec($ch);
// Closing
curl_close($ch);
// grab contents
$result = file_get_contents($url);

$stakinginfo = json_decode($result);

if ($stakinginfo->staking =1) {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:green'> Staking is online</label></ul>
EOD;
} else {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:red'> Staking is offline</label></ul>
EOD;
}

function crypto_rand($min,$max,$pedantic=True) {
    $diff = $max - $min;
    if ($diff <= 0) return $min; // not so random...
    $range = $diff + 1; // because $max is inclusive
    $bits = ceil(log(($range),2));
    $bytes = ceil($bits/8.0);
    $bits_max = 1 << $bits;
    $num = 0;
    do {
        $num = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))) % $bits_max;
        if ($num >= $range) {
            if ($pedantic) continue; // start over instead of accepting bias
            // else
            $num = $num % $range;  // to hell with security
        }
        break;
    } while (True);  // because goto attracts velociraptors
    return $num + $min;
}

$OrderID = $ticker . '-' . crypto_rand(100000000000,999999999999);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>trustaking.com</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body class="landing is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">
			<!-- Header -->
					<header id="header" class="alt">
					<?php print $message;?>
						<h1><a href="index.html">TRUSTAKING.COM</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="index.html">Home</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Banner -->
				<section id="banner">
						<div class="inner">
							<h2><img src="images/logo_transparent.png" alt="" width="150"/> <br/>TRUSTAKING.COM</h2>
							<p>The trusted home of <br />
							cold staking<br />
							<a href="#main" class="more scrolly"><b>PAYMENT</b></a>
					</section>

				<!-- Main -->
					<article id="main">
							<section class="wrapper style5">
								<div class="inner">
								<form method="POST" action="https://btcpay.trustaking.com/api/v1/invoices" margin: 0 auto; >
									<input type="hidden" name="storeId" value="HABeciwEXCSLXzyQDpgXmgM7RkCFWoELpZp1KcZ8W87q" />
									<input type="hidden" name="price" value="2" />
									<input type="hidden" name="orderId" value="<?php print $OrderID;?>" />
									<input type="hidden" name="currency" value="USD" />
									<input type="hidden" name="checkoutDesc" value="One month cold staking service" />
									<input type="hidden" name="notifyEmail" value="admin@trustaking.com" />
									<input type="hidden" name="browserRedirect" value="http://<?php print $ticker; ?>.trustaking.com/activate.php?OrderID=<?php print $OrderID; ?>" />
									<input type="image" src="https://btcpay.trustaking.com/img/paybutton/pay.png" name="submit" style="width:209px" alt="Pay with BtcPay, Self-Hosted Bitcoin Payment Processor">
								</form>
							</div>
							</section>
					</article>

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
							<li><a href="https://discord.gg/BRcDVqM" class="fab fa-discord"></a></li>
							<li><a href="mailto:admin@trustaking.com" class="icon fa-envelope-o"></a></li>
						</ul>
						<ul class="copyright">
							<li>&copy; TRUSTAKING.COM</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>