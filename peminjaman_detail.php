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
<script>
  const video = document.getElementById('video');
  const scanButton = document.getElementById('scanButton');
  const kodePanggilInput = document.getElementById('kode_panggil');

  scanButton.addEventListener('click', async () => {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
      video.srcObject = stream;
      await video.play();

      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

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
    } catch (error) {
      console.error('Error accessing camera:', error);
    }
  });
</script>



