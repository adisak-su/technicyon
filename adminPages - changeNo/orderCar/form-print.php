<?php
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('myTCPDF.php');
require_once('../../assets/php/common.php');
require_once("../../service/configData.php");
require_once('../../service/connect.php');
try {
    $orderRunningNum = $_POST['id'];
    $vat ="1";
    $widthMax = 560;
    $messageLine = CreateNewRowTableLine(90);
    
    $pdf = new MYTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetAutoPageBreak(true, 5); // (TRUE, 5  PDF_MARGIN_BOTTOM);
    $DB = new Database();
    $conn = $DB->connect();
    $order = $DB->getOrderByOrderID($orderRunningNum);
    $fileName = genOrderPDF($orderRunningNum,$order);

    // header("Location: viewPDF.php?fileName=$fileName");
    // exit;
    $fileNamePrint = $locationOrder . $fileName;
    $fileNamePrint = $fileName;
    $response = [
        'status' => true,
        'message' => $fileNamePrint
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
function genOrderPDF($orderRunningNum, $order)
{
    global $pdf;

    $directory = getcwd();
    $pdf->SetFont('thsarabun', 'B', 14);
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    CreatePage($orderRunningNum, $order);

    // return $pdf;
    $filename = "$orderRunningNum.pdf";
    $filename = str_replace("-", "_", $filename);
    $pdf->output("$directory/pdf/$filename", 'F');
    return $filename;
    // header("Location: viewPDF.php?fileName=order_pdf/$filename");
    // header("Location: order_pdf/$filename");
}

function CreatePage($orderRunningNum, $order)
{
    global $pdf;
    global $vat;
    
    $orderHead = $order;
    $orderDetail = $order['orderDetail'];
    $vat = $orderHead["vat"];
    $pdf->AddPage('P', 'A5');
    CreateHeaderTable($orderHead);
    CreateDetailTable($orderDetail);
    CreateButtonTable($orderHead);
}

function CreateHeaderTable($orderHead)
{
    global $pdf;
    global $messageHeader;
    $tab2space = '&nbsp;&nbsp;';

    $orderNo = 'เลขที่' . $tab2space . $orderHead['orderNo'];
    $orderDateTime = 'วันที่' . $tab2space . changeDateToThaiLong($orderHead['orderDateTime']);
    $headerTable =  '<font face="thsarabun" size="14">'
        . '<table cellpadding="1">'
        . '<tr>'
        .   '<td colspan="8" align="center"><font face="thsarabun" size="20">' . "ใบส่งของชั่วคราว" . '</font></td>'
        . '</tr>'
        . '<tr>'
        .   '<td colspan="8" align="center"><font face="thsarabun" size="20">' . "หจก.ธนสารเปเปอร์" . '</font></td>'
        . '</tr>'
        . '<tr>'
        .   '<td colspan="4" align="left"><font face="thsarabun" size="18">' . $orderNo . '</font></td>'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . $orderDateTime . '</font></td>'
        . '</tr>'
        . '<tr>'
        .   '<td colspan="5" align="left"><font face="thsarabun" size="18">' . "ลูกค้า" . $tab2space . $orderHead['customerName'] . '</font></td>'
        .   '<td colspan="3" align="right"><font face="thsarabun" size="18">' . "จังหวัด" . $tab2space . $orderHead['address'] . '</font></td>'
        . '</tr>'
        . '<tr>'
        .   '<td colspan="8" align="left"><font face="thsarabun" size="15"></font></td>'
        . '</tr>'
        . '</table>';
    $messageHeader = $headerTable;
    $pdf->writeHTMLCell(0, 0, '', '', $headerTable, 0, 1, 0, true, '', true);
}


function CreateButtonTable($orderHead)
{
    global $pdf;
    global $vat;

    $tab2space = '&nbsp;&nbsp;';
    $tab5space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $detailTable =  '<font face="thsarabun" size="14">'
        . '<table border="0" cellpadding="1">';

    if($vat==1) {
        $detailTable = $detailTable
        . '<tr style="line-height: 8px;">'
        .   '<td colspan="8" align="right"></td>'
        . '</tr>'
        . '<tr style="line-height: 16px;">'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . $tab5space . "รวมเงิน" . '</font></td>'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . number_format($orderHead['amount'], 2) . $tab2space . 'บาท' . $tab5space . '</font></td>'
        . '</tr>'
        . '<tr style="line-height: 16px;">'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . $tab5space . "ภาษี" . '</font></td>'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . number_format($orderHead['total'] - $orderHead['amount'], 2) . $tab2space . 'บาท' . $tab5space . '</font></td>'
        . '</tr>';
    }
    $detailTable = $detailTable
        . '<tr style="line-height: 16px;">'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . $tab5space . "รวมเงินสุทธิ" . '</font></td>'
        .   '<td colspan="4" align="right"><font face="thsarabun" size="18">' . number_format($orderHead['total'], 2) . $tab2space . 'บาท' . $tab5space . '</font></td>'
        . '</tr>'
        . '<tr style="line-height: 18px;">'
        .   '<td colspan="8" align="right"><font face="thsarabun" size="18">( ' . Convert($orderHead['total']) . ' )' . $tab5space . '</font></td>'
        . '</tr>'
        . '<tr style="line-height:30px;">'
        .   '<td colspan="8" align="center"><font face="thsarabun" size="18">ส่ง___________________________ขนส่ง' . $tab5space . 'จำนวน___________ชิ้น</font></td>'
        . '</tr>'
        . '<tr style="line-height:30px;">'
        .   '<td colspan="8" align="center"><font face="thsarabun" size="18">ผู้รับสินค้า (_________________________)' . $tab5space . 'วันที่ (______________)</font></td>'
        . '</tr>';
    $detailTable = $detailTable . "</table>";

    $pdf->writeHTMLCell(0, 0, '', '', $detailTable, 0, 1, 0, true, '', true);
}
function CreateHeadDetailTable()
{
    $detailTable =  '<font face="thsarabun" size="16">'
        . '<table border="0" cellpadding="1" border="1" width="100%">'
        . '<tr>'
        .   '<th colspan="4" align="center">จำนวน</th>'
        .   '<th colspan="20" align="center">รายการ</th>'
        .   '<th colspan="5" align="center">ราคา</th>'
        .   '<th colspan="5" align="center">จำนวนเงิน</th>'
        . '</tr>';

    return $detailTable;
}

function CreateDetailTable($orderDetail)
{
    global $pdf;
    global $messageHeader;
    global $vat;

    if($vat==1) {
        $perPage = 10;
    }
    else {
        $perPage = 12;
    }

    $startPage = 1;

    $detailTable = CreateHeadDetailTable();
    $detailTableHeader = $detailTable;

    for ($i = 0; $i < count($orderDetail); $i++) {
        if (($i) == ($perPage * $startPage)) {
            $startPage++;
            $detailTable .= '</table>';
            $pdf->writeHTMLCell(0, 0, '', '', $detailTable, 0, 1, 0, true, '', true);
            $pdf->AddPage('L', 'A5');
            $pdf->writeHTMLCell(0, 0, '', '', $messageHeader, 0, 1, 0, true, '', true);
            $detailTable = $detailTableHeader;
        }
        $detailTable .= CreateRowDetailTable($orderDetail[$i], $i);
    }

    for($row=$i;$row<$perPage;$row++) {
        $detailTable .= CreateNewRowDetail();
    }

    $detailTable .= '</table>';
    $pdf->writeHTMLCell(0, 0, '', '', $detailTable, 0, 1, 0, true, '', true);
}

function CreateRowDetailTable($item, $i)
{
    $tab2space = '&nbsp;&nbsp;';

    $tab5space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $amount = $item['qty'];
    $total = $item['total'];
    $price = $item['price'];
    $productName = $item['productName'];

    $detailTable =  ""
        . '<tr>'
        .   '<td colspan="4" align="right">' . $amount . $tab5space . '</td>'
        .   '<td colspan="20" align="left">' . $tab2space . $productName . '</td>'
        .   '<td colspan="5" align="right">' . number_format($price, 2) . '</td>'
        .   '<td colspan="5" align="right">' . number_format($total, 2) . '</td>'
        . '</tr>';

    return $detailTable;
}

function CreateNewRowDetail() {
    $detailTable =  ""
       . '<tr>'
       .   '<td colspan="4" align="right"></td>'
       .   '<td colspan="20" align="left"></td>'
       .   '<td colspan="5" align="right"></td>'
       .   '<td colspan="5" align="right"></td>'
       . '</tr>';
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
