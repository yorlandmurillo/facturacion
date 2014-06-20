<? 
include_once("manejadordb.php"); 
include "phpreports/PHPReportMaker.php";
$obj=new manejadordb;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?	
$year=date(Y);
$month=date(m);
$day=date(d);
$hour=date(H)-1;
$minute=date(i);
$second=date(s);
$hoy=$year."-".$month."-".$day;


$oper = Array ("item"=>"count","value"=>"sum");
$alias = Array ("count"=>"qtde","sum"=>"total");
$r = new PHPReportMaker ();
$r-> setUser ("root");
$r-> setPassword ("120842ma");
$r-> setConnection ("localhost");
$r-> setDatabase ("pglibreria");
$r-> setDatabaseInterface ("mysql");
$r-> setSQL ("select name , city , type , item , value from sales order by city,name,type ");
$r-> addInputPlugin ("crosstab",Array(" name "," city "),"type",Array(" COLUMNS_FUNCTIONS "=>$oper ," FUNCTIONS_ALIASES "=> $alias ));
$r-> createFromTemplate ("Crosstab");
$r->run();

?>
</body>
</html>