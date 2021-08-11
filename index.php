<?php 

function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
   
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    } 
    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
} 
$coindeskapi = file_get_contents("https://api.coindesk.com/v1/bpi/currentprice/btc.json");//btc to usd online price api//api
$rasterapi = file_get_contents("https://raters.ir/exchange/api/currency/usd");//usd to rial online price api//api
$mycoindeskapiJSON = json_decode($coindeskapi,true);//use btc to usd online price api with array//array
$myrasterapiJSON = json_decode($rasterapi,true);//use usd to rial online price api with array//array
$BTC_TO_USD_PRICE = intval(tofloat($mycoindeskapiJSON['bpi']['USD']['rate']));//btc online price(type::string)tofloat and after that to integr//value
$USD_TO_TOMAN_PRICE = (intval((str_replace(",","",$myrasterapiJSON['data']['prices'][0]['live'])))/10);//usd to rial online price //value
$BTC_TO_TOMAN = $BTC_TO_USD_PRICE*$USD_TO_TOMAN_PRICE;
$lastblockapi = file_get_contents("https://chain.api.btc.com/v3/block/latest");
$mylastblockapijson = json_decode($lastblockapi,true);
$BTC_NETWORK_DIFFICULTY = $mylastblockapijson['data']['difficulty'];
?>
<!DOCTYPE html>
<html lang="fa">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , inicial-scale=1.0">
    <title>ماشین حساب استخراج بیت کوین</title>
    <link rel="stylesheet" href="Css/reset.css">
    <link rel="stylesheet" href="Css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="Images/logo.png"
          sizes="32x32">
</head>
<body>
	<div class="site">
		<header class="header">
            <a href="https://amirhosseinmp02.ir"><img src="Images/logo.png" alt="Logo"></a>
            <h1>ماشین حساب استخراج بیت کوین</h1>
        </header>
		<main class="main">
		<div id="fmain">
			<div class="content">
				<h2><b>قیمت فعلی BTC</b><br><?php echo $BTC_TO_USD_PRICE ;?> <label>دلار</label> <br><?php echo $BTC_TO_TOMAN ;?>
					<label><b>تومان</b></label></h2>
				<h2><b>الگوریتم</b><br>SHA-256<br><b>پاداش بلاک</b><br>6.25</h2>
				<h2><b>سختی شبکه</b><br><?php echo substr($BTC_NETWORK_DIFFICULTY,0,8); ?>M<br><b>دلار سنا</b><br><?php echo $USD_TO_TOMAN_PRICE ?> تومان</h2>
			</div>
			<form action="Get" class="form">
				<div>
					<input type="number" step="any" placeholder="هش ریت (TH/s)" name="hashtext" id="hashtext">
					<select id="hashselect" onchange="hash();">
						<option value="14.5" id="1350" selected="selected">Antminer S9j</option>
						<option value="10" id="1432">Antminer T9+</option>
						<option value="68" id="3360">Whatsminer M20S</option>
						<option value="56" id="3360">Whatsminer M21S</option>
						<option value="12.5" id="2050">Whatsminer M3 V2</option>
						<option value="11.5" id="2000">Whatsminer M3 V1</option>
						<option value="56" id="2520">Antminer S17</option>
						<option value="13.5" id="1420">Ebit E9i</option>
						<option value="20.5" id="1530">Antminer S11</option>
						<option value="40" id="2200">Antminer T17</option>
						<option value="18" id="1650">Ebit E10</option>
						<option value="custom">سایر</option>
					</select>
				</div>
				<input type="number" step="any" name="wselect" id="wselect" placeholder="برق مصرفی (W)">
				<div>
					<input type="number" step="any" name="electext" id="electext" placeholder="هزینه هر کیلووات (تومان)">
					<select id="elecselect" onchange="elec();">
						<option value="290" selected="selected">خانگی</option>
						<option value="92">صنعتی</option>
						<option value="52">کشاورزی</option>
						<option value="965">متوسط صادراتی</option>
					</select>
				</div>
					
				<input type="number" step="any" name="endValue" placeholder="کارمزد استخر">
				<input type="hidden" name="BlockReward" value="6.25" />
				<input type="hidden" name="BTC_NETWORK_DIFFICULTY" value="<?php echo $BTC_NETWORK_DIFFICULTY; ?>" />
				<input type="hidden" name="BTC_TO_USD_PRICE" value="<?php echo $BTC_TO_USD_PRICE; ?>" />
				<input type="hidden" name="BTC_TO_TOMAN" value="<?php echo $BTC_TO_TOMAN; ?>" />

				<button>محاسبه</button>
				<span id="loading">در حال محاسبه...</span>
				<div id="error"></div>
			</form>
			</div>
			<table>
				<tbody>
					<tr>
						<th></th>
						<th><b>بیتکوین</b></th>
						<th><b>دلار</b></th>
						<th><b>برق</b></th>
						<th><b>تومان</b></th>
					</tr>
					<tr>
						<th><b>روزانه</b></th>
						<th id="bitcoin_day">0</th>
						<th id="dollar_day">0</th>
						<th id="bargh_day">0</th>
						<th id="toman_day">0</th>
					</tr>
					<tr>
						<th><b>هفتگی</b></th>
						<th id="bitcoin_week">0</th>
						<th id="dollar_week">0</th>
						<th id="bargh_week">0</th>
						<th id="toman_week">0</th>
					</tr>
					<tr>
						<th><b>ماهانه</b></th>
						<th id="bitcoin_month">0</th>
						<th id="dollar_month">0</th>
						<th id="bargh_month">0</th>
						<th id="toman_month">0</th>
					</tr>
					<tr>
						<th><b>سالانه</b></th>
						<th id="bitcoin_year">0</th>
						<th id="dollar_year">0</th>
						<th id="bargh_year">0</th>
						<th id="toman_year">0</th>
					</tr>
				</tbody>
			</table>
		</main>
		<footer class="footer">
            <h2>ما را در شبکه های اجتماعی دنبال کنید</h2>
            <div class="social">
                <a href="#"><i class="fa fa-telegram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>
        </footer>
	</div>

	<script src="Js/jquery-3.6.0.min.js"></script>
	<script src="Js/app.js"></script>
	<script>
		$(function () {
			$("#loading").hide();
			$('form').on('submit', function (e) {

				e.preventDefault();
				$("#loading").show();
				$.ajax({
					type: 'get',
					url: 'Actions/Form.php',
					data: $('form').serialize(),
					success: function (data) {

						if (data.elec && data.bitcoin && data.dollar && data.toman) {
							$("#bargh_day").text(data.elec.day);
							$("#bargh_week").text(data.elec.week);
							$("#bargh_month").text(data.elec.month);
							$("#bargh_year").text(data.elec.year);

							$("#bitcoin_day").text(data.bitcoin.day);
							$("#bitcoin_week").text(data.bitcoin.week);
							$("#bitcoin_month").text(data.bitcoin.month);
							$("#bitcoin_year").text(data.bitcoin.year);

							$("#dollar_day").text(data.dollar.day);
							$("#dollar_week").text(data.dollar.week);
							$("#dollar_month").text(data.dollar.month);
							$("#dollar_year").text(data.dollar.year);

							$("#toman_day").text(data.toman.day);
							$("#toman_week").text(data.toman.week);
							$("#toman_month").text(data.toman.month);
							$("#toman_year").text(data.toman.year);
							
							$("#error").text("");
						}
						if (data.error) {
							$("#error").text(data.error);
						}
						$("#loading").hide();
						ConvertNumbersToPersian();
					}
				});

			});

		});
	</script>
</body>
</html>