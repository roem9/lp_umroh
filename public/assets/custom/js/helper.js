function bersihkanForm(form) {
  $(form)
    .find(
      "input[type=hidden], input[type=text], input[type=date], input[type=file], textarea, select"
    )
    .val("");
}

function bersihkanValidasi(form) {
  $(form + " .invalid-feedback").hide();

  // remove invalid form
  $(form + " .is-invalid").removeClass("is-invalid");

  $(form + " .alert-error").hide();
}

function bersihkanCardSelection(form) {
  $(form + " .card-select").removeClass("bg-light");
}

function initializeCardSelection(cardSelector, inputSelector) {
  $(document).on("click", cardSelector, function () {
    // Remove selected class from all cards in the same group
    $(cardSelector).removeClass("bg-light");

    // Add selected class to the clicked card
    $(this).addClass("bg-light");

    // Get the value from data attribute
    var value = $(this).data("value");

    // Set the value to the hidden input
    $(inputSelector).val(value);
  });
}

function showFormError() {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "lengkapi form terlebih dahulu",
  });
}

function formatRupiah(angka) {
  var rupiah = "";
  var angka_rev = angka.toString().split("").reverse().join("");
  for (var i = 0; i < angka_rev.length; i++) {
    if (i % 3 == 0) {
      rupiah += ".";
    }
    rupiah += angka_rev.substr(i, 1);
  }
  return "Rp. " + rupiah.split("").reverse().join("");
}
