$(document).ready(function () {
  var currentPage = 1;
  var limit = 3;
  var tienda = document.getElementById("tienda").value;

  //Mostar en tabla (paginado)
  function loadProducts(page) {
    $.ajax({
      url: "../controllers/ProductController.php?action=getProductsByPage",
      type: "GET",
      data: {
        page: page,
        limit: limit,
        shop_id: tienda,
      },
      dataType: "json",
      success: function (response) {
        //Cargar datos
        var products = response.data;
        var html = "";
        for (var i = 0; i < products.length; i++) {
          var producto = products[i];
          html += '<tr">';
          html += '<td class="align-middle">' + producto.nombre + "</td>";
          html += '<td class="align-middle">' + producto.sku + "</td>";
          html += '<td class="align-middle">' + producto.descripcion + "</td>";
          html += '<td class="align-middle">' + producto.valor + "</td>";
          html +=
            '<td><img src="' +
            producto.imagen +
            '" class="img-fluid rounded shadow" alt="Imagen del producto"></td>';
          html += '<td class="align-middle">';
          html +=
            '<span class="btn btn-warning editarBtn" data-sku="' +
            producto.sku +
            '"><i class="bi bi-pencil-fill"></i></span>';
          html +=
            '<span class="mx-1 btn btn-danger eliminarBtn" data-sku="' +
            producto.sku +
            '"><i class="bi bi-trash-fill"></i></span>';
          html += "</td>";
          html += "</tr>";
        }
        $("#listaProductos").html(html);

        var totalPages = response.totalPages;
        var paginationHtml = "";
        if (currentPage > 1) {
          paginationHtml +=
            '<button class="btn btn-sm btn-outline-secondary" data-page="' +
            (currentPage - 1) +
            '">🡰</button>';
        }
        if (currentPage < totalPages) {
          paginationHtml +=
            '<button class="btn btn-sm btn-outline-secondary" data-page="' +
            (currentPage + 1) +
            '">🡲</button>';
        }
        $("#pagination").html(paginationHtml);
      },
      error: function () {
        alert("Error al cargar los productos");
      },
    });
  }

  loadProducts(currentPage);

  $("#pagination").on("click", "button", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    currentPage = page;
    loadProducts(page);
  });

  //Guardar (Crear-Editar)
  $("#formularioProducto").on("submit", function (e) {
    e.preventDefault();
    var sku = $("#productoSku").val();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var valor = $("#valor").val();

    //Validar con regex
    var regex = /^\d+(\.\d+)?$/;

    if (regex.test(valor)) {
      var formData = new FormData();
      formData.append("sku", sku);
      formData.append("nombre", nombre);
      formData.append("descripcion", descripcion);
      formData.append("valor", valor);
      formData.append("tienda", tienda);
      formData.append("imagen", $("#imagen")[0].files[0]);

      $.ajax({
        url: "../controllers/ProductController.php?action=saveProduct",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $("#crearModal").modal("hide");
          $("#formularioProducto")[0].reset();
          currentPage = 1;
          loadProducts(currentPage);
        },
        error: function () {
          alert("Error al crear producto.");
        },
      });
    } else {
      alert("El valor debe ser un número válido.");
    }
  });

  //Renombrar para crear
  $(document).on("click", ".crearBtn", function () {
    $("#crearModalLabel").text("Crear Producto");
    $("#productoSku").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#valor").val("");
    $("#imagen").val("");
    $("#crearModal").modal("show");
  });

  //Editar
  $(document).on("click", ".editarBtn", function () {
    var sku = $(this).data("sku");
    $.ajax({
      url: "../controllers/ProductController.php?action=getProduct",
      method: "GET",
      data: {
        sku: sku,
      },
      dataType: "json",
      success: function (response) {
        $("#crearModalLabel").text("Editar Producto");
        $("#nombre").val(response.nombre);
        $("#productoSku").val(response.sku);
        $("#descripcion").val(response.descripcion);
        $("#valor").val(response.valor);
        $("#imagen").val("");
        $("#crearModal").modal("show");
        currentPage = 1;
        loadProducts(currentPage);
      },
    });
  });

  //Eliminar
  $(document).on("click", ".eliminarBtn", function () {
    if (confirm("¿Estás seguro de eliminar este producto?")) {
      var sku = $(this).data("sku");
      $.ajax({
        url: "../controllers/ProductController.php?action=deleteProduct",
        method: "POST",
        data: {
          sku: sku,
        },
        success: function (response) {
          currentPage = 1;
          loadProducts(currentPage);
        },
      });
    }
  });
});
