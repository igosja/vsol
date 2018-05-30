<?php

include(__DIR__ . '/simplehtmldom_1_5/simple_html_dom.php');

if (isset($_POST['html']))
{
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
        $playerArray[] = array(
            'name' => str_replace('"', '', $player[8]),
            'link' => str_replace('"', '', $player[7]),
            'country' => $player[4],
            'lineup' => $player[9],
            'p_gk' => $player[10],
            'p_def' => $player[12],
            'p_mid' => $player[15],
            'p_for' => $player[18],
        );
    }
    print '<pre>';
    print_r($teamUrl);
    print '<pre>';
    print_r($playerArray);
    exit;
}
?>
<form method="post">
    <textarea name="html"></textarea>
    <input type="submit"/>
</form>