<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<h1><?php echo $page->title()->html() ?></h1>

		<div class="row">
			<div class="small-12 medium-6 large-7 columns">
				<?php snippet('product.gallery') ?>
			</div>
			
			<section class="small-12 medium-6 large-5 columns">
				<?php $variants = $page->variants()->toStructure() ?>
				<?php if (count($variants)) { ?>
					<ul class="variants small-block-grid-1 medium-block-grid-2">
						<?php foreach ($variants as $variant) { ?>
							<li>
								<div class="small-12 columns">
									<strong><?php echo $variant->name() ?></strong>
									<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()) ?>
								</div>
					            <form class="small-12 columns" method="post" action="<?php echo url('shop/cart') ?>">
					                <input type="hidden" name="action" value="add">
					                <input type="hidden" name="uri" value="<?php echo $page->uri() ?>">
					                <input type="hidden" name="variant" value="<?php echo str::slug($variant->name()) ?>">
									<?php $options = str::split($variant->options()) ?>
									<?php if (count($options)) { ?>
										<select name="option">
											<?php foreach ($options as $option) { ?>
												<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
											<?php } ?>
										</select>
									<?php } ?>

									<?php if (inStock($variant)) { ?>
										<button class="tiny expand" type="submit"><?php echo l::get('buy') ?> <?php echo formatPrice($variant->price()->value) ?></button>
									<?php } else { ?>
										<button class="tiny expand" disabled><?php echo l::get('out-of-stock') ?> <?php echo formatPrice($variant->price()->value) ?></button>
									<?php } ?>
					            </form>
					        </li>
						<?php } ?>
					</ul>
				<?php } ?>
			</section>

			<div class="description small-12 columns">
				<?php echo $page->text()->kirbytext() ?>

				<?php $tags = str::split($page->tags()) ?>
				<?php if (count($tags)) { ?>
					<div class="panel tags">
						<?php foreach ($tags as $tag) { ?>
							<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>"><?php echo $tag ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<!-- Related products -->
		<?php
			$index = $pages->index();
			$products = [];
			foreach ($page->relatedproducts()->toStructure() as $slug) {
				$product = $index->findByURI($slug->product());
				if($product->isVisible()) {
					$products[] = $product;
				}
			}
		?>
		<?php if (count($products)) { ?>
			<section class="related">
				<h3><?php echo l::get('related-products') ?></h3>
				<?php snippet('list.product',['products' => $products]) ?>
			</section>
		<?php } ?>

<?php snippet('footer') ?>