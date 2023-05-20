<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="2";
$sql = "UPDATE tblreservas SET Estado=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Reserva cancelada con éxito";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE tblreservas SET Estado=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();

$msg="Reserva confirmada con éxito";
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

	<title>Portal Bike House |Admin testimonios   </title>

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

						<h2 class="page-title">Adminstrar reservas</h2>

						<!-- Tabla de confirmacion cero -->
						<div class="panel panel-default">
							<div class="panel-heading">Información de resevas</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
				else if($msg){?><div class="succWrap"><strong>EXITO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
											<th>Nombre</th>
											<th>vehiculos</th>
											<th>A partir de</th>
											<th>Hasta fecha</th>
											<th>Mensajes</th>
											<th>Estado</th>
											<th>Fecha Publicación</th>
											<th>Acción</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
										<th>Nombre</th>
											<th>vehiculos</th>
											<th>A partir de</th>	
											<th>Hasta fecha</th>
											<th>Mensajes</th>
											<th>Estado</th>
											<th>Fecha publicación</th>
											<th>Acción</th>
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT tblmarcas.NombreMarca,tblvehiculos.TituloVehiculo,tblreservas.FechaInicio,tblreservas.FechaFin,tblreservas.Mensajes,tblreservas.IdVehiculo as tblreservas.Estado,tblreservas.FechaPosteo,tblreservas.id  from tblreservas join tblvehiculos on tblvehiculos.id=tblreservas.IdVehiculo join  tblmarcas on tblvehiculos.MarcaVehiculo=tblvehiculos.id  ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<!--<td><?php //echo htmlentities($result->FullName);?></td>-->
											<td><a href="editar-vehiculo.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></td>
											<td><?php echo htmlentities($result->FechaInicio);?></td>
											<td><?php echo htmlentities($result->FechaFin);?></td>
											<td><?php echo htmlentities($result->Mensajes);?></td>
											<td><?php
if($result->Estado==0)
{
echo htmlentities('Aún no confirmada');
} else if ($result->Estado==1) {
echo htmlentities('Confirmado');
}
 else{
 	echo htmlentities('Cancelado');
 }
										?></td>
											<td><?php echo htmlentities($result->FechaPosteo);?></td>
										<td><a href="administrar-reservas.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿De verdad quieres Confirmar esta reserva?')"> Confirmar</a> /


<a href="administrar-reservas.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Realmente desea cancelar esta reserva?')"> Cancelar</a>
</td>

										</tr>
										<?php $cnt=$cnt+1; }} ?>

									</tbody>
								</table>



							</div>
						</div>



					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Scripts -->
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
