<?php echo Modules::run("base/header"); ?>
<?php echo Modules::run("base/menu"); ?>
<style>
* {box-sizing: border-box}
.mySlides1, .mySlides2 {display: none;}
img {vertical-align: middle;max-height:350px;}

/* Slideshow container */
.slideshow-container {
  max-width: 100%;
  max-height:350px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a grey background color */
.prev:hover, .next:hover {
  background-color: #f1f1f1;
  color: black;
}
</style>

<div class="main-container">
    <div id="content">
    <div class="slideshow-container">
  <div class="mySlides1">
    <img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-1.jpg" style="width:100%">
  </div>

  <div class="mySlides1">
    <img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-2.jpg" style="width:100%">
  </div>

  <div class="mySlides1">
    <img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-1.jpg" style="width:100%">
  </div>

  <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
  <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
</div>

        <div class="container">
            <div class="row">
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-left">
                    <div class="module sohomepage-slider ">
                        <div class="yt-content-slider"  data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="0" data-items_column00="1" data-items_column0="1" data-items_column1="1" data-items_column2="1"  data-items_column3="1" data-items_column4="1" data-arrows="no" data-pagination="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                            <div class="yt-content-slide">
                                <a href="#"><img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-1.jpg" alt="slider1" class="img-responsive"></a>
                            </div>
                            <div class="yt-content-slide">
                                <a href="#"><img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-2.jpg" alt="slider2" class="img-responsive"></a>
                            </div>
                            <div class="yt-content-slide">
                                <a href="#"><img src="<?php echo base_url()?>assets/image/catalog/slideshow/home2/slide-3.jpg" alt="slider3" class="img-responsive"></a>
                            </div>
                        </div>
                        
                        <div class="loadeding"></div>
                    </div>
                </div>
              -->
            </div>

            <div class="block-policy1">
              <ul>
                <li class="item-1">
                  <a href="#" class="item-inner">       
                    <div class="content">
                      <b>Free Shipping</b>
                      <span>From $99.00</span>
                    </div>
                  </a>
                </li>
                <li class="item-2">
                  <a href="#" class="item-inner">       
                      <div class="content">
                        <b>Money Guarantee</b>
                        <span>30 days back</span>
                      </div> 
                    </a>
                </li>
                <li class="item-3">
                  <a href="#" class="item-inner">       
                    <div class="content">
                      <b>Payment Method</b>
                      <span>Secure System</span>
                    </div>
                  </a>
                </li>
                <li class="item-4">
                  <a href="#" class="item-inner">       
                    <div class="content">
                      <b>Online Support</b>
                      <span>24 hours on day</span>
                    </div>
                  </a>
                </li>
                <li class="item-5">
                  <a href="#" class="item-inner">        
                    <div class="content">
                      <b>100% Safe</b>
                      <span>Secure shopping</span>
                    </div>
                  </a>
                </li>
              </ul>
            </div>

            <div id="so_categories_16425506561529398732" class="so-categories module custom-slidercates">
                <h3 class="modtitle"><span>Featured Products</span></h3>            
                <div class="form-group">
                  <a class="viewall" href="#">View All</a>                               
                </div>
            
                <div class="modcontent">
                    <div class="yt-content-slider cat-wrap" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="5" data-items_column0="5" data-items_column1="4" data-items_column2="3"  data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                        <?php
                        foreach($featured_product as $row)
                        {
                        
                        ?>
                        <div class="content-box">
                            <div class="image-cat">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                                <img src="<?php echo $row['image'];?>" alt="img">
                              </a>
                            </div>
                            <div class="cat-title">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                              <?php echo $row['product_name'];?>
                              </a>
                            </div>      
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mtop-50" style="margin-top:50px"></div>
            <div id="so_categories_16425506561529398732" class="so-categories module custom-slidercates">
                <h3 class="modtitle"><span>Deals of the day</span></h3>            
                <div class="form-group">
                  <a class="viewall" href="#">View All</a>                               
                </div>
            
                <div class="modcontent">
                    <div class="yt-content-slider cat-wrap" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="5" data-items_column0="5" data-items_column1="4" data-items_column2="3"  data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                        <?php
                        foreach($deals_day as $row)
                        {
                        
                        ?>
                        <div class="content-box">
                            <div class="image-cat">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                                <img src="<?php echo $row['image'];?>" alt="img">
                              </a>
                            </div>
                            <div class="cat-title">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                              <?php echo $row['product_name'];?>
                              </a>
                            </div>      
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            
            <div class="banners bannersb">
                <div class="banner">
                  <a href="#"><img src="<?php echo base_url()?>assets/image/catalog/banners/id2-banner-b.jpg" alt="image"></a>
                </div>
            </div>
            <div class="mtop-50" style="margin-top:50px"></div>
            <div id="so_categories_16425506561529398732" class="so-categories module custom-slidercates">
                <h3 class="modtitle"><span>Trending product</span></h3>            
                <div class="form-group">
                  <a class="viewall" href="#">View All</a>                               
                </div>
            
                <div class="modcontent">
                    <div class="yt-content-slider cat-wrap" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="5" data-items_column0="5" data-items_column1="4" data-items_column2="3"  data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                        <?php
                        foreach($trending_product as $row)
                        {
                        
                        ?>
                        <div class="content-box">
                            <div class="image-cat">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                                <img src="<?php echo $row['image'];?>" alt="img">
                              </a>
                            </div>
                            <div class="cat-title">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                              <?php echo $row['product_name'];?>
                              </a>
                            </div>      
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mtop-50" style="margin-top:50px"></div>
            <div id="so_categories_16425506561529398732" class="so-categories module custom-slidercates">
                <h3 class="modtitle"><span>Top Sales product</span></h3>            
                <div class="form-group">
                  <a class="viewall" href="#">View All</a>                               
                </div>
            
                <div class="modcontent">
                    <div class="yt-content-slider cat-wrap" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="5" data-items_column0="5" data-items_column1="4" data-items_column2="3"  data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                        <?php
                        foreach($top_sales_product as $row)
                        {
                        
                        ?>
                        <div class="content-box">
                            <div class="image-cat">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                                <img src="<?php echo $row['image'];?>" alt="img">
                              </a>
                            </div>
                            <div class="cat-title">
                              <a href="<?php echo base_url();?>" title="<?php echo $row['product_name'];?>">
                              <?php echo $row['product_name'];?>
                              </a>
                            </div>      
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mtop-50" style="margin-top:50px"></div>
            <div class="banners bannersb">
                <div class="banner">
                  <a href="#"><img src="<?php echo base_url()?>assets/image/catalog/banners/id2-banner-b.jpg" alt="image"></a>
                </div>
            </div>
            <div class="mtop-50" style="margin-top:50px"></div>
        </div>
    </div>
</div>
<!-- //Main Container -->
<?php echo Modules::run("base/footer"); ?>
<script>
  
var slideIndex = [1,1];
var slideId = ["mySlides1", "mySlides2"]
showSlides(1, 0);
showSlides(1, 1);

function plusSlides(n, no) {
  showSlides(slideIndex[no] += n, no);
}

function showSlides(n, no) {
  var i;
  var x = document.getElementsByClassName(slideId[no]);
  if (n > x.length) {slideIndex[no] = 1}    
  if (n < 1) {slideIndex[no] = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex[no]-1].style.display = "block";  
  setTimeout(showSlides, 2000);
}
</script>
   

    