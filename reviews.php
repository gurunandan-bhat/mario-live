<!-- Start Header Area -->
<?php include "header.php" ;
	if (isset($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;
	$pageLimit = 15;
	$offset = ($page - 1) * $pageLimit; 
	if (isset($_GET['key']))
        $productUrlName = $_GET['key'];
	$product        = mysqli_fetch_object(getProductByUrlName( $productUrlName ));
    $productReviews = getAllReviewsByProductId( $product->iProdID );
?>
<!-- End Header Area -->
<br>
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li><a href="product/<?php echo $product-> vUrlName;?>"><?php echo $product->vName; ?><i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="reviews/<?php echo $product-> vUrlName;?>">Reviews</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container review-container">
<section class="col-md-12">
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-header-rev">
				<a href="product/<?php echo $product-> vUrlName;?>">
                	<img class="default-img-review" src="uploads/products/sml_<?php echo $product-> vSmallImage;?>" alt="<?php echo $product-> vSmallImage_AltTag;?>">
				</a>
			</div>
            <div class="card-content">
                <div class="card-content-member">
					<a href="product/<?php echo $product-> vUrlName;?>">
						  <h6 class="m-t-0"><?php echo $product->vName; ?></h6><br>
					</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="review-block">
          	<div class="row">
            	<h5 class="review-product-title"><?php echo $product->vName; ?> Reviews</h5>
            </div>
          	<?php if($productReviews->num_rows > 0) { 
          		for($i=0; $o = mysqli_fetch_object($productReviews); $i++) {
          	?>
          	<hr>
            <div class="row">
                <div class="col-sm-2">
                    <div class="review-block-img">
                        <img src="images/user.jpg" class="img-rounded" alt="<?php echo str_replace(' ','_',strtolower($o->reviewer_name));?>">
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="review-block-title"><?php echo $o->reviewer_name; ?><br><p><?php echo date_format(date_create($o->datetime),"D, d M Y");?></p></div> 
                    <div class="review-block-description"><?php echo $o->review; ?></div>
                </div>
            </div>
          	<?php } } ?>
        </div>
      	<!-- <div class="pagination-tab">
          <?php 
				$total_pages = ceil($count/ $pageLimit);
         		echo '<ul class="pagination">';
                if($page > 1)
                	echo '<li><a href="'.SITE_ADDRESS.'all-reviews.php?product_id='.$product_id.'&page='.($page - 1).'">Previous</a></li>'; 
                for($i=1; $i<=$total_pages; $i++)	{
                  if($i == $page)
                    $active = "active"; 
                  else
                    $active = "";
                  echo '<li class="page-item '.$active.' ">
                        	<a class="page-link" href="'.SITE_ADDRESS.'all-reviews.php?product_id='.$product_id.'&page='.$i.'">'.$i.'</a> 
                        </li>';
                }
                if($total_pages > $page)
                	echo '<li><a href="'.SITE_ADDRESS.'all-reviews.php?product_id='.$product_id.'&page='.($page + 1).'">Next</a></li>';  
                echo '</ul>';
          ?>
      	</div> -->
    </div>
</div> 
</section>
</div> 	
		
		<!-- Start Footer Area -->
        <?php include "footer.php" ?>
		<!-- /End Footer Area -->
</body>
</html>