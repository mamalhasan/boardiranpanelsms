<?php

function SendSMS($gateway, $message) {
	if (is_file( 'lib/nusoap.php' )) {
		include_once( 'lib/nusoap.php' );
	}
	else {
		include_once( '../lib/nusoap.php' );
	}

	nusoap_client;
	new ( 'http://79.175.167.50/webservice/server.php?wsdl' );
	$client = ;
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$parameters['username'] = $gateway['number'];
	$parameters['password'] = $gateway['pass'];
	$parameters['to'] = $message['numbers'];
	$parameters['LineNumber'] = $gateway['LineNumber'];
	$parameters['text'] = $message['content'];
	$client->call( 'SENDSMS', array( 'UserName' => $parameters['username'], 'Password' => $parameters['password'], 'LineNumber' => $parameters['LineNumber'], 'Recivers' => $parameters['to'], 'Smsmsg' => $parameters['text'], 'SendDate' => date( 'Y-m-d' ), 'SendTime' => date( 'H:i:s' ), 'MesClass' => '1' ) );
	$result = ;

	if ($result[Error] == '') {
		return '4' . ',' . $result[SendID];
	}

	return $result[Error];
}

function client_change_password($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($row_mod['changepass'] == 1) {
			mysql_fetch_assoc( mysql_query( 'SELECT email FROM tblclients WHERE id=\'' . $vars['userid'] . '\'' ) );
			$row_masteremail = ;
			str_replace( '{emailaddress}', $row_masteremail['email'], $row_mod['passwordchangetxt'] );
			$passwordchangetxt = ;
			str_replace( '{password}', $vars['password'], $passwordchangetxt );
			$passwordchangetxt = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
			$tel = ;
			@mysql_fetch_assoc( $tel );
			$row_tel = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
			$report = ;
			@mysql_fetch_assoc( $report );
			$row_report = ;

			if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $vars['userid'] . '\'' );
				$teli = ;
				@mysql_fetch_assoc( $teli );
				$row_teli = ;
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $vars['userid'] . '\'' );
				$reportal = ;
				@mysql_fetch_assoc( $reportal );
				$row_reportal = ;

				if ($row_teli['value'] == '') {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $passwordchangetxt . $row_mod['businessname'] ) . '\')' );
					$error = 7;
				}


				if ($error != 1) {
					$row_teli['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_teli['value'] );

					if ($row_teli['value'][0] != '0') {
						$row_teli['value'] = '0' . $row_teli['value'];
					}
				}


				if ($error != 1) {
					if ($row_reportal['value'] == $row_mod['no_area']) {
						$error = 7;
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars[0] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $passwordchangetxt . $row_mod['businessname'] ) . '\')' );
					}
				}


				if ($error != 1) {
					$gateway['number'] = $row_mod['username'];
					$gateway['pass'] = $row_mod['password'];
					$message['numbers'] = $row_teli['value'];
					$message['content'] = $passwordchangetxt . $row_mod['businessname'];
					$gateway['LineNumber'] = $row_mod['LineNumber'];
					SendSMS( $gateway, $message );
					$response = ;
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'' . $row_teli['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $passwordchangetxt . $row_mod['businessname'] ) . '\')' );
				}
			}
			else {
				mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
			}
		}
	}

	return true;
}

function ticket_open($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($vars['userid'] != 0) {
			if (( $row_mod['newticket'] == 1 || $row_mod['newticketadmin'] == 1 )) {
				mysql_fetch_assoc( mysql_query( 'SELECT firstname, lastname FROM tblclients WHERE id=\'' . $vars['userid'] . '\'' ) );
				$row_kullaniciyial = ;
				$ticketopentxtclient = $row_mod['ticketopentxtclient'] . $row_mod['businessname'];
				str_replace( '{department}', $vars['deptname'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{subject}', $vars['subject'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{priority}', $vars['priority'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{clientname}', $row_kullaniciyial['firstname'] . ' ' . $row_kullaniciyial['lastname'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{ticketid}', $vars['ticketid'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{departmentid}', $vars['deptid'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				str_replace( '{message}', $vars['message'], $ticketopentxtclient );
				$ticketopentxtclient = ;
				$ticketopentxtadmin = $row_mod['ticketopentxtadmin'] . $row_mod['businessname'];
				str_replace( '{department}', $vars['deptname'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{subject}', $vars['subject'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{priority}', $vars['priority'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{clientname}', $row_kullaniciyial['firstname'] . ' ' . $row_kullaniciyial['lastname'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{ticketid}', $vars['ticketid'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{departmentid}', $vars['deptid'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				str_replace( '{message}', $vars['message'], $ticketopentxtadmin );
				$ticketopentxtadmin = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
				$tel = ;
				@mysql_fetch_assoc( $tel );
				$row_tel = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
				$report = ;
				@mysql_fetch_assoc( $report );
				$row_report = ;

				if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $vars['userid'] . '\'' );
					$tel = ;
					@mysql_fetch_assoc( $tel );
					$row_tel = ;
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $vars['userid'] . '\'' );
					$reportal = ;
					@mysql_fetch_assoc( $reportal );
					$row_reportal = ;

					if ($row_tel['value'] == '') {
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $ticketopentxtclient ) . '\')' );
						$error = 7;
					}


					if ($error != 1) {
						$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

						if ($row_tel['value'][0] != '0') {
							$row_tel['value'] = '0' . $row_tel['value'];
						}
					}


					if ($error != 1) {
						if ($row_reportal['value'] == $row_mod['no_area']) {
							$error = 7;

							if ($row_mod['newticket'] == 1) {
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $ticketopentxtclient ) . '\')' );
							}
						}
					}


					if ($row_mod['newticket'] == 1) {
						if ($error != 1) {
							$gateway['number'] = $row_mod['username'];
							$gateway['pass'] = $row_mod['password'];
							$message['numbers'] = $row_tel['value'];
							$message['content'] = $ticketopentxtclient;
							$gateway['LineNumber'] = $row_mod['LineNumber'];
							SendSMS( $gateway, $message );
							$response = ;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ticketopentxtclient ) . '\')' );
						}
					}


					if ($row_mod['newticketadmin'] == 1) {
						if ($row_mod['urgency1'] == 1) {
							$ticketonstring1 = 'Low';
						}


						if ($row_mod['urgency2'] == 1) {
							$ticketonstring2 = 'Medium';
						}


						if ($row_mod['urgency3'] == 1) {
							$ticketonstring3 = 'High';
						}


						if (( ( $vars['priority'] == $ticketonstring1 || $vars['priority'] == $ticketonstring2 ) || $vars['priority'] == $ticketonstring3 )) {
							$gateway['number'] = $row_mod['username'];
							$gateway['pass'] = $row_mod['password'];
							$message['numbers'] = $row_mod['adminmobile'];
							$message['content'] = $ticketopentxtadmin;
							$gateway['LineNumber'] = $row_mod['LineNumber'];
							SendSMS( $gateway, $message );
							$response = ;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'admin\', \'' . $row_mod['adminmobile'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ticketopentxtadmin ) . '\')' );
						}
					}
				}
				else {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
				}
			}
		}
	}

	return true;
}

function ticket_admin($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		@mysql_query( 'SELECT userid FROM tbltickets WHERE id=\'' . $vars['ticketid'] . '\'' );
		$ticketal = ;
		@mysql_fetch_assoc( $ticketal );
		$row_ticketal = ;

		if ($row_ticketal['userid'] != 0) {
			if ($row_mod['ticketreply'] == 1) {
				$ticketreplytext = $row_mod['ticketreplytext'] . $row_mod['businessname'];
				str_replace( '{ticketid}', $vars['ticketid'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{replyid}', $vars['replyid'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{admin}', $vars['admin'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{departmentid}', $vars['deptid'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{department}', $vars['deptname'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{subject}', $vars['subject'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{message}', $vars['message'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{priority}', $vars['priority'], $ticketreplytext );
				$ticketreplytext = ;
				str_replace( '{status}', $vars['status'], $ticketreplytext );
				$ticketreplytext = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
				$tel = ;
				@mysql_fetch_assoc( $tel );
				$row_tel = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
				$report = ;
				@mysql_fetch_assoc( $report );
				$row_report = ;

				if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_ticketal['userid'] . '\'' );
					$tel = ;
					@mysql_fetch_assoc( $tel );
					$row_tel = ;
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_ticketal['userid'] . '\'' );
					$reportal = ;
					@mysql_fetch_assoc( $reportal );
					$row_reportal = ;

					if ($row_tel['value'] == '') {
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_ticketal['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $ticketreplytext ) . '\')' );
						$error = 7;
					}


					if ($error != 1) {
						$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

						if ($row_tel['value'][0] != '0') {
							$row_tel['value'] = '0' . $row_tel['value'];
						}
					}


					if ($error != 1) {
						if ($row_reportal['value'] == $row_mod['no_area']) {
							$error = 7;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_ticketal['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $ticketreplytext ) . '\')' );
						}
					}


					if ($error != 1) {
						$gateway['number'] = $row_mod['username'];
						$gateway['pass'] = $row_mod['password'];
						$message['numbers'] = $row_tel['value'];
						$message['content'] = $ticketreplytext;
						$gateway['LineNumber'] = $row_mod['LineNumber'];
						SendSMS( $gateway, $message );
						$response = ;
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_ticketal['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ticketreplytext ) . '\')' );
					}
				}
				else {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_ticketal['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
				}
			}
		}
	}

	return true;
}

function ticket_client($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($row_mod['ticketreplyadmin'] == 1) {
			mysql_fetch_assoc( @mysql_query( 'SELECT firstname, lastname FROM tblclients WHERE id=\'' . $vars['userid'] . '\'' ) );
			$user = ;
			$ticketreplytextadmin = $row_mod['ticketreplytextadmin'] . $row_mod['businessname'];
			str_replace( '{ticketid}', $vars['ticketid'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{replyid}', $vars['replyid'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{userid}', $vars['userid'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{departmentid}', $vars['deptid'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{department}', $vars['deptname'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{subject}', $vars['subject'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{message}', $vars['message'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{priority}', $vars['priority'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{status}', $vars['status'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			str_replace( '{clientname}', $user['firstname'] . ' ' . $user['lastname'], $ticketreplytextadmin );
			$ticketreplytextadmin = ;
			$gateway['number'] = $row_mod['username'];
			$gateway['pass'] = $row_mod['password'];
			$message['numbers'] = $row_mod['adminmobile'];
			$message['content'] = $ticketreplytextadmin;
			$gateway['LineNumber'] = $row_mod['LineNumber'];
			SendSMS( $gateway, $message );
			$response = ;
			mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'admin\', \'' . $row_mod['adminmobile'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ticketreplytextadmin ) . '\')' );
		}
	}

	return true;
}

function after_checkout($vars) {
	if (( $vars['InvoiceID'] != '' && $vars['InvoiceID'] != 0 )) {
		@mysql_query( 'SELECT * FROM mod_smsaddon' );
		$mod = ;
		@mysql_fetch_assoc( $mod );
		$row_mod = ;

		if ($mod) {
			if (( $row_mod['orders'] == 1 || $row_mod['ordersadmin'] == 1 )) {
				@mysql_query( 'SELECT userid, duedate, total FROM tblinvoices WHERE id=\'' . $vars['InvoiceID'] . '\'' );
				$invoice = ;
				@mysql_fetch_assoc( $invoice );
				$row_invoice = ;
				@mysql_query( 'SELECT value FROM tblconfiguration WHERE setting=\'DateFormat\'' );
				$dateformat = ;
				@mysql_fetch_assoc( $dateformat );
				$row_dateformat = ;
				explode( '-', $row_invoice['duedate'] );
				$date = ;
				str_replace( array( 'YYYY', 'MM', 'DD' ), array( $date[0], $date[1], $date[2] ), $row_dateformat['value'] );
				$history = ;
				str_replace( '{amount}', $row_invoice['total'], $row_mod['ordertextclient'] );
				$ordertextclient = ;
				str_replace( '{duedate}', $history, $ordertextclient );
				$ordertextclient = ;
				str_replace( '{orderid}', $vars['OrderID'], $ordertextclient );
				$ordertextclient = ;
				str_replace( '{ordernumber}', $vars['OrderNumber'], $ordertextclient );
				$ordertextclient = ;
				str_replace( '{amount}', $row_invoice['total'], $row_mod['ordertextadmin'] );
				$ordertextadmin = ;
				str_replace( '{duedate}', $history, $ordertextadmin );
				$ordertextadmin = ;
				str_replace( '{orderid}', $vars['OrderID'], $ordertextadmin );
				$ordertextadmin = ;
				str_replace( '{ordernumber}', $vars['OrderNumber'], $ordertextadmin );
				$ordertextadmin = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
				$tel = ;
				@mysql_fetch_assoc( $tel );
				$row_tel = ;
				mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
				$report = ;
				@mysql_fetch_assoc( $report );
				$row_report = ;

				if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_invoice['userid'] . '\'' );
					$tel = ;
					@mysql_fetch_assoc( $tel );
					$row_tel = ;
					@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_invoice['userid'] . '\'' );
					$reportal = ;
					@mysql_fetch_assoc( $reportal );
					$row_reportal = ;

					if ($row_tel['value'] == '') {
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_invoice['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $ordertextclient . $row_mod['businessname'] ) . '\')' );
						$error = 7;
					}


					if ($error != 1) {
						$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

						if ($row_tel['value'][0] != '0') {
							$row_tel['value'] = '0' . $row_tel['value'];
						}
					}


					if ($error != 1) {
						if ($row_reportal['value'] == $row_mod['no_area']) {
							$error = 7;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_invoice['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $ordertextclient . $row_mod['businessname'] ) . '\')' );
						}
					}


					if ($row_mod['orders'] == 1) {
						if ($error != 1) {
							$gateway['number'] = $row_mod['username'];
							$gateway['pass'] = $row_mod['password'];
							$message['numbers'] = $row_tel['value'];
							$message['content'] = $ordertextclient . $row_mod['businessname'];
							$gateway['LineNumber'] = $row_mod['LineNumber'];
							SendSMS( $gateway, $message );
							$response = ;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_invoice['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ordertextclient . $row_mod['businessname'] ) . '\')' );
						}
					}


					if ($row_mod['ordersadmin'] == 1) {
						$gateway['number'] = $row_mod['username'];
						$gateway['pass'] = $row_mod['password'];
						$message['numbers'] = $row_mod['adminmobile'];
						$message['content'] = $ordertextadmin . $row_mod['businessname'];
						$gateway['LineNumber'] = $row_mod['LineNumber'];
						SendSMS( $gateway, $message );
						$response = ;
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'admin\', \'' . $row_mod['adminmobile'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $ordertextadmin . $row_mod['businessname'] ) . '\')' );
					}
				}
				else {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_invoice['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
				}
			}
		}
	}

	return true;
}

function after_create($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($row_mod['modulecreate'] == 1) {
			str_replace( '{domain}', $vars['params']['domain'], $row_mod['modulecreatetext'] );
			$modulecreatetext = ;
			str_replace( '{username}', $vars['params']['username'], $modulecreatetext );
			$modulecreatetext = ;
			str_replace( '{password}', $vars['params']['password'], $modulecreatetext );
			$modulecreatetext = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
			$tel = ;
			@mysql_fetch_assoc( $tel );
			$row_tel = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
			$report = ;
			@mysql_fetch_assoc( $report );
			$row_report = ;

			if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $vars['params']['clientsdetails']['userid'] . '\'' );
				$tel = ;
				@mysql_fetch_assoc( $tel );
				$row_tel = ;
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $vars['params']['clientsdetails']['userid'] . '\'' );
				$reportal = ;
				@mysql_fetch_assoc( $reportal );
				$row_reportal = ;

				if ($row_tel['value'] == '') {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $modulecreatetext . $row_mod['businessname'] ) . '\')' );
					$error = 7;
				}


				if ($error != 1) {
					$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

					if ($row_tel['value'][0] != '0') {
						$row_tel['value'] = '0' . $row_tel['value'];
					}
				}


				if ($error != 1) {
					if ($row_reportal['value'] == $row_mod['no_area']) {
						$error = 7;
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $modulecreatetext . $row_mod['businessname'] ) . '\')' );
					}
				}


				if ($error != 1) {
					$gateway['number'] = $row_mod['username'];
					$gateway['pass'] = $row_mod['password'];
					$message['numbers'] = $row_tel['value'];
					$message['content'] = $modulecreatetext . $row_mod['businessname'];
					$gateway['LineNumber'] = $row_mod['LineNumber'];
					SendSMS( $gateway, $message );
					$response = ;
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $modulecreatetext . $row_mod['businessname'] ) . '\')' );
				}
			}
			else {
				mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
			}
		}
	}

	return true;
}

function after_suspend($vars) {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($row_mod['modulesuspend'] == 1) {
			str_replace( array( '{domain}', '{username}' ), array( $vars['params']['domain'], $vars['params']['username'] ), $row_mod['modulesuspendtext'] );
			$modulesuspendtext = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) );
			$tel = ;
			@mysql_fetch_assoc( $tel );
			$row_tel = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
			$report = ;
			@mysql_fetch_assoc( $report );
			$row_report = ;

			if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $vars['params']['clientsdetails']['userid'] . '\'' );
				$tel = ;
				@mysql_fetch_assoc( $tel );
				$row_tel = ;
				@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $vars['params']['clientsdetails']['userid'] . '\'' );
				$reportal = ;
				@mysql_fetch_assoc( $reportal );
				$row_reportal = ;

				if ($row_tel['value'] == '') {
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $modulesuspendtext . $row_mod['businessname'] ) . '\')' );
					$error = 7;
				}


				if ($error != 1) {
					$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

					if ($row_tel['value'][0] != '0') {
						$row_tel['value'] = '0' . $row_tel['value'];
					}
				}


				if ($error != 1) {
					if ($row_reportal['value'] == $row_mod['no_area']) {
						$error = 7;
						mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $modulesuspendtext . $row_mod['businessname'] ) . '\')' );
					}
				}


				if ($error != 1) {
					$gateway['number'] = $row_mod['username'];
					$gateway['pass'] = $row_mod['password'];
					$message['numbers'] = $row_tel['value'];
					$message['content'] = $modulesuspendtext . $row_mod['businessname'];
					$gateway['LineNumber'] = $row_mod['LineNumber'];
					SendSMS( $gateway, $message );
					$response = ;
					mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $modulesuspendtext . $row_mod['businessname'] ) . '\')' );
				}
			}
			else {
				mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $vars['params']['clientsdetails']['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
			}
		}
	}

	return true;
}

function daily_cron_job() {
	@mysql_query( 'SELECT * FROM mod_smsaddon' );
	$mod = ;
	@mysql_fetch_assoc( $mod );
	$row_mod = ;

	if ($mod) {
		if ($row_mod['new_bill'] == 1) {
			mysql_query( 'SELECT value FROM tblconfiguration WHERE setting=\'CreateInvoiceDaysBefore\'' );
			$daysbefore = ;
			mysql_fetch_assoc( $daysbefore );
			$row_daysbefore = ;
			$row_daysbefore['value'];
			$today = ;
			$today1 = $today * 86400;
			time(  );
			$begin = ;
			$today2 = $today1 + $begin;
			date( 'Y-m-d', $today2 );
			$today3 = ;
			@mysql_query( 'SELECT userid, amount, nextduedate FROM tblhosting WHERE nextduedate=\'' . $today3 . '\' AND domainstatus=\'Active\'' );
			$bill = ;
			@mysql_num_rows( $bill );
			$totalRows_bill = ;
			@mysql_query( 'SELECT value FROM tblconfiguration WHERE setting=\'DateFormat\'' );
			$dateformat = ;
			@mysql_fetch_assoc( $dateformat );
			$row_dateformat = ;
			mysql_fetch_assoc( mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['mobilenumberfield'], 'text' ) ) ) );
			$row_tel = ;
			mysql_query( sprintf( 'SELECT id FROM tblcustomfields WHERE fieldname=%s', @GetSQLValueString( $row_mod['notificationfield'], 'text' ) ) );
			$report = ;
			@mysql_fetch_assoc( $report );
			$row_report = ;

			if (( $row_tel['id'] != '' && $row_report['id'] != '' )) {
				if (0 < $totalRows_bill) {
					mysql_fetch_assoc( $bill );

					if ($row_bill = ) {
						explode( '-', $row_bill['nextduedate'] );
						$date = ;
						str_replace( 'YYYY', $date[0], $row_dateformat['value'] );
						$history = ;
						str_replace( 'MM', $date[1], $history );
						$history = ;
						str_replace( 'DD', $date[2], $history );
						$history = ;
						str_replace( '{amount}', $row_bill['amount'], $row_mod['invoicetextclient'] );
						$invoicetextclient = ;
						str_replace( '{duedate}', $history, $invoicetextclient );
						$invoicetextclient = ;
						@mysql_fetch_assoc( @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_bill['userid'] . '\'' ) );
						$tel = ;
						@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_bill['userid'] . '\'' );
						$reportal = ;
						@mysql_fetch_assoc( $reportal );
						$row_reportal = ;

						if ($tel['value'] == '') {
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							$error = 11;
						}


						if ($error != 1) {
							$tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $tel['value'] );

							if ($tel['value'][0] != '0') {
								$tel['value'] = '0' . $tel['value'];
							}
						}


						if ($error != 1) {
							if ($row_reportal['value'] == $row_mod['no_area']) {
								$error = 11;
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							}
						}


						if ($error != 1) {
							$gateway['number'] = $row_mod['username'];
							$gateway['pass'] = $row_mod['password'];
							$message['numbers'] = $row_tel['value'];
							$message['content'] = $invoicetextclient . $row_mod['businessname'];
							$gateway['LineNumber'] = $row_mod['LineNumber'];
							SendSMS( $gateway, $message );
							$response = ;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
						}
					}
				}

				@mysql_query( 'SELECT userid, recurringamount, nextduedate FROM tbldomains WHERE status=\'Active\' AND nextduedate=\'' . $today3 . '\'' );
				$domainler = ;
				@mysql_num_rows( $domainler );
				$totalRows_domainler = ;

				if (0 < $totalRows_domainler) {
					mysql_fetch_assoc( $domainler );

					if ($row_domainler = ) {
						explode( '-', $row_domainler['nextduedate'] );
						$date = ;
						str_replace( 'YYYY', $date[0], $row_dateformat['value'] );
						$history = ;
						str_replace( 'MM', $date[1], $history );
						$history = ;
						str_replace( 'DD', $date[2], $history );
						$history = ;
						str_replace( '{amount}', $row_domainler['recurringamount'], $row_mod['invoicetextclient'] );
						$invoicetextclient = ;
						str_replace( '{duedate}', $history, $invoicetextclient );
						$invoicetextclient = ;
						@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_domainler['userid'] . '\'' );
						$tel = ;
						@mysql_fetch_assoc( $tel );
						$row_tel = ;
						@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_domainler['userid'] . '\'' );
						$reportal = ;
						@mysql_fetch_assoc( $reportal );
						$row_reportal = ;

						if ($row_tel['value'] == '') {
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							$error = 11;
						}


						if ($error != 1) {
							$row_tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $row_tel['value'] );

							if ($row_tel['value'][0] != '0') {
								$row_tel['value'] = '0' . $row_tel['value'];
							}
						}


						if ($error != 1) {
							if ($row_reportal['value'] == $row_mod['no_area']) {
								$error = 11;
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'' . $row_tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							}
						}


						if ($error != 1) {
							$gateway['number'] = $row_mod['username'];
							$gateway['pass'] = $row_mod['password'];
							$message['numbers'] = $row_tel['value'];
							$message['content'] = $invoicetextclient . $row_mod['businessname'];
							$gateway['LineNumber'] = $row_mod['LineNumber'];
							SendSMS( $gateway, $message );
							$response = ;
							mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
						}
					}
				}

				$row_mod['domainxdays'];
				$today = ;

				if (0 < $today) {
					$today1 = $today * 86400;
					time(  );
					$begin = ;
					$today2 = $today1 + $begin;
					date( 'Y-m-d', $today2 );
					$today3 = ;
					@mysql_query( 'SELECT userid, domain, recurringamount, expirydate, nextduedate FROM tbldomains WHERE expirydate=\'' . $today3 . '\' AND status=\'Active\'' );
					$domainler = ;
					@mysql_num_rows( $domainler );
					$totalRows_domainler = ;

					if (0 < $totalRows_domainler) {
						mysql_fetch_assoc( $domainler );

						if ($row_domainler = ) {
							explode( '-', $row_domainler['expirydate'] );
							$date = ;
							str_replace( 'YYYY', $date[0], $row_dateformat['value'] );
							$history = ;
							str_replace( 'MM', $date[1], $history );
							$history = ;
							str_replace( 'DD', $date[2], $history );
							$history = ;
							str_replace( '{remainingdays}', $row_mod['domainxdays'], $row_mod['domainxdaystext'] );
							$invoicetextclient = ;
							str_replace( '{expirydate}', $history, $invoicetextclient );
							$invoicetextclient = ;
							str_replace( '{domain}', $row_domainler['domain'], $invoicetextclient );
							$invoicetextclient = ;
							@mysql_fetch_assoc( @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_domainler['userid'] . '\'' ) );
							$tel = ;
							@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_domainler['userid'] . '\'' );
							$reportal = ;
							@mysql_fetch_assoc( $reportal );
							$row_reportal = ;

							if ($tel['value'] == '') {
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
								$error = 11;
							}


							if ($error != 1) {
								$tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $tel['value'] );

								if ($tel['value'][0] != '0') {
									$tel['value'] = '0' . $tel['value'];
								}
							}


							if ($error != 1) {
								if ($row_reportal['value'] == $row_mod['no_area']) {
									$error = 11;
									mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'' . $tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
								}
							}


							if ($error != 1) {
								$gateway['number'] = $row_mod['username'];
								$gateway['pass'] = $row_mod['password'];
								$message['numbers'] = $tel['value'];
								$message['content'] = $invoicetextclient . $row_mod['businessname'];
								$gateway['LineNumber'] = $row_mod['LineNumber'];
								SendSMS( $gateway, $message );
								$response = ;
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_domainler['userid'] . '\', \'' . $tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							}
						}
					}
				}


				if ($row_mod['dueinvoice'] == 1) {
					time(  );
					$begin = ;
					$today2 = $begin - 86400;
					date( 'Y-m-d', $today2 );
					$today3 = ;
					@mysql_query( 'SELECT userid, total, duedate FROM tblinvoices WHERE duedate=\'' . $today3 . '\' AND status=\'Unpaid\'' );
					$bill = ;
					@mysql_num_rows( $bill );
					$totalRows_bill = ;

					if (0 < $totalRows_bill) {
						mysql_fetch_assoc( $bill );

						if ($row_bill = ) {
							explode( '-', $row_bill['duedate'] );
							$date = ;
							str_replace( 'YYYY', $date[0], $row_dateformat['value'] );
							$history = ;
							str_replace( 'MM', $date[1], $history );
							$history = ;
							str_replace( 'DD', $date[2], $history );
							$history = ;
							str_replace( '{amount}', $row_bill['total'], $row_mod['dueinvoicetext'] );
							$invoicetextclient = ;
							str_replace( '{duedate}', $history, $invoicetextclient );
							$invoicetextclient = ;
							@mysql_fetch_assoc( @mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_tel['id'] . '\' AND relid=\'' . $row_bill['userid'] . '\'' ) );
							$tel = ;
							@mysql_query( 'SELECT value FROM tblcustomfieldsvalues WHERE fieldid=\'' . $row_report['id'] . '\' AND relid=\'' . $row_bill['userid'] . '\'' );
							$reportal = ;
							@mysql_fetch_assoc( $reportal );
							$row_reportal = ;

							if ($tel['value'] == '') {
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'\', \'Empty mobile number\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
								$error = 11;
							}


							if ($error != 1) {
								$tel['value'] = str_replace( array( ' ', '-', '(', ')', '' ), '', $tel['value'] );

								if ($tel['value'][0] != '0') {
									$tel['value'] = '0' . $tel['value'];
								}
							}


							if ($error != 1) {
								if ($row_reportal['value'] == $row_mod['no_area']) {
									$error = 11;
									mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'' . $tel['value'] . '\', \'Client doesn\'t want to receive text messages\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
								}
							}


							if ($error != 1) {
								$gateway['number'] = $row_mod['username'];
								$gateway['pass'] = $row_mod['password'];
								$message['numbers'] = $tel['value'];
								$message['content'] = $invoicetextclient . $row_mod['businessname'];
								$gateway['LineNumber'] = $row_mod['LineNumber'];
								SendSMS( $gateway, $message );
								$response = ;
								mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_bill['userid'] . '\', \'' . $row_tel['value'] . '\', \'' . $response . '\', \'' . str_replace( '\'', '\'', $invoicetextclient . $row_mod['businessname'] ) . '\')' );
							}
						}
					}
				}
			}
			else {
				mysql_query( 'INSERT INTO mod_smsaddon_logs(time, client, mobilenumber, result, text) VALUES (\'' . time(  ) . '\', \'' . $row_invoice['userid'] . '\', \'\', \'Invalid module settings\', \'\')' );
			}
		}
	}

	return true;
}

echo '
';

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

add_hook( 'ClientChangePassword', 1, 'client_change_password', '' );
@add_hook( 'TicketOpen', 1, 'ticket_open', '' );
@add_hook( 'TicketAdminReply', 1, 'ticket_admin', '' );
@add_hook( 'TicketUserReply', 1, 'ticket_client', '' );
@add_hook( 'AfterShoppingCartCheckout', 1, 'after_checkout', '' );
@add_hook( 'AfterModuleCreate', 1, 'after_create', '' );
@add_hook( 'AfterModuleSuspend', 1, 'after_suspend', '' );
@add_hook( 'DailyCronJob', 1, 'daily_cron_job', '' );
?>
