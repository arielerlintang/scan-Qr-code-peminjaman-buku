<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Form </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Form </li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- <style>
    #video-container {
      position: relative;
      width: 100%;
      margin: 20px auto;
    }
    #video {
      width: 100%;
      max-width: 600px;
      height: auto;
      border: 2px solid #333;
      border-radius: 8px;
    }
    #scanButton {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      font-size: 18px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    #result {
      margin-top: 20px;
      font-size: 18px;
    }
  </style> -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-12">
          <div class="row">
            <div class="col-md-4 offset-md-4 col-12">
              <div id="video-container" class="card">
                <video id="video"></video>
              </div>
            </div>
          </div>
          <!-- Horizontal Form -->
          <div class="card card-info">
            <!-- /.card-header -->
            <!-- form start -->
            <form id="scanForm" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="card">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode Panggil</label>
                    <div class="col-sm-9">
                      <input type="text" id="kode_panggil" name="kode_panggil" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="button" id="scanButton" class="btn btn-outline-primary">Scan QR Code</button>
                  <button type="submit" class="btn btn-outline-primary">Simpan</button>
                  <a href="<?php echo base_url("index.php/admin/buku"); ?>" class="btn btn-outline-secondary">Kembali</a>
                </div>
              </div>
            </form>
          </div>


          <!-- /.card -->

          

        </div>
        <!--/.col (left) -->

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
<!--  Memuat library jsQR dari CDN, yang digunakan untuk memproses gambar dan mendeteksi QR code.  -->

<script>
  const video = document.getElementById('video');
  const scanButton = document.getElementById('scanButton');
  const kodePanggilInput = document.getElementById('kode_panggil');

  // Mengambil elemen-elemen HTML yang akan digunakan dalam skrip:

//video: Elemen video untuk menampilkan umpan kamera.
//scanButton: Tombol untuk memulai pemindaian QR Code.
//kodePanggilInput: Input text untuk menampilkan hasil pemindaian QR Code

  scanButton.addEventListener('click', async () => {
    // Menambahkan event listener pada tombol scan untuk menjalankan fungsi pemindaian saat tombol ditekan.
    try {
      // Mengakses kamera perangkat menggunakan API getUserMedia dengan opsi facingMode: 'environment' untuk menggunakan kamera belakang (biasanya pada perangkat mobile).
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
      video.srcObject = stream;
      await video.play();

      // Membuat elemen canvas dan mengatur ukurannya sesuai dengan ukuran video untuk menangkap gambar dari umpan video.
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      // Fungsi scan melakukan hal berikut:
//Mengambil gambar dari elemen video dan menggambarnya di canvas.
//Mengambil data gambar dari canvas dan menggunakannya untuk mendeteksi QR code menggunakan jsQR.
//Jika QR code terdeteksi, nilai dari QR code dimasukkan ke dalam input text kode_panggil dan kamera dihentikan.
//Jika tidak terdeteksi, fungsi scan dipanggil kembali pada frame berikutnya menggunakan requestAnimationFrame.
      const scan = () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);
        if (code) {
          kodePanggilInput.value = code.data; // Isi nilai QR code ke input field
          video.srcObject.getTracks().forEach(track => track.stop()); // Hentikan pengambilan gambar dari kamera
        } else {
          requestAnimationFrame(scan);
        }
      };

      requestAnimationFrame(scan);
    } 
    //  Menangkap dan mencetak kesalahan jika terjadi masalah saat mengakses kamera
    catch (error) {
      console.error('Error accessing camera:', error);
    }
  });
</script>

<!--
  Intisari
HTML:

Struktur Halaman: Terdiri dari header, breadcrumb, dan form untuk input data.
Video Container: Tempat untuk menampilkan video dari kamera.
Form: Input text untuk hasil pemindaian QR code dan tombol untuk memulai scan serta menyimpan data.

JavaScript:

Library jsQR: Digunakan untuk mendeteksi dan membaca QR code dari gambar.
Event Listener: Menggunakan tombol untuk memulai proses pemindaian QR code.
API getUserMedia: Mengakses kamera perangkat untuk menangkap umpan video.
Canvas: Menangkap gambar dari video dan memprosesnya untuk mendeteksi QR code.
Fungsi scan: Melakukan pemindaian QR code secara berulang hingga kode terdeteksi atau proses dihentikan.
Skrip ini memungkinkan pengguna untuk memindai QR code menggunakan kamera perangkat mereka dan memasukkan hasilnya ke dalam input form secara otomatis.
-->



