<?php
header('Content-Type: text/html; charset=UTF-8');

$imagesDir = realpath(__DIR__ . '/../images');
if (!$imagesDir || !is_dir($imagesDir)) {
    $imagesDir = __DIR__ . '/../images';
    if (!file_exists($imagesDir)) {
        @mkdir($imagesDir, 0777, true);
    }
}

// AJAX API
if (isset($_GET['api']) || isset($_POST['api'])) {
    header('Content-Type: application/json');
    $action = $_REQUEST['action'] ?? '';

    if ($action === 'scan') {
        $findExt = trim($_POST['find_ext'] ?? '');
        $extList = [];
        if (!empty($findExt) && $findExt !== '*') {
            $parts = explode(',', strtolower($findExt));
            foreach ($parts as $p) {
                $p = trim($p, " .*\t\n\r");
                if ($p !== '') {
                    $extList[] = $p;
                    if ($p === 'jpg') $extList[] = 'jpeg';
                    if ($p === 'jpeg') $extList[] = 'jpg';
                }
            }
        }
        $extList = array_unique($extList);

        $files = [];
        if (is_dir($imagesDir)) {
            $scan = scandir($imagesDir);
            foreach ($scan as $file) {
                if ($file === '.' || $file === '..' || str_starts_with($file, '.')) continue;
                $fullPath = $imagesDir . '/' . $file;
                if (!is_file($fullPath)) continue;

                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!empty($extList) && !in_array($ext, $extList)) continue;
                if (empty($extList) && !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) continue;

                $size = filesize($fullPath);
                $dim = @getimagesize($fullPath);

                $files[] = [
                    'filename' => $file,
                    'basename' => pathinfo($file, PATHINFO_FILENAME),
                    'ext' => $ext,
                    'size' => $size,
                    'size_formatted' => formatBytes($size),
                    'width' => $dim ? $dim[0] : 0,
                    'height' => $dim ? $dim[1] : 0,
                ];
            }
            usort($files, function($a, $b) {
                return strnatcasecmp($a['filename'], $b['filename']);
            });
        }
        echo json_encode(['success' => true, 'files' => $files]);
        exit;
    }

    if ($action === 'clear_cache') {
        $thumbDir = $imagesDir . '/.thumb_cache';
        $deleted = 0;
        if (is_dir($thumbDir)) {
            $files = glob($thumbDir . '/*');
            if ($files) {
                foreach ($files as $f) {
                    if (is_file($f)) {
                        @unlink($f);
                        $deleted++;
                    }
                }
            }
        }
        echo json_encode(['success' => true, 'deleted_count' => $deleted]);
        exit;
    }

    if ($action === 'rename_single') {
        $oldFile = basename($_POST['file'] ?? '');
        $newFile = basename($_POST['target_name'] ?? '');

        $oldPath = $imagesDir . '/' . $oldFile;
        $newPath = $imagesDir . '/' . $newFile;

        if (!file_exists($oldPath)) {
            echo json_encode(['success' => false, 'error' => "File $oldFile not found"]);
            exit;
        }

        if ($oldPath !== $newPath) {
            if (!@rename($oldPath, $newPath)) {
                echo json_encode(['success' => false, 'error' => "Could not rename $oldFile to $newFile"]);
                exit;
            }
        }

        echo json_encode(['success' => true, 'old_file' => $oldFile, 'new_file' => $newFile]);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unknown action']);
    exit;
}

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rename Image Tool</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-sky-500 selection:text-white">
  <div class="min-h-screen bg-gradient-to-br from-sky-950 via-slate-900 to-indigo-950 p-4 sm:p-6 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

      <!-- Header & Navigation -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/10">
        <div>
          <?php include __DIR__ . '/../components/back.php'; ?>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                Rename Image Tool
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                  Folder: /tools/images
                </span>
              </h1>
              <p class="text-sm text-slate-400">Quickly rename image files in batch with custom prefixes, sequential numbering, and extension changing.</p>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <a href="../resize-image/" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium bg-sky-600/80 hover:bg-sky-500 text-white rounded-lg border border-sky-400/40 shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Need Resizing? Open Resize Tool &rarr;</span>
          </a>
          <button onclick="clearThumbCache()" id="btn-clear-cache" title="Clear thumbnail cache" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium bg-slate-800/80 hover:bg-rose-950/40 text-slate-300 hover:text-rose-300 rounded-lg border border-slate-700 hover:border-rose-700/50 transition">
            <span>Clear Cache</span>
          </button>
          <button onclick="scanImages()" id="btn-refresh" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium bg-slate-800/80 hover:bg-slate-700/90 text-slate-200 rounded-lg border border-slate-700 transition">
            <span>Refresh</span>
          </button>
        </div>
      </div>

      <!-- Settings Panel -->
      <div class="bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Find Ext -->
          <div class="space-y-1.5">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">Find Extension:</label>
            <input type="text" id="find_ext" value="jpeg" placeholder="e.g. jpeg or png, jpeg, gif"
              class="w-full bg-slate-950/70 border border-slate-700 focus:border-amber-500 rounded-lg px-3 py-2 text-sm text-white transition">
            <div class="flex items-center gap-1 text-[11px] text-slate-400">
              <span>Quick:</span>
              <button onclick="setPreset('jpeg')" class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-300 hover:bg-slate-700">jpeg</button>
              <button onclick="setPreset('png, jpeg, gif')" class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-300 hover:bg-slate-700">all types</button>
            </div>
          </div>

          <!-- Target Ext -->
          <div class="space-y-1.5">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">New Extension:</label>
            <input type="text" id="target_ext" value="jpg" placeholder="e.g. jpg or png"
              class="w-full bg-slate-950/70 border border-slate-700 focus:border-amber-500 rounded-lg px-3 py-2 text-sm text-white transition">
            <p class="text-[11px] text-slate-400">Extension to rename to (e.g. jpg)</p>
          </div>

          <!-- Prefix -->
          <div class="space-y-1.5">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">Prefix Name:</label>
            <input type="text" id="prefix_name" value="itb-2026-" placeholder="e.g. itb-2026-"
              class="w-full bg-slate-950/70 border border-slate-700 focus:border-amber-500 rounded-lg px-3 py-2 text-sm text-white transition">
          </div>

          <!-- Start Number & Padding -->
          <div class="grid grid-cols-2 gap-2">
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">Start #:</label>
              <input type="number" id="start_number" value="1" min="0"
                class="w-full bg-slate-950/70 border border-slate-700 focus:border-amber-500 rounded-lg px-3 py-2 text-sm text-white transition">
            </div>
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">Digits:</label>
              <select id="pad_digits" class="w-full bg-slate-950/70 border border-slate-700 focus:border-amber-500 rounded-lg px-2 py-2 text-sm text-white transition">
                <option value="1">1 (1, 2...)</option>
                <option value="2" selected>2 (01, 02...)</option>
                <option value="3">3 (001, 002...)</option>
                <option value="4">4 (0001...)</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Preview example and Start Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-white/5">
          <div class="flex items-center gap-2 text-xs">
            <span class="text-slate-400">Example:</span>
            <span class="font-mono text-slate-400">IMG_0001.jpeg</span>
            <span class="text-amber-400">&rarr;</span>
            <span id="preview_example" class="font-mono font-bold text-amber-300 bg-amber-950/50 px-2 py-0.5 rounded border border-amber-800/40">itb-2026-01.jpg</span>
          </div>

          <button id="btn-start" onclick="startBatchRename()"
            class="px-5 py-2.5 rounded-xl font-semibold text-sm bg-gradient-to-r from-amber-500 to-rose-600 hover:from-amber-400 hover:to-rose-500 text-white shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="btn-start-label">Start Rename (0 Files)</span>
          </button>
        </div>
      </div>

      <!-- Table of Files -->
      <div class="bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-white/10 pb-3">
          <h2 class="text-base font-semibold text-white">Files List</h2>
          <span id="badge-count" class="text-xs text-slate-400 font-mono">0 files</span>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
          <table class="w-full text-left text-xs text-slate-300 divide-y divide-white/5">
            <thead class="bg-slate-950/80 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
              <tr>
                <th class="py-3 px-3 w-10 text-center">
                  <input type="checkbox" id="check-all" onchange="toggleCheckAll(this.checked)" checked class="rounded bg-slate-900 border-slate-700 text-amber-500">
                </th>
                <th class="py-3 px-3 w-12 text-center">#</th>
                <th class="py-3 px-3">Current File</th>
                <th class="py-3 px-3 text-center w-8">&rarr;</th>
                <th class="py-3 px-3">Target New Name</th>
                <th class="py-3 px-3 text-center w-32">Status</th>
              </tr>
            </thead>
            <tbody id="files-table-body" class="divide-y divide-white/5 bg-slate-900/40">
              <tr><td colspan="6" class="py-6 text-center text-slate-500">Scanning...</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script>
    let fileList = [];
    const findExtInput = document.getElementById('find_ext');
    const targetExtInput = document.getElementById('target_ext');
    const prefixInput = document.getElementById('prefix_name');
    const startNumInput = document.getElementById('start_number');
    const padDigitsSelect = document.getElementById('pad_digits');
    const previewExample = document.getElementById('preview_example');
    const filesTableBody = document.getElementById('files-table-body');
    const badgeCount = document.getElementById('badge-count');
    const btnStartLabel = document.getElementById('btn-start-label');

    [findExtInput, targetExtInput, prefixInput, startNumInput, padDigitsSelect].forEach(el => {
      el.addEventListener('input', () => { updateExample(); renderTable(); });
      el.addEventListener('change', () => { updateExample(); renderTable(); });
    });

    findExtInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') scanImages();
    });

    function setPreset(v) {
      findExtInput.value = v;
      scanImages();
    }

    function updateExample() {
      const prefix = prefixInput.value;
      const start = parseInt(startNumInput.value) || 1;
      const pad = parseInt(padDigitsSelect.value) || 2;
      const ext = targetExtInput.value.replace(/^\./, '');
      const num = String(start).padStart(pad, '0');
      previewExample.textContent = `${prefix}${num}.${ext}`;
    }

    async function scanImages() {
      const formData = new FormData();
      formData.append('api', '1');
      formData.append('action', 'scan');
      formData.append('find_ext', findExtInput.value);

      const res = await fetch('index.php', { method: 'POST', body: formData });
      const data = await res.json();
      if (data.success) {
        fileList = data.files.map(f => ({ ...f, selected: true, status: 'ready' }));
        updateCount();
        renderTable();
      }
    }

    function updateCount() {
      const total = fileList.length;
      const sel = fileList.filter(f => f.selected).length;
      badgeCount.textContent = `${total} files found`;
      btnStartLabel.textContent = `Start Rename (${sel} Files)`;
      document.getElementById('check-all').checked = total > 0 && sel === total;
    }

    function toggleCheckAll(checked) {
      fileList.forEach(f => f.selected = checked);
      updateCount();
      renderTable();
    }

    function toggleSelect(idx, checked) {
      if (fileList[idx]) fileList[idx].selected = checked;
      updateCount();
    }

    function renderTable() {
      if (fileList.length === 0) {
        filesTableBody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-slate-500">No files found.</td></tr>`;
        return;
      }
      const prefix = prefixInput.value;
      const start = parseInt(startNumInput.value) || 1;
      const pad = parseInt(padDigitsSelect.value) || 2;
      const ext = targetExtInput.value.replace(/^\./, '');

      let html = '';
      let targetIdx = 0;
      fileList.forEach((f, idx) => {
        const num = String(start + targetIdx).padStart(pad, '0');
        const targetName = `${prefix}${num}.${ext}`;
        f.targetName = targetName;

        let statusHtml = '<span class="text-slate-400">Ready</span>';
        if (f.status === 'processing') statusHtml = '<span class="text-amber-400 animate-pulse">Renaming...</span>';
        else if (f.status === 'success') statusHtml = '<span class="text-emerald-400 font-bold">Done</span>';
        else if (f.status === 'error') statusHtml = '<span class="text-rose-400">Error</span>';

        html += `
          <tr class="hover:bg-white/[0.02]">
            <td class="py-2.5 px-3 text-center">
              <input type="checkbox" onchange="toggleSelect(${idx}, this.checked)" ${f.selected ? 'checked' : ''} class="rounded bg-slate-900 border-slate-700 text-amber-500">
            </td>
            <td class="py-2.5 px-3 text-center font-mono text-slate-500">${idx + 1}</td>
            <td class="py-2.5 px-3 font-mono text-slate-200">${f.filename}</td>
            <td class="py-2.5 px-3 text-center text-slate-500 font-bold">&rarr;</td>
            <td class="py-2.5 px-3 font-mono font-semibold text-amber-300">${targetName}</td>
            <td class="py-2.5 px-3 text-center">${statusHtml}</td>
          </tr>
        `;
        if (f.selected) targetIdx++;
      });
      filesTableBody.innerHTML = html;
    }

    async function startBatchRename() {
      const selected = fileList.filter(f => f.selected);
      if (selected.length === 0) return alert('Select at least 1 file.');
      if (!confirm(`Rename ${selected.length} files now?`)) return;

      for (let i = 0; i < selected.length; i++) {
        const f = selected[i];
        f.status = 'processing';
        renderTable();

        const formData = new FormData();
        formData.append('api', '1');
        formData.append('action', 'rename_single');
        formData.append('file', f.filename);
        formData.append('target_name', f.targetName);

        const res = await fetch('index.php', { method: 'POST', body: formData });
        const data = await res.json();
        f.status = data.success ? 'success' : 'error';
        renderTable();
      }

      await clearThumbCache(false);
      setTimeout(() => scanImages(), 1000);
    }

    async function clearThumbCache(showAlert = true) {
      try {
        const formData = new FormData();
        formData.append('api', '1');
        formData.append('action', 'clear_cache');
        const res = await fetch('index.php', { method: 'POST', body: formData });
        const data = await res.json();
        if (data.success && showAlert) {
          alert(`Cleared ${data.deleted_count} cached thumbnail file(s) successfully.`);
          scanImages();
        }
      } catch (e) {
        console.error(e);
      }
    }

    updateExample();
    scanImages();
  </script>
</body>
</html>