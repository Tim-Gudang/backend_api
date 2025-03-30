   <!-- Footer -->
   <div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <span>&copy; 2025 <a
                href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328">Gudang TSTH2</a></span>
    </div>
</div>
<!-- /footer -->

   <!-- /demo config -->

</body>
<script>
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });

    scanner.addListener('scan', function(content) {
        document.getElementById('qrcode-result').value = content;
        alert("QR Code Terdeteksi: " + content);
    });

    document.getElementById('scan-btn').addEventListener('click', function() {
        document.getElementById('scanner-container').style.display = 'flex';

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]); // Gunakan kamera pertama
            } else {
                alert('Tidak ada kamera yang ditemukan.');
            }
        }).catch(function(e) {
            console.error(e);
        });
    });

    document.getElementById('close-btn').addEventListener('click', function() {
        document.getElementById('scanner-container').style.display = 'none';
        scanner.stop(); // Matikan kamera saat ditutup
    });
</script>


</html>
