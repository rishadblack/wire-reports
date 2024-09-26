<div>
    <style>
        /* Default layout for large screens (desktop) */
        .print-layout {
            all: unset;
            /* Reset inherited styles */
            display: block;
            width: 100%;
            /* Max width for A4 page */
            padding: 2mm;
            background: white;
            border: 1px solid #ccc;
            margin: 0 auto;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        /* Portrait (default A4 size) */
        .print-layout-portrait {
            max-width: 210mm;
            /* A4 width */
        }

        /* Landscape */
        .print-layout-landscape {
            max-width: 297mm;
            /* A4 height as width */
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .print-layout {
                width: 100%;
                /* Full width for smaller screens */
                max-width: 100%;
                /* No fixed max width */
                padding: 10px;
                /* Increase padding for readability on mobile */
            }
        }

        @media (max-width: 480px) {
            .print-layout {
                width: 100%;
                padding: 5px;
                /* Smaller padding for very small screens */
            }
        }

        /* Print-specific rules */
        @media print {
            .print-layout {
                all: unset;
                width: 210mm;
                height: 297mm;
                padding: 2mm;
                background: white;
                box-shadow: none;
                page-break-after: always;
            }

            .mt-2 {
                display: none;
                /* Hide pagination on print */
            }
        }

        /* Ensure content doesn't break inside elements */
        .print-layout * {
            page-break-inside: avoid;
            /* Avoid breaking rows or blocks between pages */
        }
    </style>

    <!-- Include view content here -->
    @includeIf($view)
    @if (config('wire-reports.show_pagination'))
        <!-- Pagination links for web view -->
        <div class="mt-2">
            {{ $datas->links() }}
        </div>
    @endif

</div>
