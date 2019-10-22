<?php 
$JSV = time();
// $JSV = '21102019';
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css?{{ $JSV }}" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js?{{ $JSV }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    body{font-size:12px}

    .header{padding-top: 25px; text-align:center}
    .footer{padding-top: 25px; text-align:center}
    .talCnt{text-align:center{}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 header">
            HEADER<br/>
            <?php if (isset($HEADER)) echo $HEADER; ?><hr/>
            </div>

            <div class="col-12"><br/>
            <?php if (isset($CONTENT)) echo $CONTENT; ?>
            </div>
            
            <div class="col-12 footer"><hr/>
            copyright &copy; 2019
            </div>
        </div>
    </div>
</body>
</html>