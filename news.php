<?php

include (__DIR__ . '/include/include.php');
include(__DIR__ . '/include/simplehtmldom_1_5/simple_html_dom.php');


if (isset($_POST['game'])) {
    $html = $_POST['game'];
    $html = new simple_html_dom();
    $html->load_file($_POST['game']);
    $table = $html->find('table', 6)->find('td', 1);
    $home = $table->find('a', 0);
    $guest = $table->find('a', 1);
    $score = $table->find('b', 2);
    $scoreArray = explode(':', $score);
    $scoreHome = $scoreArray[0];
    $scoreGuest = $scoreArray[1];
    $table = $html->find('table', 5)->find('td', 4);
    $stadium = explode('"', $table->plaintext);
    $stadium = $stadium[1];
    $visitor = explode('Зрителей: ', $table->plaintext);
    $visitor = end($visitor);
    $visitor = explode('. Билет:', $visitor);
    $visitor = $visitor[0];
    $visitor = str_replace(' ', '', $visitor);
    $table = $html->find('table', 7);
    $positionHome = $table->find('td', 2)->plaintext;
    $positionGuest = $table->find('td', 4)->plaintext;
    $tacticHome = $table->find('td', 7)->plaintext;
    $tacticGuest = $table->find('td', 9)->plaintext;
    $moodHome = $table->find('td', 25)->plaintext;
    $moodGuest = $table->find('td', 27)->plaintext;
    $table = $html->find('table', 22);
    $trArray = $table->find('tr');
    unset($trArray[0]);
    unset($trArray[1]);
    unset($trArray[2]);
    unset($trArray[3]);
    $eventArray = array();
    foreach ($trArray as $tr) {
        $event = array();
        $tdArray = $tr->find('td');
        $event['minute'] = $tdArray[0]->plaintext;
        $event['type'] = $tdArray[1]->title;
        $event['team'] = $tdArray[2]->plaintext;
        $playerOne = $tdArray[3]->find('a', 0);
        if ($playerOne) {
            $event['playerOne'] = $playerOne->plaintext;
        }
        $playerTwo = $tdArray[3]->find('a', 1);
        if ($playerTwo) {
            $event['playerTwo'] = $playerTwo->plaintext;
        }
        $event['score'] = $tdArray[4]->plaintext;
        $eventArray[] = $event;
    }
    print '<pre>';
    print_r($home);
    print '<pre>';
    print_r($guest);
    print '<pre>';
    print_r($score);
    print '<pre>';
    print_r($scoreHome);
    print '<pre>';
    print_r($scoreGuest);
    print '<pre>';
    print_r($stadium);
    print '<pre>';
    print_r($visitor);
    print '<pre>';
    print_r($positionHome);
    print '<pre>';
    print_r($positionGuest);
    print '<pre>';
    print_r($tacticHome);
    print '<pre>';
    print_r($tacticGuest);
    print '<pre>';
    print_r($moodHome);
    print '<pre>';
    print_r($moodGuest);
    print '<pre>';
    print_r($eventArray);
    exit;
}

$text = [
    'visitor' => [
        'sun' => [
            '{visitor} зрителей на Progress загорают под ярким солнцем.',
        ],
        'good' => [
            '{visitor} зрителей собралось на {stadium}, где установилась хорошая для футбола погода.',
            'Прекрасная для футбола погода на Barons Arena, где собралось 54661 зрителей.',
        ],
        'cold' => [
            'В этот холодный и пасмурный день {visitor} зрителей собралось на Progress.',
        ],
        'rain' => [
            '{visitor} зрителей пришло на {stadium} несмотря на сильный ливень.',
            'Целый день идет дождь, но {visitor} преданных болельщиков пришло на {stadium}.',
            '933 зрителей собралось на одесса стадиум, несмотря на угрожающие тучи на горизонте.',
            '324 зрителей собралось на Arsenal Vyshgorod Arena под идущим весь день дождем.',
        ],
    ],
];


include(__DIR__ . '/view/layout.php');