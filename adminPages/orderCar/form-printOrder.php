<?php
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('myTCPDF.php');
require_once('../../assets/php/common.php');
require_once('../../service/connect.php');

try {
    $widthMax = 560;
    $messageLine = CreateNewRowTableLine(90);

    $pdf = new MYTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetAutoPageBreak(true, 5); // (TRUE, 5  PDF_MARGIN_BOTTOM);
    $DB = new Database();
    $conn = $DB->connect();

    $dateSale = date("yy-m-d");
    $type = "Order";
    $startDate = $_REQUEST['startDate'];
    $endDate = $_REQUEST['endDate'];
    $status = $_REQUEST['status'];
    $checkStartDate = $_REQUEST['checkStartDate'];
        
    // $conditionTime = "";
    // if ($checkStartDate == "true") {
    //     $conditionTime = "orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY";
    // } else {
    //     $conditionTime = "orderDateTime < '$endDate' + INTERVAL 1 DAY";
    // }

    // if ($status != "All") {
    //     $sql = "SELECT * FROM $tb_ordersale WHERE $conditionTime AND status='$status' ORDER BY orderDateTime DESC";
    // } else {
    //     $sql = "SELECT * FROM $tb_ordersale WHERE $conditionTime ORDER BY orderDateTime DESC";
    // }

    $checkEndDate = $_REQUEST['checkEndDate'];
	$conditionTime = "";
	if($checkStartDate=="true" && $checkEndDate=="true") {
		$conditionTime = "WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}
	else if($checkStartDate=="true") {
		$conditionTime = "WHERE orderDateTime >= '$startDate'";
	}
	else if($checkEndDate=="true") {
		$conditionTime = "WHERE orderDateTime < '$endDate' + INTERVAL 1 DAY";
	}
	else {
		$conditionTime = "";
	}

	if($status!="All") {
		// $sql = "SELECT * FROM $tb_ordersale WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY AND status='$status' ORDER BY orderNo DESC";
		if($conditionTime == "") {
			$sql = "SELECT * FROM $tb_ordersale WHERE status='$status' ORDER BY orderDateTime DESC";
		}
		else {
			$sql = "SELECT * FROM $tb_ordersale $conditionTime AND status='$status' ORDER BY orderDateTime DESC";
		}
	}
	else {
		// $sql = "SELECT * FROM $tb_ordersale WHERE orderDateTime >= '$startDate' AND orderDateTime < '$endDate' + INTERVAL 1 DAY ORDER BY orderNo DESC";
		$sql = "SELECT * FROM $tb_ordersale $conditionTime ORDER BY orderDateTime DESC";
	}


    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    genOrderPDF($result);
    $response = [
        'status' => true,
        'message' => "order.pdf"
    ];
    http_response_code(200);
} catch (Exception $ex) {
    http_response_code(500);
    $response = [
        'status' => false,
        'message' => json_encode($ex->getMessage())
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;

function genOrderPDF($result)
{
    global $pdf;

    $directory = getcwd();
    $pdf->SetFont('thsarabun', 'B', 14);
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    CreatePage($result);

    // return $pdf;
    $filename = "pdf/order.pdf";
    $filename = str_replace("-", "_", $filename);
    $pdf->output("$directory/$filename", 'F');
    return "order.pdf";
    // header("Location: viewPDF.php?fileName=order.pdf");
    // header("Location: $filename");
}

function CreatePage($result)
{
    global $pdf;
    $pdf->AddPage('P', 'A4');
    CreateDetailTable($result);
}

function genDiv($message, $type = "normal")
{
    return "<div style='font-weight: $type;'>$message</div>";
}

function CreateHeadDetailTable()
{
    global $result;
    global $type;
    global $startDate, $endDate, $status, $checkStartDate;

    $count = count($result);
    // colspan => max 3
    $message = "";
    if ($type == 'Invoice') {
        $message = "รายการใบวางบิล";
    } else {
        $message = "รายการใบส่งสินค้า";
    }

    if ($status != "All") {
        $message  .= " ( " . getStatusOrder($status) . " )";
    }

    if ($checkStartDate != "false") {
        $message  .= " ช่วงวันที่ " . changeDateToThaiLong($startDate) . " - " . changeDateToThaiLong($endDate);
    }

    $detailTable = CreateNewRowTable($message);
    // $detailTable .=  '<font face="thsarabun" size="14">'
    //     . '<table border="0" cellpadding="1" border="1" width="100%">'
    //     . '<tr>'
    //     .   '<th colspan="10" align="center">#</th>'
    //     .   '<th colspan="33" align="center">เลขที่</th>'
    //     .   '<th colspan="23" align="center">วันที่</th>'
    //     .   '<th colspan="50" align="center">ซื่อลูกค้า</th>'
    //     .   '<th colspan="23" align="center">ยอดสินค้า</th>'
    //     .   '<th colspan="23" align="center">ภาษี</th>'
    //     .   '<th colspan="23" align="center">ยอดเงิน</th>'
    //     .   '<th colspan="40" align="center">หมายเหตุ</th>';

    $detailTable .=  '<font face="thsarabun" size="14">'
        . '<table border="0" cellpadding="1" border="1" width="100%">'
        . '<tr>'
        .   '<th colspan="10" align="center">#</th>'
        .   '<th colspan="33" align="center">เลขที่</th>'
        .   '<th colspan="23" align="center">วันที่</th>'
        .   '<th colspan="50" align="center">ซื่อลูกค้า</th>'
        .   '<th colspan="23" align="center">ยอดเงิน</th>'
        .   '<th colspan="40" align="center">สถานะ</th>'
        .   '<th colspan="46" align="center">หมายเหตุ</th>';
    $detailTable .= '</tr>';

    return $detailTable;
}

function CreateDetailTable($result)
{
    global $pdf;
    global $messageHeader;

    $perPage = 39;
    $startPage = 1;
    $row = 0;
    $detailTable = CreateHeadDetailTable();



    $detailTable = CreateHeadDetailTable();
    $detailTableHeader = $detailTable;
    $row = 0;
    for ($i = 0; $i < count($result); $i++) {
        $row++;
        if (($i) == ($perPage * $startPage)) {
            $startPage++;
            $detailTable .= '</table>';
            $pdf->writeHTMLCell(0, 0, '', '', $detailTable, 0, 1, 0, true, '', true);
            $pdf->AddPage('P', 'A4');
            $detailTable = $detailTableHeader;
            $row = 0;
        }
        $detailTable .= CreateRowDetailTable($result[$i], $i);
    }

    for ($row = $row + 2; $row <= $perPage; $row++) {
        $detailTable .= CreateNewRowDetail();
    }

    $detailTable .= '</table>';
    $pdf->writeHTMLCell(0, 0, '', '', $detailTable, 0, 1, 0, true, '', true);
}

function CreateRowDetailTable($item, $i)
{
    $tab2space = '&nbsp;&nbsp;';
    $tabspace = '&nbsp;';
    $status = "";
    $statusMessage = "";
    if ($item['status'] == 0)
        $status = getStatusOrder($item['status']);

    if ($item['status'] != 1)
        $statusMessage = getStatusOrder($item['status']);

    $detailTable =  ""
        . '<tr>'
        .   '<td colspan="10" align="right">' . ($i + 1) . '</td>'
        .   '<td colspan="33" align="center">' . $item['orderNo'] . '</td>'
        .   '<td colspan="23" align="center">' . changeDateToThaiLong($item['orderDateTime']) . '</td>'
        .   '<td colspan="50" align="left"> ' . $item['customerName'] . '</td>'
        .   '<td colspan="23" align="right">' . number_format($item['total'], 2) . $tab2space . '</td>'
        .   '<td colspan="40" align="left">' . $tab2space . $statusMessage . ' </td>'
        .   '<td colspan="46" align="left">' . $tab2space . $status . '</td>';

    // $detailTable =  ""
    //     . '<tr>'
    //     .   '<td colspan="10" align="right">' . ($i + 1) . '</td>'
    //     .   '<td colspan="33" align="center">' . $item['orderNo'] . '</td>'
    //     .   '<td colspan="23" align="center">' . changeDateToThaiLong($item['orderDateTime']) . '</td>'
    //     .   '<td colspan="50" align="left"> ' . $item['customerName'] . '</td>'
    //     .   '<td colspan="23" align="right">' . number_format($item['amount'], 2) . $tab2space . ' </td>'
    //     .   '<td colspan="23" align="right">' . number_format(($item['total']-$item['amount']), 2) . $tab2space . ' </td>'
    //     .   '<td colspan="23" align="right">' . number_format($item['total'], 2) . $tab2space . '</td>'
    //     .   '<td colspan="40" align="left">' . $tab2space . $status . '</td>';

    $detailTable .= '</tr>';

    return $detailTable;
}

function CreateNewRowDetail()
{
    $detailTable =  '<tr>'
        .   '<td colspan="10"></td>'
        .   '<td colspan="33"></td>'
        .   '<td colspan="23"></td>'
        .   '<td colspan="50"></td>'
        .   '<td colspan="23"></td>'
        .   '<td colspan="40"></td>'
        .   '<td colspan="46"></td>';
    $detailTable .= '</tr>';
    return $detailTable;
}

function CreateNewRowTable($message = "")
{
    global $widthMax;

    $detailTable =  '<font face="thsarabun" size="20">'
        . '<table border="0" cellpadding="1" height="10px">'
        . '<tr>'
        .   '<td width="' . $widthMax . '" align="center"><font face="thsarabun" size="25">' . $message . '</font></td>'
        . '</tr>';
    $detailTable .= '</table>';

    return $detailTable;
}

function CreateNewRowTableLine($max)
{
    global $widthMax;

    $detailTable =  '<font face="thsarabun" size="15">'
        . '<table border="0" cellpadding="1" height="10px">'
        . '<tr>'
        .   '<td width="' . $widthMax . '" align="Cente">' . str_repeat("_", $max) . '</td>'
        . '</tr>';
    $detailTable .= '</table>';

    return $detailTable;
}
