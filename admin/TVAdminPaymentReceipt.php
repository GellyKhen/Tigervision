<?php
include_once("TVConnectionString.php");
//$varcharReservationID=$_GET['id'];
//$varcharPaymentMethod=$_GET['pm'];
//$varcharPaymentType=$_GET['pt'];
$varcharReservationID = $_GET['reservationid'];
$varcharPaymentIDG = $_GET['paymentid'];
//$varcharPaymentMethod = "Bank";
//$varcharPaymentType = "Paid Full";
$reservationQuery="SELECT * FROM tbl_reservation WHERE reservation_ID = $varcharReservationID";
$paymentQuery="SELECT * FROM tbl_payments WHERE payment_ID = $varcharPaymentIDG";
$reservationArray=mysqli_query($connect,$reservationQuery);
$paymentArray=mysqli_query($connect,$paymentQuery);
while($res=mysqli_fetch_array($reservationArray))
{
	$varcharReservationFirstName = $res['reservation_firstName'];
	$varcharReservationLastName = $res['reservation_lastName'];
    $varcharReservationType = $res['reservation_type'];
    $varcharReservationSchoolName = $res['reservation_schoolName'];
	$varcharReservationContactNum = $res['reservation_contactNum'];
	$varcharReservationEmailAdd = $res['reservation_emailAdd'];
	$varcharReservationAddress = $res['reservation_address'];
	$varcharReservationDateApplied = $res['reservation_dateApplied'];
	$varcharReservationPlannedDate = $res['reservation_plannedDate'];
	$varcharReservationPackageID = $res['reservation_packageID'];
	$varcharReservationPackageType = $res['reservation_packageType'];
	$varcharReservationStatus = $res['reservation_status'];
    $varcharReservationTotalHead = $res['reservation_totalHead'];
    $varcharReservationTotalPrice = $res['reservation_totalPrice'];
    $varcharPartialPrice = $varcharReservationTotalPrice/2;
    $varcharReservationPricePerHead = $res['reservation_pricePerHead'];
    $varcharReservationPaid = $res['reservation_paid'];
    $varcharReservationDebt = $res['reservation_debt'];
}
while($res2=mysqli_fetch_array($paymentArray))
{
	$varcharPaymentID = $res2['payment_ID'];
	$varcharPaymentName = $res2['payment_name'];
	$varcharPaymentAmount = $res2['payment_amount'];
	$varcharPaymentDate = $res2['payment_date'];
	$varcharPaymentMethod = $res2['payment_method'];
	$varcharPaymentType = $res2['payment_type'];
	$varcharPaymentReservationID = $res2['payment_reservationID'];
	$varcharPaymentProcessed = $res2['payment_processed'];
	$varcharPaymentEmailStatus = $res2['payment_emailStatus'];
}
$varcharPaymentLeft = $varcharReservationTotalPrice - $varcharPaymentAmount;
include('fpdf17/fpdf.php');
$voucher = new FPDF('p','mm','A4');
$voucher->AddPage();
$voucher->SetFont('Arial','B','24');

$voucher->Cell(130	,10	,"TigerVision Travel and Tours Co.",0,0);
$voucher->Cell(59	,10	,"",0,1);
$voucher->Image("Images/LogoTigerVision.png"	,169	,10	,30	,30);


$voucher->Cell(189	,5	,"",0,1);

$voucher->SetFont('Arial','','12');
$voucher->Cell(130	,5	,"G/F One Victoria Plaza, A. Mabini Street,",0,0);
$voucher->Cell(59	,5	,"",0,1);

$voucher->SetFont('Arial','','12');
$voucher->Cell(130	,5	,"Kapasigan, Pasig City, Philippines, 1800",0,0);
$voucher->Cell(30	,5	,"",0,0);
$voucher->Cell(29	,5	,"",0,1);

$voucher->SetFont('Arial','','12');
$voucher->Cell(130	,5	,"Phone +63 26334493",0,0);
$voucher->Cell(30	,5	,"",0,0);
$voucher->Cell(29	,5	,"",0,1);

$voucher->Line(10	,45	,199	,45);

$voucher->SetFont('Arial','B','12');
$voucher->Cell(189	,10	,"",0,1);
$voucher->Cell(95	,5	,"Paid By",0,0);
$voucher->Cell(94	,5	,"",0,1);

$voucher->SetFont('Arial','','12');
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"$varcharPaymentName",0,0);
$voucher->Cell(134	,5	,"",0,1);

$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"OR#$varcharPaymentID",0,0);
$voucher->Cell(134	,5	,"",0,1);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"$varcharPaymentDate",0,0);
$voucher->Cell(134	,5	,"",0,1);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"Under: $varcharReservationFirstName $varcharReservationLastName",0,0);
$voucher->Cell(134	,5	,"",0,1);

$voucher->SetFont('Arial','B','12');
$voucher->Cell(189	,10	,"",0,1);
$voucher->Cell(95	,5	,"Reservation Description",0,0);
$voucher->Cell(94	,5	,"Package Description",0,1);

$voucher->SetFont('Arial','','12');
$voucher->SetFont('Arial','','12');
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"Reservation ID",0,0);
$voucher->Cell(40	,5	,"$varcharReservationID",0,0);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(39	,5	,"Package ID",0,0);
$voucher->Cell(40	,5	,"$varcharReservationPackageID",0,1);

if($varcharReservationPackageType	== "tour package")
{
	$packageQuery="SELECT * FROM tbl_reservation INNER JOIN tbl_tourpackage ON tbl_reservation.reservation_packageID=tbl_tourpackage.package_ID WHERE tbl_reservation.reservation_packageID = $varcharReservationPackageID and tbl_reservation.reservation_ID = $varcharReservationID";
	$packageArray=mysqli_query($connect, $packageQuery);
	while($res1=mysqli_fetch_array($packageArray))
	{
		$varcharPackageName=$res1['package_name'];
		$varcharPackageDestination1=$res1['package_destination1'];
		$varcharPackageDestination2=$res1['package_destination2'];
		$varcharPackageDestination3=$res1['package_destination3'];
		$varcharPackageDestination4=$res1['package_destination4'];
		$varcharPackageDestination5=$res1['package_destination5'];
	}
}
else
{
	$packageQuery="SELECT * FROM tbl_reservation INNER JOIN tbl_createnewpackage ON tbl_reservation.reservation_packageID=tbl_createnewpackage.np_ID WHERE tbl_reservation.reservation_packageID = $varcharReservationPackageID and tbl_reservation.reservation_ID = $varcharReservationID";
	$packageArray=mysqli_query($connect, $packageQuery);
	while($res1=mysqli_fetch_array($packageArray))
	{
		$varcharPackageName=$res1['np_name'];
		$varcharPackageDestination1=$res1['np_destination1'];
		$varcharPackageDestination2=$res1['np_destination2'];
		$varcharPackageDestination3=$res1['np_destination3'];
		$varcharPackageDestination4=$res1['np_destination4'];
		$varcharPackageDestination5=$res1['np_destination5'];
	}
}
if(!empty($varcharPackageDestination1))
{
	$destinationQuery="SELECT * FROM tbl_destination WHERE destination_ID=$varcharPackageDestination1";
	$destinationArray=mysqli_query($connect, $destinationQuery);
	while($res1=mysqli_fetch_array($destinationArray))
	{
		$varcharDestinationName1=$res1['destination_name'];
	}
}
if(!empty($varcharPackageDestination2))
{
	$destinationQuery="SELECT * FROM tbl_destination WHERE destination_ID=$varcharPackageDestination2";
	$destinationArray=mysqli_query($connect, $destinationQuery);
	while($res1=mysqli_fetch_array($destinationArray))
	{
		$varcharDestinationName2=$res1['destination_name'];
	}
}
if(!empty($varcharPackageDestination3))
{
	$destinationQuery="SELECT * FROM tbl_destination WHERE destination_ID=$varcharPackageDestination3";
	$destinationArray=mysqli_query($connect, $destinationQuery);
	while($res1=mysqli_fetch_array($destinationArray))
	{
		$varcharDestinationName3=$res1['destination_name'];
	}
}
if(!empty($varcharPackageDestination4))
{
	$destinationQuery="SELECT * FROM tbl_destination WHERE destination_ID=$varcharPackageDestination4";
	$destinationArray=mysqli_query($connect, $destinationQuery);
	while($res1=mysqli_fetch_array($destinationArray))
{
	$varcharDestinationName4=$res1['destination_name'];
}
}
if(!empty($varcharPackageDestination5))
{
	$destinationQuery="SELECT * FROM tbl_destination WHERE destination_ID=$varcharPackageDestination5";
	$destinationArray=mysqli_query($connect, $destinationQuery);
	while($res1=mysqli_fetch_array($destinationArray))
	{
		$varcharDestinationName5=$res1['destination_name'];
	}
}
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"Type",0,0);
$voucher->Cell(40	,5	,"$varcharReservationType",0,0);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(39	,5	,"Package Name",0,0);
$voucher->SetFont('Arial','','8');
$voucher->Cell(40	,5	,"$varcharPackageName",0,1);
$voucher->Cell(15	,5	,"",0,0);
$voucher->SetFont('Arial','','12');
$voucher->Cell(40	,5	,"Date Applied",0,0);
$voucher->Cell(40	,5	,"$varcharReservationDateApplied",0,0);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(39	,5	,"Package Type",0,0);
$voucher->Cell(40	,5	,"$varcharReservationPackageType",0,1);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"Date Planned",0,0);
$voucher->Cell(40	,5	,"$varcharReservationPlannedDate",0,0);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(79	,5	,"",0,1);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(40	,5	,"Status",0,0);
$voucher->Cell(40	,5	,"$varcharReservationStatus",0,0);
$voucher->Cell(15	,5	,"",0,0);
$voucher->Cell(79	,5	,"",0,1);

$voucher->SetFont('Arial','B','12');
$voucher->Cell(189	,10	,"",0,1);

$voucher->Cell(189	,5	,"Destinations",0,1);

$voucher->SetFont('Arial','','12');

$packageQuery="SELECT tbl_toupackage.package_name FROM tbl_reservation	INNER JOIN tbl_packages ON tbl_reservation.reservation_packageID=tbl_tourpackage.package_ID WHERE tbl_reservation.reservation_ID = $varcharReservationID";
$packageArray=mysqli_query($connect, $packageQuery);

$voucher->SetFont('Arial','','12');
if(!empty($varcharPackageDestination1))
{
	$voucher->Cell(15	,5	,"",0,0);
	$voucher->Cell(39	,5	,"Destination 1",0,0);
	$voucher->Cell(150	,5	,"$varcharDestinationName1",0,1);
}
if(!empty($varcharPackageDestination2))
{
	$voucher->Cell(15	,5	,"",0,0);
	$voucher->Cell(39	,5	,"Destination 2",0,0);
	$voucher->Cell(150	,5	,"$varcharDestinationName2",0,1);
}
if(!empty($varcharPackageDestination3))
{
	$voucher->Cell(15	,5	,"",0,0);
	$voucher->Cell(39	,5	,"Destination 3",0,0);
	$voucher->Cell(150	,5	,"$varcharDestinationName3",0,1);
}
if(!empty($varcharPackageDestination4))
{
	$voucher->Cell(15	,5	,"",0,0);
	$voucher->Cell(39	,5	,"Destination 4",0,0);
	$voucher->Cell(150	,5	,"$varcharDestinationName4",0,1);
}
if(!empty($varcharPackageDestination5))
{
	$voucher->Cell(15	,5	,"",0,0);
	$voucher->Cell(39	,5	,"Destination 5",0,0);
	$voucher->Cell(150	,5	,"$varcharDestinationName5",0,1);
}
$varcharReservationTotalPrice = number_format($varcharReservationTotalPrice,2);
$varcharReservationPricePerHead	 = number_format($varcharReservationPricePerHead,2);
$varcharPartialPrice = number_format($varcharPartialPrice,2);
$voucher->Cell(189	,10	,"",0,1);

$voucher->Cell(189	,00	,"",1,1);
$voucher->SetFont('Arial','B','12');
$voucher->Cell(47	,7	,"Package ID",1,0,'C');
$voucher->Cell(47	,7	,"Quantity/Heads",1,0,'C');
$voucher->Cell(47	,7	,"Price/Head",1,0,'C');
$voucher->Cell(48	,7	,"Total Price",1,1,'C');
$voucher->SetFont('Arial','','12');
$voucher->Cell(47	,10	,"$varcharReservationPackageID",1,0,'C');
$voucher->Cell(47	,10	,"$varcharReservationTotalHead",1,0,'C');
$voucher->Cell(47	,10	,"Php $varcharReservationPricePerHead",1,0,'C');
$voucher->SetFont('Arial','B','12');
$voucher->Cell(48	,10	,"Php $varcharReservationTotalPrice",1,1,'C');

$voucher->Cell(189	,10	,"",0,1);

$voucher->SetFont('Arial','','14');
$voucher->Cell(65	,7	,"Payment Method:",0,0);
$voucher->Cell(48	,7	,"$varcharPaymentMethod	",0,1);
$voucher->SetFont('Arial','','14');
$voucher->Cell(65	,7	,"Payment Type:",0,0);
$voucher->Cell(48	,7	,"$varcharPaymentType",0,1);
$voucher->Cell(65	,7	,"Total Price:",0,0);
$voucher->SetFont('Arial','B','14');

$voucher->Cell(48	,7	,"Php $varcharReservationTotalPrice",0,1);
$voucher->Cell(189	,10	,"",0,1);

$voucher->Cell(65	,7	,"-",0,0);
$voucher->Cell(48	,7	,"Php $varcharPaymentAmount",0,1);
$voucher->Cell(65	,7	,"=",0,0);
$voucher->Cell(48	,7	,"Php $varcharPaymentLeft",0,1);
$voucher->Cell(189	,10	,"",0,1);
$voucher->Line(10	,45	,199	,45);


//$voucher->SetFont('Arial','','12');
//$voucher->Cell(189	,5	,"*I have accepted the terms and condition*",0,1,'C');

$voucher->Line(10	,266	,199	,266);
$voucher->SetY(250);
$voucher->Cell(189	,5	,"Reminder:",0,1,'C');
$voucher->Cell(189	,5	,"50% of the total payment must be settled 7 days before the date planned",0,1,'C');
$voucher->Cell(189	,5	,"to process the reservation.",0,1,'C'); 
$voucher->SetFont('Arial','B','14');
$voucher->Cell(189	,10	,"--THANK YOU FOR BOOKING A RESERVATION!--",0,1,'C');



$pdfoutputfile = 'filestobesent/' .$varcharPaymentID. 'receipt.pdf';
$pdfdoc = $voucher->Output($pdfoutputfile, 'F');
$voucher->Output();
?>