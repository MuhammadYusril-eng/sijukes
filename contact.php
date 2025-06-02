                
<?php
include 'partials/header.php';
?>
    <!-- start slider section -->
    <section class="wow animate__fadeInDown p-0">
        <div class="swiper-container slider-half-screen black-move" data-slider-options='{ "loop": true, "slidesPerView": "1", "allowTouchMove":true, "autoplay": "false", "keyboard": { "enabled": true, "onlyInViewport": true }, "navigation": { "nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev" }, "pagination": { "el": ".swiper-pagination", "clickable": true } }' style="height:  400px !important;">
            <div class="swiper-wrapper">
                <!-- start slider item -->
                <div class="swiper-slide cover-background sm-background-image-center" style="background-image:url(https://balitourismboard.id/uploads/image/slider/pexels-photo-737533.jpeg);">
                    <div class="container-fluid position-relative h-100">
                        <div class="row h-100">
                            <div class="col-12 d-flex flex-column justify-content-center padding-ten-left sm-padding-five-left h-100">
                                                                    <span class="text-extra-large alt-font text-white font-weight-700 w-25 margin-20px-top sm-margin-20px-tb d-block md-w-60">Contact</span>
                                                                <span class="separator-line-horrizontal-medium-light2 idep-bg-kuning d-table w-100px text-left margin-20px-top sm-margin-20px-tb"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end slider item -->
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination-white swiper-pagination swiper-pagination-square"></div>
            <!--<div class="swiper-button-next light"><i class="ti-angle-right"></i></div>
            <div class="swiper-button-prev light"><i class="ti-angle-left"></i></div>-->
        </div>
    </section>
    <!-- end slider section -->

<section class="wow animate__fadeInDown">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-xs-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.226396575929!2d115.23552947531354!3d-8.670007188250935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240f476ad688b%3A0xccd510c041dba68e!2sBali%20Tourism%20Board!5e0!3m2!1sen!2sid!4v1714640172691!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                <div class="contactInfo">
                    <ul class="list-unstyled list-address">
                        <li>
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            Jalan Prof. Moh. Yamin No. 17X, Denpasar 80229, Bali - Indonesia                        </li>
                        <li>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                                                                                                <a href="tel:+62 361 235 600">+62 361 235 600</a>
                                                                    <a href="tel:+62 361 239 200">+62 361 239 200</a>
                                                                                    </li>
                        <li>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                                                <a href="mailto:balitourismboard@gmail.com">balitourismboard@gmail.com</a>
                                                                                    </li>
                        
                                                                                <li>
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                <a href="http://facebook.com/btbbali" target="_blank">Facebook</a>
                                </li>
                                                        <li>
                                <i class="fab fa-lg fa-instagram" aria-hidden="true"></i>
                                <a href="https://www.instagram.com/balitourismboardofficial/" target="_blank">Instagram</a>
                                </li>
                                                                            
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-xs-12">
                <div class="signUpFormArea">
                    <div class="priceTableTitle">
                        <h5 class="alt-font text-extra-dark-gray font-weight-600 text-uppercase m-0">Get in Touch</h5>
                        <p>Please feel free to contact us if you have queries, require more information or have any other request.</p>
                    </div>
                    <div class="signUpForm">
                        <a name="contactfomr"></a><form  enctype="multipart/form-data" method="post" class="k_form" id="contactform" name="contactfomr" action="#contactfomr" accept-charset="utf-8">                            <div class="formSection">
                                <div class="row">

                                    
                                    

                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="companyName" class="control-label">Subject*</label>
                                        <input type="text" name="subject"  id="subject" value=""  class="form-control"/>                                    </div>
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="companyName" class="control-label">Company Name*</label>
                                        <input type="text" name="company"  id="company" value=""  class="form-control"/>                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="yourName" class="control-label">Your Name*</label>
                                        <input type="text" name="name"  id="name" value=""  class="form-control"/>                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="emailAddress" class="control-label">Email Address*</label>
                                        <input type="text" name="email"  id="email" value=""  class="form-control"/>                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="textBox" class="control-label">Text*</label>
                                        <textarea  name="message"  id="message"  class="form-control" rows="3"></textarea>                                    </div>
                                    <div class="form-group col-xs-12 mb0">
                                        <input type="submit" name="submit"  id="submit" value="Send Now"  class="btn btn-primary btn-block"/>                                    </div>
                                </div>
                            </div>
                        <input type="hidden" name="k_hid_contactfomr" id="k_hid_contactfomr" value="contactfomr" /></form>                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'partials/footer.php';
?>