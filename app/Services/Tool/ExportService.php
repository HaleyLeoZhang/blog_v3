<?php
namespace App\Services\Tool;

// ----------------------------------------------------------------------
// 导出文件相关
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ExportService
{
    const EMPTY_STRING = '暂无数据';

    /**
     * 导出 Execl
     * 需要下载包支持 https://packagist.org/packages/maatwebsite/excel
     * - 需要在 config/app.php 配置
     * --- 配置 providers  Maatwebsite\Excel\ExcelServiceProvider::class,
     * --- 配置 aliases    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
     * @param string $file_title 文件名
     * @param array $ths 标题部分
     * @param array $tds 每行内容部分（二维数组）
     * @return string
     */
    public static function excel($file_title, $ths, $tds)
    {
        if (0 == count($tds)) {
            return self::EMPTY_STRING;
        }
        // 生成标题
        array_unshift($tds, $ths);
        \Excel::create($file_title, function ($excel) use ($tds, $file_title) {
            $excel->sheet($file_title, function ($sheet) use ($tds) {
                $sheet->rows($tds);
            });
        })->export('xls');
        return '';
    }

    /**
     * 导出 CSV
     * @param string $file_title 文件名
     * @param array $ths 标题部分
     * @param array $tds 每行内容部分（二维数组）
     * @return string
     */
    public static function csv($file_title, $ths, $tds)
    {
        if (0 == count($tds)) {
            return self::EMPTY_STRING;
        }
        $csv_row = '';
        // 生成标题
        array_unshift($tds, $ths);

        foreach ($tds as $td) {
            $one_row = [];
            foreach ($td as $key => $value) {
                if (is_numeric($value)) {
                    // $one_row[] = '=\"' .$value."\"";
                    $one_row[] = '="' . $value . '"';
                } else {
                    $one_row[] = '"' . $value . '"';
                }
            }
            $csv_row .= implode(',', $one_row) . "\n";
        }
        $csv_row = iconv('utf-8', 'gb2312', $csv_row);

        $filename = $file_title . '.csv';
        header('Content-Type: application/download');
        header('Content-type:text/csv');
        header('Content-Disposition:attachment;filename=' . $filename); // “生成文件名称”=自定义
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        return $csv_row;
    }

    
    protected function __contruct()
    {}


}
