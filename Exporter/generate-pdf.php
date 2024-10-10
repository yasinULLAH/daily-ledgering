<?php
ob_start();
require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
function Footer()
		{
			//Title
			$this->SetFont('Arial','',7);
			$this->Cell(0,6,'yking.khan@facebook.com',0,1,'C');
			$this->Ln(10);
			//Ensure table header is output
			parent::Footer();
		}
}
include('../Connections/myconn.php');
$pdf=new PDF();
//$pdf->AddPage();
//First table: put all columns automatically
$id = $_GET['id'];
//echo $id;die();
$name = $_GET['name'];
//echo $name;die();
/*if($id>0)
{
	$pdf->Table("SELECT `id` as ID,`name` as Name,`Debut`,`Credit`, `result`,`date` from clients where id = '$id'");	
}
elseif($name>0)
{
	$pdf->Table("SELECT `id` as ID,`name` as Name,`Debut`,`Credit`, `result`,`date` from clients where name = '$name' order by id");	
}else
{*/
//$pdf->Table("SELECT `name` as Name,`id` as ID,`Debut`,`Credit`, `result`,`date` from clients order by id");
/*}*/
if(!isset($_GET['dt']))
{
	$pdf->AddPage();
	//Second table: specify 3 columns
	$pdf->AddCol('ID',20,'','C');
	$pdf->AddCol('name',70,'Name','C');
	$pdf->AddCol('Credit',27,'Total Debut','C');
	$pdf->AddCol('Debut',27,'Total Credit','C');
	$pdf->AddCol('result',27,'Total','C');
	$prop=array('HeaderColor'=>array(255,150,100),
				'color1'=>array(255,255,255),
				'color2'=>array(255,255,255),
				'padding'=>0);
	if(!empty($name))
	{
	$pdf->Table("select name,result,id as ID,Debut,Credit from clients where name = '$name' order by id",$prop);
	}
	elseif($id>0)
	{
		$pdf->Table("select name,result,id as ID,Debut,Credit from clients where id = '$id' order by id",$prop);
	}
	else
	{
		$pdf->Table("select name,result,id as ID,Debut,Credit from clients order by id",$prop);
	}
}
elseif(isset($_GET['dt']))
{
		$pdf->AddPage();
	//Second table: specify 3 columns
	$pdf->AddCol('name',69,'Name','C');
	$pdf->AddCol('type',16,'Type','C');
	$pdf->AddCol('amount',27,'Amount','C');
	$pdf->AddCol('date',22,'Date','C');
	$pdf->AddCol('info',93,'Information','C');
	$pdf->AddCol('detail',69,'Detail','C');
	$prop=array('HeaderColor'=>array(255,150,100),
				'color1'=>array(255,255,255),
				'color2'=>array(255,255,255),
				'padding'=>0);	if(!empty($name))
	{
	$pdf->Table("select name,amount,conn_id as ID,type,detail,info,date from detail where name = '$name' order by id",$prop);
	}
	elseif($id>0)
	{
		$pdf->Table("select name,amount,conn_id as ID,type,detail,info,date from detail where conn_id = '$id' order by id",$prop);
	}
	else
	{
		$pdf->Table("select name,amount,conn_id as ID,type,detail,info,date from detail order by id",$prop);
	}
}
//$pdf->Output("C:\Users\John\Desktop/somename.pdf",'F'); 

$downloadfilename = "king";
if($pdf->Output($downloadfilename.".pdf")){
header('location:../export.php?msg=Exported Successfully');
}else{
	header('location:../export.php?msg=Exported Successfully');
}
ob_flush();
?>
