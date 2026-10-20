<?php

namespace App\Libraries;

use RuntimeException;
use ZipArchive;

/**
 * يبني ملف xlsx حقيقي بدون مكتبات خارجية.
 * يحتاج إضافة zip مفعّلة في PHP (extension=zip).
 * كل النصوص تُخزَّن كنص (inline string) فلا يمكن أن تتحول إلى صيغة.
 */
class SimpleXlsx
{
    public static function isAvailable(): bool
    {
        return class_exists(ZipArchive::class);
    }

    public static function build(string $sheetName, array $headers, array $rows): string
    {
        if (!self::isAvailable()) {
            throw new RuntimeException('إضافة zip غير مفعّلة في PHP');
        }

        $rows   = array_map('array_values', array_values($rows));
        $widths = self::columnWidths($headers, $rows);

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive();

        if ($zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('تعذر إنشاء ملف الإكسل');
        }

        $zip->addFromString('[Content_Types].xml', self::contentTypes());
        $zip->addFromString('_rels/.rels', self::rootRels());
        $zip->addFromString('xl/workbook.xml', self::workbook($sheetName));
        $zip->addFromString('xl/_rels/workbook.xml.rels', self::workbookRels());
        $zip->addFromString('xl/styles.xml', self::styles());
        $zip->addFromString('xl/worksheets/sheet1.xml', self::sheet($headers, $rows, $widths));

        if (!$zip->close()) {
            @unlink($tmp);
            throw new RuntimeException('تعذر حفظ ملف الإكسل');
        }

        $content = file_get_contents($tmp);
        @unlink($tmp);

        if ($content === false) {
            throw new RuntimeException('تعذر قراءة ملف الإكسل');
        }

        return $content;
    }

    // ===== عرض الأعمدة حسب أطول نص =====
    protected static function columnWidths(array $headers, array $rows): array
    {
        $widths = [];

        foreach ($headers as $i => $header) {
            $widths[$i] = self::textWidth((string) $header);
        }

        foreach ($rows as $row) {
            foreach ($row as $i => $value) {
                $w = self::textWidth((string) $value);
                if (!isset($widths[$i]) || $w > $widths[$i]) {
                    $widths[$i] = $w;
                }
            }
        }

        foreach ($widths as $i => $w) {
            $widths[$i] = max(10, min(60, $w + 4));
        }

        return $widths;
    }

    protected static function textWidth(string $text): float
    {
        $max = 0;

        foreach (preg_split('/\R/u', $text) ?: [] as $line) {
            $len = mb_strlen($line, 'UTF-8');
            if ($len > $max) {
                $max = $len;
            }
        }

        return $max * 1.2;
    }

    // ===== ملفات الـ XML =====
    protected static function sheet(array $headers, array $rows, array $widths): string
    {
        $cols = '';
        foreach ($widths as $i => $w) {
            $n     = $i + 1;
            $cols .= '<col min="' . $n . '" max="' . $n . '" width="' . number_format($w, 2, '.', '') . '" customWidth="1"/>';
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $xml .= '<sheetViews><sheetView workbookViewId="0" rightToLeft="1">'
              . '<pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/>'
              . '<selection pane="bottomLeft" activeCell="A2" sqref="A2"/>'
              . '</sheetView></sheetViews>';
        $xml .= '<sheetFormatPr defaultRowHeight="15"/>';
        $xml .= '<cols>' . $cols . '</cols>';
        $xml .= '<sheetData>';

        // صف العناوين
        $xml .= '<row r="1" ht="24" customHeight="1">';
        foreach ($headers as $i => $header) {
            $xml .= self::cell(self::colLetter($i) . '1', $header, 1);
        }
        $xml .= '</row>';

        // صفوف البيانات
        foreach ($rows as $r => $row) {
            $rowNum = $r + 2;
            $xml   .= '<row r="' . $rowNum . '">';
            foreach ($row as $i => $value) {
                $xml .= self::cell(self::colLetter($i) . $rowNum, $value, 2);
            }
            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';

        return $xml;
    }

    protected static function cell(string $ref, $value, int $style): string
    {
        if (is_int($value) || is_float($value)) {
            return '<c r="' . $ref . '" s="' . $style . '"><v>' . $value . '</v></c>';
        }

        return '<c r="' . $ref . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">'
            . self::clean((string) $value)
            . '</t></is></c>';
    }

    protected static function clean(string $text): string
    {
        // حذف الرموز غير المسموحة في XML
        $text = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $text) ?? '';

        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    protected static function colLetter(int $index): string
    {
        $letter = '';
        $n      = $index + 1;

        while ($n > 0) {
            $mod    = ($n - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $n      = intdiv($n - 1, 26);
        }

        return $letter;
    }

    protected static function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
    }

    protected static function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    protected static function workbook(string $sheetName): string
    {
        $name = preg_replace('/[\[\]\:\*\?\/\\\\]/u', '', $sheetName) ?? '';
        $name = mb_substr($name, 0, 31, 'UTF-8');
        if ($name === '') {
            $name = 'Sheet1';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<bookViews><workbookView xWindow="0" yWindow="0" windowWidth="16000" windowHeight="9000"/></bookViews>'
            . '<sheets><sheet name="' . self::clean($name) . '" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    protected static function workbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    protected static function styles(): string
    {
        $border = '<border>'
            . '<left style="thin"><color rgb="FFC5B298"/></left>'
            . '<right style="thin"><color rgb="FFC5B298"/></right>'
            . '<top style="thin"><color rgb="FFC5B298"/></top>'
            . '<bottom style="thin"><color rgb="FFC5B298"/></bottom>'
            . '<diagonal/></border>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2">'
            .   '<font><sz val="11"/><name val="Calibri"/></font>'
            .   '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '</fonts>'
            . '<fills count="3">'
            .   '<fill><patternFill patternType="none"/></fill>'
            .   '<fill><patternFill patternType="gray125"/></fill>'
            .   '<fill><patternFill patternType="solid"><fgColor rgb="FF02807A"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            .   '<border><left/><right/><top/><bottom/><diagonal/></border>'
            .   $border
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="3">'
            .   '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            .   '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">'
            .     '<alignment horizontal="center" vertical="center"/></xf>'
            .   '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1">'
            .     '<alignment horizontal="right" vertical="center" wrapText="1"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }
}