<!-- FOOTER -->
<footer id="footer" class="footer layout-01">
    <div class="footer-content background-footer-03">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <section class="footer-item">
                        <a href="#" class="logo footer-logo"><img src="{{ asset('client/assets/images/logo.png') }}"
                                alt="Lucky Star logo" width="135" height="34"></a>
                        <div class="footer-phone-info mode-03">
                            <i class="biolife-icon icon-head-phone"></i>
                            <p class="r-info">
                                <span>Got Questions ?</span>
                                <span class="number">(043) 784-3987</span>
                            </p>
                        </div>
                        <div class="contact-info-block footer-layout simple-info">
                            <h4 class="title">Contact info</h4>
                            <div class="info-item">
                                <img src="{{ asset('client/assets/images/location-icon.png') }}" width="22"
                                    height="26" alt="" class="icon">
                                <p class="desc">Lot 9 Block 6 Mercedez Home Subdivision, San Miguel, Sto. Tomas
                                    Batangas</p>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12 ">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-12 md-margin-top-6px xs-margin-top-40px">
                            <section class="footer-item">
                                <h3 class="section-title">My Account</h3>
                                <div class="wrap-custom-menu vertical-menu-2">
                                    <ul class="menu">
                                        @guest
                                            <li><a href="{{ route('login') }}">Sign In</a></li>
                                        @endguest
                                        <li><a href="{{ route('address') }}">My Address</a></li>
                                        <li><a href="/orders">View Cart</a></li>
                                        <li><a href="{{ route('orders.track') }}">Track My Order</a></li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12 md-margin-top-6px xs-margin-top-40px">
                            <section class="footer-item">
                                <h3 class="section-title">Why Buy From Us</h3>
                                <div class="wrap-custom-menu vertical-menu-2">
                                    <ul class="menu">
                                        <li><a href="#" id="openShippingReturnsModal">Shipping & Returns</a></li>
                                        <li><a href="#" id="openSecureShoppingModal">Secure Shopping</a></li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12 md-margin-top-6px xs-margin-top-40px">
                            <section class="footer-item">
                                <h3 class="section-title">Information</h3>
                                <div class="wrap-custom-menu vertical-menu-2">
                                    <ul class="menu">
                                        <li><a href="#" id="openDeliveryModal">Delivery infomation</a></li>
                                        <li><a href="#" id="openPrivacyModal">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-section">
                <!-- Shipping & Returns Modal -->
                <div class="modal fade" id="shippingReturnsModal" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="modalLabel">Shipping & Returns</h4>
                            </div>
                            <div class="modal-body">
                                <h4>Shipping Information:</h4>
                                <ul>
                                    <li>We offer fast and reliable shipping within Batangas.</li>
                                    <li>Enjoy free shipping on orders over Php 2,500.</li>
                                    <li>You can expect your order to arrive within 1 to 3 hours after placing it.</li>
                                </ul>

                                <h4>Return Policy:</h4>
                                <ul>
                                    <li>You can return items only if they are damaged upon delivery.</li>
                                </ul>

                                <h4>Damaged or Defective Items:</h4>
                                <ul>
                                    <li>If your order arrives with visible damage, please take a short video while
                                        opening the package.</li>
                                    <li>This video will serve as the accepted proof of damage, helping us understand the
                                        situation better.</li>
                                    <li>If you have valid proof of the damage, please contact us immediately. We're here
                                        to assist you in requesting a replacement or refund.</li>
                                    <li>We'll guide you through the process and make sure you're taken care of.</li>
                                </ul>

                                <h4>Refunds and Store Credit:</h4>
                                <ul>
                                    <li>Refunds will be issued to your original payment method within 1 to 3 days.</li>
                                </ul>

                                <h4>Contact Us:</h4>
                                <ul>
                                    <li>For any shipping or returns inquiries, reach out to our friendly customer
                                        support team at <a
                                            href="mailto:support@luckystargroceries.com">support@luckystargroceries.com</a>.
                                    </li>
                                </ul>

                                <p class="text-center"><b>Shop with confidence at Lucky Star and enjoy
                                        the convenience of online shopping combined with exceptional service!</b></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Secure Shopping Modal -->
                <div class="modal fade" id="secureShoppingModal" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel">
                    <!-- Secure Shopping modal content ... -->
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="modalLabel">Secure Shopping</h4>
                            </div>
                            <div class="modal-body">
                                <h4>Secure Shopping at Lucky Star</h4>
                                <p>We prioritize your security and peace of mind when you shop online. We've implemented
                                    robust measures to ensure your personal and financial information is protected
                                    throughout your shopping journey.</p>

                                <ul>
                                    <li><strong>Data Encryption:</strong> We use advanced encryption technology to
                                        secure your data during transmission. This means that any information you share
                                        with us is encrypted and cannot be intercepted by unauthorized parties.</li>
                                    <li><strong>Payment Security:</strong> Our secure payment gateways are designed to
                                        process your transactions securely. You can confidently enter your payment
                                        details knowing that your information is protected.</li>
                                    <li><strong>Privacy Protection:</strong> Your privacy matters to us. We adhere to
                                        strict privacy policies to safeguard your personal information and ensure it's
                                        used only for the purpose of processing your orders.</li>
                                    <li><strong>Trusted Partners:</strong> We work with reputable and trusted partners
                                        to provide you with a seamless and secure shopping experience. These partners
                                        are also committed to upholding high standards of security.</li>
                                    <li><strong>Regular Audits:</strong> Our systems undergo regular security audits to
                                        identify and address any potential vulnerabilities. This proactive approach
                                        ensures that your information is safe at all times.</li>
                                    <li><strong>Stay Informed:</strong> We'll never ask you for sensitive information
                                        such as passwords or credit card details through unsolicited emails or messages.
                                        If you ever receive suspicious communication, please let us know immediately.
                                    </li>
                                </ul>

                                <p>At Lucky Star, you can shop with confidence, knowing that we take
                                    your security seriously. Your trust is our priority, and we're committed to
                                    providing you with a safe and secure online shopping experience.</p>

                                <p>If you have any questions or concerns about security, please don't hesitate to reach
                                    out to our dedicated customer support team at <a
                                        href="mailto:support@luckystargroceries.com">support@luckystargroceries.com</a>.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="privacyModal" tabindex="-1" role="dialog"
                    aria-labelledby="privacyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="privacyModalLabel">Privacy and Policy</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>At Lucky Star, we take your privacy seriously. Our Privacy Policy outlines how we
                                    handle your personal information to ensure your data is safe and secure:</p>

                                <ul>
                                    <li><strong>Information Collection:</strong> We collect necessary information to
                                        process your orders and improve your shopping experience.</li>
                                    <li><strong>Data Usage:</strong> Your information is used to fulfill orders,
                                        personalize your experience, and communicate with you.</li>
                                    <li><strong>Security Measures:</strong> We've implemented measures to protect your
                                        data from unauthorized access.</li>
                                    {{-- <li><strong>Cookies:</strong> We use cookies for a better user experience. By using
                                        our site, you agree to our Cookie Policy.</li> --}}
                                </ul>

                                {{-- <p>For more details, please read our complete <a href="#">Privacy Policy</a> and
                                    <a href="#">Cookie Policy</a>.</p> --}}

                                <p><strong>Contact Us</strong></p>
                                <p>If you have questions about your data or privacy, our customer support team is here
                                    to assist. Reach out to us at <a
                                        href="mailto:support@luckystar.com">support@luckystar.com</a>, and we'll be
                                    happy to help.</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog"
                    aria-labelledby="deliveryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="deliveryModalLabel">Delivery Information</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Getting fresh groceries to your doorstep is our priority at Lucky Star. Here's what
                                    you need to know:</p>

                                <h4>Delivery Options</h4>
                                <ul>
                                    <li><strong>Pickup on Store Location:</strong> Select this option to pick up your
                                        groceries directly from our store location.</li>
                                    <li><strong>Home Delivery:</strong> Choose the home delivery option to have your
                                        groceries delivered to your preferred address.</li>
                                </ul>

                                <h4>Estimated Time and Tracking</h4>
                                <ul>
                                    <li>During checkout, we'll provide an estimated time for pickup or home delivery.
                                        Once your order is ready for pickup or shipped, we'll notify you. No tracking
                                        number needed for store pickup.</li>
                                </ul>

                                <p><strong>Contact Us</strong></p>
                                <p>Need assistance with delivery or tracking? Our dedicated support team is available to
                                    help. Drop us an email at <a
                                        href="mailto:support@luckystargroceries.com">support@luckystargroceries.com</a>,
                                    and we'll assist you promptly.</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br>
        </div>

        <div class="copy-rights-contain">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="copy-right-text">
                            <p>Copyright &copy Lucky Star Convenient Store {{ date('Y') }}</p>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="payment-methods">
                                <ul>
                                    <li><a href="#" class="payment-link"><img src="{{asset('client/assets/images/card1.jpg')}}" width="51" height="36" alt=""></a></li>
                                    <li><a href="#" class="payment-link"><img src="{{asset('client/assets/images/card2.jpg')}}" width="51" height="36" alt=""></a></li>
                                    <li><a href="#" class="payment-link"><img src="{{asset('client/assets/images/card3.jpg')}}" width="51" height="36" alt=""></a></li>
                                    <li><a href="#" class="payment-link"><img src="{{asset('client/assets/images/card4.jpg')}}" width="51" height="36" alt=""></a></li>
                                    <li><a href="#" class="payment-link"><img src="{{asset('client/assets/images/card5.jpg')}}" width="51" height="36" alt=""></a></li>
                                </ul>
                            </div>
                        </div> --}}
                </div>
            </div>
        </div>

    </div>
</footer>

<!--Footer For Mobile-->
<div class="mobile-footer">
    <div class="mobile-footer-inner">
        <div class="mobile-block block-menu-main">
            <a class="menu-bar menu-toggle btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                <span class="fa fa-bars"></span>
                <span class="text">Menu</span>
            </a>
        </div>

        <div class="mobile-block block-minicart">
            @auth
                <a class="link-to-cart" href="{{ route('orders.checkout') }}">
                    <span class="fa fa-shopping-cart" aria-hidden="true"></span>
                    <span class="text">Cart</span>
                </a>
            @else
                <a class="link-to-cart" href="{{ route('products') }}">
                    <span class="fa fa-shopping-cart" aria-hidden="true"></span>
                    <span class="text">Products</span>
                </a>
            @endauth
        </div>

        <div class="mobile-block block-minicart">
            @auth
                <a class="link-to-cart" href="{{ route('account.index') }}">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <span class="text">Account</span>
                </a>
            @else
                <a class="link-to-cart" href="{{ route('login') }}">
                    <span class="fa fa-sign-in" aria-hidden="true"></span>
                    <span class="text">Login</span>
                </a>
            @endauth
        </div>
    </div>
</div>

<!--Quickview Popup-->
<div id="biolife-quickview-block" class="biolife-quickview-block">
    <div class="quickview-container">
        <a href="#" class="btn-close-quickview" data-object="open-quickview-block"><span
                class="biolife-icon icon-close-menu"></span></a>
        <div class="biolife-quickview-inner">
            <div class="media">
                <ul class="biolife-carousel quickview-for"
                    data-slick='{"arrows":false,"dots":false,"slidesMargin":30,"slidesToShow":1,"slidesToScroll":1,"fade":true,"asNavFor":".quickview-nav"}'>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_01.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_02.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_03.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_04.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_05.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_06.jpg') }}" alt=""
                            width="500" height="500"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/detail_07.jpg') }}" alt=""
                            width="500" height="500"></li>
                </ul>
                <ul class="biolife-carousel quickview-nav"
                    data-slick='{"arrows":true,"dots":false,"centerMode":false,"focusOnSelect":true,"slidesMargin":10,"slidesToShow":3,"slidesToScroll":1,"asNavFor":".quickview-for"}'>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_01.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_02.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_03.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_04.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_05.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_06.jpg') }}" alt=""
                            width="88" height="88"></li>
                    <li><img src="{{ asset('client/assets/images/details-product/thumb_07.jpg') }}" alt=""
                            width="88" height="88"></li>
                </ul>
            </div>
            <div class="product-attribute">
                <h4 class="title"><a href="#" class="pr-name">National Fresh Fruit</a></h4>
                <div class="rating">
                    <p class="star-rating"><span class="width-80percent"></span></p>
                </div>

                <div class="price price-contain">
                    <ins><span class="price-amount"><span class="currencySymbol">Php </span>85.00</span></ins>
                    <del><span class="price-amount"><span class="currencySymbol">Php </span>95.00</span></del>
                </div>
                <p class="excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel maximus lacus.
                    Duis ut mauris eget justo dictum tempus sed vel tellus.</p>
                <div class="from-cart">
                    <div class="qty-input">
                        <input type="text" name="qty12554" value="1" data-max_value="20" data-min_value="1"
                            data-step="1">
                        <a href="#" class="qty-btn btn-up"><i class="fa fa-caret-up"
                                aria-hidden="true"></i></a>
                        <a href="#" class="qty-btn btn-down"><i class="fa fa-caret-down"
                                aria-hidden="true"></i></a>
                    </div>
                    <div class="buttons">
                        <a href="#" class="btn add-to-cart-btn btn-bold">add to cart</a>
                    </div>
                </div>

                <div class="product-meta">
                    <div class="product-atts">
                        <div class="product-atts-item">
                            <b class="meta-title">Categories:</b>
                            <ul class="meta-list">
                                <li><a href="#" class="meta-link">Milk & Cream</a></li>
                                <li><a href="#" class="meta-link">Fresh Meat</a></li>
                                <li><a href="#" class="meta-link">Fresh Fruit</a></li>
                            </ul>
                        </div>
                        <div class="product-atts-item">
                            <b class="meta-title">Tags:</b>
                            <ul class="meta-list">
                                <li><a href="#" class="meta-link">food theme</a></li>
                                <li><a href="#" class="meta-link">organic food</a></li>
                                <li><a href="#" class="meta-link">organic theme</a></li>
                            </ul>
                        </div>
                        <div class="product-atts-item">
                            <b class="meta-title">Brand:</b>
                            <ul class="meta-list">
                                <li><a href="#" class="meta-link">Fresh Fruit</a></li>
                            </ul>
                        </div>
                    </div>
                    <span class="sku">SKU: N/A</span>
                    <div class="biolife-social inline add-title">
                        <span class="fr-title">Share:</span>
                        <ul class="socials">
                            <li><a href="#" title="twitter" class="socail-btn"><i class="fa fa-twitter"
                                        aria-hidden="true"></i></a></li>
                            <li><a href="#" title="facebook" class="socail-btn"><i class="fa fa-facebook"
                                        aria-hidden="true"></i></a></li>
                            <li><a href="#" title="instagram" class="socail-btn"><i class="fa fa-instagram"
                                        aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll Top Button -->
<a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>

<script src="{{ asset('client/assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('client/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('client/assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('client/assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('client/assets/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('client/assets/js/slick.min.js') }}"></script>
<script src="{{ asset('client/assets/js/biolife.framework.js') }}"></script>
<script src="{{ asset('client/assets/js/functions.js') }}"></script>
<script>
    // JavaScript using jQuery to open the Shipping & Returns modal
    $(document).ready(function() {
        $('#openShippingReturnsModal').click(function(e) {
            e.preventDefault();
            $('#shippingReturnsModal').modal('show');
        });

        $('#openSecureShoppingModal').click(function(e) {
            e.preventDefault();
            $('#secureShoppingModal').modal('show');
        });

        $('#openDeliveryModal').click(function(e) {
            e.preventDefault();
            $('#deliveryModal').modal('show');
        });

        $('#openPrivacyModal').click(function(e) {
            e.preventDefault();
            $('#privacyModal').modal('show');
        });

        // You can similarly define other modal triggers and modals using jQuery
    });
</script>
