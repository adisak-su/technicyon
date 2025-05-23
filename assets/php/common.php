<?php
// 0=ยกเลิก,1=ใบวางบิล,2=เก็บเงินแล้วแต่ยังไม่ครบ,3=เก็บเงินครบแล้ว,4=เก็บเงิน	
// 0=ยกเลิก,1=ใบorder,2=สร้าง Invoice,3=เก็บเงิน,4=เก็บเงิน	
$statusInvoice = ["ยกเลิกแล้ว", "", "ชำระแล้วบางส่วน", "", "ชำระเงินครบแล้ว"];
$statusOrder = ["ยกเลิกแล้ว", "ยังไม่ได้ทำบัญชี", "ออกใบวางบิลแล้ว", "", "ชำระเงินแล้ว"];

date_default_timezone_set("Asia/Bangkok");

function getStatusInvoice($id)
{
	global $statusInvoice;
	return $statusInvoice[$id];
}

function getStatusOrder($id)
{
	global $statusOrder;
	return $statusOrder[$id];
}

function Convert($amount_number)
{
	$amount_number = number_format($amount_number, 2, ".", "");
	$pt = strpos($amount_number, ".");
	$number = $fraction = "";
	if ($pt === false)
		$number = $amount_number;
	else {
		$number = substr($amount_number, 0, $pt);
		$fraction = substr($amount_number, $pt + 1);
	}

	$ret = "";
	$baht = ReadNumber($number);
	if ($baht != "")
		$ret .= $baht . "บาท";

	$satang = ReadNumber($fraction);
	if ($satang != "")
		$ret .=  $satang . "สตางค์";
	else
		$ret .= "ถ้วน";
	return $ret;
}

function ReadNumber($number)
{
	$position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
	$number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
	$number = $number + 0;
	$ret = "";
	if ($number == 0) return $ret;
	if ($number > 1000000) {
		$ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
		$number = intval(fmod($number, 1000000));
	}

	$divider = 100000;
	$pos = 0;
	while ($number > 0) {
		$d = intval($number / $divider);
		$ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
		$ret .= ($d ? $position_call[$pos] : "");
		$number = $number % $divider;
		$divider = $divider / 10;
		$pos++;
	}
	return $ret;
}

function changeDateToThaiShort($date)
{
	$time = strtotime($date);
	$thai_date = date("d", $time);
	$thai_date .= "/" . date("m", $time);
	$thai_date .= "/" . substr((date("Y", $time) + 543), -2);
	return $thai_date;
}

function changeDateToThaiLong($date)
{
	$time = strtotime($date);
	$thai_date = date("d", $time);
	$thai_date .= "/" . date("m", $time);
	$thai_date .= "/" . (date("Y", $time) + 543);
	return $thai_date;
}

function getLocalDateTime($date, $full = false)
{
	$thai_date = "";
	if ($full) {
		$time = strtotime($date);
		$thai_date = date("d", $time);
		$thai_date .= "/" . date("m", $time);
		$thai_date .= "/" . (date("Y", $time) + 543);
		$thai_date .= " " . (date("H", $time));
		$thai_date .= ":" . (date("i", $time));
		$thai_date .= ":" . (date("s", $time)) . " น.";
	} else {
		$time = strtotime($date);
		$thai_date = date("d", $time);
		$thai_date .= "/" . date("m", $time);
		$thai_date .= "/" . substr((date("Y", $time) + 543), -2);
	}
	return $thai_date;
}
