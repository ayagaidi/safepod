<!DOCTYPE html>
<!-- Testo - Pizza and Fast Food Landing Page Template design design by Jthemes (http://www.jthemes.net) -->
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
@if (\Session::get('language') == 'ar')
    <html lang="ar" dir="rtl">
@elseif(\Session::get('language') == 'en')
    <html lang="en" dir="rtl">
@else
    <html lang="ar" dir="rtl">
@endif


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="aya" />

    <!-- SITE TITLE -->
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('colorico.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>safePod-@yield('title')</title>


    <!-- FAVICON AND TOUCH ICONS -->

    <!-- GOOGLE FONTS -->

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- FONT ICONS -->
    <link href="https://use.fontawesome.com/releases/v5.11.0/css/all.css" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('front/css/flaticon.css') }}" rel="stylesheet">

    <!-- PLUGINS STYLESHEET -->
    <link href="{{ asset('front/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/jquery.datetimepicker.min.css') }}" rel="stylesheet">

    <!-- TEMPLATE CSS -->
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('NotoKufArabic.css') }}" rel="stylesheet" type="text/css">

    <!-- RESPONSIVE CSS -->
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('sweetalert2@9') }}"></script>

</head>




<body style="font-family:'Noto Kufi Arabic', sans-serif;">










    <!-- HEADER-1
  ============================================= -->
    <header id="header-1" class="header navik-header header-shadow center-menu-1 header-transparent">
        <div class="container">


            <!-- NAVIGATION MENU -->
            <div class="navik-header-container">


                <!-- CALL BUTTON -->
                <div class="callusbtn text-right"><a href="tel:{{ $Contactus->phonenumber }}"><i class="fas fa-phone"></i></a></div>


                <!-- LOGO IMAGE -->

                @if (\Session::get('language') == 'ar')
   
                <div class="logo" data-mobile-logo="{{ asset('logoo.png') }}"
                    data-sticky-logo="{{ asset('logoo.png') }}">
                    <a href="#hero-2"><img src="{{ asset('logoo.png') }}" alt="header-logo" /></a>
                </div>
@elseif(\Session::get('language') == 'en')
 
<div class="logo" data-mobile-logo="{{ asset('logoo1.png') }}"
data-sticky-logo="{{ asset('logoo1.png') }}">
<a href="#hero-2"><img src="{{ asset('logoo1.png') }}" alt="header-logo" /></a>
</div>
@else
  
<div class="logo" data-mobile-logo="{{ asset('logoo.png') }}"
data-sticky-logo="{{ asset('logoo.png') }}">
<a href="#hero-2"><img src="{{ asset('logoo.png') }}" alt="header-logo" /></a>
</div>
@endif



                <!-- BURGER MENU -->
                <div class="burger-menu">
                    <div class="line-menu line-half first-line"></div>
                    <div class="line-menu"></div>
                    <div class="line-menu line-half last-line"></div>
                </div>


                <!-- MAIN MENU -->
                <nav class="navik-menu menu-caret navik-yellow">
                    <ul class="top-list text-right">
                        <!-- Home Link -->
                        <li>
                            <a href="{{ route('/') }}">@lang('navbar.home')</a>
                        </li>

                        <!-- Language Switcher -->
                       

                        <!-- About Link -->
                        <li>
                            <a href="{{ route('about') }}">@lang('navbar.about')</a>
                        </li>
                    </ul>

                    <ul>
                        <!-- Menu Link -->
                        <li>
                            <a href="{{ route('menu') }}">@lang('navbar.menu')</a>
                        </li>

                        <!-- Contact Us Link -->
                        <li>
                            <a href="{{ route('contacts') }}">@lang('navbar.contact_us')</a>
                        </li>

                        <li>
                            @if (\Session::get('language') == 'en')
                                <a style="color: black; font-family:Noto Kufi Arabic;"
                                    href="{{ route('changeLanguage', 'language=ar') }}" class="getstarted scrollto">
                                    العربية
                                </a>
                            @elseif (\Session::get('language') == 'ar')
                                <a style="color: black;" href="{{ route('changeLanguage', 'language=en') }}"
                                    class="getstarted scrollto">
                                    English
                                </a>
                            @else
                                <a style="color: black; font-family:Noto Kufi Arabic;"
                                    href="{{ route('changeLanguage', 'language=ar') }}" class="getstarted scrollto">
                                    العربية
                                </a>
                            @endif
                        </li>
                    </ul>
                </nav>

                <!-- END MAIN MENU -->


            </div>
            <!-- END NAVIGATION MENU -->


        </div>
        <!-- End container -->
    </header>
    <!-- END HEADER-1 -->




    <!-- PAGE CONTENT
  ============================================= -->
    <div id="page" class="page">
        <section id="hero-2" class="bg-fixed hero-section division">
            <div class="bg-fixed bg-inner division">


                <!-- HERO TEXT -->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hero-2-txt text-center">

                                <!-- Title -->

                                <!-- Image -->


                            </div>
                        </div>
                    </div>
                    <!-- End row -->
                </div>
                <!-- END HERO TEXT -->


                <!-- SECTION OVERLAY -->
                <div class="bg-fixed white-overlay-wave"></div>


            </div>
            <!-- End Bg Inner -->
        </section>


        @yield('content')
        @include('sweetalert::alert')

        <!-- FOOTER-2
   ============================================= -->
        <footer id="footer-2" class="footer division" style="background-color: #222; color: #fff; padding: 50px 0;">
            <div class="container">
                <div class="footer-2-holder text-center">
                    <div class="row">

                        <!-- FOOTER INFO -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="footer-info mb-30">
                                <h5 class="h5-md text-uppercase mb-3" style="color: #e54d61;">@lang('footer.address')</h5>
                                @if (\Session::get('language') == 'ar')
                                <p> {{ $Contactus->adress }}</p>
                            @elseif(\Session::get('language') == 'en')
                            <p> {{ $Contactus->adressen }}</p>
                            @else
                            <p> {{ $Contactus->adress }}</p>
                            @endif
                            </div>
                        </div>

                        <!-- WORKING HOURS -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="footer-info mb-30">
                                <h5 class="h5-md text-uppercase mb-3" style="color: #e54d61;">@lang('footer.working_hours') </h5>
                                @if (\Session::get('language') == 'ar')
                                <p>{{ $Contactus->ourworksa }}</p>
                            @elseif(\Session::get('language') == 'en')
                            <p>{{ $Contactus->ourworkse }}</p>
                            @else
                            <p>{{ $Contactus->ourworksa }}</p>
                            @endif
                            </div>
                        </div>

                        <!-- FOOTER CONTACTS -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="footer-contacts mb-30">
                                <h5 class="h5-md text-uppercase mb-3" style="color: #e54d61;">@lang('footer.order_now') </h5>
                                <p>@lang('footer.call_us')</p>
                                <p class="mt-3">
                                    <a href="{{ $Contactus->phonenumber }}" class="yellow-color"
                                        style="color: #e54d61; font-size: 1.2rem; font-weight: bold;">
                                        {{ $Contactus->phonenumber }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- FOOTER SOCIAL LINKS -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="footer-socials-links mb-30">
                                <h5 class="h5-md text-uppercase mb-3" style="color: #e54d61;">@lang('footer.follow_us')</h5>
                                <ul class="foo-socials text-center list-unstyled d-flex justify-content-center gap-3">
                                    <li>
                                        <a href="https://www.facebook.com/profile.php?id=61561335121913"
                                            class="ico-facebook" style="color: #e54d61; font-size: 1.5rem;">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/colorbeauty.lib/" class="ico-instagram"
                                            style="color: #e54d61; font-size: 1.5rem;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- END ROW -->

                    <!-- FOOTER COPYRIGHT -->
                    <div class="bottom-footer mt-5 pt-4" style="border-top: 1px solid #444;">
                        <p class="mb-0" style="color: #aaa; font-size: 0.9rem;">
                            &copy; 2024 <span style="color: #e54d61;">colorbeauty.ly</span> - جميع الحقوق محفوظة.
                        </p>
                    </div>
                    <!-- END FOOTER COPYRIGHT -->

                </div>
                <!-- End footer-2-holder -->
            </div>
            <!-- End container -->
        </footer>

        <!-- END FOOTER-2 -->




    </div>
    <!-- END PAGE CONTENT -->




    <!-- EXTERNAL SCRIPTS
  ============================================= -->
    <script src="{{ asset('front/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('front/js/jquery.easing.js') }}"></script>
    <script src="{{ asset('front/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('front/js/jquery.scrollto.js') }}"></script>
    <script src="{{ asset('front/js/menu.js') }}"></script>
    <script src="{{ asset('front/js/materialize.js') }}"></script>
    <script src="{{ asset('front/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('front/js/jquery.datetimepicker.full.js') }}"></script>
    <script src="{{ asset('front/js/jquery.ajaxchimp.min.js') }}"></script>

    <!-- Custom Script -->
    {{-- <script src="{{ asset('front/js/custom.js') }}"></script> --}}


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!-- [if lt IE 9]>
   <script src="js/html5shiv.js" type="text/javascript"></script>
   <script src="js/respond.min.js" type="text/javascript"></script>
  <![endif] -->

    <!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information. -->
    <!--
  <script>
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-XXXXX-X']);
      _gaq.push(['_trackPageview']);

      (function() {
          var ga = document.createElement('script');
          ga.type = 'text/javascript';
          ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
              '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(ga, s);
      })();
  </script>
  -->



    <script defer src="{{ asset('front/js/changer.js') }}"></script>



</body>



</html>
