<!-- Start Header Area -->
<?php include "header.php" ;
	if (isset($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;
	$pageLimit = 15;
	$offset = ($page - 1) * $pageLimit; 
	$searchSuggestionList = searchProductList(htmlspecialchars(htmlspecialchars($_GET['key'],ENT_QUOTES),ENT_QUOTES),$offset,$pageLimit,"");
	//$countSuggestionList  = countSearchProductList($_GET['key']);
?>
<!-- End Header Area -->
		
		<!-- Product Style -->
		<section class="product-area shop-sidebar shop section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-2 col-md-4 col-12">
						<div class="shop-sidebar">
							<!-- Shop By Price -->
							<div class="single-widget range">
								<h3 class="title">Sort By</h3>
								<ul class="check-box-list">
									<li>
										<label class="checkbox-inline" for="1" id="lblhl"><input type="radio" id="hl" name="sort-order" value="hl">Price High to Low</label>
									</li>
									<li>
										<label class="checkbox-inline" for="2" id="lbllh"><input type="radio" id="lh" name="sort-order" value="lh">Price Low to High</label>
									</li>
									<li>
										<label class="checkbox-inline" for="3" id="lblaz"><input type="radio" id="az" name="sort-order" value="az">A - Z</label>
									</li>
								</ul>
							</div>
							<!--/ End Shop By Price -->
						</div>
					</div>
					<div class="col-lg-10 col-md-8 col-12">
						<div class="row product-list">
						<?php 
							if($searchSuggestionList->num_rows > 0)	{ 
							for($i=0; $o = mysqli_fetch_object($searchSuggestionList); $i++) {
						?>
							<div class="col-lg-3 col-md-6 col-12">
								<div class="single-product">
									<div class="product-img">
										<a href="product/<?php echo $o-> vUrlName;?>">
											<img class="default-img" src="uploads/products/sml_<?php echo $o-> vSmallImage;?>" alt="<?php echo $o-> vSmallImage_AltTag;?>">
										</a>
									</div>
									<div class="product-content">
										<h3><a href="product/<?php echo $o-> vUrlName;?>"><?php echo $o-> vName;?></a></h3>
										<?php if ( $o->iStockQty > 0 && $o->iSold > 0 ) { ?>
										<span class="special-quantity-message"><?php echo 'Sold '.$o->iSold.' of '.$o->iStockQty;?></span>
										<?php } ?>
										<div class="product-price">
											<span><b>&#8377; <?php echo $o->fPrice ;?></b></span>
										</div>
									</div>
								</div>
							</div>
						<?php } 
						} else { ?>
							<div class="col-lg-12 col-md-8 col-12">
								<h3><br><center><span>No Results Found</span></center></h3>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Product Style 1  -->	
		
		<!-- Start Footer Area -->
        <?php include "footer.php" ?>
		<!-- /End Footer Area -->
		<script>
			$(".checkbox-inline").click(function() {
				var order = $(this).attr("id").replace('lbl','');
				$('#'+order).prop("checked", true);
				var data = 'query=<?php echo $_GET['key']?>&offset=<?php echo $offset?>&pageLimit=<?php echo $pageLimit?>&order='+order;
				$.ajax({
					url: 'config/api.php',
					type: 'GET',
					data: data,
					success: function(response) {
						$('.product-list').html(response);
					},
					error: function(response) {
						alert(data.responseText);
					}
				});
			});
		</script>
</body>
</html>