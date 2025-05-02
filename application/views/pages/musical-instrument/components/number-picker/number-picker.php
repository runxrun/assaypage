<div class="d-flex align-items-center">
  <button class="btn btn-secondary rounded-circle fs-8 p-0" style="min-width: 28px; height: 28px;" type="button" id="button-minus">-</button>
  <div class="px-2 w-100">
    <input type="number" class="form-control rounded-pill h-100 px-2 fs-8 fw-bold text-dark text-center" id="input-number" value="1" min="1" readonly="">
  </div>
  <button class="btn btn-secondary rounded-circle fs-8 p-0" style="min-width: 28px; height: 28px;" type="button" id="button-plus">+</button>
</div>

<script type="text/javascript">
  document.getElementById('button-minus').addEventListener('click', function() {
    var input = document.getElementById('input-number');
    var value = parseInt(input.value, 10);
    if (value > 1) {
      input.value = value - 1;
    }
  });

  document.getElementById('button-plus').addEventListener('click', function() {
    var input = document.getElementById('input-number');
    var value = parseInt(input.value, 10);
    if (value < 10) {
      input.value = value + 1;
    }
  });
</script>