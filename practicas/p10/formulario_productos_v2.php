<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" >
    <title>Formulario productos</title>
    <style type="text/css">
      ol, ul { 
      list-style-type: none;
      }
    </style>
  </head>
<body>
    <?php
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
        $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
        $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
        $unidades = isset($_POST['unidades']) ? $_POST['unidades'] : '';
        $detalles = isset($_POST['detalles']) ? $_POST['detalles'] : '';
        $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : '';
    ?>
    <h1><?php echo $id ? 'Modificar Producto' : 'Registro de producto'; ?></h1>
    <form id="formularioProductos" 
      action="<?php echo $id ? 'http://localhost/tecweb/practicas/p10/update_producto.php' : 'http://localhost/tecweb/practicas/p09/set_producto_v2.php'; ?>" 
      method="post" 
      enctype="multipart/form-data">
   <fieldset>
    <legend>Información del Producto</legend>
        <input type="hidden" name="id" id="form-id" value="<?php echo $id; ?>">
    <ul>
        <li><label for="form-name">Nombre:</label> 
            <input type="text" name="name" id="form-name" value="<?php echo htmlspecialchars($nombre); ?>">
        </li>
        
        <li>
            <label for="form-brand">Marca:</label>
            <select name="brand" id="form-brand">
                <option value="">Selecciona una marca</option>
                <option value="Samsung" <?php if($marca=='Samsung') echo 'selected'; ?>>Samsung</option>
                <option value="Apple" <?php if($marca=='Apple') echo 'selected'; ?>>Apple</option>
                <option value="Xiaomi" <?php if($marca=='Xiaomi') echo 'selected'; ?>>Xiaomi</option>
                <option value="Huawei" <?php if($marca=='Huawei') echo 'selected'; ?>>Huawei</option>
                <option value="Motorola" <?php if($marca=='Motorola') echo 'selected'; ?>>Motorola</option>
            </select>
        </li>

        <li><label for="form-model">Modelo:</label> 
            <input type="text" name="model" id="form-model" value="<?php echo htmlspecialchars($modelo); ?>">
        </li>
        
        <li>
            <label for="form-price">Precio (MXN):</label>
            <input type="number" name="price" id="form-price" min="0" step="0.01" inputmode="decimal" placeholder="0.00" value="<?php echo $precio; ?>">
        </li>
        
        <li>
            <label for="form-description">Detalles:</label><br>
            <textarea name="description" rows="4" cols="60" id="form-description" placeholder="No más de 250 caracteres de longitud"><?php echo htmlspecialchars($detalles); ?></textarea>
        </li>
        
        <li>
            <label for="form-stock">Unidades disponibles:</label>
            <input type="number" name="stock" id="form-stock" min="0" step="1" inputmode="numeric" placeholder="0" value="<?php echo $unidades; ?>">
        </li>
        
        <li>
            <label for="form-image">Imagen del producto:</label>
            <input type="file" name="image" id="form-image" accept="image/*">
            <?php if($imagen): ?>
                <br><small>Imagen actual: <img src="<?php echo $imagen; ?>" width="50"></small>
            <?php endif; ?>
            <input type="hidden" name="imagen_actual" value="<?php echo $imagen; ?>">
        </li>
        
        <li>    
            <button type="submit"><?php echo $id ? 'Actualizar producto' : 'Registrar producto'; ?></button>
        </li>
    </ul>
    </fieldset>
</form>

    <script>
    document.getElementById('formularioProductos').addEventListener('submit', function(e) {
    const id = document.getElementById('form-id').value;
    const name = document.getElementById('form-name').value.trim();
    const brand = document.getElementById('form-brand').value;
    const model = document.getElementById('form-model').value.trim();
    const price = parseFloat(document.getElementById('form-price').value);
    const stock = parseInt(document.getElementById('form-stock').value);
    const description = document.getElementById('form-description').value.trim();
    const imageFile = document.getElementById('form-image').files[0];

    if (!name || name.length > 100) {
        alert('El nombre es requerido y debe tener 100 caracteres o menos.');
        e.preventDefault();
        return;
    }
    

    if (!brand || brand === '') {
        alert('Debe seleccionar una marca de la lista.');
        e.preventDefault();
        return;
    }
    
    
    const alfanumerico = /^[a-zA-Z0-9]+$/;
    if (!model || model.length > 25) {
        alert('El modelo es requerido y debe tener 25 caracteres o menos.');
        e.preventDefault();
        return;
    }
    if (!alfanumerico.test(model)) {
        alert('El modelo debe ser alfanumérico (solo letras y números).');
        e.preventDefault();
        return;
    }
    
    
    if (isNaN(price) || price <= 99.99) {
        alert('El precio debe ser mayor a 99.99');
        e.preventDefault();
        return;
    }
    
    if (description.length > 250) {
        alert('Los detalles deben tener 250 caracteres o menos.');
        e.preventDefault();
        return;
    }
    
    if (isNaN(stock) || stock < 0) {
        alert('Las unidades son requeridas y deben ser mayor o igual a 0.');
        e.preventDefault();
        return;
    }
    
   
    if (!imageFile) {
    
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'imagen_defecto';
        hiddenInput.value = 'img/imagen.png';
        this.appendChild(hiddenInput);
    }

    if (id) {
        console.log('Modo edición - ID:', id);
    } else {
        console.log('Modo creación');
    }

    });
    </script>


</body>
</html>
