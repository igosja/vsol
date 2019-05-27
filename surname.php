<?php

try {
    include(__DIR__ . '/include/include.php');
    include(__DIR__ . '/include/simplehtmldom_1_8_1/simple_html_dom.php');

    $surnameArray = [];
    for ($i=1; $i<=10; $i++) {
        $html = file_get_html('https://virtualsoccer.ru/plrz_show.php?nat_id=154&sort=1&page=' . $i);
        $table = $html->find('.tbl', 0);
        $trArray = $table->find('tr');
        foreach ($trArray as $tr) {
            $playerLink = $tr->find('a', 0);
            if ($playerLink) {
                $player = explode(' ', $playerLink->innertext);

                if (!isset($player[1])) {
                    continue;
                }

                $player = end($player);
                if (false !== strpos($player, '-')) {
                    continue;
                }

                if (false !== strpos($player, '.')) {
                    continue;
                }

                if (false !== strpos($player, '\'')) {
                    continue;
                }

                if (!in_array($player, $surnameArray)) {
                    $surnameArray[] = $player;
                }
            }
        }
    }

    sort($surnameArray);

    include(__DIR__ . '/view/layout.php');
} catch (Throwable $e) {
    print '<pre>';
    print_r($e->__toString());
    exit;
}
