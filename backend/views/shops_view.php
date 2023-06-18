<?php include('./header.php') ?>

<body>
    <div class="mt-4 d-flex justify-content-center" style="height: 84vh;">
        <div class="card border shadow">
            <div class="container">
                <h1 class="text-center">Tiendas</h1>
                <button class="btn btn-primary crearBtn" data-toggle="modal" data-target="#crearModal">Crear Tienda</button>
                <div class="mt-2 form-group">
                </div>
                <table class="mt-2 table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fecha de Apertura</th>
                            <th>Acciones</th>
                            <th>Productos</th>
                        </tr>
                    </thead>
                    <tbody id="listaTiendas">
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
                    <h5 class="modal-title" id="crearModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioTienda">
                        <input type="hidden" id="tiendaId">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaApertura">Fecha de Apertura:</label>
                            <input type="date" class="form-control" id="fechaApertura" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="../assets/js/shop.js"></script>
</body>

</html>