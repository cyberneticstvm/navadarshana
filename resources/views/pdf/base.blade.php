<!DOCTYPE html>
<html>

<head>
    <title>Navadarshana Educations</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            font-weight: normal;
        }

        .font-big {
            font-size: 15px;
        }

        .text-center {
            text-align: center;
        }

        .text-right,
        .text-end {
            text-align: right;
        }

        .table,
        .no-border {
            border: none !important;
        }

        .mx-auto {
            margin: 0 auto !important;
        }

        .bordered td,
        .bordered th,
        .bordered {
            border: 1px solid #e6e6e6;
        }

        .border-0 {
            border: 0;
        }

        th,
        td {
            border: 1px solid #262525;
            padding: 5px;
            text-align: left;
        }

        .pd-1 {
            padding: 3px !important;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-30 {
            margin-top: 30px;
        }

        .mt-50 {
            margin-top: 50px;
        }

        .pt-50 {
            padding-top: 50px;
        }

        .mt-100 {
            margin-top: 100%;
        }

        .mb-50 {
            margin-bottom: 50px;
        }

        .h-50>tr>td {
            height: 50px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-danger {
            color: red;
        }

        .txt {
            font-size: 10px !important;
        }

        .b-0 {
            border-bottom: none !important;
            border-top: none !important;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>

<body>
    <div class="container">
        @yield("pdfContent")
    </div>
</body>

</html>