<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=UTF-8');

// โหลดไฟล์ JSON
$jsonPath = __DIR__ . '/kliknbook_duplicate_bookings.json';
if (!file_exists($jsonPath)) {
    $jsonPath = __DIR__ . '/../kliknbook-supplier-ref-duplicate/kliknbook_duplicate_bookings.json';
}

$rawData = array();
if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $decoded = json_decode($jsonContent, true);
    $rawData = is_array($decoded) ? $decoded : array();
}

// คอลัมน์ทั้งหมดที่แสดงในตาราง
$columns = array(
    'supplier_ref' => 'เลขที่ส่งให้ Channel (Supplier Ref)',
    'channel'      => 'Channel',
    'file_no'      => 'File No',
    'agent'        => 'Agent',
    'os_ref'       => 'O/S Ref',
    'hotel'        => 'โรงแรม',
    'checkin'      => 'เช็คอิน',
    'status'       => 'สถานะในระบบ',
);

// ฟังก์ชันแปลงวันที่ภาษาไทย (เช่น "3 พ.ย. 2569") เป็นรูปแบบ YYYY-MM-DD เพื่อใช้เรียงลำดับที่ถูกต้อง
function thaiDateToSortable($thaiDate)
{
    $thaiMonths = array(
        'ม.ค.'  => '01',
        'ก.พ.'  => '02',
        'มี.ค.' => '03',
        'เม.ย.' => '04',
        'พ.ค.'  => '05',
        'มิ.ย.' => '06',
        'ก.ค.'  => '07',
        'ส.ค.'  => '08',
        'ก.ย.'  => '09',
        'ต.ค.'  => '10',
        'พ.ย.'  => '11',
        'ธ.ค.'  => '12',
    );

    $parts = preg_split('/\s+/', trim((string)$thaiDate));
    if (count($parts) === 3) {
        $day   = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        $month = isset($thaiMonths[$parts[1]]) ? $thaiMonths[$parts[1]] : '00';
        $year  = $parts[2];
        return "{$year}-{$month}-{$day}";
    }
    return (string)$thaiDate;
}

// นับจำนวนรายการที่มี Supplier Ref ซ้ำกัน เพื่อทำสีเน้นกลุ่มข้อมูล
$supplierRefCounts = array();
foreach ($rawData as $row) {
    $ref = isset($row['เลขที่ส่งให้ Channel (Supplier Ref)']) ? $row['เลขที่ส่งให้ Channel (Supplier Ref)'] : '';
    if ($ref !== '') {
        $supplierRefCounts[$ref] = (isset($supplierRefCounts[$ref]) ? $supplierRefCounts[$ref] : 0) + 1;
    }
}

// รับค่า Filter และ Sort จาก URL Query ($_GET)
$search        = trim(isset($_GET['q']) ? $_GET['q'] : '');
$filterChannel = trim(isset($_GET['channel']) ? $_GET['channel'] : '');
$filterStatus  = trim(isset($_GET['status']) ? $_GET['status'] : '');
$sortKey       = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortDir       = strtolower(isset($_GET['dir']) ? $_GET['dir'] : 'asc') === 'desc' ? 'desc' : 'asc';

if ($sortKey !== '' && !isset($columns[$sortKey])) {
    $sortKey = '';
}

// ดึงตัวเลือกสำหรับ Dropdown Filter
$allChannels = array_values(array_unique(array_filter(array_column($rawData, 'Channel'))));
sort($allChannels);
$allStatuses = array_values(array_unique(array_filter(array_column($rawData, 'สถานะในระบบ'))));

// กรองข้อมูล (Filter)
$filteredData = array_filter($rawData, function ($row) use ($search, $filterChannel, $filterStatus) {
    $rowChannel = isset($row['Channel']) ? $row['Channel'] : '';
    $rowStatus  = isset($row['สถานะในระบบ']) ? $row['สถานะในระบบ'] : '';

    if ($filterChannel !== '' && $rowChannel !== $filterChannel) {
        return false;
    }
    if ($filterStatus !== '' && $rowStatus !== $filterStatus) {
        return false;
    }
    if ($search !== '') {
        $haystack = implode(' ', array_values($row));
        $found = function_exists('mb_stripos')
            ? mb_stripos($haystack, $search) !== false
            : stripos($haystack, $search) !== false;
        if (!$found) {
            return false;
        }
    }
    return true;
});

$filteredData = array_values($filteredData);

// เรียงลำดับข้อมูล (Order By)
if ($sortKey !== '') {
    $fieldName = $columns[$sortKey];
    usort($filteredData, function ($a, $b) use ($fieldName, $sortKey, $sortDir) {
        $valA = (string)(isset($a[$fieldName]) ? $a[$fieldName] : '');
        $valB = (string)(isset($b[$fieldName]) ? $b[$fieldName] : '');

        if ($sortKey === 'checkin') {
            $cmp = strcmp(thaiDateToSortable($valA), thaiDateToSortable($valB));
        } else {
            $cmp = strnatcasecmp($valA, $valB);
        }

        return $sortDir === 'desc' ? -$cmp : $cmp;
    });
}

// ฟังก์ชันสร้าง URL สำหรับคลิกหัวตารางเพื่อเรียงลำดับ
function buildSortUrl($colKey, $currentSort, $currentDir)
{
    $nextDir = ($currentSort === $colKey && $currentDir === 'asc') ? 'desc' : 'asc';
    $params = $_GET;
    $params['sort'] = $colKey;
    $params['dir']  = $nextDir;
    return '?' . http_build_query($params);
}

// สรุปสถิติข้อมูลที่แสดงผล
$totalCount = count($rawData);
$shownCount = count($filteredData);
$uniqueSupplierRefs = count(array_unique(array_column($filteredData, 'เลขที่ส่งให้ Channel (Supplier Ref)')));
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Duplicate Bookings - Kliknbook</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-sky-500 selection:text-white">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/40 p-4 sm:p-6 md:p-8">
        <div class="max-w-[1440px] mx-auto space-y-6">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
                <div>
                    <div class="pb-3">
                        <a href="../" class="inline-flex items-center gap-1.5 text-sm font-medium text-sky-600 hover:text-sky-800 transition">
                            <span>&larr;</span>
                            <span>Back to Tools</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-indigo-600 flex items-center justify-center shadow-md shadow-sky-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900 flex flex-wrap items-center gap-2">
                                Kliknbook Duplicate Bookings
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-700 border border-sky-200 font-mono">
                                    kliknbook_duplicate_bookings.json
                                </span>
                            </h1>
                            <p class="text-sm text-slate-500">คลิกที่หัวตาราง (Header) เพื่อเรียงลำดับข้อมูล (Order By ASC / DESC) หรือค้นหากรองข้อมูลตามต้องการ</p>
                        </div>
                    </div>
                </div>

                <!-- Summary Badges -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 shadow-xs text-xs">
                        <span class="text-slate-500">แสดงผล:</span>
                        <span class="font-bold text-slate-900 ml-1"><?= number_format($shownCount) ?></span>
                        <span class="text-slate-400">/ <?= number_format($totalCount) ?> รายการ</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 shadow-xs text-xs">
                        <span class="text-slate-500">Supplier Ref ที่ไม่ซ้ำ:</span>
                        <span class="font-bold text-sky-600 ml-1"><?= number_format($uniqueSupplierRefs) ?></span>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <?php if ($sortKey !== ''): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sortKey) ?>">
                    <input type="hidden" name="dir" value="<?= htmlspecialchars($sortDir) ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">ค้นหาข้อมูล (Search)</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="q"
                                value="<?= htmlspecialchars($search) ?>"
                                placeholder="ค้นหา Supplier Ref, File No, โรงแรม, Agent..."
                                class="w-full bg-slate-50 border border-slate-300 focus:bg-white focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-lg pl-9 pr-3 py-2 text-sm text-slate-900 placeholder-slate-400 transition">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Channel -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Channel</label>
                        <select name="channel" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-300 focus:bg-white focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-lg px-3 py-2 text-sm text-slate-900 transition">
                            <option value="">ทั้งหมด (All)</option>
                            <?php foreach ($allChannels as $ch): ?>
                                <option value="<?= htmlspecialchars($ch) ?>" <?= $filterChannel === $ch ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ch) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="md:col-span-3 space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">สถานะในระบบ</label>
                        <select name="status" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-300 focus:bg-white focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-lg px-3 py-2 text-sm text-slate-900 transition">
                            <option value="">ทั้งหมด (All)</option>
                            <?php foreach ($allStatuses as $st): ?>
                                <option value="<?= htmlspecialchars($st) ?>" <?= $filterStatus === $st ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($st) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="md:col-span-2 flex items-center gap-2">
                        <button type="submit" class="flex-1 bg-sky-600 hover:bg-sky-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-xs transition cursor-pointer">
                            ค้นหา
                        </button>
                        <?php if ($search !== '' || $filterChannel !== '' || $filterStatus !== '' || $sortKey !== ''): ?>
                            <a href="?" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm py-2 px-3 rounded-lg border border-slate-300 transition" title="ล้างตัวกรองและการเรียงลำดับ">
                                รีเซ็ต
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <!-- Active Sort Indicator -->
            <?php if ($sortKey !== ''): ?>
                <div class="flex items-center justify-between bg-sky-50 border border-sky-200 rounded-xl px-4 py-2.5 text-xs text-sky-900">
                    <div class="flex items-center gap-2">
                        <span class="text-sky-700">กำลังเรียงลำดับตาม:</span>
                        <span class="font-bold text-sky-950 bg-white px-2.5 py-0.5 rounded border border-sky-200 shadow-2xs">
                            <?= htmlspecialchars($columns[$sortKey]) ?>
                        </span>
                        <span class="font-mono font-semibold uppercase px-2 py-0.5 rounded bg-amber-100 text-amber-800 border border-amber-200">
                            <?= $sortDir === 'asc' ? '▲ น้อยไปมาก (ASC)' : '▼ มากไปน้อย (DESC)' ?>
                        </span>
                    </div>
                    <a href="?<?= http_build_query(array_diff_key($_GET, ['sort' => '', 'dir' => ''])) ?>" class="font-medium text-sky-700 hover:text-sky-900 underline">
                        ยกเลิกการเรียงลำดับ
                    </a>
                </div>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto max-h-[75vh]">
                    <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                        <thead class="bg-slate-100/95 text-[11px] font-semibold text-slate-600 uppercase tracking-wider sticky top-0 z-10 backdrop-blur-md border-b border-slate-200">
                            <tr>
                                <th class="py-3.5 px-3 w-12 text-center text-slate-400 select-none">#</th>
                                <?php foreach ($columns as $colKey => $colLabel):
                                    $isSorted = ($sortKey === $colKey);
                                    $sortUrl  = buildSortUrl($colKey, $sortKey, $sortDir);
                                ?>
                                    <th class="p-0 select-none">
                                        <a
                                            href="<?= htmlspecialchars($sortUrl) ?>"
                                            class="group flex items-center justify-between gap-2 py-3.5 px-3.5 hover:bg-slate-200/60 transition <?= $isSorted ? 'bg-sky-100/80 text-sky-800 font-bold' : 'text-slate-600 hover:text-slate-900' ?>">
                                            <span><?= htmlspecialchars($colLabel) ?></span>
                                            <span class="inline-flex flex-col items-center justify-center w-4 h-4 rounded <?= $isSorted ? 'text-sky-600 font-bold' : 'text-slate-400 group-hover:text-slate-600' ?>">
                                                <?php if ($isSorted && $sortDir === 'asc'): ?>
                                                    ▲
                                                <?php elseif ($isSorted && $sortDir === 'desc'): ?>
                                                    ▼
                                                <?php else: ?>
                                                    ⇅
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($filteredData)): ?>
                                <tr>
                                    <td colspan="<?= count($columns) + 1 ?>" class="py-12 text-center text-slate-400 text-sm">
                                        ไม่พบรายการข้อมูลที่ค้นหา
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($filteredData as $idx => $row):
                                    $supplierRef = isset($row['เลขที่ส่งให้ Channel (Supplier Ref)']) ? $row['เลขที่ส่งให้ Channel (Supplier Ref)'] : '';
                                    $channel     = isset($row['Channel']) ? $row['Channel'] : '';
                                    $fileNo      = isset($row['File No']) ? $row['File No'] : '';
                                    $agent       = isset($row['Agent']) ? $row['Agent'] : '';
                                    $osRef       = isset($row['O/S Ref']) ? $row['O/S Ref'] : '';
                                    $hotel       = isset($row['โรงแรม']) ? $row['โรงแรม'] : '';
                                    $checkin     = isset($row['เช็คอิน']) ? $row['เช็คอิน'] : '';
                                    $status      = isset($row['สถานะในระบบ']) ? $row['สถานะในระบบ'] : '';

                                    $dupCount    = isset($supplierRefCounts[$supplierRef]) ? $supplierRefCounts[$supplierRef] : 1;

                                    // สี Badge ของสถานะ (สำหรับ Light Theme)
                                    $statusBadgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    if (strpos($status, 'ยกเลิกในระบบแล้ว') !== false) {
                                        $statusBadgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    } elseif (strpos($status, 'โดยผิดพลาด') !== false) {
                                        $statusBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                    }

                                    // สี Badge ของ Channel (สำหรับ Light Theme)
                                    $channelBadgeClass = $channel === 'Channex'
                                        ? 'bg-purple-50 text-purple-700 border-purple-200'
                                        : 'bg-sky-50 text-sky-700 border-sky-200';

                                    // เช็คว่า O/S Ref ตรงกับ Supplier Ref หรือไม่
                                    $isMatchingRef = ($supplierRef !== '' && $supplierRef === $osRef);
                                ?>
                                    <tr class="hover:bg-sky-50/50 even:bg-slate-50/50 transition">
                                        <td class="py-3 px-3 text-center font-mono text-slate-400">
                                            <?= $idx + 1 ?>
                                        </td>
                                        <td class="py-3 px-3.5 font-mono font-semibold text-slate-900 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span><?= htmlspecialchars($supplierRef) ?></span>
                                                <?php if ($dupCount > 1): ?>
                                                    <span class="text-[10px] px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 border border-slate-200 font-medium" title="พบซ้ำ <?= $dupCount ?> รายการ">
                                                        ×<?= $dupCount ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3.5 whitespace-nowrap">
                                            <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-medium border <?= $channelBadgeClass ?>">
                                                <?= htmlspecialchars($channel) ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-3.5 font-mono font-medium text-indigo-600 whitespace-nowrap">
                                            <?= htmlspecialchars($fileNo) ?>
                                        </td>
                                        <td class="py-3 px-3.5 text-slate-600 whitespace-nowrap">
                                            <?= htmlspecialchars($agent) ?>
                                        </td>
                                        <td class="py-3 px-3.5 font-mono whitespace-nowrap <?= $isMatchingRef ? 'text-sky-600 font-semibold' : 'text-slate-600' ?>">
                                            <?= htmlspecialchars($osRef) ?>
                                        </td>
                                        <td class="py-3 px-3.5 font-medium text-slate-900">
                                            <?= htmlspecialchars($hotel) ?>
                                        </td>
                                        <td class="py-3 px-3.5 whitespace-nowrap text-slate-600">
                                            <?= htmlspecialchars($checkin) ?>
                                        </td>
                                        <td class="py-3 px-3.5">
                                            <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium border <?= $statusBadgeClass ?>">
                                                <?= htmlspecialchars($status) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>

</html>