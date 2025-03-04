<?php

return [
    'pdf_export_by' => 'mpdf',       // snappy or mpdf
    'pdf_paper_size' => 'A4',        // A3, A4, A5, Legal, Letter, Tabloid
    'pdf_orientation' => 'portrait', // landscape or portrait
    'default_download_file_name' => 'report',
    'default_pagination' => 10,
    'show_reset_button' => true,
    'show_wide_view_button' => true,
    'show_export_button' => true,
    'show_pagination' => true,
    'snappy' => [
        'binary' => env('WKHTMLTOPDF_BINARY', '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"'),
        'timeout' => false,
        'options' => [],
        'no-outline' => true,
        'margin-left' => 5,
        'margin-right' => 5,
        'margin-top' => 5,
        'margin-bottom' => 5,
    ],
    'mpdf' => [
        'no-outline' => true,
        'default_font_size' => 12,
        'auto_language_detection' => true,
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 5,
        'margin_bottom' => 5,
        'default_font' => 'SolaimanLipi',
        'font_path' => public_path('fonts/'),
        'font_data' => [
            'solaimanlipi' => [
                'R' => 'SolaimanLipi.ttf',      // Regular
                'B' => 'SolaimanLipi-Bold.ttf', // Bold (if available)
            ],
        ],
    ],
    'export_options' => [
        ['type' => 'pdf', 'class' => 'btn-primary'],
        ['type' => 'xlsx', 'class' => 'btn-info'],
        ['type' => 'csv', 'class' => 'btn-warning'],
    ],
    'pdf_header' => [
        'html_view' => null, //Header location for html view like pdf_header.blade.php
        'left' => null,      //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
        'center' => null,    //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
        'right' => null,     //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
    ],
    'pdf_footer' => [
        'html_view' => null, //Footer location for html view like pdf_footer.blade.php
        'left' => null,      //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
        'center' => null,    //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
        'right' => null,     //current_page,total_page,current_page_and_total_page,date,time,date_and_time,custom text
    ],
];