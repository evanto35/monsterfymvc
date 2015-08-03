<div class="row">
    <?php foreach($this->data as $Dto): ?>
        <div class="col-sm-6 col-md-4">
            <a href="../<?php echo $Dto->name; ?>" class="thumbnail">
                <img src="<?php echo $Dto->icon; ?>">
                <div class="caption">
                    <h3><?php echo $Dto->title; ?></h3>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>