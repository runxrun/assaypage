<div class="bg-footer">
  <div class="py-2" style="background-color: rgba(255,255,255,0.1);">
    <div class="text-center">
      <a
        href="javascript:void(0)"
        class="fs-7 text-white text-decoration-none"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
        Back to top
      </a>
    </div>
  </div>
  <div class="container">
    <div class="py-4">
      <div class="row g-3">
        <div class="col-12 col-lg-3">
          <?php
          $footerLinks = [
            ["name" => "About Us", "link" => "/musical-instrument/about-us"],
            ["name" => "Our Services", "link" => "/musical-instrument/our-services"],
            ["name" => "Return and Exchange Policy", "link" => "/musical-instrument/return-and-exchange-policy"],
            ["name" => "Cookies Policy", "link" => "/musical-instrument/cookies-policy"],
            ["name" => "Contact Us", "link" => "/musical-instrument/contact-us"],
          ];
          ?>
          <div class="row g-1 fs-7 text-light">
            <?php foreach ($footerLinks as $link) { ?>
              <div class="col-12">
                <a href="<?php echo $link['link']; ?>" class="text-light text-decoration-none">
                  <?php echo $link['name']; ?>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="pt-0 fs-7 text-light">
            <div class="pb-2 fw-bold">Branch Operating Hours</div>
            <div class="opacity-75">Monday-Friday</div>
            <div class="opacity-75">10.30-21.00</div>
            <div class="opacity-75">Saturday-Sunday and Public Holidays</div>
            <div class="opacity-75">10.00-21.00</div>
          </div>
          <div class="pt-3 fs-7 text-light">
            <div class="pb-2 fw-bold">Response Hours</div>
            <div class="opacity-75">Every day 9.00-24.00</div>
            <div class="opacity-75">Phone Number 082-331-3830</div>
          </div>
        </div>
        <div class="col-12 col-lg-3">
          <div class="pt-0 text-light">
            <div class="pb-0 fs-7 fw-bold">Social Media</div>
            <div class="row g-3 fs-3 text-light">
              <div class="col-auto">
                <div class="text-white">
                  <i class="fa-brands fa-square-facebook"></i>
                </div>
              </div>
              <div class="col-auto">
                <div class="text-white">
                  <i class="fa-brands fa-square-instagram"></i>
                </div>
              </div>
              <div class="col-auto">
                <div class="text-white">
                  <i class="fa-brands fa-square-x-twitter"></i>
                </div>
              </div>
              <div class="col-auto">
                <div class="text-white">
                  <i class="fa-brands fa-youtube"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr class="m-0 p-0 text-light opacity-25">
    <div class="pt-3 pb-4">
      <div class="fs-8 text-lg-end text-light">
        &copy; <?php echo date("Y"); ?>
        Musical Instrument Store.
        All rights reserved.
      </div>
    </div>
  </div>
</div>