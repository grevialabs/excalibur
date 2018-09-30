<html>
<head>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <style type="text/css" >
    @page {
        margin: 25px 18px;
    }
    *{
        color: #111;
    }
    body {
        font-size: 11pt;
        padding: 107.402pt 56.693pt 99.213pt 53.858pt;
        margin: 0;
    }
        div.page
        {
            overflow:hidden;
            page-break-after: always;
            page-break-inside: avoid;
        }
    </style>

    <script type="text/php">
        if (isset($pdf)) {
            $x = 250;
            $y = 10;
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $font = null;
            $size = 14;
            $color = array(255,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</head>
<body>


<div class="page">
<h2>Invoice</h2>
Heello from pdf total page {!! $PAGE_COUNT or ''!!} <span id="lbl_totpage"></span>

</div>
<div class="page">ini hal 3</div>
<div class="page">ini hal 4</div>
<div class="page">ini hal 5</div>
</body>

<script>
$(document).ready(function (){
    var height = $( document ).height();
    height = 'koplak';
    $('#lbl_totpage').html(height + 'px');
});
</script>

</html>
