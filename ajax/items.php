<?php
$action = $_REQUEST['action'] ?? '';
if ($action == 'ajax') {
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");

	// Eliminar ítem
	if (isset($_REQUEST['id'])){
	$id = intval($_REQUEST['id']);
	$delete = mysqli_query($con, "DELETE FROM inventario WHERE id='$id'");
}


	// Editar cantidad o precio
		if (isset($_REQUEST['id_editar'])){
		$id = intval($_REQUEST['id_editar']);
		
		// Si viene cantidad y precio juntos
		if (isset($_REQUEST['cantidad']) && isset($_REQUEST['precio'])) {
			$cantidad = intval($_REQUEST['cantidad']);
			$precio = floatval($_REQUEST['precio']);
			$update = mysqli_query($con, "UPDATE inventario SET cantidad='$cantidad', precio='$precio' WHERE id='$id'");
		}
	}

	// Insertar nuevo ítem
	if (isset($_POST['descripcion'])) {
		$codigo = mysqli_real_escape_string($con, $_POST['codigo']);
		$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
		$cantidad = intval($_POST['cantidad']);
		$precio = floatval($_POST['precio']);
		$unidad = mysqli_real_escape_string($con, $_POST['unidad']);

		$sql = "INSERT INTO inventario (codigo, descripcion, cantidad, precio, unidad) 
		        VALUES ('$codigo', '$descripcion', $cantidad, $precio, '$unidad')";
		mysqli_query($con, $sql);
	}

	// Mostrar tabla
	$query = mysqli_query($con, "SELECT * FROM inventario ORDER BY id");
	$suma = 0;
	$suma_stock = 0;

	while ($row = mysqli_fetch_array($query)) {
		$id = $row['id'];
		$total = number_format($row['cantidad'] * $row['precio'], 2, '.', '');
		$suma += $total;
		$suma_stock += $row['cantidad'];
		?>
		<tr>
	<td class='text-center'><?= $row['codigo']; ?></td>
	<td><?= $row['descripcion']; ?></td>
	<td class='text-center'><?= $row['unidad']; ?></td>

	<td class='text-center'>
		<input type="number" class="form-control input-sm" id="cantidad_<?= $row['id']; ?>" value="<?= $row['cantidad']; ?>" style="width: 70px;">
	</td>

	<td class='text-right'>
		<input type="number" class="form-control input-sm" id="precio_<?= $row['id']; ?>" value="<?= number_format($row['precio'], 2, '.', ''); ?>" style="width: 70px;">
	</td>

	<td class='text-right'><?= number_format($row['cantidad'] * $row['precio'], 2); ?></td>

	<td class='text-right'>
		<button class="btn btn-sm btn-warning" onclick="actualizar_item(<?= $row['id']; ?>)">
			<span class="glyphicon glyphicon-refresh"></span> Actualizar
		</button>
		<button class="btn btn-sm btn-danger" onclick="eliminar_item(<?= $row['id']; ?>)">
			<span class="glyphicon glyphicon-trash"></span>
		</button>
	</td>
</tr>


		<?php
	}

	?>
	<tr>
		<td colspan='7'>
			<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal" style="border-radius: 30px; font-weight: bold;">
	<span class="glyphicon glyphicon-plus"></span> Agregar nuevo producto
</button>

			<span class='valor_total'><?= number_format($suma, 2); ?></span>
			<span class='suma_stock'><?= number_format($suma_stock, 2); ?></span>
		</td>
	</tr>
	<?php
}
?>
