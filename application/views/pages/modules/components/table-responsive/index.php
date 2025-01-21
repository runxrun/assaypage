<link rel="stylesheet" href="/application/views/pages/modules/components/table-responsive/custom-style.css">
<div class="py-2">
  <div class="container">
    <div class="py-4">
      <div class="row g-3">
        <div class="col-auto">
          <a href="/modules/" class="text-white text-decoration-none">
            <div class="d-flex">
              <div class="pe-2 fs-7"><i class="fas fa-arrow-left"></i></div>
              <div class="pe-0 fs-7">Module</div>
            </div>
          </a>
        </div>
        <div class="col-auto">
          <div class="text-white fs-7">
            |
          </div>
        </div>
        <div class="col-auto">
          <div class="text-white fs-7">
            Table Responsive
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container py-4">

  <div class="pb-4">
    <div 
      class="p-0" 
      style="background-color: rgba(0,0,0,0.8); white-space: pre;">
      <code class="language-css">
        @media (max-width: 768px) {
          .responsive-table tr {
            display: block;
          }
          .responsive-table td {
            display: block;
            width: 100%;
          }
        }
      </code>
    </div>
  </div>

  <div class="pb-4 text-white">
    <table class="responsive-table w-100 border-0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" class="border border-light p-4">AAA</td>
        <td width="50%" class="border border-light p-4">BBB</td>
      </tr>
    </table>
  </div>
  <div class="pb-4 text-white">
    <table class="responsive-table w-100 border-0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" class="border border-light p-4">AAA</td>
        <td width="25%" class="border border-light p-4">BBB</td>
        <td width="25%" class="border border-light p-4">CCC</td>
      </tr>
    </table>
  </div>
  <div class="pb-4 text-white">
    <table class="responsive-table w-100 border-0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="25%" class="border border-light p-4">AAA</td>
        <td width="25%" class="border border-light p-4">BBB</td>
        <td width="25%" class="border border-light p-4">CCC</td>
        <td width="25%" class="border border-light p-4">DDD</td>
      </tr>
    </table>
  </div>
</div>