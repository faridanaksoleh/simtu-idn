<!-- ======= Footer ======= -->
<footer id="footer" class="footer mt-auto py-4 bg-light border-top sticky-footer">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="copyright text-center text-md-start ps-4">
          &copy; Copyright <strong><span>SIMTU IDN</span></strong>. All Rights Reserved
        </div>
      </div>
      <div class="col-md-6">
        <div class="credits text-center text-md-end text-muted pe-4">
          Designed by faridz with ❤️
        </div>
      </div>
    </div>
  </div>
</footer><!-- End Footer -->

<style>
/* 🔥 PERBAIKAN: Sticky Footer */
.sticky-footer {
  position: sticky;
  bottom: 0;
  background: #f8f9fa !important;
  z-index: 100;
  margin-top: auto; /* Untuk push footer ke bawah */
}

/* 🔥 PERBAIKAN: Padding yang lebih longgar */
.footer {
  padding-top: 1rem !important; /* py-4 = 1.5rem atas bawah */
  padding-bottom: 1rem !important;
}

/* 🔥 PERBAIKAN: Padding kiri kanan untuk text */
.footer .copyright {
  padding-left: 1rem; /* ps-3 = 1rem kiri */
}

.footer .credits {
  padding-right: 1rem; /* pe-3 = 1rem kanan */
}

/* 🔥 PERBAIKAN: Pastikan body dan main layout proper */
body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

#main {
  flex: 1;
  padding-bottom: 20px; /* Space untuk footer */
}

/* 🔥 PERBAIKAN: Footer text styling */
.footer .copyright {
  font-size: 0.875rem;
  color: #6c757d;
}

.footer .credits {
  font-size: 0.875rem;
}

.footer .credits span {
  color: #dc3545;
}

/* 🔥 PERBAIKAN: Responsive padding untuk mobile */
@media (max-width: 768px) {
  .footer {
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
  }
  
  .footer .copyright,
  .footer .credits {
    text-align: center !important;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
}
</style>