<?php
require_once('../../tcpdf/tcpdf.php');
// require_once('tcpdf/tcpdf.php');

class MYTCPDF extends TCPDF
{
  // สร้าง function ชื่อ Header สำหรับปรับแต่งการแสดงผลในส่วนหัวของเอกสาร
  public function Header()
  {
  }

  // สร้าง function ชื่อ Footer สำหรับปรับแต่งการแสดงผลในส่วนท้ายของเอกสาร
  public function Footer()
  {
    /*
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('thsarabun', 'B', 25);
    $tab10space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $this->Cell(0, 10, ' หน้า ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    */
  }
}
