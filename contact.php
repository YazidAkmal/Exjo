<?php
include 'init.php';
include 'header.php';
?>

<div class="bradcam_area bradcam_bg_4">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Kontak</h3>
                    <p>Hubungi kami di kontak dibawah ini</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="d-none d-sm-block mb-5 pb-4">
            <div class="map-wrapper">
                <div class="embed-map-fixed">
                    <div class="embed-map-container">
                        <iframe class="embed-map-frame" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?q=Universitas%20Amikom%20Yogyakarta&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Kirim kami pesan</h2>
            </div>
            <div class="col-lg-8">
                <form action="contact_process.php" method="post" class="form-contact contact_form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                    placeholder="Masukkan Pesan" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="name" id="name" type="text" placeholder="Nama Anda"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="email" id="email" type="email"
                                    placeholder="Email Anda" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text" placeholder="Subjek"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm boxed-btn">Kirim</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>Daerah Istimewa Yogyakarta 55281</h3>
                        <p>Jl. Ring Road Utara, Ngringin, Condongcatur, Kec. Depok, Kab. Sleman</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>+62 0000 1111 123</h3>
                        <p>Sen s.d Sab, 09:00 - 18:00</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3>exjoyk@gmail.com</h3>
                        <p>Hubungi kami kapan saja!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            const status = urlParams.get('status');
            const brandColor = '#1EC6B6';

            if (status === 'sukses') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Terkirim!',
                    text: 'Terima kasih telah menghubungi kami. Kami akan segera merespon pesan Anda.',
                    confirmButtonColor: brandColor
                });
            } else {
                const error = urlParams.get('error') || 'Terjadi kesalahan, silakan coba lagi.';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops... Gagal Terkirim',
                    text: decodeURIComponent(error.replace(/\+/g, ' ')),
                    confirmButtonColor: brandColor
                });
            }
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>