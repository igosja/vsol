<h1>Фамилии (<?= count($surnameArray); ?>)</h1>
<div class="row">
    <div class="col-lg-12">
        <?php foreach ($surnameArray as $item) { ?>
            '<?= $item; ?>',
            <br/>
        <?php } ?>
    </div>
</div>