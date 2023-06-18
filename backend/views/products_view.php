<?php include('./header.php') ?>

<?php
$nombreTienda = isset($_GET['shop_name']) ? urldecode($_GET['shop_name']) : '';
$tienda = isset($_GET['shop_id']) ? intval($_GET['shop_id']) : 0;
?>

<body>
    <div class="mt-4 d-flex justify-content-center" style="height: 80vh;">
        <div class="card border shadow">
            <div class="container">
                <h1 class="text-center"><?php echo 'Productos: ' . $nombreTienda; ?></h1>
                <input type="hidden" id="tienda" value="<?php echo $tienda; ?>">
                <button class="btn btn-primary crearBtn" data-toggle="modal" data-target="#crearModal">Crear Producto</button>
                <table class="mt-2 table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th>Valor</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listaProductos">
                    </tbody>
                </table>
                <div class="d-flex justify-content-between" id="pagination">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearModalLabel">Registro de Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioProducto">
                        <input type="hidden" id="productoSku">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" id="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor:</label>
                            <input type="number" class="form-control" id="valor" required>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <input type="file" class="form-control" id="imagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="../assets/js/product.js"></script>
</body>

</html>