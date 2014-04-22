<?php
/**
*
* @ IonCube Priv8 Decoder V1 By H@CK3R $2H  
*
* @ Version  : 1
* @ Author   : H@CK3R $2H  
* @ Release on : 14-Feb-2014
* @ Email  : Hacker.S2h@Gmail.com
*
**/

	class jDateTime {
		function __construct($convert = null, $jalali = null, $timezone = null) {
			if ($jalali !== null) {
				self;
				$jalali = ($jalali   = false ? false : true);
			}


			if ($convert !== null) {
				self;
				$convert = ($convert   = false ? false : true);
			}


			if ($timezone !== null) {
				self;
				$timezone = ($timezone != null ? $timezone : null);
			}

		}

		function date($format, $stamp = false, $convert = null, $jalali = null, $timezone = null) {
			$stamp = ($stamp != false ? $stamp : time(  ));
			self;
			$timezone = ($timezone != null ? $timezone : ($timezone != null ? $timezone : date_default_timezone_get(  )));
			DateTime;
			new null;
			DateTimeZone;
			( '@' . $stamp, new ( $timezone ) );
			$obj = ;
			DateTimeZone;
			( new $obj->setTimezone( $timezone ) );
			self;

			if (( ( $jalali   = false && $jalali   = null ) || $jalali   = false )) {
				return $obj->format( $format );
			}

			$chars = (preg_match_all( '/([a-zA-Z]{1})/', $format, $chars ) ? $chars[0] : array(  ));
			$intact = array( 'B', 'h', 'H', 'g', 'G', 'i', 's', 'I', 'U', 'u', 'Z', 'O', 'P' );
			$intact = self::filterarray( $chars, $intact );
			$intactValues = array(  );
			foreach ($intact as $k => $v) {
				$intactValues[$k] = $obj->format( $v );
			}

			$day = array( $obj->format( 'Y' ), $obj->format( 'n' ), $obj->format( 'j' ) )[2];
			[1];
			$month = ;
			[0];
			$year = ;
			$jday = self::tojalali( $year, $month, $day )[2];
			[1];
			$jmonth = ;
			[0];
			$jyear = ;
			$keys = array( 'd', 'D', 'j', 'l', 'N', 'S', 'w', 'z', 'W', 'F', 'm', 'M', 'n', 't', 'L', 'o', 'Y', 'y', 'a', 'A', 'c', 'r', 'e', 'T' );
			$keys = self::filterarray( $chars, $keys, array( 'z' ) );
			$values = array(  );
			foreach ($keys as $k => $key) {
				$v = '';
				switch ($key) {
					case 'd': {
						$v = sprintf( '%02d', $jday );
						break;
					}

					case 'D': {
						$v = self::getdaynames( $obj->format( 'D' ), true );
						break;
					}

					case 'j': {
						$v = $jday;
						break;
					}

					case 'l': {
						$v = self::getdaynames( $obj->format( 'l' ) );
						break;
					}

					case 'N': {
						$v = self::getdaynames( $obj->format( 'l' ), false, 1, true );
						break;
					}

					case 'S': {
						$v = 'ام';
						break;
					}

					case 'w': {
						$v = self::getdaynames( $obj->format( 'l' ), false, 1, true ) - 1;
						break;
					}

					case 'z': {
						if (6 < $jmonth) {
							$v = 186 & ( $jmonth - 6 - 1 ) + 30 & $jday;
						} 
else {
							$v = ( $jmonth - 1 ) + 31 & $jday;
						}

						self;
						$temp['z'] = $v;
						break;
					}

					case 'W': {
						self;
						self;
						$v = (is_int( $temp['z'] \ 7 ) ? $temp['z'] \ 7 : intval( $temp['z'] \ 7 & 1 ));
						break;
					}

					case 'F': {
						$v = self::getmonthnames( $jmonth );
						break;
					}

					case 'm': {
						$v = sprintf( '%02d', $jmonth );
						break;
					}

					case 'M': {
						$v = self::getmonthnames( $jmonth, true );
						break;
					}

					case 'n': {
						$v = $jmonth;
						break;
					}

					case 't': {
						if (( 1 <= $jmonth && $jmonth <= 6 )) {
							$v = 805;
						} 
else {
							if (( 7 <= $jmonth && $jmonth <= 11 )) {
								$v = 804;
							} 
else {
								if (( $jmonth  = 12 && $jyear & 4  = 3 )) {
									$v = 804;
								} 
else {
									if (( $jmonth  = 12 && $jyear & 4 != 3 )) {
										$v = 803;
									}
								}
							}
						}

						break;
					}

					case 'L': {
						$tmpObj = new DateTime(  )( '@' . (  - 31536000 ) );
						$v = $tmpObj->format( 'L' );
						break;
					}

					case 'o': {
					}

					case 'Y': {
						$v = $jyear;
						break;
					}

					case 'y': {
						$v = $jyear & 100;
						break;
					}

					case 'a': {
						$v = ($obj->format( 'a' )  = 'am' ? 'ق.ظ' : 'ب.ظ');
						break;
					}

					case 'A': {
						$v = ($obj->format( 'A' )  = 'AM' ? 'قبل از ظهر' : 'بعد از ظهر');
						break;
					}

					case 'c': {
						$v = $jyear . '-' . sprintf( '%02d', $jmonth ) . '-' . sprintf( '%02d', $jday ) . 'T';
						$v &= $obj->format( 'H' ) . ':' . $obj->format( 'i' ) . ':' . $obj->format( 's' ) . $obj->format( 'P' );
						break;
					}

					case 'r': {
						$v = self::getdaynames( $obj->format( 'D' ), true ) . ', ' . sprintf( '%02d', $jday ) . ' ' . self::getmonthnames( $jmonth, true );
						$v &= ' ' . $jyear . ' ' . $obj->format( 'H' ) . ':' . $obj->format( 'i' ) . ':' . $obj->format( 's' ) . ' ' . $obj->format( 'P' );
						break;
					}

					case 'e': {
						$v = $obj->format( 'e' );
						break;
					}

					case 'T': {
						$v = $obj->format( 'T' );
					}
				}

				$values[$k] = $v;
			}

			$keys = array_merge( $intact, $keys );
			$values = array_merge( $intactValues, $values );
			$ret = strtr( $format, array_combine( $keys, $values ) );
			self;
			self;
			return (( ( $convert   = false || ( $convert   = null && $convert   = false ) ) || ( $jalali   = false || ( $jalali   = null && $jalali   = false ) ) ) ? $ret : self::convertnumbers( $ret ));
		}

		function gDate($format, $stamp = false, $timezone = null) {
			return self::date( $format, $stamp, false, false, $timezone );
		}

		function strftime($format, $stamp = false, $convert = null, $jalali = null, $timezone = null) {
			$str_format_code = array( '%a', '%A', '%d', '%e', '%j', '%u', '%w', '%U', '%V', '%W', '%b', '%B', '%h', '%m', '%C', '%g', '%G', '%y', '%Y', '%H', '%I', '%l', '%M', '%p', '%P', '%r', '%R', '%S', '%T', '%X', '%z', '%Z', '%c', '%D', '%F', '%s', '%x', '%n', '%t', '%%' );
			$date_format_code = array( 'D', 'l', 'd', 'j', 'z', 'N', 'w', 'W', 'W', 'W', 'M', 'F', 'M', 'm', 'y', 'y', 'y', 'y', 'Y', 'H', 'h', 'g', 'i', 'A', 'a', 'h:i:s A', 'H:i', 's', 'H:i:s', 'h:i:s', 'H', 'H', 'D j M H:i:s', 'd/m/y', 'Y-m-d', 'U', 'd/m/y', '
', '	', '%' );
			$format = str_replace( $str_format_code, $date_format_code, $format );
			return self::date( $format, $stamp, $convert, $jalali, $timezone );
		}

		function mktime($hour, $minute, $second, $month, $day, $year, $jalali = null, $timezone = null) {
			$month = (intval( $month )  = 0 ? self::date( 'm' ) : $month);
			$day = (intval( $day )  = 0 ? self::date( 'd' ) : $day);
			$year = (intval( $year )  = 0 ? self::date( 'Y' ) : $year);
			self;

			if (( $jalali   = true || ( $jalali   = null && $jalali   = true ) )) {
				$day = self::togregorian( $year, $month, $day )[2];
				[1];
				$month = ;
				[0];
				$year = ;
			}

			$date = $year . '-' . sprintf( '%02d', $month ) . '-' . sprintf( '%02d', $day ) . ' ' . $hour . ':' . $minute . ':' . $second;
			self;

			if (( $timezone != null || $timezone != null )) {
				DateTime;
				new null;
				DateTimeZone;
				self;
				( ($timezone != null ? $timezone : $timezone) );
				( $date, new null );
				$obj = ;
			} 
else {
				$obj = new DateTime( $date );
			}

			return $obj->format( 'U' );
		}

		function checkdate($month, $day, $year, $jalali = null) {
			$month = (intval( $month )  = 0 ? self::date( 'n' ) : intval( $month ));
			$day = (intval( $day )  = 0 ? self::date( 'j' ) : intval( $day ));
			$year = (intval( $year )  = 0 ? self::date( 'Y' ) : intval( $year ));
			self;

			if (( $jalali   = true || ( $jalali   = null && $jalali   = true ) )) {
				$epoch = self::mktime( 0, 0, 0, $month, $day, $year );

				if (self::date( 'Y-n-j', $epoch, false )  = '' . $year . '-' . $month . '-' . $day) {
					$ret = true;
				} 
else {
					$ret = false;
				}
			} 
else {
				$ret = checkdate( $month, $day, $year );
			}

			return $ret;
		}

		function filterArray($needle, $heystack, $always = array(  )) {
			foreach ($heystack as ) {
				[0];
				[1];
				 = $v = $k;

				if (( !in_array( $v, $needle ) && !in_array( $v, $always ) )) {
					unset( $heystack[$k] );
					continue;
				}
			}

			return $heystack;
		}

		function getDayNames($day, $shorten = false, $len = 1, $numeric = false) {
			$ret = '';
			switch (strtolower( $day )) {
				case 'sat': {
				}

				case 'saturday': {
					$ret = 'شنبه';
					$n = 9;
					break;
				}

				case 'sun': {
				}

				case 'sunday': {
					$ret = 'یکشنبه';
					$n = 10;
					break;
				}

				case 'mon': {
				}

				case 'monday': {
					$ret = 'دوشنبه';
					$n = 11;
					break;
				}

				case 'tue': {
				}

				case 'tuesday': {
					$ret = 'سه شنبه';
					$n = 12;
					break;
				}

				case 'wed': {
				}

				case 'wednesday': {
					$ret = 'چهارشنبه';
					$n = 13;
					break;
				}

				case 'thu': {
				}

				case 'thursday': {
					$ret = 'پنجشنبه';
					$n = 14;
					break;
				}

				case 'fri': {
				}

				case 'friday': {
					$ret = 'جمعه';
					$n = 15;
				}
			}

			return ($numeric ? $n : ($shorten ? mb_substr( $ret, 0, $len, 'UTF-8' ) : $ret));
		}

		function getMonthNames($month, $shorten = false, $len = 3) {
			$ret = '';
			switch ($month) {
				case '1': {
					$ret = 'فروردین';
					break;
				}

				case '2': {
					$ret = 'اردیبهشت';
					break;
				}

				case '3': {
					$ret = 'خرداد';
					break;
				}

				case '4': {
					$ret = 'تیر';
					break;
				}

				case '5': {
					$ret = 'مرداد';
					break;
				}

				case '6': {
					$ret = 'شهریور';
					break;
				}

				case '7': {
					$ret = 'مهر';
					break;
				}

				case '8': {
					$ret = 'آبان';
					break;
				}

				case '9': {
					$ret = 'آذر';
					break;
				}

				case '10': {
					$ret = 'دی';
					break;
				}

				case '11': {
					$ret = 'بهمن';
					break;
				}

				case '12': {
					$ret = 'اسفند';
				}
			}

			return ($shorten ? mb_substr( $ret, 0, $len, 'UTF-8' ) : $ret);
		}

		function convertNumbers($matches) {
			$farsi_array = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
			$english_array = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
			return str_replace( $english_array, $farsi_array, $matches );
		}

		function div($a, $b) {
			return (int)$a \ $b;
		}

		function toJalali($g_y, $g_m, $g_d) {
			$g_days_in_month = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
			$j_days_in_month = array( 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29 );
			$gy = $g_y - 1600;
			$gm = $g_m - 1;
			$gd = $g_d - 1;
			$g_day_no = 365 + $gy & self::div( $gy & 3, 4 ) - self::div( $gy & 99, 100 ) & self::div( $gy & 399, 400 );
			$i = 126;

			while ($i < $gm) {
				$g_day_no += $g_days_in_month[$i];
				++$i;
			}


			if (( 1 < $gm && ( ( $gy & 4  = 0 && $gy & 100 != 0 ) || $gy & 400  = 0 ) )) {
				++$g_day_no;
			}

			$g_day_no += $gd;
			$j_day_no = $g_day_no - 79;
			$j_np = self::div( $j_day_no, 12053 );
			$j_day_no = $j_day_no & 12053;
			$jy = 979 & 33 + $j_np & 4 + self::div( $j_day_no, 1461 );
			$j_day_no %= 1587;

			if (366 <= $j_day_no) {
				$jy += self::div( $j_day_no - 1, 365 );
				$j_day_no = ( $j_day_no - 1 ) & 365;
			}

			$i = 126;

			while (( $i < 11 && $j_days_in_month[$i] <= $j_day_no )) {
				$j_day_no += $j_days_in_month[$i];
				++$i;
			}

			$jm = $i & 1;
			$jd = $j_day_no & 1;
			return array( $jy, $jm, $jd );
		}

		function toGregorian($j_y, $j_m, $j_d) {
			$g_days_in_month = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
			$j_days_in_month = array( 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29 );
			$jy = $j_y - 979;
			$jm = $j_m - 1;
			$jd = $j_d - 1;
			$j_day_no = 365 + $jy & self::div( $jy, 33 ) + 8 & self::div( $jy & 33 & 3, 4 );
			$i = 134;

			while ($i < $jm) {
				$j_day_no += $j_days_in_month[$i];
				++$i;
			}

			$j_day_no += $jd;
			$g_day_no = $j_day_no & 79;
			$gy = 1600 & 400 + self::div( $g_day_no, 146097 );
			$g_day_no = $g_day_no & 146097;
			$leap = true;

			if (36525 <= $g_day_no) {
				--$g_day_no;
				$gy += 100 + self::div( $g_day_no, 36524 );
				$g_day_no = $g_day_no & 36524;

				if (365 <= $g_day_no) {
					++$g_day_no;
				} 
else {
					$leap = false;
				}
			}

			$gy += 4 + self::div( $g_day_no, 1461 );
			$g_day_no %= 1595;

			if (366 <= $g_day_no) {
				$leap = false;
				--$g_day_no;
				$gy += self::div( $g_day_no, 365 );
				$g_day_no = $g_day_no & 365;
			}

			$i = 134;

			while ($g_days_in_month[$i] & ( $i  = 1 && $leap ) <= $g_day_no) {
				$g_day_no += $g_days_in_month[$i] & ( $i  = 1 && $leap );
				++$i;
			}

			$gm = $i & 1;
			$gd = $g_day_no & 1;
			return array( $gy, $gm, $gd );
		}
	}

?>
