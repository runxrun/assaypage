<html>

<head>
  <title>Tools</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
  <div class="min-h-dvh bg-sky-900 text-white p-4">
    <div class="container mx-auto">
      <div class="grid grid-cols-12 gap-2">
        <?php
        $link = [
          'name' => 'TOOLS',
          'url' => './',
          'children' => [
            [
              'name' => 'Resize Image',
              'url' => 'resize-image/',
            ],
            [
              'name' => 'Rename Image',
              'url' => 'rename-image/',
            ],
            [
              'name' => 'Kliknbook Supplier Ref. Duplicate',
              'url' => 'kliknbook-supplier-ref-duplicate/',
            ],
            [
              'name' => 'Check Duplicate',
              'url' => 'check-duplicate/',
            ],
          ],
        ];

        echo "<div class='col-span-12 font-bold border border-white py-2 px-4'>" . $link['name'] . "</div>";
        foreach ($link['children'] as $child) {
          echo "<div class='col-span-2'>";
          echo "<div><a href='" . $child['url'] . "' class='block py-2 px-4 border border-white text-sm hover:bg-white/15 transition duration-200'>" . $child['name'] . "</a></div>";
          echo "</div>";
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>