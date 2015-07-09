<br />

<div class="row">
    <ul class="col-sm-6 col-md-4">
        <?php foreach($View->data as $Item): ?>
            <li class="thumbnail">
                <img src="<?php echo $Item->imageName; ?>">
                <div class="caption">
                    <h3><?php echo $Item->title; ?></h3>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>