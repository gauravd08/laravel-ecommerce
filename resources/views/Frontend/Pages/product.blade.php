@extends('layouts.front')

@section('content')

<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>CAtegory PAge</h4>
        <div class="site-pagination">
            <a href="">Home</a> /
            <a href="">Shop</a> /
        </div>
    </div>
</div>
<!-- Page info end -->

	<!-- product section -->
	<section class="product-section">
		<div class="container">
			<div class="back-link">
				<a href="./category.html"> &lt;&lt; Back to Category</a>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
						<img class="product-big-img" src="/assets/frontend/img/products/{{ $record[0]->id.'/'.$record[0]->ProductImage[0]->image }}" alt="">
					</div>
					<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
						<div class="product-thumbs-track">
							<?php $i = 1; ?>
							@foreach ($record[0]->ProductImage as $image)
								<?php  
									if($i == 1)
									{
										$class = 'pt active';
									}
									else
									{
										$class = 'pt';
									}
								?>
								<div class="{{ $class }}" data-imgbigurl="/assets/frontend/img/products/{{ $record[0]->id.'/'.$image->image }}"><img src="/assets/frontend/img/products/{{ $record[0]->id.'/thumb-'.$image->image }}" alt=""></div>
								<?php $i++; ?>
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-lg-6 product-details">
					<h2 class="p-title">White peplum top</h2>
					<h3 class="p-price">&#8377;{{ $record[0]->price }}</h3>
					<h4 class="p-stock">Available: 
						@if ($totalStock > 0)
							<span>In Stock</span>	
						@else
							<span>Out of Stock</span>
						@endif
					</h4>
					<div class="p-rating">
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o fa-fade"></i>
					</div>
					<div class="p-review">
						<a href="">3 reviews</a>|<a href="">Add your review</a>
					</div>
					{{ Form::open(['method' => 'POST','url' => '/cart']) }}
					<div class="fw-size-choose">
						<p>Size</p>
						@if ($record[0]->ProductSpecification[0]->xs_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="xs-size" class="size-class" value='xs' checked>
								<label for="xs-size">32</label>
							</div>
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="xs-size" disabled>
								<label for="xs-size">32</label>
							</div>
						@endif
						
						@if ($record[0]->ProductSpecification[0]->s_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="s-size" class="size-class" value='s'>
								<label for="s-size">34</label>
							</div>
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="s-size" disabled>
								<label for="s-size">34</label>
							</div>
						@endif
						
						@if ($record[0]->ProductSpecification[0]->m_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="m-size" class="size-class" value='m'>
								<label for="m-size">36</label>
							</div>
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="m-size" disabled>
								<label for="m-size">36</label>
							</div>
						@endif
						
						@if ($record[0]->ProductSpecification[0]->l_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="l-size" class="size-class" value='l'>
								<label for="l-size">38</label>
							</div>	
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="l-size" disabled>
								<label for="l-size">38</label>
							</div>
						@endif
						
						@if ($record[0]->ProductSpecification[0]->xl_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="xl-size" class="size-class" value='xl'>
								<label for="xl-size">40</label>
							</div>	
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="xl-size" disabled>
								<label for="xl-size">40</label>
							</div>
						@endif
						
						@if ($record[0]->ProductSpecification[0]->xl_quantity > 0)
							<div class="sc-item">
								<input type="radio" name="size" id="xxl-size" class="size-class" value='xxl'>
								<label for="xxl-size">42</label>
							</div>	
						@else
							<div class="sc-item disable">
								<input type="radio" name="size" id="xxl-size" disabled>
								<label for="xxl-size">42</label>
							</div>
						@endif
						
					</div>
					<div class="quantity">
						<p>Quantity</p>
                        <div class="pro-qty"><input type="text" value="1" name="quantity"></div>
					</div>

					<input type="hidden" name="product_id" value="{{ $record[0]->id }}">

					<input type="hidden" name="price" value="{{ $record[0]->price }}">

					<button type="submit" class="site-btn add-cart">SHOP NOW</button>
					
					{{ Form::close() }}
					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">information</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
									<p>Approx length 66cm/26" (Based on a UK size 8 sample)</p>
									<p>Mixed fibres</p>
									<p>The Model wears a UK size 8/ EU size 36/ US size 4 and her height is 5'8"</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
								<div class="panel-body">
									<img src="./img/cards.png" alt="">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">
									<h4>7 Days Returns</h4>
									<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="social-sharing">
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-pinterest"></i></a>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- product section end -->


	<!-- RELATED PRODUCTS section -->
	<section class="related-product-section">
		<div class="container">
			<div class="section-title">
				<h2>RELATED PRODUCTS</h2>
			</div>
			<div class="product-slider owl-carousel">
				<div class="product-item">
					<div class="pi-pic">
						<img src="./img/product/1.jpg" alt="">
						<div class="pi-links">
							<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
							<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
						</div>
					</div>
					<div class="pi-text">
						<h6>$35,00</h6>
						<p>Flamboyant Pink Top </p>
					</div>
				</div>
				<div class="product-item">
					<div class="pi-pic">
						<div class="tag-new">New</div>
						<img src="./img/product/2.jpg" alt="">
						<div class="pi-links">
							<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
							<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
						</div>
					</div>
					<div class="pi-text">
						<h6>$35,00</h6>
						<p>Black and White Stripes Dress</p>
					</div>
				</div>
				<div class="product-item">
					<div class="pi-pic">
						<img src="./img/product/3.jpg" alt="">
						<div class="pi-links">
							<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
							<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
						</div>
					</div>
					<div class="pi-text">
						<h6>$35,00</h6>
						<p>Flamboyant Pink Top </p>
					</div>
				</div>
				<div class="product-item">
						<div class="pi-pic">
							<img src="./img/product/4.jpg" alt="">
							<div class="pi-links">
								<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
								<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
							</div>
						</div>
						<div class="pi-text">
							<h6>$35,00</h6>
							<p>Flamboyant Pink Top </p>
						</div>
					</div>
				<div class="product-item">
					<div class="pi-pic">
						<img src="./img/product/6.jpg" alt="">
						<div class="pi-links">
							<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
							<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
						</div>
					</div>
					<div class="pi-text">
						<h6>$35,00</h6>
						<p>Flamboyant Pink Top </p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- RELATED PRODUCTS section end -->


@endsection

@push('view-scripts');
<script type="text/javascript">
	var size = 'xs';
	
	//set size on click
	$(".size-class").click(function(e)
	{
		size = $(this).val();
	});


	$(".add-cart").click(function(e){
		e.preventDefault();
		var product_id = {{ $record[0]->id }} ;
		var quantity = $("input[name=quantity]").val();
		var price = {{ $record[0]->price }};
		var finalPrice = parseInt(price) * parseInt(quantity);
		$.ajax({
			type:'POST',
			url:'/add-to-cart',
			data:{product_id:product_id, quantity:quantity, price:finalPrice, size:size},
			success:function(data)
			{
				console.log(data);
				location.href = "/cart";
			}

		});

	});
</script>
@endpush;