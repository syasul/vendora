<section class="cta-section my-5">
    <div class="container">
        <div class="cta-card p-5 rounded-4 position-relative overflow-hidden shadow-lg border-0 bg-gradient-premium">
            <!-- Decorative circles -->
            <div class="cta-circle circle-1"></div>
            <div class="cta-circle circle-2"></div>
            
            <div class="row align-items-center position-relative z-index-10 text-white">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <span class="badge bg-blur text-white px-3 py-2 mb-3 ft-12 text-uppercase tracking-wider">Penawaran Terbatas</span>
                    <h2 class="display-5 font-weight-bold mb-3 text-white">Temukan Koleksi Eksklusif Hari Ini!</h2>
                    <p class="lead mb-0 text-white-50">Dapatkan diskon hingga 50% untuk pembelian pertama Anda. Jelajahi ribuan produk berkualitas tinggi dari penjual terpercaya kami.</p>
                </div>
                <div class="col-lg-4 text-lg-right">
                    <a href="<?=$main_url;?>categories" class="btn btn-light btn-lg px-5 py-3 rounded-pill font-weight-bold shadow-sm transition-all hover-scale-up">
                        Mulai Belanja <i class="fa fa-arrow-right ml-2 text-primary"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-gradient-premium {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
    }
    .cta-card {
        position: relative;
        border-radius: 1.5rem !important;
    }
    .bg-blur {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .z-index-10 {
        z-index: 10;
    }
    .text-white-50 {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    .cta-circle {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
    }
    .circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -50px;
    }
    .circle-2 {
        width: 250px;
        height: 250px;
        bottom: -80px;
        left: -50px;
    }
    .hover-scale-up {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .hover-scale-up:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }
    .tracking-wider {
        letter-spacing: 0.1em;
    }
</style>
