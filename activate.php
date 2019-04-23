<?php 

$OrderID=$_GET['OrderID'];
// Grab the next unused address 
// Set variables
$ticker      = 'redstone'; // Name of coin
$server_ip 	 = 'localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$api_port    = '38222'; // '37222'; << Mainnet 
$WalletName  = 'hot-wallet' ; // Hot wallet name
$AccountName = 'coldStakingHotAddresses' ; // special account for cold staking addresses
$scheme		 = 'http' ;// tcp protocol to access json on coin. [default]

$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Wallet/unusedaddress?WalletName='.$WalletName.'&AccountName='.$AccountName ;
//  Initiate curl
$ch = curl_init() ;
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$address = curl_exec($ch);
// Closing
curl_close($ch);
// grab contents
$address = file_get_contents($url);

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

//Check invoice paid
// Set variables
$invoiceId   = 'CtT6BnSTimsH1kQaXZjkUC' ; //Testing only
$apiKey      = 'aWxaMWJZVkdZaHBvVmtkTHlvN3lvZGRrN0wwMEhVb0lrUmlFN0hiaVd2aQ==' ;
$url 		 = 'https://btcpay.trustaking.com/invoices/'.$invoiceId ;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "443",
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{\"method\":\"getblock\", \"params\": [6931c538229099305baadd8ee17d9d3bad960c8f83e2468b428da887785297d4\",1]}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic ".$apiKey."",
    "Content-Type: application/json",
    "cache-control: no-cache"
  ),
));

$result = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

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

				<!-- Main -->
					<article id="main">
						<header>
							<img src="images/coin_logo.png" alt="" width="200"/>
						</header>
							<section class="wrapper style5">
								<div class="inner">
								<h3>ORDER #<?php print $OrderID;?></h3>
								<p>Thank you for your payment - before you get started, open your local wallet and ensure it's fully synced.</p><br>
								<p>Then open a terminal window and run the following script:</p>
								<pre><code>bash <( curl http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.sh )</code></pre>
								<p>Here is your hot wallet address when prompted: <pre><code><?php print $address; ?></code></pre></p>
								<br/>
								<p>Run this script at any time to see your cold staking balance:</p>
								<pre><code>bash <( curl http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.sh )</code></pre>
								<p>If you need to add funds at a later date use this command:</p>
								<pre><code>bash <( curl http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.sh )</code></pre>
								<p>And finally, when you want to withdraw your funds use this command:</p>
								<pre><code>bash <( curl http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.sh )</code></pre>
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