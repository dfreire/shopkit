<?php if(count($products)) { ?>
	<ul class="product featured listing small-block-grid-1 large-block-grid-2">
	  <?php foreach($products as $featuredProduct) { ?>
	  	  <?php $product = $featuredProduct['product'] ?>
		  <li>
		  	<?php
		  		// Get featured product's price for one-click button
		  		$price = $priceValue = false;
		  		foreach ($product->prices()->toStructure() as $variant) {
		  			// Assign the first price
		  			if (!$price) {
		  				$price = $variant;
		  				$priceValue = $variant->price()->value;
		  				continue;
		  			}

		  			// For each variant, override the price as necessary 
		  			if ($featuredProduct['calculation'] === 'low' and $variant->price()->value < $priceValue){
		  				$price = $variant;
		  				$priceValue = $variant->price()->value;		  				
		  			} else if ($featuredProduct['calculation'] === 'high' and $variant->price()->value > $priceValue) {
		  				$price = $variant;
		  				$priceValue = $variant->price()->value;		  				
		  			}
		  		}
		  	?>

		  	<a href="<?php echo $product->url() ?>" title="<?php echo $product->title()->html() ?>">
				<?php if($image = $product->images()->sortBy('sort', 'asc')->first()){ ?>
					<img src="<?php echo thumb($image,array('height'=>400))->dataUri() ?>" title="<?php echo $image->title() ?>"/>
				<?php } ?>
				<h5><?php echo $product->title()->html() ?></h5>
				<p class="variant"><?php echo $price->name() ?></p>
			</a>
            
            <form method="post" action="<?php echo url('shop/cart') ?>">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="uri" value="<?php echo $product->uri() ?>">
                <input type="hidden" name="variant" value="<?php echo str::slug($price->name()) ?>">
				<?php if ($options = str::split($price->options()->value)) { ?>
					<select name="option">
						<?php foreach ($options as $option) { ?>
							<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
						<?php } ?>
					</select>
				<?php } ?>

				<?php if (inStock($price)) { ?>
					<button class="small expand" type="submit"><?php echo l::get('buy') ?> <?php echo formatPrice($priceValue) ?></button>
				<?php } else { ?>
					<button class="small expand" disabled><?php echo l::get('out-of-stock') ?> <?php echo formatPrice($priceValue) ?></button>
				<?php } ?>
            </form>
		  </li>
	  <?php } ?>
	</ul>
<?php } ?>