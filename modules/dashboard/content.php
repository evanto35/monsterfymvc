<div class="row">
    <?php foreach($this->data as $Dto): ?>
        <div class="col-sm-6 col-md-4">
    	    <div class="caption">
    	    	<h3>
	    	    	<a href="../<?php echo $Dto->name; ?>" class="thumbnail">
            	    	<img src="<?php echo $Dto->icon; ?>" />
                    	<?php echo $Dto->title; ?>
            		</a>
            	</h3>
            </div>
		</div>
    <?php endforeach; ?>
</div>