<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{

if(isset($_POST['submit']))
  {
$vehicletitle=$_POST['TituloVehiculo'];
$brand=$_POST['MarcaVehiculo'];
$vehicleoverview=$_POST['DescripcionVehiculo'];
$priceperday=$_POST['PrecioDia'];
$modelyear=$_POST['aYear'];
$seatingcapacity=$_POST['Capacidad'];
$airconditioner=$_POST['Barritas'];
$powerdoorlocks=$_POST['BombaAire'];
$antilockbrakingsys=$_POST['Camara'];
$brakeassist=$_POST['Desmontables'];
$powersteering=$_POST['Manguitos'];
$driverairbag=$_POST['Chaleco'];
$passengerairbag=$_POST['CuentakilometrosGPS'];
$powerwindow=$_POST['Candado'];
$cdplayer=$_POST['Casco'];
$centrallocking=$_POST['Guantes'];

$sql="INSERT INTO tblvehiculos(TituloVehiculo,MarcaVehiculo,DescripcionVehiculo,PrecioDia,aYear,Capacidad,Barritas,BombaAire,Camara,Desmontables,Manguitos,Chaleco,CuentakilometrosGPS,Candado,Casco,Guantes) VALUES(:TituloVehiculo,:MarcaVehiculo,:DescripcionVehiculo,:PrecioDia,:aYear,:BombaAire,:Camara,:Desmontables,:Manguitos,:Chaleco,:CuentakilometrosGPS,:Candado,:Casco,:Guantes)";
$query = $dbh->prepare($sql);
$query->bindParam(':TituloVehiculo',$vehicletitle,PDO::PARAM_STR);
$query->bindParam(':MarcaVehiculo',$brand,PDO::PARAM_STR);
$query->bindParam(':DescripcionVehiculo',$vehicleoverview,PDO::PARAM_STR);
$query->bindParam(':PrecioDia',$priceperday,PDO::PARAM_STR);
$query->bindParam(':aYear',$modelyear,PDO::PARAM_STR);
$query->bindParam(':Capacidad',$seatingcapacity,PDO::PARAM_STR);
$query->bindParam(':Barritas',$airconditioner,PDO::PARAM_STR);
$query->bindParam(':BombaAire',$powerdoorlocks,PDO::PARAM_STR);
$query->bindParam(':Camara',$antilockbrakingsys,PDO::PARAM_STR);
$query->bindParam(':Desmontables',$brakeassist,PDO::PARAM_STR);
$query->bindParam(':Manguitos',$powersteering,PDO::PARAM_STR);
$query->bindParam(':Chaleco',$driverairbag,PDO::PARAM_STR);
$query->bindParam(':CuentakilometrosGPS',$passengerairbag,PDO::PARAM_STR);
$query->bindParam(':Candado',$powerwindow,PDO::PARAM_STR);
$query->bindParam(':Casco',$cdplayer,PDO::PARAM_STR);
$query->bindParam(':Guantes',$centrallocking,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Vehículo publicado con éxito";
}
else
{
$error="Algo salió mal. Inténtalo de nuevo";
}

}


	?>
<!doctype html>
<html lang="es" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">

	<title>Portal Bike House | Admin Publicar Vehículo</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
<style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Publicar un vehículo</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Información básica</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
				else if($msg){?><div class="succWrap"><strong>EXITO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
									<form method="post" class="form-horizontal" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-sm-2 control-label">Título del vehículo<span style="color:red">*</span></label>
										<div class="col-sm-4">
											<input type="text" name="vehicletitle" class="form-control" required>
										</div>
										<label class="col-sm-2 control-label">Seleccionar marca<span style="color:red">*</span></label>
										<div class="col-sm-4">
											<select class="selectpicker" name="brandname" required>
												<option value=""> Seleccionar </option>
<?php $ret="select id,NombreMarca from tblmarcas";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $result)
{
?>
												<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->NombreMarca);?></option>
<?php }} ?>

											</select>
										</div>
									</div>

									<div class="hr-dashed"></div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Resumen de vehículos<span style="color:red">*</span></label>
											<div class="col-sm-10">
												<textarea class="form-control" name="vehicalorcview" rows="3" required></textarea>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">Precio por día<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="priceperday" class="form-control" required>
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-2 control-label">Año<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="modelyear" class="form-control" required>
											</div>
												<label class="col-sm-2 control-label">Capacidad<span style="color:red">*</span></label>
												<div class="col-sm-4">
													<input type="text" name="seatingcapacity" class="form-control" required>
												</div>
											</div>
											<div class="hr-dashed"></div>

											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn btn-default" type="reset">Cancelar</button>
													<button class="btn btn-primary" name="submit" type="submit">Guardar cambios</button>
												</div>
											</div>

										</form>
									</div>
								</div>
							</div>
						</div>



					</div>
				</div>



			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>
