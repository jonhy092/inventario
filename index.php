<?php
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);

?>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Script PHP para control de notas de gastos" />
    <meta name="author" content="Su Servidor" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Plantilla de Inventario con PHP y MySQL </title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="/inventario/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="/inventario/assets/css/style.css" rel="stylesheet" />
	<link rel=icon href='/inventario/img/logo-icon.png' sizes="32x32" type="image/png">
	<link href="/inventario/assets/css/select2.min.css" rel="stylesheet" />
	<style>
	body {
		background: #f8f9fa;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
	}
	.outer-section {
		background: white;
		padding: 30px;
		border-radius: 15px;
		box-shadow: 0 0 20px rgba(0,0,0,0.1);
		margin-top: 30px;
	}

	h4 {
		color: #16a085;
		font-weight: bold;
	}

	blockquote {
		font-size: 24px;
		font-weight: bold;
		color: #2c3e50;
		border-left: 5px solid #16a085;
		padding-left: 15px;
	}

	.table th {
		background-color: #16a085 !important;
		color: white;
	}

	.table td {
		vertical-align: middle;
	}

	.btn-info, .btn-success, .btn-danger, .btn-warning {
		border-radius: 20px;
	}

	.modal-content {
		border-radius: 12px;
	}

	#myModal label {
		font-weight: bold;
		color: #34495e;
	}
</style>

</head>
<body >
	<!-- Alertas de éxito o error -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

    <div class="container outer-section" >
        
       <form class="form-horizontal" role="form" id="datos_inventario" method="post">
        <div id="print-area">
                  <div class="row pad-top font-big">
                <div class="col-lg-4 col-md-4 col-sm-4 text-center">
	<a href="https://github.com/jonhy092" target="_blank">
		<img src="/inventario/assets/img/logo.png" alt="Logo Inventario" style="max-height: 80px; border-radius: 10px;">
	</a>
	<h3 style="margin-top: 10px; color: #16a085; font-weight: bold;">Mi Inventario</h3>
</div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <strong>E-mail : </strong> <?php echo $rw['email'];?>
                    <br />
                    <strong>Teléfono :</strong> <?php echo $rw['telefono'];?> <br />
					<strong >Sitio web :</strong> <?php echo $rw['web'];?> 
                   
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <strong><?php echo $rw['nombre_comercial'];?>  </strong>
                    <br />
                    Dirección : <?php echo $rw['direccion'];?> 
                </div>

            </div>
          
            
            

            <div class="row ">
			<hr />
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h4>VALOR TOTAL DEL INVENTARIO: </h4>
                    <div class="row">
						<div class="col-lg-6">
						  <blockquote class='inventario'  ></blockquote>
						</div>
					</div>
				
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h4>ARTÍCULOS EN INVENTARIO:</h4>
					<div class="row">
						<div class="col-lg-6">
						  <blockquote class='total_stock' ></blockquote>
						</div>
						
					
					</div>
				
                   
				
								
                   
                    
                  
                </div>
            </div>
            
         
            <div class="row">
			<hr />
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover">
                            <thead>
                                <tr style="background-color:#16a085;color:white;">
                                    <th class='text-center'>Código</th>
									<th class='text-left'>Descripción</th>
									<th class='text-center'>Talle/Nro</th>
									<th class='text-center'>Cantidad</th>
									<th class='text-right'>Costo</th>
                                    <th class='text-right'>Costo Total</th>
									<th class='text-right'></th>
                                </tr>
                            </thead>
                            <tbody class='items'>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
           
           
            
		
        </div>
       <div class="row"> <hr /></div>
       
		</form>
    </div>
	<form class="form-horizontal" name="guardar_item" id="guardar_item">
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Nuevo Ítem</h4>
				  </div>
				  <div class="modal-body">
					
					  <div class="row">
						<div class="col-md-4">
							<label>Código</label>
							<input type="text" class="form-control" id="codigo" name="codigo" required placeholder="Ej: PRD-001">
							
						</div>
						
						<div class="col-md-8">
							<label>Descripción del producto</label>
							<input type="text" class="form-control" id="descripcion" name="descripcion" required  placeholder="Descripción del producto">
							<input type="hidden" class="form-control" id="action" name="action"  value="ajax">
						</div>
						
					  </div>

					  <div class="row">
						<div class="col-md-4">
							<label>Cantidad</label>
							<input type="text" class="form-control" id="cantidad" name="cantidad" required placeholder="Ej: 10">
						</div>
						<div class="col-md-4">
							<label>Talle</label>
							<input type="text" class="form-control" id="unidad" name="unidad" required placeholder="Ej: Talle M">
						</div>
						
						<div class="col-md-4">
							<label>Costo unitario</label>
						  <input type="text" class="form-control" id="precio" name="precio" required placeholder="Ej: 150.00">
						</div>
						
					  </div>
				
					
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-info" >Guardar</button>
					
				  </div>
				</div>
			  </div>
			</div>
	</form>
	
   
</body>
	<script src="/inventario/js/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="/inventario/js/jquery.min.js"></script>
<script src="/inventario/js/bootstrap.min.js"></script>
<script src="/inventario/js/VentanaCentrada.js"></script>
<script src="/inventario/js/select2.min.js"></script>

<script type="text/javascript">

	function mostrar_alerta(mensaje, tipo = 'success') {
	const alertHTML = `
		<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
			${mensaje}
			<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	`;

	const contenedor = document.getElementById('alert-container');
	contenedor.innerHTML = alertHTML;

	// Ocultar luego de 3 segundos
	setTimeout(() => {
		$('.alert').alert('close');
	}, 3000);
}

function mostrar_items() {
	const parametros = { action: 'ajax' };
	$.ajax({
		url: '/inventario/ajax/items.php',
		data: parametros,
		beforeSend: function () {
			$('.items').html('Cargando...');
		},
		success: function (data) {
			$(".items").html(data).fadeIn('slow');
			mostrar_valores();
		}
	});
}

function mostrar_valores() {
	$(".valor_total, .suma_stock").hide();
	let total = $('.valor_total').text();
	let stock = $('.suma_stock').text();
	$(".inventario").text("$ " + total);
	$(".total_stock").text(stock);
}

function eliminar_item(id) {
	if (confirm('¿Estás seguro de eliminar este ítem del inventario?')) {
		$.ajax({
			url: '/inventario/ajax/items.php',
			type: 'GET',
			data: {
				action: 'ajax',
				id: id
			},
			beforeSend: function () {
				$('.items').html('Cargando...');
			},
			success: function (data) {
	$(".items").html(data).fadeIn('slow');
	mostrar_valores();
	mostrar_alerta("Producto eliminado con éxito");
}

		});
	}
}

function actualizar_item(id) {
	const cantidad = $("#cantidad_" + id).val();
	const precio = $("#precio_" + id).val();

	$.ajax({
		url: '/inventario/ajax/items.php',
		type: 'GET',
		data: {
			action: 'ajax',
			id_editar: id,
			cantidad: cantidad,
			precio: precio
		},
		beforeSend: function () {
			$('.items').html('Cargando...');
		},
		success: function (data) {
	$(".items").html(data).fadeIn('slow');
	mostrar_valores();
	mostrar_alerta("Producto actualizado correctamente");
}
	});
}

$("#guardar_item").submit(function (event) {
	const parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: '/inventario/ajax/items.php',
		data: parametros,
		beforeSend: function () {
			$('.items').html('Cargando...');
		},
		success: function (data) {
	$(".items").html(data).fadeIn('slow');
	$("#myModal").modal('hide');
	$("#guardar_item")[0].reset();
	mostrar_valores();
	mostrar_alerta("Producto agregado con éxito");
}
	});
	event.preventDefault();
});

// Iniciar al cargar
mostrar_items();
</script>


</html>
