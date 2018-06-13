<h1>Президенсткие новости</h1>
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
                <input name="game" class="form-control"/>
                <input class="btn btn-default" type="submit" value="Новость о матче"/>
            </form>
        <?php } ?>
    </div>
</div>