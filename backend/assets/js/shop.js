$(document).ready(function () {
  var currentPage = 1;
  var limit = 5;

  //Mostar en tabla (paginado)
  function loadShops(page) {
    $.ajax({
      url: "../controllers/ShopController.php?action=getShopsByPage",
      type: "GET",
      data: {
        page: page,
        limit: limit,
      },
      dataType: "json",
      success: function (response) {
        //Cargar datos
        var shops = response.data;
        var html = "";
        for (var i = 0; i < shops.length; i++) {
          var tienda = shops[i];
          html += "<tr>";
          html += '<td class="align-middle">' + tienda.id + "</td>";
          html += '<td class="align-middle">' + tienda.nombre + "</td>";
          html += '<td class="align-middle">' + tienda.fecha_apertura + "</td>";
          html += '<td class="align-middle">';
          html +=
            '<span class="btn btn-warning editarBtn" data-id="' +
            tienda.id +
            '"><i class="bi bi-pencil-fill"></i></span>';
          html +=
            '<span class="mx-1 btn btn-danger eliminarBtn" data-id="' +
            tienda.id +
            '"><i class="bi bi-trash-fill"></i></span>';
          html += '</td class="align-middle">';
          html += "<td>";
          html +=
            '<a class="btn btn-info productosBtn" href="products_view.php?shop_id=' +
            encodeURIComponent(tienda.id) +
            "&shop_name=" +
            encodeURIComponent(tienda.nombre) +
            '"><i class="bi bi-search"></i> Ver productos</a>';
          html += "</td>";
          html += "</tr>";
        }
        $("#listaTiendas").html(html);

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
        alert("Error al cargar las tiendas");
      },
    });
  }

  loadShops(currentPage);

  $("#pagination").on("click", "button", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    currentPage = page;
    loadShops(page);
  });

  //Guardar (Crear-Editar)
  $("#formularioTienda").on("submit", function (e) {
    e.preventDefault();
    var id = $("#tiendaId").val();
    var nombre = $("#nombre").val();
    var fechaApertura = $("#fechaApertura").val();
    //Validar con regex
    var regex = /^(\d{4})-(\d{2})-(\d{2})$/;
    if (regex.test(fechaApertura)) {
      fechaApertura = fechaApertura.replace(regex, "$3-$2-$1");
    }
    $.ajax({
      url: "../controllers/ShopController.php?action=saveShop",
      method: "POST",
      data: {
        id: id,
        nombre: nombre,
        fechaApertura: fechaApertura,
      },
      success: function (response) {
        $("#crearModal").modal("hide");
        $("#formularioTienda")[0].reset();
        currentPage = 1;
        loadShops(currentPage);
      },
    });
  });

  //Renombrar para crear
  $(document).on("click", ".crearBtn", function () {
    $("#crearModalLabel").text("Crear Tienda");
    $("#tiendaId").val("");
    $("#nombre").val("");
    $("#fechaApertura").val("");
    $("#crearModal").modal("show");
  });

  //Editar
  $(document).on("click", ".editarBtn", function () {
    var id = $(this).data("id");
    $.ajax({
      url: "../controllers/ShopController.php?action=getShop",
      method: "GET",
      data: {
        id: id,
      },
      dataType: "json",
      success: function (response) {
        $("#crearModalLabel").text("Editar Tienda");
        $("#tiendaId").val(response.id);
        $("#nombre").val(response.nombre);
        //Validar con regex
        var fecha_apertura;
        var regex = /^(\d{2})-(\d{2})-(\d{4})$/;
        if (regex.test(response.fecha_apertura)) {
          fecha_apertura = response.fecha_apertura.replace(regex, "$3-$2-$1");
        }
        $("#fechaApertura").val(fecha_apertura);
        $("#crearModal").modal("show");
        currentPage = 1;
        loadShops(currentPage);
      },
    });
  });

  //Eliminar
  $(document).on("click", ".eliminarBtn", function () {
    if (confirm("¿Estás seguro de eliminar esta tienda?")) {
      var id = $(this).data("id");
      $.ajax({
        url: "../controllers/ShopController.php?action=deleteShop",
        method: "POST",
        data: {
          id: id,
        },
        success: function (response) {
          currentPage = 1;
          loadShops(currentPage);
        },
      });
    }
  });
});
