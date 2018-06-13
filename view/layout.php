<?php
/**
 * @var string $tpl
 */
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
            <a class="navbar-brand" href="/index.php">ВСОЛ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/real_team.php">Реальные команды</a></li>
                <li><a href="/news.php">Новости</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="starter-template">
        <?php include (__DIR__ . '/' . $tpl); ?>
    </div>
</div>
</body>
</html>