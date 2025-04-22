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
            Menu Swipe
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .menu-container {
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
    font-size: 0.9rem;
  }

  .menu {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 0rem 0.5rem;
    scrollbar-width: none;
    /* Firefox */
  }

  .menu::-webkit-scrollbar {
    display: none;
    /* Chrome, Safari */
  }

  .menu-item {
    flex: 0 0 auto;
    padding: 8px 20px;
    margin: 0 0.25rem;
    background-color: #f0f0f0;
    border-radius: 0.25rem;
    cursor: pointer;
    white-space: nowrap;
  }

  .nav-btn {
    background: rgb(2, 130, 214);
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 0.25rem;
    cursor: pointer;
  }

  .nav-btn:hover {
    background-color: #555;
  }
</style>


<div class="container py-4">
  <div class="menu-container">
    <button class="nav-btn me-2" id="prevBtn">Prev</button>
    <div class="menu" id="menu">
      <div class="menu-item">Menu-A</div>
      <div class="menu-item">Menu-B</div>
      <div class="menu-item">Menu-C</div>
      <div class="menu-item">Menu-D</div>
      <div class="menu-item">Menu-E</div>
      <div class="menu-item">Menu-F</div>
      <div class="menu-item">Menu-G</div>
      <div class="menu-item">Menu-H</div>
      <div class="menu-item">Menu-I</div>
      <div class="menu-item">Menu-J</div>
      <div class="menu-item">Menu-K</div>
      <div class="menu-item">Menu-L</div>
      <div class="menu-item">Menu-M</div>
      <div class="menu-item">Menu-N</div>
      <div class="menu-item">Menu-O</div>
      <div class="menu-item">Menu-P</div>
      <div class="menu-item">Menu-Q</div>
      <div class="menu-item">Menu-R</div>
      <div class="menu-item">Menu-S</div>
      <div class="menu-item">Menu-T</div>
      <div class="menu-item">Menu-U</div>
      <div class="menu-item">Menu-V</div>
      <div class="menu-item">Menu-W</div>
      <div class="menu-item">Menu-X</div>
      <div class="menu-item">Menu-Y</div>
      <div class="menu-item">Menu-Z</div>
    </div>
    <button class="nav-btn ms-2" id="nextBtn">Next</button>
  </div>
</div>
<script>
  let isDown = false;
  let startX;
  let scrollLeft;

  const menu = document.getElementById('menu');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');

  // Mouse drag support
  menu.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - menu.offsetLeft;
    scrollLeft = menu.scrollLeft;
    menu.classList.add('no-select'); // Prevent text selection
    e.preventDefault(); // Prevent default behavior to avoid text selection
  });

  menu.addEventListener('mouseleave', () => {
    isDown = false;
    menu.classList.remove('no-select'); // Re-enable text selection
  });

  menu.addEventListener('mouseup', () => {
    isDown = false;
    menu.classList.remove('no-select'); // Re-enable text selection
  });

  menu.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    const x = e.pageX - menu.offsetLeft;
    const walk = x - startX;
    menu.scrollLeft = scrollLeft - walk; // Sticky follow mouse move
    e.preventDefault(); // Prevent default behavior to avoid text selection
  });

  // Button click support
  nextBtn.addEventListener('click', () => {
    menu.scrollBy({
      left: 400,
      behavior: 'smooth'
    });
  });

  prevBtn.addEventListener('click', () => {
    menu.scrollBy({
      left: -400,
      behavior: 'smooth'
    });
  });

  // Add CSS to prevent text selection
  const style = document.createElement('style');
  style.textContent = `
    .no-select {
      -webkit-user-select: none; /* For Safari */
      -ms-user-select: none; /* For IE/Edge */
    }
  `;
  document.head.appendChild(style);
</script>