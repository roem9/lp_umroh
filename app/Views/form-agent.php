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
                      <?= $message;?>
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
          
                      <input type="hidden" name="fk_id_agent" id="fk_id_agent" value="<?= $agent['pk_id_agent']?>">
                      <input type="hidden" name="fk_id_produk" id="fk_id_produk" value="<?= (!empty($produk['pk_id_produk']) ? $produk['pk_id_produk'] : $produk['pk_id_produk_travel'])?>">
                      <input type="hidden" name="jenis_produk" id="jenis_produk" value="<?= (!empty($produk['pk_id_produk']) ? 'produk' : 'travel')?>">
                      <div class="col-12 mb-3">
                          <label>Nama Agent <span class="text-danger">*</span></label>
                          <input name="nama_agent" id="nama_agent" class="multisteps-form__input form-control" placeholder="Nama Agent" value="<?= $agent['nama_agent']?>" disabled>
                      </div>
                      <div class="col-12 mb-3">
                          <label>Nama Produk <span class="text-danger">*</span></label>
                          <input name="nama_produk" id="nama_produk" class="multisteps-form__input form-control" placeholder="Nama Produk" value="<?= $produk['nama_produk']?>" disabled>
                          <div class="invalid-feedback" data-id="nama_produk"></div>
                      </div>

                      <div class="col-12 mb-3">
                          <label>Nama Customer <span class="text-danger">*</span></label>
                          <input name="nama_customer" id="nama_customer" class="multisteps-form__input form-control" placeholder="Nama Customer">
                          <div class="invalid-feedback" data-id="nama_customer"></div>
                      </div>
              
                      <div class="col-12 mb-3">
                          <label>No WA <span class="text-danger">*</span></label>
                          <input name="no_wa" id="no_wa" class="multisteps-form__input form-control" placeholder="No WA">
                          <small class="text-xxs text-danger">* Harap mengisi nomor whatsapp dengan kode negara, contoh : 6281xxxxx</small>
                          <div class="invalid-feedback" data-id="no_wa"></div>
                      </div>
              
                      <!-- <div class="col-12 mb-3">
                          <label>Alamat</label>
                          <textarea name="alamat" id="alamat" class="multisteps-form__input form-control" placeholder="Alamat"></textarea>
                          <div class="invalid-feedback" data-id="alamat"></div>
                      </div> -->
              
                      <!-- <div class="col-12 mb-3">
                          <label>Provinsi</label>
                          <input class="form-control" list="listprovinsi" name="provinsi" id="provinsi" placeholder="Ketik untuk mencari..." autocomplete="off">
                          <datalist id="listprovinsi">
                          </datalist>
                          <div class="invalid-feedback" data-id="provinsi"></div>
                      </div> -->
                      <div class="col-12 mb-3">
                          <label>Domisili</label>
                          <input class="form-control" list="listkota_kabupaten" name="kota_kabupaten" id="kota_kabupaten" placeholder="Ketik untuk mencari..." autocomplete="off">
                          <datalist id="listkota_kabupaten">
                          </datalist>
                          <div class="invalid-feedback" data-id="kota_kabupaten"></div>
                      </div>
                      <!-- <div class="col-12 mb-3">
                          <label>Kecamatan</label>
                          <input class="form-control" list="listkecamatan" name="kecamatan" id="kecamatan" placeholder="Ketik untuk mencari..." autocomplete="off">
                          <datalist id="listkecamatan">
                          </datalist>
                          <div class="invalid-feedback" data-id="kecamatan"></div>
                      </div> -->
                      <!-- <div class="col-12 mb-3">
                          <label>Kelurahan/Desa</label>
                          <input class="form-control" list="listkelurahan" name="kelurahan" id="kelurahan" placeholder="Ketik untuk mencari..." autocomplete="off">
                          <datalist id="listkelurahan">
                          </datalist>
                          <div class="invalid-feedback" data-id="kelurahan"></div>
                      </div> -->
              
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

    let nama_customer = $(`${form} #nama_customer`).val();
    let no_wa = $(`${form} #no_wa`).val();
    // let alamat = $(`${form} #alamat`).val();
    // let kelurahan = $(`${form} #kelurahan`).val();
    // let kecamatan = $(`${form} #kecamatan`).val();
    let kota_kabupaten = $(`${form} #kota_kabupaten`).val();
    // let provinsi = $(`${form} #provinsi`).val();
    let email = $(`${form} #email`).val();
    let fk_id_agent = $(`${form} #fk_id_agent`).val();
    let fk_id_produk = $(`${form} #fk_id_produk`).val();
    let jenis_produk = $(`${form} #jenis_produk`).val();
    let tipe_agent = $(`${form} #tipe_agent`).val();

    let data = {
      'nama_customer' : nama_customer,
      'no_wa' : no_wa,
      // 'alamat' : alamat,
      // 'kelurahan' : kelurahan,
      // 'kecamatan' : kecamatan,
      'kota_kabupaten' : kota_kabupaten,
      // 'provinsi' : provinsi,
      'email' : email,
      'fk_id_agent' : fk_id_agent,
      'fk_id_produk' : fk_id_produk,
      'jenis_produk' : jenis_produk,
      'tipe_agent' : tipe_agent,
    };

    $.ajax({
      url: "<?= base_url()?>/registrasi/save",
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

          showFormError()
          
          $("#btnSimpan").show();
          $("#btnLoading").hide();
  
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

        
        $("#btnSimpan").show();
        $("#btnLoading").hide();
      }
    });
  }
</script>
<?= $this->endSection() ?>
