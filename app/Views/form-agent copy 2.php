<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<main class="main-content  mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column mx-auto">
            <div class="card card-plain mt-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 bg-image-repeat">
                    <div class="text-center">
                      <img src="<?= base_url()?>/public/assets/img/logo.svg" alt="" class="img-fluid mb-0" width="100%">
                      <!-- <div class="d-none d-md-block d-lg-block">
                        <img src="<?= base_url()?>/public/assets/img/logo.svg" alt="" class="img-fluid mb-0" width="100%">
                        <img src="<?= base_url()?>/public/assets/img/logo.svg" alt="" class="img-fluid mb-0" width="100%">
                        <img src="<?= base_url()?>/public/assets/img/logo.svg" alt="" class="img-fluid mb-0" width="100%">
                      </div> -->
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-8">
                    <h3 class="font-weight-bolder text-dark text-gradient"><?= $title ?></h3>
                    <div id="message-success" class="alert alert-info bg-gold-custom" style="background-image: none; display: none; white-space: pre-line;" role="alert">
                      <?= $message['setting_value'];?>
                    </div>
                    <form id="form-registrasi">
                      <input type="hidden" name="pk_id_agent" id="pk_id_agent" value="<?= (isset($agent['pk_id_agent']) ? $agent['pk_id_agent'] : NULL)?>?>">
          
                      <div class="row d-flex justify-content-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
                          <img alt="Image placeholder" src="<?= base_url()?>/public/assets/myimg/gold.jpg" class="img-fluid border-radius-lg shadow-lg">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-3">
                          <img alt="Image placeholder" src="<?= base_url()?>/public/assets/myimg/silver.jpg" class="img-fluid border-radius-lg shadow-lg">
                        </div>
                      </div>
          
                      <p>
                        Kapan lagi bisa mendapatkan ilmu selengkap ini, tergabung di beberapa travel pilihan/ tidak hanya satu travel, dan bisa langsung jadi Agent juga.
                      </p>
                      <p>
                        Yang Anda Dapatkan:
                      </p>
                      
                      <p>&#x2705; Menjadi Agent Umroh dan Haji di beberapa travel</p>
                      <p>&#x2705; Bimbingan dari pemula dan gaptek</p>
                      <p>&#x2705; Tersedia grup whatsapp exclusive bersama mentor</p>
                      <p>&#x2705; Materi pengembangan diri</p>
                      <p>&#x2705; Materi Facebook Ads Basic dan Advance (Paket Gold)</p>
                      <p>&#x2705; Materi Website SEO (Paket Gold)</p>
                      <p>&#x2705; Materi Google Ads (Paket Gold)</p>
                      <p>&#x2705; Materi Landingpage (Paket Gold)</p>
                      <p>&#x2705; Mendapatkan Landinpage Untuk Jualan</p>
                      <p>&#x2705; Mendapatkan Tools Marketing Untuk Jualan</p>
                      <p>&#x2705; Disediakan Audio Hipnoterapi Untuk Sukses</p>
                      <p>&#x2705; Affiliate Kelas-Kelas Mentoring Umroh (Komisi 50%)</p>
                      <p>&#x2705; Bisa Hanya Belajar Tanpa Harus Jadi Agent</p>
          
                      <div class="col-12 mb-3">
                        <label for="tipe_agent">Paket Pilihan Anda</label>
                        <select name="tipe_agent" id="tipe_agent" class="multisteps-form__input form-control">
                          <option value="">Pilih Paket</option>
                          <option value="silver">Silver</option>
                          <option value="gold">Gold</option>
                        </select>
                        <div class="invalid-feedback" data-id="tipe_agent"></div>
                      </div>
          
                      <div class="col-12 mb-3">
                          <label>Nama Anda <span class="text-danger">*</span></label>
                          <input name="nama_agent" id="nama_agent" class="multisteps-form__input form-control" placeholder="Nama Anda">
                          <div class="invalid-feedback" data-id="nama_agent"></div>
                      </div>
              
                      <div class="col-12 mb-3">
                          <label>No WA <span class="text-danger">*</span></label>
                          <input name="no_wa" id="no_wa" class="multisteps-form__input form-control" placeholder="No WA">
                          <small class="text-xxs text-danger">* Harap mengisi nomor whatsapp dengan kode negara, contoh : 6281xxxxx</small>
                          <div class="invalid-feedback" data-id="no_wa"></div>
                      </div>
              
                      <div class="col-12 mb-3">
                          <label>Email <span class="text-danger">*</span></label>
                          <input name="email" id="email" class="multisteps-form__input form-control" placeholder="Email">
                          <div class="invalid-feedback" data-id="email"></div>
                      </div>
          
                      <div class="d-flex justify-content-end">
                          <button type="button" class="btn bg-gold-custom" id="btnSimpan">Simpan</button>
                          <button class="btn bg-gold-custom text-light" id="btnLoading" type="button" disabled style="display:none">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">Loading...</span>
                          </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?= $this->endSection() ?>

<?= $this->section('js-script') ?>
<script>
  // kumpulan function

  document.addEventListener('DOMContentLoaded', () => {
    // showListProvinsi();
    showAllKota();

    $("#message-success").hide();
    $("#form-registrasi").show();
    
    $('#no_wa').on('keyup', function() {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#btnSimpan").click(function(){
        tambahData();

        $("#btnSimpan").hide();
        $("#btnLoading").show();
    })

  })

  function tambahData() {
    let form = '#form-registrasi'

    let pk_id_agent = $(`${form} #pk_id_agent`).val();
    let nama_agent = $(`${form} #nama_agent`).val();
    let tipe_agent = $(`${form} #tipe_agent`).val();
    let no_wa = $(`${form} #no_wa`).val();
    let email = $(`${form} #email`).val();

    let data = {
      'pk_id_agent' : pk_id_agent,
      'nama_agent' : nama_agent,
      'tipe_agent' : tipe_agent,
      'no_wa' : no_wa,
      'email' : email,
    };

    $.ajax({
      url: "<?= base_url()?>/registrasi/saveAgent",
      type: "POST",
      data: data,
      dataType: "json",
      success: function(response) {
        if(response.error){
          bersihkanValidasi(`${form}`);

          let errorMessage = '';
          for (var key in response.error) {
              var error = response.error[key];
              $(`[name='${key}']`).addClass("is-invalid")
              $(`[data-id='${key}']`).show()
              $(`[data-id='${key}']`).text(error)
          }

          $("#btnSimpan").show();
          $("#btnLoading").hide();

          showFormError();
  
        } else {
          // Toast.fire({
          //     icon: response.status,
          //     title: response.message
          // })

          $("#message-success").show();
          $("#form-registrasi").hide();
        }
        
      },
      error: function(xhr, status, error) {
        Toast.fire({
            icon: 'error',
            title: `terjadi kesalahan: ${error}`
        })
      }
    });
  }
</script>
<?= $this->endSection() ?>
