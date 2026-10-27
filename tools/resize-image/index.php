<?php
// Ensure UTF-8
header('Content-Type: text/html; charset=UTF-8');

$imagesDir = realpath(__DIR__ . '/../images');
if (!$imagesDir || !is_dir($imagesDir)) {
    $imagesDir = __DIR__ . '/../images';
    if (!file_exists($imagesDir)) {
        @mkdir($imagesDir, 0777, true);
    }
}

// -------------------------------------------------------------
// AJAX API ENDPOINTS
// -------------------------------------------------------------
if (isset($_GET['api']) || isset($_POST['api'])) {
    header('Content-Type: application/json');
    $action = $_REQUEST['action'] ?? '';

    // 1. Scan directory and return matching files
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
                // If filter provided, check matching extension
                if (!empty($extList) && !in_array($ext, $extList)) {
                    continue;
                }
                // Check if it's an image
                if (empty($extList) && !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                    continue;
                }

                $size = filesize($fullPath);
                $dim = @getimagesize($fullPath);
                $width = $dim ? $dim[0] : 0;
                $height = $dim ? $dim[1] : 0;

                $files[] = [
                    'filename' => $file,
                    'basename' => pathinfo($file, PATHINFO_FILENAME),
                    'ext' => $ext,
                    'size' => $size,
                    'size_formatted' => formatBytes($size),
                    'width' => $width,
                    'height' => $height,
                    'mtime' => filemtime($fullPath)
                ];
            }

            // Natural sort files by filename
            usort($files, function($a, $b) {
                return strnatcasecmp($a['filename'], $b['filename']);
            });
        }

        echo json_encode(['success' => true, 'files' => $files, 'count' => count($files)]);
        exit;
    }

    // 2. Thumbnail Generator for fast preview
    if ($action === 'thumb') {
        $file = basename($_GET['file'] ?? '');
        $srcPath = $imagesDir . '/' . $file;
        if (!file_exists($srcPath)) {
            http_response_code(404);
            echo "Not found";
            exit;
        }

        $thumbDir = $imagesDir . '/.thumb_cache';
        if (!file_exists($thumbDir)) {
            @mkdir($thumbDir, 0777, true);
        }
        $thumbPath = $thumbDir . '/' . md5($file . filemtime($srcPath)) . '.jpg';

        if (!file_exists($thumbPath)) {
            if (extension_loaded('imagick')) {
                try {
                    $im = new Imagick($srcPath);
                    $im->autoOrient();
                    $im->thumbnailImage(160, 160, true);
                    $im->setImageFormat('JPEG');
                    $im->setImageCompressionQuality(75);
                    $im->writeImage($thumbPath);
                    $im->clear();
                    $im->destroy();
                } catch (\Exception $e) {
                    // Fallback to source
                    $thumbPath = $srcPath;
                }
            } elseif (extension_loaded('gd')) {
                createGdThumbnail($srcPath, $thumbPath, 160, 160);
            } else {
                $thumbPath = $srcPath;
            }
        }

        header('Content-Type: image/jpeg');
        header('Cache-Control: public, max-age=86400');
        readfile($thumbPath);
        exit;
    }

    // 3. Process single file (Resize, Rename, Convert)
    if ($action === 'process') {
        $file = basename($_POST['file'] ?? '');
        $targetName = trim(basename($_POST['target_name'] ?? ''));
        $targetExt = strtolower(trim($_POST['target_ext'] ?? 'jpg'));
        $resizeMode = $_POST['resize_mode'] ?? 'max_dim';
        $maxWidth = (int)($_POST['max_width'] ?? 1920);
        $maxHeight = (int)($_POST['max_height'] ?? 1920);
        $scalePercent = (float)($_POST['scale_percent'] ?? 50);
        $quality = (int)($_POST['quality'] ?? 85);
        $quality = max(10, min(100, $quality));
        $autoOrient = !empty($_POST['auto_orient']);
        $originalAction = $_POST['original_action'] ?? 'replace'; // replace, backup, keep

        $srcPath = $imagesDir . '/' . $file;
        if (!file_exists($srcPath)) {
            echo json_encode(['success' => false, 'error' => "Source file '$file' not found"]);
            exit;
        }

        // Clean target extension
        if ($targetExt === 'jpeg') $targetExt = 'jpg';
        if (empty($targetName)) {
            $targetName = pathinfo($file, PATHINFO_FILENAME) . '.' . $targetExt;
        } else {
            // Ensure target extension is appended if missing
            if (!str_ends_with(strtolower($targetName), '.' . $targetExt)) {
                $targetName .= '.' . $targetExt;
            }
        }

        $destPath = $imagesDir . '/' . $targetName;
        $tempDestPath = $imagesDir . '/.tmp_' . uniqid() . '.' . $targetExt;

        $origSize = filesize($srcPath);
        $origDim = @getimagesize($srcPath);
        $origW = $origDim ? $origDim[0] : 0;
        $origH = $origDim ? $origDim[1] : 0;

        $newW = $origW;
        $newH = $origH;

        $processSuccess = false;
        $errorMessage = '';

        try {
            if (extension_loaded('imagick')) {
                $im = new Imagick($srcPath);
                if ($autoOrient) {
                    $im->autoOrient();
                }
                $curW = $im->getImageWidth();
                $curH = $im->getImageHeight();
                $origW = $curW;
                $origH = $curH;

                $targetW = $curW;
                $targetH = $curH;

                if ($resizeMode === 'max_dim') {
                    if (($maxWidth > 0 && $curW > $maxWidth) || ($maxHeight > 0 && $curH > $maxHeight)) {
                        $wLim = $maxWidth > 0 ? $maxWidth : $curW;
                        $hLim = $maxHeight > 0 ? $maxHeight : $curH;
                        $scale = min($wLim / $curW, $hLim / $curH);
                        $targetW = (int)round($curW * $scale);
                        $targetH = (int)round($curH * $scale);
                    }
                } elseif ($resizeMode === 'scale_percent') {
                    if ($scalePercent > 0 && $scalePercent != 100) {
                        $targetW = (int)round($curW * ($scalePercent / 100));
                        $targetH = (int)round($curH * ($scalePercent / 100));
                    }
                } elseif ($resizeMode === 'custom') {
                    if ($maxWidth > 0 && $maxHeight > 0) {
                        $targetW = $maxWidth;
                        $targetH = $maxHeight;
                    }
                }

                if ($targetW !== $curW || $targetH !== $curH) {
                    $im->resizeImage($targetW, $targetH, Imagick::FILTER_LANCZOS, 1, false);
                }

                $newW = $targetW;
                $newH = $targetH;

                // Handle format conversion
                $fmt = strtoupper($targetExt);
                if ($fmt === 'JPG') $fmt = 'JPEG';
                $im->setImageFormat($fmt);
                $im->setImageCompressionQuality($quality);

                // Flatten transparency when converting to JPEG
                if ($fmt === 'JPEG' && $im->getImageAlphaChannel()) {
                    $bg = new Imagick();
                    $bg->newImage($im->getImageWidth(), $im->getImageHeight(), 'white');
                    $bg->compositeImage($im, Imagick::COMPOSITE_OVER, 0, 0);
                    $im->clear();
                    $im->destroy();
                    $im = $bg;
                    $im->setImageFormat('JPEG');
                    $im->setImageCompressionQuality($quality);
                }

                $im->writeImage($tempDestPath);
                $im->clear();
                $im->destroy();
                $processSuccess = true;
            } elseif (extension_loaded('gd')) {
                // GD fallback
                $processSuccess = processWithGd($srcPath, $tempDestPath, [
                    'target_ext' => $targetExt,
                    'quality' => $quality,
                    'resize_mode' => $resizeMode,
                    'max_width' => $maxWidth,
                    'max_height' => $maxHeight,
                    'scale_percent' => $scalePercent,
                    'auto_orient' => $autoOrient
                ], $newW, $newH);
            } else {
                throw new \Exception("Neither Imagick nor GD extension is available in PHP.");
            }
        } catch (\Exception $e) {
            $processSuccess = false;
            $errorMessage = $e->getMessage();
            if (file_exists($tempDestPath)) @unlink($tempDestPath);
        }

        if (!$processSuccess || !file_exists($tempDestPath)) {
            echo json_encode([
                'success' => false,
                'error' => $errorMessage ?: "Failed to process image file '$file'"
            ]);
            exit;
        }

        // Original file handling (replace, backup, keep)
        if ($originalAction === 'backup') {
            $backupDir = $imagesDir . '/_backup';
            if (!file_exists($backupDir)) {
                @mkdir($backupDir, 0777, true);
            }
            @rename($srcPath, $backupDir . '/' . $file);
        } elseif ($originalAction === 'replace') {
            // Delete old source file if destination path is different
            if ($srcPath !== $destPath && file_exists($srcPath)) {
                @unlink($srcPath);
            }
        }
        // If target file already exists, overwrite
        @rename($tempDestPath, $destPath);

        $newSize = filesize($destPath);
        $savedBytes = max(0, $origSize - $newSize);
        $percentSaved = $origSize > 0 ? round(($savedBytes / $origSize) * 100, 1) : 0;

        echo json_encode([
            'success' => true,
            'original_file' => $file,
            'new_file' => $targetName,
            'original_size' => $origSize,
            'original_size_formatted' => formatBytes($origSize),
            'new_size' => $newSize,
            'new_size_formatted' => formatBytes($newSize),
            'percent_saved' => $percentSaved,
            'original_dim' => "{$origW} x {$origH}",
            'new_dim' => "{$newW} x {$newH}",
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unknown action']);
    exit;
}

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function createGdThumbnail($src, $dest, $maxW, $maxH) {
    $info = @getimagesize($src);
    if (!$info) return false;
    $mime = $info['mime'];
    $srcImg = null;
    switch ($mime) {
        case 'image/jpeg': $srcImg = @imagecreatefromjpeg($src); break;
        case 'image/png': $srcImg = @imagecreatefrompng($src); break;
        case 'image/gif': $srcImg = @imagecreatefromgif($src); break;
        case 'image/webp': $srcImg = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : null; break;
    }
    if (!$srcImg) return false;

    // Orientation
    if (function_exists('exif_read_data')) {
        $exif = @exif_read_data($src);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3: $srcImg = imagerotate($srcImg, 180, 0); break;
                case 6: $srcImg = imagerotate($srcImg, -90, 0); break;
                case 8: $srcImg = imagerotate($srcImg, 90, 0); break;
            }
        }
    }

    $w = imagesx($srcImg);
    $h = imagesy($srcImg);
    $scale = min($maxW / $w, $maxH / $h);
    $nw = (int)round($w * $scale);
    $nh = (int)round($h * $scale);

    $thumb = imagecreatetruecolor($nw, $nh);
    imagecopyresampled($thumb, $srcImg, 0, 0, 0, 0, $nw, $nh, $w, $h);
    imagejpeg($thumb, $dest, 75);
    imagedestroy($thumb);
    imagedestroy($srcImg);
    return true;
}

function processWithGd($src, $dest, $options, &$outW, &$outH) {
    $info = @getimagesize($src);
    if (!$info) return false;
    $mime = $info['mime'];
    $srcImg = null;
    switch ($mime) {
        case 'image/jpeg': $srcImg = @imagecreatefromjpeg($src); break;
        case 'image/png': $srcImg = @imagecreatefrompng($src); break;
        case 'image/gif': $srcImg = @imagecreatefromgif($src); break;
        case 'image/webp': $srcImg = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : null; break;
    }
    if (!$srcImg) return false;

    if (!empty($options['auto_orient']) && function_exists('exif_read_data')) {
        $exif = @exif_read_data($src);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3: $srcImg = imagerotate($srcImg, 180, 0); break;
                case 6: $srcImg = imagerotate($srcImg, -90, 0); break;
                case 8: $srcImg = imagerotate($srcImg, 90, 0); break;
            }
        }
    }

    $curW = imagesx($srcImg);
    $curH = imagesy($srcImg);
    $targetW = $curW;
    $targetH = $curH;

    $mode = $options['resize_mode'] ?? 'max_dim';
    $maxWidth = $options['max_width'] ?? 0;
    $maxHeight = $options['max_height'] ?? 0;
    $scalePercent = $options['scale_percent'] ?? 100;

    if ($mode === 'max_dim') {
        if (($maxWidth > 0 && $curW > $maxWidth) || ($maxHeight > 0 && $curH > $maxHeight)) {
            $wLim = $maxWidth > 0 ? $maxWidth : $curW;
            $hLim = $maxHeight > 0 ? $maxHeight : $curH;
            $scale = min($wLim / $curW, $hLim / $curH);
            $targetW = (int)round($curW * $scale);
            $targetH = (int)round($curH * $scale);
        }
    } elseif ($mode === 'scale_percent' && $scalePercent > 0 && $scalePercent != 100) {
        $targetW = (int)round($curW * ($scalePercent / 100));
        $targetH = (int)round($curH * ($scalePercent / 100));
    } elseif ($mode === 'custom' && $maxWidth > 0 && $maxHeight > 0) {
        $targetW = $maxWidth;
        $targetH = $maxHeight;
    }

    $outW = $targetW;
    $outH = $targetH;

    $newImg = imagecreatetruecolor($targetW, $targetH);
    $targetExt = strtolower($options['target_ext'] ?? 'jpg');

    if ($targetExt === 'png' || $targetExt === 'webp') {
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $targetW, $targetH, $transparent);
    } else {
        // White background for JPEG
        $white = imagecolorallocate($newImg, 255, 255, 255);
        imagefilledrectangle($newImg, 0, 0, $targetW, $targetH, $white);
    }

    imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $curW, $curH);

    $quality = $options['quality'] ?? 85;
    if ($targetExt === 'png') {
        $pngQuality = (int)round((100 - $quality) / 10);
        imagepng($newImg, $dest, min(9, max(0, $pngQuality)));
    } elseif ($targetExt === 'webp' && function_exists('imagewebp')) {
        imagewebp($newImg, $dest, $quality);
    } else {
        imagejpeg($newImg, $dest, $quality);
    }

    imagedestroy($newImg);
    imagedestroy($srcImg);
    return true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Resize & Rename Tool</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    /* Custom scrollbars */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: rgba(15, 23, 42, 0.6);
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(56, 189, 248, 0.4);
      border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(56, 189, 248, 0.8);
    }
  </style>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-sky-500 selection:text-white">
  <div class="min-h-screen bg-gradient-to-br from-sky-950 via-slate-900 to-indigo-950 p-4 sm:p-6 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

      <!-- Header & Navigation -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-white/10">
        <div>
          <?php include __DIR__ . '/../components/back.php'; ?>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-sky-500/20">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                Image Resize & Rename Tool
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-500/30">
                  Folder: /tools/images
                </span>
              </h1>
              <p class="text-sm text-slate-400">Scan, rename sequentially, convert format, and batch resize images in one click.</p>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <button onclick="scanImages()" id="btn-refresh" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium bg-slate-800/80 hover:bg-slate-700/90 text-slate-200 rounded-lg border border-slate-700 shadow-sm transition">
            <svg class="w-4 h-4 text-sky-400" id="icon-refresh" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Scan / Refresh</span>
          </button>
        </div>
      </div>

      <!-- Settings Panel Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left: Search & Rename Settings (7 Cols) -->
        <div class="lg:col-span-7 bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl space-y-5">
          <div class="flex items-center justify-between border-b border-white/10 pb-3">
            <h2 class="text-base font-semibold text-white flex items-center gap-2">
              <span class="flex h-2 w-2 rounded-full bg-sky-400"></span>
              1. Extension & Rename Configuration
            </h2>
            <span class="text-xs text-slate-400">Source: <code class="text-sky-300">tools/images/</code></span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Source Ext Filter -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                1.1 Find Files With Extension:
              </label>
              <input type="text" id="find_ext" value="jpeg" placeholder="e.g. jpeg or png, jpeg, gif"
                class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white placeholder-slate-500 transition">
              <div class="flex flex-wrap items-center gap-1.5 pt-1">
                <span class="text-[11px] text-slate-400">Presets:</span>
                <button type="button" onclick="setPresetExt('jpeg')" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">jpeg</button>
                <button type="button" onclick="setPresetExt('png, jpeg, gif')" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">png, jpeg, gif</button>
                <button type="button" onclick="setPresetExt('png')" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">png</button>
                <button type="button" onclick="setPresetExt('*')" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">all (*)</button>
              </div>
            </div>

            <!-- Target Convert Extension -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                1.2 Convert To Extension:
              </label>
              <select id="target_ext"
                class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
                <option value="jpg" selected>jpg (Recommended / Standard)</option>
                <option value="jpeg">jpeg</option>
                <option value="png">png</option>
                <option value="webp">webp (Ultra Compressed)</option>
              </select>
              <p class="text-[11px] text-slate-400">Output image format for converted files.</p>
            </div>
          </div>

          <!-- Rename Pattern Settings -->
          <div class="pt-2 border-t border-white/5 space-y-3">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
              1.3 Rename Pattern:
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              <div>
                <label class="text-[11px] text-slate-400 block mb-1">Prefix Name:</label>
                <input type="text" id="prefix_name" value="itb-2026-" placeholder="e.g. itb-2026-"
                  class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white placeholder-slate-500 transition">
              </div>
              <div>
                <label class="text-[11px] text-slate-400 block mb-1">Start Number:</label>
                <input type="number" id="start_number" value="1" min="0"
                  class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
              </div>
              <div>
                <label class="text-[11px] text-slate-400 block mb-1">Zero Padding (Digits):</label>
                <select id="pad_digits"
                  class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
                  <option value="1">1 digit (1, 2, 3...)</option>
                  <option value="2" selected>2 digits (01, 02, 03...)</option>
                  <option value="3">3 digits (001, 002...)</option>
                  <option value="4">4 digits (0001, 0002...)</option>
                </select>
              </div>
            </div>

            <!-- Example Preview Badge -->
            <div class="bg-slate-950/50 rounded-xl p-3 border border-slate-800 flex flex-wrap items-center justify-between gap-2 text-xs">
              <span class="text-slate-400">Rename preview example:</span>
              <div class="flex items-center gap-2 font-mono">
                <span class="text-slate-400">IMG_0001.jpeg</span>
                <span class="text-sky-400">&rarr;</span>
                <span id="preview_example_name" class="text-emerald-400 font-semibold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-800/50">itb-2026-01.jpg</span>
              </div>
            </div>
          </div>

          <!-- Original File Handling -->
          <div class="pt-2 border-t border-white/5 space-y-2">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
              1.4 Original File Action:
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
              <label class="relative flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-700/80 bg-slate-950/40 cursor-pointer hover:border-sky-500/50 transition">
                <input type="radio" name="original_action" value="replace" checked class="text-sky-500 focus:ring-sky-500 bg-slate-900 border-slate-700">
                <div>
                  <div class="text-xs font-medium text-white">Replace Original</div>
                  <div class="text-[10px] text-slate-400">Delete old file (Rename)</div>
                </div>
              </label>

              <label class="relative flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-700/80 bg-slate-950/40 cursor-pointer hover:border-sky-500/50 transition">
                <input type="radio" name="original_action" value="backup" class="text-sky-500 focus:ring-sky-500 bg-slate-900 border-slate-700">
                <div>
                  <div class="text-xs font-medium text-white">Move to Backup</div>
                  <div class="text-[10px] text-slate-400">Save to <code class="text-sky-300">_backup/</code></div>
                </div>
              </label>

              <label class="relative flex items-center gap-2.5 p-2.5 rounded-lg border border-slate-700/80 bg-slate-950/40 cursor-pointer hover:border-sky-500/50 transition">
                <input type="radio" name="original_action" value="keep" class="text-sky-500 focus:ring-sky-500 bg-slate-900 border-slate-700">
                <div>
                  <div class="text-xs font-medium text-white">Keep Both</div>
                  <div class="text-[10px] text-slate-400">Don't delete original</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Right: Resize & Quality Settings (5 Cols) -->
        <div class="lg:col-span-5 bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl space-y-5 flex flex-col justify-between">
          <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-white/10 pb-3">
              <h2 class="text-base font-semibold text-white flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400"></span>
                2. Resize & Compression
              </h2>
              <span class="text-xs text-emerald-400 font-medium">Imagick &bull; Auto-Orient</span>
            </div>

            <!-- Resize Mode -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                2.1 Resize Mode:
              </label>
              <select id="resize_mode" onchange="toggleResizeModeInputs()"
                class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
                <option value="max_dim" selected>Max Width / Height (Maintain Aspect Ratio)</option>
                <option value="scale_percent">Scale by Percentage (e.g. 50%)</option>
                <option value="custom">Exact Width & Height (Force Size)</option>
                <option value="none">No Resize (Convert & Rename Only)</option>
              </select>
            </div>

            <!-- Dimensions inputs for max_dim / custom -->
            <div id="dim_inputs_group" class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-[11px] text-slate-400 block mb-1">Max Width (px):</label>
                <input type="number" id="max_width" value="1920" step="10" min="50"
                  class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
              </div>
              <div>
                <label class="text-[11px] text-slate-400 block mb-1">Max Height (px):</label>
                <input type="number" id="max_height" value="1920" step="10" min="50"
                  class="w-full bg-slate-950/70 border border-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 rounded-lg px-3 py-2 text-sm text-white transition">
              </div>
              <div class="col-span-2 flex items-center gap-1.5 pt-0.5">
                <span class="text-[11px] text-slate-400">Presets:</span>
                <button type="button" onclick="setDimPreset(1920, 1920)" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">1920px (FHD)</button>
                <button type="button" onclick="setDimPreset(1200, 1200)" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">1200px (Web)</button>
                <button type="button" onclick="setDimPreset(800, 800)" class="px-2 py-0.5 text-xs rounded bg-slate-800 hover:bg-sky-600/30 text-sky-300 border border-slate-700 transition">800px (Compact)</button>
              </div>
            </div>

            <!-- Percentage input for scale_percent -->
            <div id="percent_input_group" class="hidden space-y-1">
              <label class="text-[11px] text-slate-400 block">Scale Percentage (%):</label>
              <div class="flex items-center gap-3">
                <input type="range" id="scale_percent_slider" min="10" max="100" value="50" class="flex-1 accent-sky-400">
                <span id="scale_percent_val" class="font-mono text-sm font-semibold text-sky-400 w-12 text-right">50%</span>
              </div>
            </div>

            <!-- Quality Slider -->
            <div class="space-y-1.5 pt-2 border-t border-white/5">
              <div class="flex justify-between items-center text-xs">
                <label class="font-semibold uppercase tracking-wider text-slate-300">
                  2.2 Image Quality:
                </label>
                <span id="quality_val" class="font-mono font-bold text-sky-400 bg-sky-950/60 px-2 py-0.5 rounded border border-sky-800/40">85%</span>
              </div>
              <input type="range" id="quality" min="20" max="100" value="85"
                class="w-full accent-sky-400 cursor-pointer">
              <div class="flex justify-between text-[10px] text-slate-500">
                <span>20% (Smallest)</span>
                <span>85% (Balanced)</span>
                <span>100% (Lossless)</span>
              </div>
            </div>

            <!-- Auto Orient Toggle -->
            <div class="pt-2 border-t border-white/5">
              <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" id="auto_orient" checked class="w-4 h-4 rounded text-sky-500 focus:ring-sky-500 bg-slate-950 border-slate-700">
                <div>
                  <span class="text-xs font-medium text-slate-200">Auto-fix EXIF Orientation</span>
                  <p class="text-[11px] text-slate-400">Automatically corrects sideways or upside-down smartphone photos.</p>
                </div>
              </label>
            </div>
          </div>

          <!-- Quick Action Button in Right Panel -->
          <div class="pt-4 border-t border-white/10">
            <button id="btn-start-process" onclick="startBatchProcess()"
              class="w-full py-3 px-4 rounded-xl font-semibold text-sm bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white shadow-lg shadow-sky-500/25 flex items-center justify-center gap-2 transition transform active:scale-[0.98]">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              <span id="btn-process-label">Start Processing (0 Files)</span>
            </button>
          </div>
        </div>

      </div>

      <!-- Execution Progress Bar (Shown while running) -->
      <div id="progress-container" class="hidden bg-slate-900/80 backdrop-blur-md border border-sky-500/30 rounded-2xl p-5 shadow-2xl space-y-3">
        <div class="flex items-center justify-between text-sm">
          <div class="flex items-center gap-3">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-sky-400 border-t-transparent"></div>
            <span id="progress-title" class="font-semibold text-white">Processing images...</span>
          </div>
          <div class="flex items-center gap-3">
            <span id="progress-count" class="font-mono text-xs text-sky-300">0 / 0</span>
            <span id="progress-percent" class="font-mono text-xs font-bold text-white bg-sky-600 px-2 py-0.5 rounded">0%</span>
            <button onclick="stopProcessing()" class="text-xs px-2.5 py-1 rounded bg-rose-900/80 hover:bg-rose-800 text-rose-200 border border-rose-700 transition">
              Cancel
            </button>
          </div>
        </div>
        <div class="w-full bg-slate-950 rounded-full h-3 overflow-hidden p-0.5 border border-slate-800">
          <div id="progress-bar-fill" class="bg-gradient-to-r from-sky-500 to-emerald-400 h-full rounded-full transition-all duration-200" style="width: 0%"></div>
        </div>
        <div class="flex justify-between items-center text-xs text-slate-400">
          <span id="progress-current-file" class="font-mono truncate max-w-md">Preparing...</span>
          <span id="progress-stats" class="text-emerald-400 font-medium"></span>
        </div>
      </div>

      <!-- Table Section: Images List & Live Preview -->
      <div class="bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-white/10 pb-4">
          <div class="flex items-center gap-3">
            <h2 class="text-base font-semibold text-white flex items-center gap-2">
              <span class="flex h-2 w-2 rounded-full bg-amber-400"></span>
              Files to Process
            </h2>
            <span id="badge-total-files" class="px-2.5 py-0.5 text-xs font-medium bg-slate-800 text-slate-300 rounded-full border border-slate-700">
              0 files found
            </span>
          </div>

          <!-- Selection & Filter Tools -->
          <div class="flex flex-wrap items-center gap-2">
            <button onclick="selectAll(true)" class="px-2.5 py-1.5 text-xs rounded bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition">
              Select All
            </button>
            <button onclick="selectAll(false)" class="px-2.5 py-1.5 text-xs rounded bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition">
              Deselect All
            </button>
            <input type="text" id="filter-search" oninput="applyLocalFilter()" placeholder="Search in table..."
              class="bg-slate-950/70 border border-slate-700 focus:border-sky-500 rounded-lg px-2.5 py-1 text-xs text-white placeholder-slate-500 transition w-36 sm:w-48">
          </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl border border-white/10">
          <table class="w-full text-left text-xs text-slate-300 divide-y divide-white/5">
            <thead class="bg-slate-950/80 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
              <tr>
                <th scope="col" class="py-3 px-3 w-10 text-center">
                  <input type="checkbox" id="check-all" onchange="toggleCheckAll(this.checked)" checked
                    class="rounded text-sky-500 focus:ring-sky-500 bg-slate-900 border-slate-700">
                </th>
                <th scope="col" class="py-3 px-3 w-12 text-center">#</th>
                <th scope="col" class="py-3 px-3 w-20">Preview</th>
                <th scope="col" class="py-3 px-3">Original Image</th>
                <th scope="col" class="py-3 px-3 text-center w-8">&rarr;</th>
                <th scope="col" class="py-3 px-3">New Filename & Format</th>
                <th scope="col" class="py-3 px-3 text-right">Target Action</th>
                <th scope="col" class="py-3 px-3 text-center w-36">Status</th>
              </tr>
            </thead>
            <tbody id="files-table-body" class="divide-y divide-white/5 bg-slate-900/40">
              <tr>
                <td colspan="8" class="py-8 text-center text-slate-500">
                  <div class="flex flex-col items-center justify-center gap-2">
                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-sky-400 border-t-transparent"></div>
                    <span>Scanning <code class="text-sky-300">tools/images/</code>...</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script>
    // State management
    let fileList = [];
    let isProcessing = false;
    let stopRequested = false;

    // Elements
    const findExtInput = document.getElementById('find_ext');
    const targetExtSelect = document.getElementById('target_ext');
    const prefixInput = document.getElementById('prefix_name');
    const startNumInput = document.getElementById('start_number');
    const padDigitsSelect = document.getElementById('pad_digits');
    const resizeModeSelect = document.getElementById('resize_mode');
    const maxWidthInput = document.getElementById('max_width');
    const maxHeightInput = document.getElementById('max_height');
    const scalePercentSlider = document.getElementById('scale_percent_slider');
    const scalePercentVal = document.getElementById('scale_percent_val');
    const qualitySlider = document.getElementById('quality');
    const qualityVal = document.getElementById('quality_val');
    const previewExampleName = document.getElementById('preview_example_name');
    const filesTableBody = document.getElementById('files-table-body');
    const badgeTotalFiles = document.getElementById('badge-total-files');
    const btnProcessLabel = document.getElementById('btn-process-label');

    // Event listeners for live preview update
    [findExtInput, targetExtSelect, prefixInput, startNumInput, padDigitsSelect, resizeModeSelect, maxWidthInput, maxHeightInput].forEach(el => {
      el.addEventListener('input', () => {
        updateExamplePreview();
        renderTableRows();
      });
      el.addEventListener('change', () => {
        updateExamplePreview();
        renderTableRows();
      });
    });

    findExtInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        scanImages();
      }
    });

    scalePercentSlider.addEventListener('input', (e) => {
      scalePercentVal.textContent = e.target.value + '%';
      renderTableRows();
    });

    qualitySlider.addEventListener('input', (e) => {
      qualityVal.textContent = e.target.value + '%';
    });

    function setPresetExt(ext) {
      findExtInput.value = ext;
      scanImages();
    }

    function setDimPreset(w, h) {
      maxWidthInput.value = w;
      maxHeightInput.value = h;
      renderTableRows();
    }

    function toggleResizeModeInputs() {
      const mode = resizeModeSelect.value;
      const dimGroup = document.getElementById('dim_inputs_group');
      const percentGroup = document.getElementById('percent_input_group');

      if (mode === 'scale_percent') {
        dimGroup.classList.add('hidden');
        percentGroup.classList.remove('hidden');
      } else if (mode === 'none') {
        dimGroup.classList.add('hidden');
        percentGroup.classList.add('hidden');
      } else {
        dimGroup.classList.remove('hidden');
        percentGroup.classList.add('hidden');
      }
      renderTableRows();
    }

    function updateExamplePreview() {
      const prefix = prefixInput.value;
      const startNum = parseInt(startNumInput.value) || 1;
      const pad = parseInt(padDigitsSelect.value) || 2;
      const ext = targetExtSelect.value;
      const formattedNum = String(startNum).padStart(pad, '0');
      previewExampleName.textContent = `${prefix}${formattedNum}.${ext}`;
    }

    // Scan directory
    async function scanImages() {
      const btnRefresh = document.getElementById('btn-refresh');
      const iconRefresh = document.getElementById('icon-refresh');
      iconRefresh.classList.add('animate-spin');

      try {
        const formData = new FormData();
        formData.append('api', '1');
        formData.append('action', 'scan');
        formData.append('find_ext', findExtInput.value);

        const res = await fetch('index.php', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        if (data.success) {
          // Keep existing selections if any
          const oldSelection = new Set(fileList.filter(f => f.selected).map(f => f.filename));
          fileList = data.files.map(f => ({
            ...f,
            selected: oldSelection.size === 0 ? true : oldSelection.has(f.filename),
            status: 'ready', // ready, processing, success, error
            result: null
          }));
          updateBadgeCount();
          renderTableRows();
        } else {
          alert('Scan failed: ' + (data.error || 'Unknown error'));
        }
      } catch (err) {
        console.error(err);
        filesTableBody.innerHTML = `<tr><td colspan="8" class="py-6 text-center text-rose-400">Error connecting to server.</td></tr>`;
      } finally {
        iconRefresh.classList.remove('animate-spin');
      }
    }

    function updateBadgeCount() {
      const total = fileList.length;
      const selected = fileList.filter(f => f.selected).length;
      badgeTotalFiles.textContent = `${total} files found`;
      btnProcessLabel.textContent = `Start Processing (${selected} Files)`;
      document.getElementById('check-all').checked = total > 0 && selected === total;
    }

    function selectAll(state) {
      fileList.forEach(f => f.selected = state);
      updateBadgeCount();
      renderTableRows();
    }

    function toggleCheckAll(checked) {
      selectAll(checked);
    }

    function toggleFileSelect(index, checked) {
      if (fileList[index]) {
        fileList[index].selected = checked;
        updateBadgeCount();
      }
    }

    function applyLocalFilter() {
      const query = document.getElementById('filter-search').value.toLowerCase();
      const rows = filesTableBody.querySelectorAll('tr[data-filename]');
      rows.forEach(r => {
        const name = r.getAttribute('data-filename').toLowerCase();
        if (name.includes(query)) {
          r.style.display = '';
        } else {
          r.style.display = 'none';
        }
      });
    }

    // Render file rows
    function renderTableRows() {
      if (fileList.length === 0) {
        filesTableBody.innerHTML = `
          <tr>
            <td colspan="8" class="py-8 text-center text-slate-400">
              No files found matching extension <code class="text-sky-300 font-mono">"${findExtInput.value}"</code> in <code class="text-slate-300">tools/images/</code>.
            </td>
          </tr>
        `;
        return;
      }

      const prefix = prefixInput.value;
      const startNum = parseInt(startNumInput.value) || 1;
      const pad = parseInt(padDigitsSelect.value) || 2;
      const ext = targetExtSelect.value;
      const resizeMode = resizeModeSelect.value;
      const maxW = parseInt(maxWidthInput.value) || 1920;
      const maxH = parseInt(maxHeightInput.value) || 1920;
      const percent = parseInt(scalePercentSlider.value) || 50;

      let html = '';
      let targetIndex = 0;

      fileList.forEach((file, idx) => {
        const num = startNum + targetIndex;
        const formattedNum = String(num).padStart(pad, '0');
        const targetFilename = `${prefix}${formattedNum}.${ext}`;
        file.targetFilename = targetFilename;

        // Calculate expected dimensions
        let estDim = `${file.width} x ${file.height}`;
        if (resizeMode === 'max_dim' && file.width > 0 && file.height > 0) {
          if (file.width > maxW || file.height > maxH) {
            const scale = Math.min(maxW / file.width, maxH / file.height);
            estDim = `~${Math.round(file.width * scale)} x ${Math.round(file.height * scale)}`;
          }
        } else if (resizeMode === 'scale_percent' && file.width > 0) {
          estDim = `~${Math.round(file.width * (percent / 100))} x ${Math.round(file.height * (percent / 100))}`;
        } else if (resizeMode === 'custom') {
          estDim = `${maxW} x ${maxH}`;
        } else if (resizeMode === 'none') {
          estDim = `Original (${file.width} x ${file.height})`;
        }

        // Status badge
        let statusBadge = '';
        if (file.status === 'ready') {
          statusBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 text-slate-300 border border-slate-700">
            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Ready
          </span>`;
        } else if (file.status === 'processing') {
          statusBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-sky-950/80 text-sky-300 border border-sky-700/60 animate-pulse">
            <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> Resizing...
          </span>`;
        } else if (file.status === 'success') {
          statusBadge = `<div class="flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-950/80 text-emerald-300 border border-emerald-700/60">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Done
            </span>
            <span class="text-[10px] text-emerald-400 font-mono mt-0.5">-${file.result.percent_saved}%</span>
          </div>`;
        } else if (file.status === 'error') {
          statusBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-rose-950/80 text-rose-300 border border-rose-700/60" title="${file.errorMessage || ''}">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Error
          </span>`;
        }

        html += `
          <tr data-filename="${file.filename}" class="hover:bg-white/[0.03] transition ${file.selected ? '' : 'opacity-50'}">
            <td class="py-2.5 px-3 text-center">
              <input type="checkbox" onchange="toggleFileSelect(${idx}, this.checked)" ${file.selected ? 'checked' : ''}
                class="rounded text-sky-500 focus:ring-sky-500 bg-slate-900 border-slate-700">
            </td>
            <td class="py-2.5 px-3 text-center font-mono text-slate-500">${idx + 1}</td>
            <td class="py-2.5 px-3">
              <div class="w-12 h-12 rounded-lg bg-slate-950 border border-white/10 overflow-hidden relative group cursor-pointer shadow">
                <img src="index.php?api=1&action=thumb&file=${encodeURIComponent(file.filename)}" 
                     alt="${file.filename}" 
                     loading="lazy"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
              </div>
            </td>
            <td class="py-2.5 px-3">
              <div class="font-mono font-medium text-slate-200 text-xs">${file.filename}</div>
              <div class="text-[11px] text-slate-400 flex items-center gap-2 mt-0.5">
                <span>${file.size_formatted}</span>
                <span>&bull;</span>
                <span>${file.width} &times; ${file.height}</span>
              </div>
            </td>
            <td class="py-2.5 px-3 text-center text-slate-500 font-bold">&rarr;</td>
            <td class="py-2.5 px-3">
              <div class="font-mono font-semibold text-emerald-400 text-xs">${targetFilename}</div>
              <div class="text-[11px] text-slate-400 flex items-center gap-2 mt-0.5">
                <span>Format: <strong class="text-slate-300 uppercase">${ext}</strong></span>
                <span>&bull;</span>
                <span>Est: <strong class="text-sky-300">${estDim}</strong></span>
              </div>
            </td>
            <td class="py-2.5 px-3 text-right">
              <span class="text-[11px] text-slate-400 font-mono">${resizeMode === 'none' ? 'Convert Only' : 'Resize &bull; ' + qualitySlider.value + '%'}</span>
            </td>
            <td class="py-2.5 px-3 text-center">
              ${statusBadge}
            </td>
          </tr>
        `;

        if (file.selected) {
          targetIndex++;
        }
      });

      filesTableBody.innerHTML = html;
      applyLocalFilter();
    }

    // Batch process files sequentially via AJAX
    async function startBatchProcess() {
      if (isProcessing) return;

      const selectedFiles = fileList.filter(f => f.selected);
      if (selectedFiles.length === 0) {
        alert('Please select at least 1 image to process.');
        return;
      }

      const origAction = document.querySelector('input[name="original_action"]:checked').value;
      const confirmMsg = `Ready to process ${selectedFiles.length} images?\n` +
        `• Target format: .${targetExtSelect.value}\n` +
        `• Prefix: ${prefixInput.value}\n` +
        `• Original files: ${origAction === 'replace' ? 'DELETE / REPLACE original files' : (origAction === 'backup' ? 'Move to _backup/' : 'Keep original files')}\n\n` +
        `Click OK to proceed.`;

      if (!confirm(confirmMsg)) return;

      isProcessing = true;
      stopRequested = false;

      // UI state updates
      const progressContainer = document.getElementById('progress-container');
      const progressTitle = document.getElementById('progress-title');
      const progressCount = document.getElementById('progress-count');
      const progressPercent = document.getElementById('progress-percent');
      const progressBarFill = document.getElementById('progress-bar-fill');
      const progressCurrentFile = document.getElementById('progress-current-file');
      const progressStats = document.getElementById('progress-stats');
      const btnProcess = document.getElementById('btn-start-process');

      progressContainer.classList.remove('hidden');
      btnProcess.disabled = true;
      btnProcess.classList.add('opacity-50', 'cursor-not-allowed');

      let completedCount = 0;
      let totalSavedBytes = 0;
      const totalCount = selectedFiles.length;

      for (let i = 0; i < totalCount; i++) {
        if (stopRequested) {
          progressTitle.textContent = 'Process stopped by user.';
          break;
        }

        const file = selectedFiles[i];
        file.status = 'processing';
        renderTableRows();

        progressCurrentFile.textContent = `Processing: ${file.filename} → ${file.targetFilename}`;
        progressCount.textContent = `${i + 1} / ${totalCount}`;
        const pct = Math.round(((i) / totalCount) * 100);
        progressPercent.textContent = pct + '%';
        progressBarFill.style.width = pct + '%';

        try {
          const formData = new FormData();
          formData.append('api', '1');
          formData.append('action', 'process');
          formData.append('file', file.filename);
          formData.append('target_name', file.targetFilename);
          formData.append('target_ext', targetExtSelect.value);
          formData.append('resize_mode', resizeModeSelect.value);
          formData.append('max_width', maxWidthInput.value);
          formData.append('max_height', maxHeightInput.value);
          formData.append('scale_percent', scalePercentSlider.value);
          formData.append('quality', qualitySlider.value);
          formData.append('auto_orient', document.getElementById('auto_orient').checked ? '1' : '0');
          formData.append('original_action', origAction);

          const res = await fetch('index.php', {
            method: 'POST',
            body: formData
          });
          const result = await res.json();

          if (result.success) {
            file.status = 'success';
            file.result = result;
            completedCount++;
            totalSavedBytes += Math.max(0, result.original_size - result.new_size);
            progressStats.textContent = `Total Saved: ${formatBytesJS(totalSavedBytes)}`;
          } else {
            file.status = 'error';
            file.errorMessage = result.error || 'Unknown error';
          }
        } catch (err) {
          console.error(err);
          file.status = 'error';
          file.errorMessage = err.message;
        }

        renderTableRows();
      }

      // Finish
      progressBarFill.style.width = '100%';
      progressPercent.textContent = '100%';
      progressCount.textContent = `${completedCount} / ${totalCount}`;
      progressTitle.textContent = `Completed! ${completedCount} images successfully resized & converted.`;
      progressCurrentFile.textContent = `Total space saved: ${formatBytesJS(totalSavedBytes)}`;

      isProcessing = false;
      btnProcess.disabled = false;
      btnProcess.classList.remove('opacity-50', 'cursor-not-allowed');

      // Rescan images directory after a short delay so table refreshes to new filenames
      setTimeout(() => {
        // If files were renamed or converted, refresh scan with current target ext
        scanImages();
      }, 1500);
    }

    function stopProcessing() {
      stopRequested = true;
    }

    function formatBytesJS(bytes) {
      if (bytes <= 0) return '0 B';
      const k = 1024;
      const sizes = ['B', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return (bytes / Math.pow(k, i)).toFixed(2) + ' ' + sizes[i];
    }

    // Initial load
    updateExamplePreview();
    scanImages();
  </script>
</body>

</html>