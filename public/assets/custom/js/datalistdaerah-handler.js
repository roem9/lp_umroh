$(document).ready(function () {
  $("[name='provinsi']").on("input", function () {
    $("#listkota_kabupaten").empty(); // Clear previous options
    $("#listkecamatan").empty(); // Clear previous options
    $("#listkelurahan").empty(); // Clear previous options

    $("#kota_kabupaten").val("");
    $("#kecamatan").val("");
    $("#kelurahan").val("");
    showListKota();
  });

  $("[name='kota_kabupaten']").on("input", function () {
    $("#listkecamatan").empty(); // Clear previous options
    $("#listkelurahan").empty(); // Clear previous options

    $("#kecamatan").val("");
    $("#kelurahan").val("");
    showListKecamatan();
  });

  $("[name='kecamatan']").on("input", function () {
    $("#listkelurahan").empty(); // Clear previous options

    $("#kelurahan").val("");
    showListKelurahan();
  });
});

function showListProvinsi() {
  $.ajax({
    url: `${appBaseURL}/daerah/getProvinsi`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      let html = ``;
      response.forEach((response) => {
        html += `<option value="${response.provinsi}">`;
      });

      $("#listprovinsi").html(html);
    },
    error: function (xhr, status, error) {
      Toast.fire({
        icon: "error",
        title: `terjadi kesalahan: ${error}`,
      });
    },
  });

  // listkota_kabupaten
}

function showAllKota() {
  $.ajax({
    url: `${appBaseURL}/daerah/getKota`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      let html = ``;
      response.forEach((response) => {
        html += `<option value="${response.kota_kabupaten}">`;
      });

      $("#listkota_kabupaten").html(html);
    },
    error: function (xhr, status, error) {
      Toast.fire({
        icon: "error",
        title: `terjadi kesalahan: ${error}`,
      });
    },
  });

  // listkota_kabupaten
}

function showListKota() {
  let tipe_daerah = "provinsi";
  let nama_daerah = $("[name='provinsi']").val();
  let group_daerah = "kota_kabupaten";

  $.ajax({
    url: `${appBaseURL}/daerah/getDaerah`,
    type: "POST",
    data: {
      tipe_daerah: tipe_daerah,
      nama_daerah: nama_daerah,
      group_daerah: group_daerah,
    },
    dataType: "json",
    success: function (response) {
      let html = ``;
      response.forEach((response) => {
        html += `<option value="${response.kota_kabupaten}">`;
      });

      $("#listkota_kabupaten").html(html);
    },
    error: function (xhr, status, error) {
      Toast.fire({
        icon: "error",
        title: `terjadi kesalahan: ${error}`,
      });
    },
  });

  // listkota_kabupaten
}

function showListKecamatan() {
  let tipe_daerah = "kota_kabupaten";
  let nama_daerah = $("[name='kota_kabupaten']").val();
  let group_daerah = "kecamatan";

  $.ajax({
    url: `${appBaseURL}/daerah/getDaerah`,
    type: "POST",
    data: {
      tipe_daerah: tipe_daerah,
      nama_daerah: nama_daerah,
      group_daerah: group_daerah,
    },
    dataType: "json",
    success: function (response) {
      let html = ``;
      response.forEach((response) => {
        html += `<option value="${response.kecamatan}">`;
      });

      $("#listkecamatan").html(html);
    },
    error: function (xhr, status, error) {
      Toast.fire({
        icon: "error",
        title: `terjadi kesalahan: ${error}`,
      });
    },
  });

  // listkota_kabupaten
}

function showListKelurahan() {
  let tipe_daerah = "kecamatan";
  let nama_daerah = $("[name='kecamatan']").val();
  let group_daerah = "kelurahan";

  $.ajax({
    url: `${appBaseURL}/daerah/getDaerah`,
    type: "POST",
    data: {
      tipe_daerah: tipe_daerah,
      nama_daerah: nama_daerah,
      group_daerah: group_daerah,
    },
    dataType: "json",
    success: function (response) {
      let html = ``;
      response.forEach((response) => {
        html += `<option value="${response.kelurahan}">`;
      });

      $("#listkelurahan").html(html);
    },
    error: function (xhr, status, error) {
      Toast.fire({
        icon: "error",
        title: `terjadi kesalahan: ${error}`,
      });
    },
  });

  // listkota_kabupaten
}
