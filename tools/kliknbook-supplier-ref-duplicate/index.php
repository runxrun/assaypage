<?php

/**
 * สคริปต์แปลงไฟล์ Excel (.xlsx) เป็น JSON แบบ Zero-Dependency
 * ไม่ต้องติดตั้ง composer หรือไลบรารีภายนอก
 */

function xlsxToJson($filename, $outputJsonFile = null)
{
    if (!file_exists($filename)) {
        die("ไม่พบไฟล์: {$filename}\n");
    }

    $zip = new ZipArchive();
    if ($zip->open($filename) !== true) {
        die("ไม่สามารถเปิดไฟล์ XLSX ได้\n");
    }

    // 1. อ่าน Shared Strings (ข้อความทั้งหมดในไฟล์ Excel)
    $sharedStrings = [];
    if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
        $xmlStrings = simplexml_load_string($zip->getFromIndex($index));
        foreach ($xmlStrings->si as $si) {
            $text = '';
            if (isset($si->t)) {
                $text = (string)$si->t;
            } elseif (isset($si->r)) {
                foreach ($si->r as $r) {
                    $text .= (string)$r->t;
                }
            }
            $sharedStrings[] = $text;
        }
    }

    // 2. ดึงข้อมูลแถวและเซลล์จาก Sheet1
    $sheetIndex = $zip->locateName('xl/worksheets/sheet1.xml');
    if ($sheetIndex === false) {
        die("ไม่พบชีตข้อมูลในไฟล์\n");
    }

    $sheetXml = simplexml_load_string($zip->getFromIndex($sheetIndex));
    $zip->close();

    $rows = [];
    foreach ($sheetXml->sheetData->row as $row) {
        $rowData = [];
        foreach ($row->c as $cell) {
            $cellRef = (string)$cell['r']; // เช่น A1, B4
            preg_match('/([A-Z]+)(\d+)/', $cellRef, $matches);
            $colLetter = $matches[1] ?? '';

            // แปลงรหัสคอลัมน์ A, B, C -> 0, 1, 2
            $colIndex = 0;
            for ($i = 0; $i < strlen($colLetter); $i++) {
                $colIndex = $colIndex * 26 + (ord($colLetter[$i]) - ord('A') + 1);
            }
            $colIndex -= 1;

            $type = (string)$cell['t'];
            $cellValue = '';

            if ($type === 's') { // ค่าเป็น String ที่อ้างอิงจาก sharedStrings
                $val = (string)$cell->v;
                $cellValue = $sharedStrings[(int)$val] ?? '';
            } elseif ($type === 'inlineStr') { // ค่าเป็น Inline String (<is><t>...</t></is>)
                if (isset($cell->is->t)) {
                    $cellValue = (string)$cell->is->t;
                } elseif (isset($cell->is->r)) {
                    foreach ($cell->is->r as $r) {
                        $cellValue .= (string)$r->t;
                    }
                }
            } else {
                $cellValue = (string)$cell->v;
            }

            $rowData[$colIndex] = $cellValue;
        }

        // จัดตำแหน่งคอลัมน์ให้เรียงตามลำดับ Index
        if (!empty($rowData)) {
            $maxCol = max(array_keys($rowData));
            $completeRow = [];
            for ($c = 0; $c <= $maxCol; $c++) {
                $completeRow[] = $rowData[$c] ?? '';
            }
            $rows[] = $completeRow;
        }
    }

    // 3. ตรวจหา Header Row อัตโนมัติ (แถวที่มีคำว่า File No และ Channel)
    $headerRowIndex = 0;
    foreach ($rows as $idx => $r) {
        $rowText = implode(' ', $r);
        if (strpos($rowText, 'File No') !== false && strpos($rowText, 'Channel') !== false) {
            $headerRowIndex = $idx;
            break;
        }
    }

    $headers = $rows[$headerRowIndex];
    $records = [];

    // 4. ประกอบข้อมูลลง Array
    for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
        $item = [];
        $hasData = false;
        foreach ($headers as $colIdx => $colName) {
            $colName = trim($colName);
            if (empty($colName)) continue;

            $val = trim($rows[$i][$colIdx] ?? '');
            $item[$colName] = $val;
            if ($val !== '') $hasData = true;
        }
        if ($hasData) {
            $records[] = $item;
        }
    }

    // 5. แปลงเป็น JSON พร้อมตั้งค่าภาษาไทย (JSON_UNESCAPED_UNICODE)
    $json = json_encode($records, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    if ($outputJsonFile) {
        file_put_contents($outputJsonFile, $json);
        echo "แปลงไฟล์สำเร็จ: บันทึกข้อมูล " . count($records) . " รายการไปที่ {$outputJsonFile}\n";
    }

    return $json;
}

// ระบุชื่อไฟล์ Excel ต้นทาง และชื่อไฟล์ JSON ปลายทาง
$inputFile = __DIR__ . '/kliknbook_supplier_reference_duplicate_31_pages_full.xlsx';
$outputFile = __DIR__ . '/kliknbook_duplicate_bookings.json';

xlsxToJson($inputFile, $outputFile);
