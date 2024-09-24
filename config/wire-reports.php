<?php

return [
    'pdf_export_by' => 'snappy', // snappy or mpdf
    'pdf_paper_size' => 'A4', // A3, A4, A5, Legal, Letter, Tabloid
    'pdf_orientation' => 'Portrait', // landscape or Portrait
    'default_download_file_name' => 'report',
    'default_pagination' => 10,
    'snappy' => [
        'pdf' => [
            'orientation' => 'landscape',
            'options' => [
                'no-outline' => true,
                'margin-left' => '0',
                'margin-right' => '0',
                'margin-top' => '0',
                'margin-bottom' => '0',
            ],
        ],
    ],
    'mpdf' => [
        'pdf' => [
            'orientation' => 'landscape',
            'options' => [
                'margin_left' => '0',
                'margin_right' => '0',
                'margin_top' => '0',
                'margin_bottom' => '0',
            ],
        ],
    ],
    'excel' => [
        'xlsx' => [
            'extension' => 'xlsx',
        ],
        'csv' => [
            'extension' => 'csv',
        ],
    ],
];
