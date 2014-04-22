<?php
/**
 * BOARDIRAN.IR *
 */

function sms_addon_config() {
	$configarray = array( 'name' => 'ماژول ارسال پیامک شرکت بُردایران', 'description' => 'این ماژول برای استفاده کاربران شرکت ارتباط گستر بردایران آماده شده که بتوانید از سرویس وب مستر خود به بهترین شکل ممکن استفاده نمایید
', 'version' => '3.5 ورژن', 'author' => 'SMS BOARDIRAN', 'fields' => array(  ) );
	return $configarray;
}

function sms_addon_output($vars) {
	echo '
';
	echo '<s';
	echo 'tyle>
fieldset{
	border:#4C9CC5 1px solid;
	border-radius:8px;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	direction:rtl;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:11px;
	padding:5px;
	margin-bottom:10px;
	background-color:#f7f7f7;
}
legend{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	font-weight:bold;
	margin-right:10px;
}
#almas-smspanel-ab';
	echo 'out{
	float:left;
	width:300px;
	height:auto;
	background-color:#D3F109;
	padding:5px;
	border-radius:8px;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	font-family: Tahoma, Geneva, sans-serif;
	font-size:11px;
	line-height:1.6em;
	min-height:150px;

}


/* -- CONTROL PANEL STYLES ----------------------------- */
.cpanel div.icon, #cpanel div.icon {
	text-align: center;';
	echo '
	margin-right: 15px;
	margin-bottom: 15px;

}
#cpanel div{
	margin-bottom:10px;
}
.cpanel div.icon a, #cpanel div.icon a {
	background-color: #fff;
	background-position: -30px;
	display: block;
	float: left;
	height: 97px;
	width: 108px;
	color: #565656;
	vertical-align: middle;
	text-decoration: none;
	border: 1px solid #CCC;
	text-align:center;

	-webkit-border-radius: 5px;';
	echo '
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-transition-property:
		background-position,
		-webkit-border-bottom-left-radius,
		-webkit-box-shadow;
	-moz-transition-property:
		background-position,
		-moz-border-radius-bottomleft,
		-moz-box-shadow;
	-webkit-transition-duration: 0.8s;
	-moz-transition-duration: 0.8s;
}

#cpanel div.icon a:hover,
#cpanel div.icon a:focus';
	echo ',
#cpanel div.icon a:active,
.cpanel div.icon a:hover,
.cpanel div.icon a:focus,
.cpanel div.icon a:active {
	background-position: 0;
	-webkit-border-bottom-left-radius: 50% 20px;
	-moz-border-radius-bottomleft: 50% 20px;
	border-bottom-left-radius: 50% 20px;
	-webkit-box-shadow: -5px 10px 15px rgba(0, 0, 0, 0.25);
	-moz-box-shadow: -5px 10px 15px rgba(0, 0, 0, 0.25);
	box-shadow: -5px ';
	echo '10px 15px rgba(0, 0, 0, 0.25);
	position: relative;
	z-index: 10;
}

#cpanel img,
.cpanel img {
	padding: 5px 0px 3px 0px;
	margin: 0 auto;
}

#cpanel span,
.cpanel span {
	display: block;
	text-align: center;
}

div.cpanel-left {
	width: 54%;
	float: left;
}

div.cpanel-right {
	width: 45%;
	float: right;
}
.row_0{
	background-color: #EBEBE7;
}
form input, form textar';
	echo 'ea,  form select{

	border-radius:8px;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border:#CCC 1px solid;
	background-color: #F5F5F3;
	padding:3px;

}
#almas-sms-icons{
}
</style>
    ';
	include_once( 'jDateTime.php' );
	$AlmasDateTime = new jDateTime(  );

	if (!function_exists( 'SendSMS' )) {
		function SendSMS($gateway, $message) {
			if (is_file( 'lib/nusoap.php' )) {
				include_once( 'lib/nusoap.php' );
			}
			else {
				include_once( '../lib/nusoap.php' );
			}

			$client = new nusoap_client( 'http://panel.boardiran.ir/API/SendSms.ashx' );
			$client->soap_defencoding = 'UTF-8';
			$client->decode_utf8 = false;
			$parameters['username'] = $gateway['number'];
			$parameters['password'] = $gateway['pass'];
			$parameters['to'] = $message['numbers'];
			$parameters['LineNumber'] = $gateway['LineNumber'];
			$parameters['text'] = $message['content'];
			$result = $client->call( 'SENDSMS', array( 'UserName' => $parameters['username'], 'Password' => $parameters['password'], 'LineNumber' => $parameters['LineNumber'], 'Recivers' => $parameters['to'], 'Smsmsg' => $parameters['text'], 'SendDate' => date( 'Y-m-d' ), 'SendTime' => date( 'H:i:s' ), 'MesClass' => '1' ) );

			if ($result[Error] == '') {
				return '4' . ' (' . $result[SendID] . ')';
			}

			return $result[Error];
		}
	}


	if (!function_exists( 'GetSQLValueString' )) {
		function GetSQLValueString($theValue, $theType, &$theDefinedValue = '', $theNotDefinedValue = '') {
			$theValue = (get_magic_quotes_gpc(  ) ? stripslashes( $theValue ) : $theValue);
			$theValue = (function_exists( 'mysql_real_escape_string' ) ? mysql_real_escape_string( $theValue ) : mysql_escape_string( $theValue ));
			switch ($theType) {
			case 'text': {
					$theValue = ($theValue != '' ? '\'' . $theValue . '\'' : 'NULL');
					break;
				}

			case 'long': {
				}

			case 'int': {
					$theValue = ($theValue != '' ? intval( $theValue ) : 'NULL');
					break;
				}

			case 'double': {
					$theValue = ($theValue != '' ? '\'' . doubleval( $theValue ) . '\'' : 'NULL');
					break;
				}

			case 'date': {
					$theValue = ($theValue != '' ? '\'' . $theValue . '\'' : 'NULL');
					break;
				}

			case 'defined': {
					$theValue = ($theValue != '' ? $theDefinedValue : $theNotDefinedValue);
				}
			}

			return $theValue;
		}
	}


	if (isset( $_GET['clearlog'] )) {
		mysql_query( 'TRUNCATE TABLE mod_smsaddon_logs' );
		header( 'Location: addonmodules.php?module=sms_addon&logs' );
		exit(  );
	}


	if (isset( $_GET['SendSingleSms'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );

		if ($_POST['customer'] == 'none') {
			$recipient_number = $_POST['recipient'];
			$customer = 'درج شماره';
		}
		else {
			$exploded = explode( '|', $_POST['customer'] );
			$recipient_number = $exploded[0];
			$customer = $exploded[1];
		}


		if ($recipient_number == '') {
			$time = time(  );
			$_SESSION['error'] = 'فاقد شماره موبايل';
			$error = 17;
		}


		if ($error != 1) {
			$gateway['number'] = $row_mod['username'];
			$gateway['pass'] = $row_mod['password'];
			$gateway['LineNumber'] = $row_mod['LineNumber'];
			$message['numbers'] = $recipient_number;
			$message['content'] = $_POST['content'];
			$response = SendSMS( $gateway, $message );
			$time = time(  );
			$_SESSION['error'] = 'ارسال با موفقيت انجام شد. پاسخ وب سرويس:<br />' . $response . '<br />';
			mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . $time . '\', \'' . $customer . '\', \'' . $recipient_number . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $_POST['content'] ) . '\')' );
		}

		header( 'Location: addonmodules.php?module=sms_addon&error' );
		exit(  );
	}


	if (isset( $_GET['SendMassSms'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );

		if (( isset( $_SESSION['page'] ) && $_SESSION['page'] != '' )) {
			$page = $_SESSION['page'];
		}
		else {
			$page = 16;
		}


		if (( !isset( $_POST['content'] ) || $_POST['content'] == '' )) {
			$content = $_SESSION['content'];
			$force = $_SESSION['force'];
		}
		else {
			$content = $_POST['content'];
			$force = $_POST['force'];
			$_SESSION['content'] = $_POST['content'];
			$_SESSION['force'] = $_POST['force'];
		}


		if (( $content == '' || $force == '' )) {
			$_SESSION['masssmserror'] = 'پيامک خالی قابل ارسال نمی باشد';
			header( 'Location: addonmodules.php?module=sms_addon&masssms' );
			exit(  );
		}

		$start = $page * 15;
		$querylimit = ' LIMIT ' . $start . ',15';
		$customers = @mysql_query( 'SELECT id FROM tblclients' . $querylimit );
		$all_customers = @mysql_query( 'SELECT id FROM tblclients' );
		$pageNum_customers = $page;
		$totalRows_customers = @mysql_num_rows( $all_customers );
		$totalPages_customers = ceil( $totalRows_customers / 15 ) - 1;
		$tel = mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
		$row_tel = @mysql_fetch_assoc( $tel );
		$report = mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
		$row_report = @mysql_fetch_assoc( $report );

		if ($row_customers = mysql_fetch_assoc( $customers )) {
			$error = 16;

			if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
				$tels = @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_customers['id'] . '\'' );
				$row_tels = @mysql_fetch_assoc( $tels );
				$reports = @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_customers['id'] . '\'' );
				$row_reports = @mysql_fetch_assoc( $reportal );

				if ($row_tels['value'] == '') {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_customers['id'] . '\', \'\', \'فاقد شماره موبايل\', \'\')' );
					$error = 17;
				}


				if ($error != 1) {
					$row_tels['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tels['value'] );

					if ($row_tels['value'][0] != '0') {
						$row_tels['value'] = '0' . $row_tels['value'];
					}
				}


				if ($error != 1) {
					if ($force != 1) {
						if ($row_reportal['value'] == $row_mod['no_area']) {
							$error = 17;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_customers['id'] . '\', \'' . $row_tels['value'] . '\', \'Client doesn\'t want to receive text messages\', \'\')' );
						}
					}
				}


				if ($error != 1) {
					$gateway['number'] = $row_mod['username'];
					$gateway['pass'] = $row_mod['password'];
					$gateway['LineNumber'] = $row_mod['LineNumber'];
					$message['numbers'] = $row_tels['value'];
					$message['content'] = $content . $row_mod['businessname'];
					$response = SendSMS( $gateway, $message );
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_customers['id'] . '\', \'' . $row_tels['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $content . $row_mod['businessname'] ) . '\')' );
					continue;
				}
			}

			mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_customers['id'] . '\', \'\', \'Invalid module settings\', \'\')' );
		}


		if ($pageNum_customers < $totalPages_customers - 1) {
			$_SESSION['page'] = $page + 1;
			$_SESSION['error'] = $page + 1 . '/' . $totalPages_customers . ' completed. Sending will contiune in 15 seconds. <a href="addonmodules.php?module=sms_addon&SendMassSms">Contiune now</a><script>setTimeout("window.location=\'addonmodules.php?module=sms_addon&SendMassSms\'", 15000);</script><br />';
		}
		else {
			$_SESSION['error'] = 'Successfully completed.';
			$_SESSION['content'] = '';
			$_SESSION['force'] == '';
			$_SESSION['page'] == '';
		}

		header( 'Location: addonmodules.php?module=sms_addon&error' );
		exit(  );
	}


	if (isset( $_GET['cleanup'] )) {
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon`' );
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon_codes`' );
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon_logs`' );
		header( 'Location: addonmodules.php?module=sms_addon' );
		exit(  );
	}


	if (isset( $_GET['next'] )) {
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon`' );
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon_codes`' );
		mysql_query( 'DROP TABLE IF EXISTS `mod_smsaddon_logs`' );

		if (!mysql_query( 'CREATE TABLE `mod_smsaddon` (
		  `id` bigint(255) NOT NULL auto_increment,
		  `new_bill` tinyint(1) NOT NULL default \'0\',
		  `changepass` tinyint(1) NOT NULL default \'0\',
		  `orders` tinyint(1) NOT NULL default \'0\',
		  `newticket` tinyint(1) NOT NULL default \'0\',
		  `ticketreply` tinyint(1) NOT NULL default \'0\',
		  `ordersadmin` tinyint(1) NOT NULL default \'0\',
		  `newticketadmin` tinyint(1) NOT NULL default \'0\',
		  `ticketreplyadmin` tinyint(1) NOT NULL default \'0\',
		  `adminmobile` longtext,
		  `businessname` longtext,
		  `sender` longtext,
		  `mobilenumberfield` longtext,
		  `notificationfield` longtext,
		  `username` longtext,
		  `password` longtext,
		  `LineNumber` bigint(20),
		  `no_area` longtext,
		  `senderforce` tinyint(1) NOT NULL default \'0\',
		  `modulecreate` tinyint(1) NOT NULL default \'0\',
		  `modulecreatetext` longtext,
		  `passwordchangetxt` longtext,
		  `ticketopentxtclient` longtext,
		  `ticketopentxtadmin` longtext,
		  `ticketreplytext` longtext,
		  `ticketreplytextadmin` longtext,
		  `ordertextclient` longtext,
		  `ordertextadmin` longtext,
		  `invoicetextclient` longtext,
		  `numbercorrection` tinyint(1) NOT NULL default \'0\',
		  `countrycode` longtext,
		  `leadingzeros` longtext,
		  `logsperpage` bigint(255) default \'10\',
		  `domainxdays` bigint(255) default \'0\',
		  `domainxdaystext` longtext,
		  `modulesuspend` tinyint(1) NOT NULL default \'0\',
		  `modulesuspendtext` longtext,
		  `dueinvoice` tinyint(1) NOT NULL default \'0\',
		  `dueinvoicetext` longtext,
		  `urgency1` longtext,
		  `urgency2` longtext,
		  `urgency3` longtext,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' )) {
			exit( mysql_error(  ) );
			(string)true;
		}

		mysql_query( 'CREATE TABLE `mod_smsaddon_logs` (
		`id` bigint(255) NOT NULL auto_increment,
		`time` longtext NOT NULL,
		`client` longtext,
		`mobilenumber` longtext,
		`result` longtext NOT NULL,
		`text` longtext,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' );

		if (!mysql_query( 'INSERT INTO `mod_smsaddon` (`new_bill`, `changepass`, `orders`, `newticket`, `ticketreply`, `ordersadmin`, `newticketadmin`, `ticketreplyadmin`, `adminmobile`, `sender`, `mobilenumberfield`, `notificationfield`, `username`, `password`, `no_area`, `senderforce`, `modulecreate`, `modulecreatetext`, `passwordchangetxt`, `ticketopentxtclient`, `ticketopentxtadmin`, `ticketreplytext`, `ticketreplytextadmin`, `ordertextclient`, `ordertextadmin`, `invoicetextclient`, `numbercorrection`, `countrycode`, `leadingzeros`, `logsperpage`, `domainxdays`, `domainxdaystext`, `modulesuspend`, `modulesuspendtext`, `dueinvoice`, `dueinvoicetext`, `urgency1`, `urgency2`, `urgency3`) VALUES (0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, \'No\', 0, 0, \'سرويس {domain} فعال گرديده است. لطفا ايميل خود را چک کنيد.\', \'کلمه عبور شما به روزرسانی گرديد. آدرس ايميل شما: {emailaddress}. کلمه رمز: {password}.\', \'کاربر محترم {clientname} تيکت شما با عنوان {subject} دريافت گرديده و به زودی پاسخ داده شده و به روز رسانی می گردد.\', \'کاربر با نام {clientname} در شاخه {department} اقدام به بازکردن تيکت جديد با عنوان {subject} نموده است.\', \'تيکت با عنوان {subject} به روز رسانی گرديده است. لطفا جهت بررسی به حيطه کاربری خود وارد شويد.\', \'کاربر با نام {clientname} در شاخه {department} اقدام به ارسال پاسخ در تيکت با عنوان {subject} نموده است.\', \'کاربر گرامی از سفارش شما به ارزش {amount}  ریال سپاس گزاريم. تاريخ سررسيد سفارش {duedate}.\', \'سفارش جديد به ارزش {amount} به تاريخ سررسيد {duedate} ثبت گرديده است.\', \'صورت حساب جديدی با تاريخ سررسيد {duedate} و به ارزش {amount} برای شما ايجاد گرديده است.\', 0, NULL, NULL, 50, 0, \'{domain} طی {remainingdays} روز آينده منقضی ميگردد.\', 0, \'{domain} به وضعيت تعليق در آمده است. لطفا جهت رفع هرچه سريعتر مشکل با ما تماس بگيريد.\', 1, \'ُسفارش شما به ارزش {amount} در تاريخ {duedate} منقضی گرديد.\', \'1\', \'1\', \'1\');' )) {
			exit( mysql_error(  ) );
			(string)true;
		}

		header( 'Location: addonmodules.php?module=sms_addon&settings&firstuse' );
		exit(  );
	}


	if (isset( $_GET['dosettings'] )) {
		mysql_query( 'UPDATE mod_smsaddon SET username=\'' . $_POST['username'] . '\', password=\'' . $_POST['password'] . '\', senderforce=\'' . $_POST['senderforce'] . '\', LineNumber=\'' . $_POST['LineNumber'] . '\'' );

		if ($_POST['git'] == 'anamenu') {
			header( 'Location: addonmodules.php?module=sms_addon' );
		}
		else {
			header( 'Location: addonmodules.php?module=sms_addon' );
		}

		exit(  );
	}


	if (isset( $_GET['mdosettings'] )) {
		if (!( mysql_query( 'UPDATE mod_smsaddon SET new_bill=\'' . $_POST['new_bill'] . '\', changepass=\'' . $_POST['changepass'] . '\', orders=\'' . $_POST['orders'] . '\', newticket=\'' . $_POST['newticket'] . '\', ticketreply=\'' . $_POST['ticketreply'] . '\', ordersadmin=\'' . $_POST['ordersadmin'] . '\', newticketadmin=\'' . $_POST['newticketadmin'] . '\', ticketreplyadmin=\'' . $_POST['ticketreplyadmin'] . '\', adminmobile=\'' . $_POST['adminmobile'] . '\', businessname=' . GetSQLValueString( $_POST['businessname'], 'text' ) . ', mobilenumberfield=\'' . $_POST['mobilenumberfield'] . '\', notificationfield=' . GetSQLValueString( $_POST['notificationfield'], 'text' ) . ', no_area=' . GetSQLValueString( $_POST['no_area'], 'text' ) . ', modulecreate=\'' . $_POST['modulecreate'] . '\', modulecreatetext=' . GetSQLValueString( $_POST['modulecreatetext'], 'text' ) . ', passwordchangetxt=' . GetSQLValueString( $_POST['passwordchangetxt'], 'text' ) . ', ticketopentxtclient=' . GetSQLValueString( $_POST['ticketopentxtclient'], 'text' ) . ', ticketopentxtadmin=' . GetSQLValueString( $_POST['ticketopentxtadmin'], 'text' ) . ', ticketreplytext=' . GetSQLValueString( $_POST['ticketreplytext'], 'text' ) . ', ticketreplytextadmin=' . GetSQLValueString( $_POST['ticketreplytextadmin'], 'text' ) . ', ordertextclient=' . GetSQLValueString( $_POST['ordertextclient'], 'text' ) . ', ordertextadmin=' . GetSQLValueString( $_POST['ordertextadmin'], 'text' ) . ', invoicetextclient=' . GetSQLValueString( $_POST['invoicetextclient'], 'text' ) . ', countrycode=' . GetSQLValueString( $_POST['countrycode'], 'text' ) . ', logsperpage=\'' . $_POST['logsperpage'] . '\', domainxdays=\'' . $_POST['domainxdays'] . '\', domainxdaystext=' . GetSQLValueString( $_POST['domainxdaystext'], 'text' ) . ', modulesuspend=\'' . $_POST['modulesuspend'] . '\', modulesuspendtext=' . GetSQLValueString( $_POST['modulesuspendtext'], 'text' ) . ', dueinvoice=\'' . $_POST['dueinvoice'] . '\', dueinvoicetext=' . GetSQLValueString( $_POST['dueinvoicetext'], 'text' ) . ', urgency1=\'' . $_POST['urgency1'] . '\', urgency2=\'' . $_POST['urgency2'] . '\', urgency3=\'' . $_POST['urgency3'] . '\'' ))) {
			exit( mysql_error(  ) );
			(bool)true;
		}

		header( 'Location: addonmodules.php?module=sms_addon' );
		exit(  );
	}


	if (isset( $_GET['settings'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );

		if (0 < $row_mod['id']) {
			echo '
				<form action="addonmodules.php?module=sms_addon&dosettings" method="post">
					<fieldset>
						<legend>تنظيمات كاربري سامانه</legend>
                        <table width="500" border="0" cellspacing="0" cellpadding="5" dir="rtl" align="center">
  <tr>
    <td>نام كاربري شما در سامانه</td>
    <td>:</td>
    <td><input type="text" name="use';
			echo 'rname" value="';
			echo $row_mod['username'];
			echo '" size="40"></td>
  </tr>

  <tr>
    <td>رمز عبور شما در سامانه</td>
    <td>:</td>
    <td><input type="password" name="password" value="';
			echo $row_mod['password'];
			echo '" size="40"></td>
  </tr>

  <tr>
    <td>شماره اختصاصي يا عمومي پيام كوتاه</td>
    <td>:</td>
    <td><input type="text" name="LineNumber" value="';
			echo $row_mod['LineNumber'];
			echo '" size="40"></td>
  </tr>



</table>
<!--
<input type="radio" name="senderforce" value="1"
                ';
			echo '-->

			<input type="submit" value="ذخيره تنظيمات">
		<input type="button" value="بازگشت" onclick="javascript:window.location=\'addonmodules.php?module=sms_addon\'">


			</fieldset>
</form>
';
			return null;
		}

		echo 'نصب افزونه با مشکل مواجه شده است. برای نصب مجدد <a href=\'addonmodules.php?module=sms_addon&cleanup\'>اينجا</a> کليک کنيد.';
		return 1;
	}


	if (isset( $_GET['modifysettings'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );

		if (0 < $row_mod['id']) {
			echo '
			<fieldset>
				<legend>تنظيمات ماژول</legend>
			<form action=\'addonmodules.php?module=sms_addon&mdosettings\' method=\'post\'>
			<table width=\'100%\' border=\'0\' cellspacing="5" cellpadding="5" class="datatable">
			<tr><td >نام فيلد شماره موبايل:</td>';
			$al = mysql_query( 'SELECT fieldname FROM tblcustomfields WHERE type=\'client\' AND fieldtype=\'text\'' );
			$totalRows_al = mysql_num_rows( $al );

			if ($totalRows_al == 0) {
				echo '<td style=\'border-top:1px solid black;border-bottom:1px solid black;background:#f58c8c;\'>شما بايد فيلد اضافه ای تعريف نماييد</td></tr>';
			}
			else {
				echo '<td ><select name=\'mobilenumberfield\'><option value=\'\'></option>';
				$a = 16;

				if ($row_al = mysql_fetch_assoc( $al )) {
					echo '<option value=\'' . $row_al['fieldname'] . '\'';

					if ($row_mod['mobilenumberfield'] == $row_al['fieldname']) {
						echo ' selected=\'selected\'';
						$a = 17;
					}

					echo '>' . $row_al['fieldname'] . '</option>';
				}


				if ($a != 0) {
					echo '</select><br />
					به منظور استفاده از امكانات ماژول، شما مي بايست يك فيلد سفارشي براي موبايل بسازيد و سپس در اين قسمت آن فيلد را انتخاب كنيد.
					</td></tr>';
				}
				else {
					echo '</select><br /><font style=\'background-color:red;color:#ffffff\'>لطفا فيلد مورد نظر را انتخاب نماييد</font></td></tr>';
				}
			}

			echo '<tr><td >نام فیلد ارسال پیامک:</td>';
			$al2 = mysql_query( 'SELECT fieldname FROM tblcustomfields WHERE type=\'client\' AND fieldtype=\'dropdown\'' );
			$totalRows_al2 = mysql_num_rows( $al2 );

			if ($totalRows_al2 == 0) {
				echo '<td style=\'border-top:1px solid black;border-bottom:1px solid black;background:#f58c8c;\'>You must create a custom client field as dropdown and ask client if he/she wants to receive SMS messages</td></tr>';
			}
			else {
				echo '<td ><select name=\'notificationfield\'><option value=\'\'></option>';
				$a = 16;

				if ($row_al2 = mysql_fetch_assoc( $al2 )) {
					echo '<option value=\'' . $row_al2['fieldname'] . '\'';

					if ($row_mod['notificationfield'] == $row_al2['fieldname']) {
						echo ' selected=\'selected\'';
						$a = 17;
					}

					echo '>' . $row_al2['fieldname'] . '</option>';
				}


				if ($a != 0) {
					echo '</select><br />
					به منظور استفاده از امكانات ماژول، شما مي بايست يك ليست انتخاب سفارشي بسازيد تا مشتري شما دريافت پيام را مشخص نمايد.

</td></tr>';
				}
				else {
					echo '</select><br /><font style=\'background-color:red;color:#ffffff\'>لطفا فيلد مورد نظر را انتخاب نماييد</font></td></tr>';
				}
			}

			echo '<tr><td >فيلد عدم ارسال:</td>';
			$al3 = @mysql_query( 'SELECT fieldoptions FROM tblcustomfields WHERE type=\'client\' AND fieldtype=\'dropdown\'' );
			$totalRows_al3 = mysql_num_rows( $al3 );

			if ($totalRows_al3 == 0) {
				echo '<td style=\'border-top:1px solid black;border-bottom:1px solid black;background:#f58c8c;\'>You must create a custom client field as dropdown and ask client if he/she wants to receive SMS messages</td></tr>';
			}
			else {

				if ($row_al3 = mysql_fetch_assoc( $al3 )) {
					$patlat = explode( ',', $row_al3['fieldoptions'] );
					foreach ($patlat as $isim) {
						$secenekler[] = $isim;
					}
				}

				echo '<td ><select name=\'no_area\'><option value=\'\'></option>';
				foreach ($secenekler as $secenek) {
					echo '<option value=\'' . $secenek . '\'';

					if ($row_mod['no_area'] == $secenek) {
						echo ' selected=\'selected\'';
					}

					echo '>' . $secenek . '</option>';
				}

				echo '</select><br />
				گزينه انتخابي را مشخص كنيد كه مشتري شما توسط آن دريافت پيام را غير فعال نمايد.

				</td></tr>';
			}

			echo '<tr><td >شماره موبایل مدیر :</td>';
			echo '<td ><input type=\'text\' name=\'adminmobile\' value=\'' . $row_mod['adminmobile'] . '\'><br />شماره موبایل مدیر را با فرمت صحیح وارد نمایید.در صورتی که چند مدیر دارید شماره موبایل مدیران را با ; جدا نمایید</td></tr>';
			echo '<tr><td>تعداد نمایش پیامک ها در هر صفحه:</td>';
			echo '<td><input type=\'text\' name=\'logsperpage\' value=\'' . $row_mod['logsperpage'] . '\'></td></tr>';
			echo '<tr><td colspan=\'2\'>&nbsp;</td></tr>';
			echo '<tr><td colspan=\'2\'><font color=\'red\'><b>تنظیمات پیامک ها</b></font></td></tr>';
			echo '<tr><td colspan=\'2\'><b><u>ارسال پیامک به مشتریان:</u></b></td></tr>';
			echo '<tr><td>در زمان ايجاد فاکتور (ارسال روزانه):</td>';
			echo '<td><input type=\'radio\' name=\'new_bill\' value=\'1\'';

			if ($row_mod['new_bill'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'new_bill\' value=\'0\'';

			if ($row_mod['new_bill'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'invoicetextclient\' cols=\'70\' rows=\'1\'>' . $row_mod['invoicetextclient'] . '</textarea><br />Variables: {amount}, {duedate}</td></tr>';
			echo '<tr><td >در زمان تغییر کلمه عبور:</td>';
			echo '<td ><input type=\'radio\' name=\'changepass\' value=\'1\'';

			if ($row_mod['changepass'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'changepass\' value=\'0\'';

			if ($row_mod['changepass'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'passwordchangetxt\' cols=\'70\' rows=\'1\'>' . $row_mod['passwordchangetxt'] . '</textarea><br />Variables:{emailaddress}, {password}</td></tr>';
			echo '<tr><td >هنگام ارسال سفارش جدید:</td>';
			echo '<td ><input type=\'radio\' name=\'orders\' value=\'1\'';

			if ($row_mod['orders'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'orders\' value=\'0\'';

			if ($row_mod['orders'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'ordertextclient\' cols=\'70\' rows=\'1\'>' . $row_mod['ordertextclient'] . '</textarea><br />Variables: {amount}, {duedate}, {orderid}, {ordernumber}</td></tr>';
			echo '<tr><td >هنگام ارسال تیکت پشتیبانی:</td>';
			echo '<td ><input type=\'radio\' name=\'newticket\' value=\'1\'';

			if ($row_mod['newticket'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'newticket\' value=\'0\'';

			if ($row_mod['newticket'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'ticketopentxtclient\' cols=\'70\' rows=\'1\'>' . $row_mod['ticketopentxtclient'] . '</textarea><br />Variables:{ticketid}, {clientname}, {department}, {departmentid}, {subject}, {message}, {priority}</td></tr>';
			echo '<tr><td >هنگام پاسخ دادن به تیکت پشتیبانی:</td>';
			echo '<td ><input type=\'radio\' name=\'ticketreply\' value=\'1\'';

			if ($row_mod['ticketreply'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'ticketreply\' value=\'0\'';

			if ($row_mod['ticketreply'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br />If enabled, client will be texted when admin replies to his/her support ticket.<br /><textarea dir=\'rtl\' name=\'ticketreplytext\' cols=\'70\' rows=\'1\'>' . $row_mod['ticketreplytext'] . '</textarea><br />Variables: {ticketid}, {replyid}, {admin}, {departmentid}, {department}, {subject}, {message}, {priority}, {status}</td></tr>';
			echo '<tr><td >در زمان ایجاد سرویس:</td>';
			echo '<td ><input type=\'radio\' name=\'modulecreate\' value=\'1\'';

			if ($row_mod['modulecreate'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'modulecreate\' value=\'0\'';

			if ($row_mod['modulecreate'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'modulecreatetext\' cols=\'70\' rows=\'1\'>' . $row_mod['modulecreatetext'] . '</textarea><br />Variables: {domain}, {username}, {password}</td></tr>';
			echo '<tr><td >در زمان بسته شدن سرویس:</td>';
			echo '<td ><input type=\'radio\' name=\'modulesuspend\' value=\'1\'';

			if ($row_mod['modulesuspend'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'modulesuspend\' value=\'0\'';

			if ($row_mod['modulesuspend'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'modulesuspendtext\' cols=\'70\' rows=\'1\'>' . $row_mod['modulesuspendtext'] . '</textarea><br />Variables: {domain}, {username}, {password}</td></tr>';
			echo '<tr><td >قبل از انقضای سرويس(Daily Cron):</td>';
			echo '<td ><input type=\'text\' name=\'domainxdays\' value=\'' . $row_mod['domainxdays'] . '\' style=\'width:30px\'> days before, set 0 to disable<br /><textarea dir=\'rtl\' name=\'domainxdaystext\' cols=\'70\' rows=\'1\'>' . $row_mod['domainxdaystext'] . '</textarea><br />Variables: {domain}, {remainingdays}, {expirydate}</td></tr>';
			echo '<tr><td>در زمان انقضای سفارش(Daily Cron):</td>';
			echo '<td><input type=\'radio\' name=\'dueinvoice\' value=\'1\'';

			if ($row_mod['dueinvoice'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'dueinvoice\' value=\'0\'';

			if ($row_mod['dueinvoice'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'dueinvoicetext\' cols=\'70\' rows=\'1\'>' . $row_mod['dueinvoicetext'] . '</textarea><br />Variables: {amount}, {duedate}</td></tr>';
			echo '<tr><td colspan=\'2\'><b><u>ارسال پیامک به مدیریت:</u></b></td></tr>';
			echo '<tr><td>هنگام ارسال سفارش جدید:</td>';
			echo '<td><input type=\'radio\' name=\'ordersadmin\' value=\'1\'';

			if ($row_mod['ordersadmin'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'ordersadmin\' value=\'0\'';

			if ($row_mod['ordersadmin'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'ordertextadmin\' cols=\'70\' rows=\'1\'>' . $row_mod['ordertextadmin'] . '</textarea><br />Variables: {amount}, {duedate}, {orderid}, {ordernumber}</td></tr>';
			echo '<tr><td >هنگام ارسال تیکت پشتیبانی جدید:</td>';
			echo '<td ><input type=\'radio\' name=\'newticketadmin\' value=\'1\'';

			if ($row_mod['newticketadmin'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'newticketadmin\' value=\'0\'';

			if ($row_mod['newticketadmin'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br><br>Urgency: <input type="checkbox" name="urgency3" value="1"';

			if ($row_mod['urgency3'] == 1) {
				echo ' checked="checked"';
			}

			echo '> مهم <input type="checkbox" name="urgency2" value="1"';

			if ($row_mod['urgency2'] == 1) {
				echo ' checked="checked"';
			}

			echo '> متوسط <input type="checkbox" name="urgency1" value="1"';

			if ($row_mod['urgency1'] == 1) {
				echo ' checked="checked"';
			}

			echo '> کم اهميت<br /><textarea dir=\'rtl\' name=\'ticketopentxtadmin\' cols=\'70\' rows=\'1\'>' . $row_mod['ticketopentxtadmin'] . '</textarea><br />Variables:{ticketid}, {clientname}, {department}, {departmentid}, {subject}, {message}, {priority}</td></tr>';
			echo '<tr><td>هنگام پاسخ دادن به تیکت پشتیبانی:</td>';
			echo '<td><input type=\'radio\' name=\'ticketreplyadmin\' value=\'1\'';

			if ($row_mod['ticketreplyadmin'] == 1) {
				echo ' checked=\'checked\'';
			}

			echo '> فعال <input type=\'radio\' name=\'ticketreplyadmin\' value=\'0\'';

			if ($row_mod['ticketreplyadmin'] == 0) {
				echo ' checked=\'checked\'';
			}

			echo '> غيرفعال<br /><textarea dir=\'rtl\' name=\'ticketreplytextadmin\' cols=\'70\' rows=\'1\'>' . $row_mod['ticketreplytextadmin'] . '</textarea><br />Variables: {ticketid}, {replyid}, {userid}, {clientname}, {departmentid}, {department}, {subject}, {message}, {priority}, {status}</td></tr>';
			echo '<tr><td colspan=\'2\'><b><u>تنظیمات عمومی:</u></b></td></tr>';
			echo '<tr><td>امضا:</td>';
			echo '<td><textarea dir=\'rtl\' name=\'businessname\' cols=\'70\' rows=\'1\'>' . $row_mod['businessname'] . '</textarea><br />این متن به آخر تمامی متن پیامک های ارسال شده افزوده می شود.</td></tr>';
			echo '<tr><td colspan=\'2\' align=\'center\'><input type=\'submit\' value=\'ذخيره تنظيمات\'>';

			if (!isset( $_GET['firstuse'] )) {
				echo '<input type="hidden" name="git" value="anamenu"> <input type=\'button\' value=\'بازگشت\' onclick="javascript:window.location=\'addonmodules.php?module=sms_addon\';">';
			}

			echo '</td></tr>
			</table>
			</form>
			</fieldset>
			';
			return 1;
		}

		echo 'نصب افزونه با مشکل مواجه شده است. برای نصب مجدد <a href=\'addonmodules.php?module=sms_addon&cleanup\'>اينجا</a> کليک کنيد.';
		return 1;
	}


	if (isset( $_GET['error'] )) {
		echo $_SESSION['error'] . '<br /><a href=\'javascript:history.go(-1)\'>بازگشت</a>';
		return 1;
	}


	if (isset( $_GET['singlesms'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );
		$customers = @mysql_query( 'SELECT id, firstname, lastname FROM tblclients ORDER BY firstname, lastname ASC' );
		$row_telfield = mysql_fetch_assoc( mysql_query( 'SELECT id FROM tblcustomfields WHERE fieldname=' . @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
		echo '
		<fieldset>
				<legend>ارسال پيام تكي</legend>
		<form method=\'post\' action=\'addonmodules.php?module=sms_addon&SendSingleSms\'>متن پيامک:<br /><textarea name=\'content\' style=\'width:350px;\' rows=\'10\'></textarea><br />دريافت کننده:<br /> <select name=\'customer\'><option value="none">کاربر مورد نظر</option>';

		if ($row_customers = mysql_fetch_assoc( $customers )) {
			$mod2 = @mysql_query( 'SELECT * FROM mod_smsaddon' );
			$row_mod2 = @mysql_fetch_assoc( $mod2 );
			$telu = '';
			$row_telno = mysql_fetch_assoc( @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_telfield['id'] . '\' AND relid=\'' . $row_customers['id'] . '\'' ) );
			$telu = $row_telno['value'];

			if ($telu != '') {
				$telu = str_replace( array( ' ', '-', '(', ')', '' ), '', $telu );

				if ($telu[0] != '0') {
					$telu = '0' . $telu;
				}
			}

			echo '<option value="' . $telu . '|' . $row_customers['id'] . '"';

			if ($telu == '') {
				$telu = 'فاقد شماره موبايل';
				echo ' disabled="disabled"';
			}

			echo '>' . $row_customers['firstname'] . ' ' . $row_customers['lastname'] . ' (' . $telu . ')</option>';
		}

		echo '</select><br /><b>و يا</b> شماره موبايل:<br /><input type=\'text\' name=\'recipient\'><br /><br /><input type=\'submit\' value=\'ارسال پيامک\'>
		<input type=\'button\' value=\'بازگشت\' onclick="javascript:window.location=\'addonmodules.php?module=sms_addon\';"></form></fieldset>';
		return 1;
	}


	if (isset( $_GET['masssms'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );
		$customers = @mysql_query( 'SELECT count(id) FROM tblclients' );
		$row_customers = @mysql_fetch_assoc( $customers );
		$totalRows_mod = @mysql_num_rows( $mod );
		echo '
		<fieldset>
			<legend>ارسال پيامک گروهی</legend>
			<br /><br />' . $credit_str . '<br /><br />';

		if (( isset( $_SESSION['masssmserror'] ) && $_SESSION['masssmserror'] != '' )) {
			echo '<font style="color:#f58c8c;font-weight:bold;">' . $_SESSION['masssmserror'] . '</font><br /><br />';
			$_SESSION['masssmserror'] = '';
		}

		echo '<form method=\'post\' action=\'addonmodules.php?module=sms_addon&SendMassSms\'>متن پيامک:<br /><textarea name=\'content\' style=\'width:350px;\' rows=\'10\'></textarea><br />ارسال پيامک به کل اعضا به صورت اجباری: <input type=\'radio\' name=\'force\' value=\'0\' checked=\'checked\'> خير <input type=\'radio\' name=\'force\' value=\'1\'> بله<br /><input type=\'submit\' value=\'ارسال پيامک گروهی\'>
		<input type=\'button\' value=\'بازگشت\' onclick="javascript:window.location=\'addonmodules.php?module=sms_addon\';"></form></fieldset>';
		return 1;
	}


	if (isset( $_GET['logs'] )) {
		$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
		$row_mod = @mysql_fetch_assoc( $mod );
		$maxRows_log = $row_mod['logsperpage'];
		$pageNum_log = 16;

		if (isset( $_GET['page'] )) {
			$pageNum_log = $_GET['page'] - 1;
		}

		$startRow_log = $pageNum_log * $maxRows_log;
		$query_log = 'SELECT * FROM mod_smsaddon_logs ORDER BY id DESC';
		$query_limit_log = sprintf( '%s LIMIT %d, %d', $query_log, $startRow_log, $maxRows_log );

		if (!$log = @mysql_query( $query_limit_log )) {
			exit( mysql_error(  ) );
			(string)true;
		}

		$all_log = @mysql_query( $query_log );
		$totalRows_log = @mysql_num_rows( $all_log );
		$totalPages_log = ceil( $totalRows_log / $maxRows_log ) - 1;
		echo '
		<fieldset>
			<legend>ليست پيامک های ارسالی</legend>


<table width="100%" border="0" cellspacing="0" cellpadding="3">

  <tr style="background-color:#333; color:#FFF; text-align:center">
    <td width="5" align="center">رديف</td>
    <td width="150">زمان ارسال</td>
    <td width="250">كاربر / موبايل</td>
    <td>متن پيامك</td>
    <td width="10';
		echo '">وضعيت</td>
  </tr>
';
		$i = 17;

		if ($row_log = mysql_fetch_assoc( $log )) {
			echo '
  <tr class="row_';
			echo $i % 2;
			echo '">
    <td>';
			echo $i;
			echo '</td>

    <td>
	';
			echo $AlmasDateTime->date( 'l j F Y ', $row_log['time'], true, true, 'Asia/Tehran' );
			echo '<br>';
			echo $AlmasDateTime->date( 'ساعت H:i:s', $row_log['time'], true, true, 'Asia/Tehran' );
			echo '    </td>
    <td>
';

			if (( ( $row_log['client'] != 0 && $row_log['client'] != 'admin' ) && $row_log['client'] != '' )) {
				$row_customeral = mysql_fetch_assoc( @mysql_query( 'SELECT firstname, lastname FROM tblclients WHERE id=\'' . $row_log['client'] . '\'' ) );
				echo '<a href=\'clientssummary.php?userid=' . $row_log['client'] . '\' target=\'_blank\'>' . $row_customeral['firstname'] . ' ' . $row_customeral['lastname'] . '</a>';
			}
			else {
				echo $row_log['client'];
			}

			echo '    : ';
			echo $row_log['mobilenumber'];
			echo '    </td>
    <td style="text-align:justify; direction:rtl">
	  ';
			echo $row_log['text'];
			echo '    </td>
    <td align="center">
		';

			if (preg_match( '/,/', $row_log['result'] )) {
				$res = explode( ',', $row_log['result'] );
				echo '				<img src="images/sendsmsstatus_icons/send_moteghayer.png" width="20" height="17" />
            ';
			}
			else {
				switch ($row_log['result']) {
				case 'E001': {
						$MSG = 'نام كاربري يا رمز عبور در تنظيمات اشتباه وارد شده است.';
						break;
					}

				case 'E002': {
						$MSG = 'شما به خط تنظيم شده دسترسي نداريد.';
						break;
					}

				case 'E003': {
						$MSG = 'براي اين ارسال اعتبار كافي وجود نداشته است.';
						break;
					}

				case 'E004': {
						$MSG = 'در ليست ارسال گيرنده اي با شماره صحيح يافت نشد.';
						break;
					}

				case 'E005': {
						$MSG = 'خطاي نامشخصي رخ داده است.';
						break;
					}

				default: {
						$MSG = 'خطاي نامشخصي رخ داده است.';
					}
				}

				echo '				<img src="images/sendsmsstatus_icons/alert.png" width="16" height="13" title="';
				echo $MSG;
				echo '"/>
                ';
			}

			echo '            </td>
  </tr>
';
			++$i;
		}

		echo '
  <tr style="background-color:#333; color:#FFF; text-align:center">
      <td colspan="5">&nbsp;</td>
  </tr>

</table>

<br />

		';

		if (0 < $pageNum_log) {
			echo '<a href="addonmodules.php?module=sms_addon&logs&page=' . ( max( 0, $pageNum_log - 1 ) + 1 ) . '">صفحه قبل</a> | ';
		}


		if (1 < $totalPages_log) {
			$i = 16;

			while ($i <= $totalPages_log) {
				$abc = $i + 1;

				if ($pageNum_log == $i) {
					echo '(' . $abc . ') ';
				}
				else {
					echo '<a href=\'addonmodules.php?module=sms_addon&logs&page=' . $abc . '\'>' . $abc . '</a> ';
				}

				++$i;
			}
		}


		if ($pageNum_log < $totalPages_log) {
			echo '| <a href="addonmodules.php?module=sms_addon&logs&page=' . ( min( $totalPages_log, $pageNum_log + 1 ) + 1 ) . '">صفحه بعد</a><br /><br />';
		}

		echo '<br style="clear:both">';
		echo '<input type=\'button\' value=\'حذف ليست ارسال ها\' onclick="javascript:window.location=\'addonmodules.php?module=sms_addon&clearlog\';">';
		echo ' <input type=\'button\' value=\'بازگشت\' onclick="javascript:window.location=\'addonmodules.php?module=sms_addon\';">';
		return 1;
	}

	$mod = @mysql_query( 'SELECT * FROM mod_smsaddon' );
	$row_mod = @mysql_fetch_assoc( $mod );

	if ($row_mod) {
		echo '
<fieldset>
	<legend>افزونه ارسال پيام كوتاه:</legend>
    <div id="almas-smspanel">
    	<div id="almas-smspanel-about">
        	<div style="color:#960038; text-align:center">
        	ماژول ارسال پيام كوتاه WHMCS
            <br />
			ورژن ماژول ارسال پیامک : 3.5
            <br />
            طراحي و برنامه نويسي توسط:
			<br />
 ';
		echo '           <a href="http://boardiran.ir" target="_blank">شرکت ارتباط گستر بردایران</a>
            <br /> <a href="http://boardiran.ir" target="_blank"><img src="http://boardiran.ir/BANK/email/images/logo.png" alt="" width="154" height="154"></a></div>
';
		echo '<s';
		echo 'cript>
$(document).ready(function() {
	$("#contentarea div h2").hide(0);
	$("#sms-tools").slideUp(0);
	$( "#tools-click" ).click(function() {
		$("#sms-tools").toggle(500);
	});
});
</script>
						<br />

			<div id="tools-click" style="cursor:pointer; color:#F00; text-align:center">ويــژگيهــا</div>
         <div id="sms-tools" style="text-align:justify">
			- ار';
		echo 'سال تكي با درج شماره<br />
			- ارسال تكي به مشتريان ثبت شده
            <br />
			- افزودن فيلد شماره موبايل به فرم هاي ثبت نام و ثبت سفارش<br />
			- تنظيم شماره خط پيام كوتاه<br />
			- ارسال خودكار پيام در زمان ايجاد فاكتور
            <br />
			- ارسال';
		echo ' خودكار پيام در هنگام ثبت سفارش
            <br />
			- ارسال خودكار پيام در هنگام ثبت درخواست پشتيباني
            <br />
            - ارسال پيام به مشتري در هنگام پاسخ مدير به درخواست
            <br />
			- ارسال خودكار پيام در زمان ايجاد سرويس
           ';
		echo ' <br />
			- ارسال خودكار پيام در زمان مسدود شدن سرويس
            <br />
			- ارسال خودكار پيام قبل از انقضاي سرويس
            <br />
			- ارسال خودكار پيام در زمان انقضاي سرويس
<br />
			- ارسال خودكار پيام در زمان تغيير رمز عبور<br />
			- افزودن امضاء';
		echo ' به كليه پيامهاي ارسالي<br />
            - تنظيم هوشمند متن پيام در كليه شيوه هاي ذكر شده
            <br />
            - تاريخ صحيح شمسي در ثبت پيامهاي ارسال شده<br />
            - قابليت فعال يا غير فعال كردن هر يك از تنظيمات ارسال خودكار<br />

			- و ...';
		echo '.
          </div>

        </div>

    </div>
    <div id="almas-sms-icons">
		<div id="cpanel">

			<div style="float:right;">
				<div class="icon">
				<a href="addonmodules.php?module=sms_addon&settings">
				<img src="images/sms/icon-48-config.png" alt="SC_MANAGE_PRODUCTS" name="image" align="middle" border="0" height="48" width="48"><br>
				تنظیم کاربا;
		echo 'қ̠و رمز پنــل</a>
				</div>
			</div>

			<div style="float:right;">
				<div class="icon">
				<a href="addonmodules.php?module=sms_addon&modifysettings">
				<img src="images/sms/sendNu.png" alt="SC_MANAGE_PRODUCTS" name="image" align="middle" border="0" height="48" width="48"><br>
				تنـظيمــات<br>
				مـــاژول</a>
				</div>
			</div>



			<div styl';
		echo 'e="float:right;">
				<div class="icon">
				<a href="addonmodules.php?module=sms_addon&singlesms">
				<img src="images/sms/list_send_sms.png" alt="SC_MANAGE_PRODUCTS" name="image" align="middle" border="0" height="48" width="48"><br>
				ارســال تكي<br>
                (شماره/ اعضا)
				</a>
				</div>
			</div>

			<div style="float:right;">
				<div class="icon"';
		echo '>
				<a href="addonmodules.php?module=sms_addon&masssms">
				<img src="images/sms/group.png" alt="SC_MANAGE_PRODUCTS" name="image" align="middle" border="0" height="48" width="48"><br>
				ارسال گروهي به<br>
				اعضـاي سايت</a>
				</div>
			</div>

			<div style="float:right;">
				<div class="icon">
				<a href="addonmodules.php?module=sms_addon&logs">
				<i';
		echo 'mg src="images/sms/list.png" alt="SC_MANAGE_PRODUCTS" name="image" align="middle" border="0" height="48" width="48"><br>
				ليست پيامهاي<br>
				ارســال شــده</a>
				</div>
			</div>
            <div style="clear:both"></div>


        </div>
    </div>

</fieldset>

        ';
	}
	else {
		echo '		افزونه فعال شده است ولي اطلاعات بانك اطلاعاتي و نصب نهايي انجام نشده است. لطفا براي نصب نهايي روي دكه زير كليك كنيد...
        <br />

		<button onclick="javascript:window.location=\'addonmodules.php?module=sms_addon&next\'"> نصب نهايي افزونه</button>

	';
	}


	if (isset( $_GET[firstuse] )) {
		echo '<form action=\'addonmodules.php?module=sms_addon&next\' method=\'post\'><input type=\'submit\' value=\'نصب افزونه\'></form>';
	}

}

function sms_addon_activate() {
	$query = 'CREATE TABLE `mod_addonexample` (`id` INT( 1 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`demo` TEXT NOT NULL )';
	$result = mysql_query( $query );
	return array( 'status' => 'success', 'description' => 'This is an demo module only. In a real module you might instruct a user how to get started with it here...' );
}

echo '﻿
';

if (!defined( 'WHMCS' )) {
	exit( 'This file cannot be accessed directly' );
}

?>
