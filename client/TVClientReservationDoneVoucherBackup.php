<?php  
 function fetch_data()  
 {  
      $output = '';
      $id = $_GET['id'];  
      $connect = mysqli_connect("localhost", "root", "", "tigervision");  
      $sql = "SELECT * FROM tbl_reservation WHERE reservation_purgeFlag = 1 AND reservation_ID = $id ";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '  
                          <p>Reservation ID - '.$row["reservation_ID"].'</p>  
                          <p>'.$row["reservation_firstName"].'</td>  
                          <td>'.$row["reservation_lastName"].'</td>  
                          <td>'.$row["reservation_type"].'</td>  
                          <td>'.$row["reservation_schoolName"].'</td>
                          <td>'.$row["reservation_contactNum"].'</td>
                          <td>'.$row["reservation_emailAdd"].'</td>
                          <td>'.$row["reservation_address"].'</td> 
                          <td>'.$row["reservation_dateApplied"].'</td>
                          <td>'.$row["reservation_plannedDate"].'</td>
                          <td>'.$row["reservation_packageID"].'-'.$row["reservation_packageType"].'</td>
                          <td>'.$row["reservation_status"].'</td>
                          <td>'.$row["reservation_totalPrice"].'</td>
                          <td>'.$row["reservation_pricePerHead"].'</td>
                          <td>'.$row["reservation_totalHead"].'</td>
                          <td>'.$row["reservation_paid"].'</td>
                          <td>'.$row["reservation_debt"].'</td> 
                     </tr>  
                          ';  
      }  
      return $output;  
}



 
      require_once('dependencyphp/TCPDF/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Tigervision - Reservation Voucher");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage('L');  
      $content = '';  
      $content .= '
      <img src="Images/LogoTigerVision.png" height="42" width="42"> 
      <b>Tigervision</b>
      <h4 align="center">Reservation List<br />
      <table border="1" cellspacing="0" cellpadding="3">  
          
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('file.pdf', 'I');   
 ?>  