<?php

include(__DIR__ . '/simplehtmldom_1_5/simple_html_dom.php');

if (isset($_POST['html'])) {
    $html = $_POST['html'];
    $html = str_get_html($html);
    $innertext = $html->innertext;
    $innertext = explode('var arr_mainlinks=', $innertext);
    $teamlinks = $innertext[1];
    $teamlinks = explode('var num_links', $teamlinks);
    $teamlinks = $teamlinks[0];
    $teamlinks = str_replace('[  [', '', $teamlinks);
    $teamlinks = str_replace(']  ];', '', $teamlinks);
    $teamlinks = explode('],  [', $teamlinks);
    $teamUrl = array();
    foreach ($teamlinks as $teamlink) {
        $teamlink = explode(',', $teamlink);
        $teamlink = $teamlink[1];
        $teamlink = str_replace('"', '', $teamlink);
        $teamlink = str_replace('en//', 'en/z/', $teamlink);
        $teamlink = str_replace('http://', 'https://', $teamlink);
        $teamUrl[] = $teamlink;
    }


    $players = $innertext[1];
    $players = explode('var plrdata=', $players);
    $players = $players[1];
    $players = explode('/* ]]> */', $players);
    $players = $players[0];
    $players = str_replace('[  [', '', $players);
    $players = str_replace(']  ];', '', $players);
    $players = explode('],  [', $players);
    $playerArray = array();
    foreach ($players as $player) {
        $player = explode(', ', $player);
        $link = str_replace('"', '', $player[7]);
        $link = str_replace('en//', 'en/z/', $link);
        $link = str_replace('http://', 'https://', $link);
        if ($link) {
            $playerArray[] = array(
                'name' => str_replace('"', '', $player[8]),
                'link' => $link,
                'country' => $player[4],
                'lineup' => $player[9],
                'p_gk' => $player[10],
                'p_def' => $player[12],
                'p_mid' => $player[15],
                'p_for' => $player[18],
            );
        }
    }


    $playerTmArray = array();

    foreach ($teamUrl as $lineup => $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_URL, $url);
        $html = curl_exec($ch);
        curl_close($ch);
        $html = str_get_html($html);
        $table = $html->find('.items', 0);
        if ($table) {
            $tableTr1 = $table->find('tr[class=odd]');
            $tableTr2 = $table->find('tr[class=even]');
            $tableTr = array_merge($tableTr1, $tableTr2);
            foreach ($tableTr as $tr) {
                $tdPosition = $tr->find('td', 0);
                $aPlayer = $tr->find('td', 1)->find('table', 0)->find('tr', 0)->find('td', 1)->find('a', 0);
                $link = $aPlayer->href;
                $link = explode('/', $link);
                $link = end($link);
                $imgCountry = $tr->find('td', 6)->find('img', 0);
                $playerTmArray[] = array(
                    'name' => $aPlayer->innertext,
                    'link' => 'http://www.transfermarkt.co.uk/en//profil/spieler/' . $link,
                    'country' => $imgCountry->title,
                    'lineup' => $lineup + 1,
                    'position' => $tdPosition->title,
                );
            }
        }
    }

    foreach ($playerTmArray as $keyTm => $playerTm) {
        foreach ($playerArray as $key => $player) {
            if ($playerTm['name'] == $player['name']) {
                unset($playerTmArray[$keyTm]);
                unset($playerArray[$key]);
            }
        }
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/starter-template.css">
    <script src="/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button
                    type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#navbar"
                    aria-expanded="false"
                    aria-controls="navbar"
            >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">ВСОЛ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/real_team.php">Реальные команды</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="starter-template">
        <h1>Реальные команды</h1>
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($playerTmArray) && isset($playerArray)) { ?>
                    <table class="table table-bordered table-hover table-responsive">
                        <tr>
                            <th colspan="5">Добавить игроков</th>
                        </tr>
                        <?php foreach ($playerTmArray as $item) { ?>
                            <tr>
                                <td><?= $item['name']; ?></td>
                                <td><?= $item['link']; ?></td>
                                <td><?= $item['country']; ?></td>
                                <td><?= $item['position']; ?></td>
                                <td><?= $item['lineup']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <table class="table table-bordered table-hover table-responsive">
                        <tr>
                            <th colspan="4">Удалить игроков</th>
                        </tr>
                        <?php foreach ($playerArray as $item) { ?>
                            <tr>
                                <td><?= $item['name']; ?></td>
                                <td><?= $item['link']; ?></td>
                                <td><?= $item['country']; ?></td>
                                <td><?= $item['lineup']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <form method="post">
                        <textarea name="html" class="form-control" rows="10"></textarea>
                        <input class="btn btn-default" type="submit" value="Сверить данные"/>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>