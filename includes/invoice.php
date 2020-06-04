<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hello LINE BOT</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <h1>Hello Line bot</h1>
        <p>今天是 <?php echo date("Y m d"); ?></p>
        <?php

if ($message['text'] == "統一發票"){

            $url = "http://invoice.etax.nat.gov.tw";
            $page = file_get_contents($url);

            // echo $page;
            $msg="";
            if ($page) {

                libxml_use_internal_errors(true);

                $dom = new DOMDocument();
                $dom->loadHTML($page);

                // 用 tag 名稱擷取
                $h2s = $dom->getElementsByTagName('h2');
               $msg = "開獎期間：".$h2s[1]->textContent."\n";

                $xpath = new DOMXPath($dom);
                // 用 class 名稱擷取
                $nodes = $xpath->query("//span[contains(@class,'t18Red')]");
                $count = $nodes->length;
                $dates = $xpath->query("//p[contains(@class,'date')]");
                // echo "<p>Number:$count</p>";

                if ($count>0) {
                    $msg = "特別獎 ".$nodes[0]->textContent."\n";
                    $msg = "特獎 ".$nodes[1]->textContent."\n";
                    $msg = "頭獎 ".$nodes[2]->textContent."\n";
                    $msg = "增開六獎 ".$nodes[3]->textContent."\n";
                    // foreach ($nodes as $node) {
                    // echo "<p>".$node->textContent."</p>";
                    // }
                    $msg = .$dates[0]->textContent."</p>";
                    echo '<p>資料來源(財政部稅務入口網):<a href="'.$url.'" target="_blank">'.$url.'</a></p>';
                } else {
                    $msg = "查無資料:"."\n";
                }
                libxml_clear_errors();
            } else {
                $msg = "無法取得網頁"."\n";
            }

            /*
            $doc = new DOMDocument();
            $doc -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
            echo $doc->saveHTML();
            */
}
        ?>
    </body>
</html>