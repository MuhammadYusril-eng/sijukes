<footer class="footer-classic-dark idep-bg-color-dark padding-five-bottom sm-padding-30px-bottom">
        <div class="idep-bg-color-xdark padding-30px-tb sm-padding-30px-tb">
            <div class="container">
                <div class="row align-items-center">
                    <!-- start slogan -->
                    <!-- <div class="col-lg-8 col-md-8 text-left alt-font sm-margin-15px-bottom text-black">
                        <span class="alt-font text-extra-large text-extra-dark-gray d-inline-block w-100">Subscribe to our newsletter to get the latest news from us!</span>
                    </div> -->
                    <!-- end slogan -->
                    
                    <!-- start social media -->
                    <!-- <div class="col-lg-4 col-md-4 text-right">
                        <form>
                            <input type="email" id="email" name="email" class="text-large border-color-medium-dark-gray text-dark text-small no-margin border-none" placeholder="Enter your email...">
                        </form>
                    </div> -->
                    <!-- end social media -->
                </div>
            </div>
        </div>
<div class="footer-widget-area padding-50px-top padding-30px-bottom sm-padding-30px-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 widget md-margin-30px-bottom text-center text-sm-start last-paragraph-no-margin">
                        <div class="widget-title alt-font text-small text-white text-uppercase margin-15px-bottom font-weight-600">
                            <a href="https://balitourismboard.id/"><img src="assets/img/logo/logoNavbar.png" alt="Official Ternate Tourism Board Website" width="200" /></a>
                        </div>
                        <p class="text-small w-95 sm-w-100 text-white">Ternate Tourism Board (BTB) formed by nine Tourism Associations in Ternate on 1st March 2002 with its main aim to build and develop a better and sustainable tourism industry in Ternate and Indonesia.</p>
                    </div>
                    <!-- end about -->
                    <!-- start blog post -->
                    <div class="col-lg-5 col-sm-6 widget md-margin-30px-bottom">
                        <div class="widget-title alt-font text-white text-uppercase text-extra-large margin-15px-bottom font-weight-600 text-center text-sm-start">Information</div>
                        <ul class="list-unstyled">
                            <li class="w-50 float-start"><a href="what-is-kololi.php" target="_blank" class="text-white text-small ">What is Kololi</a></li>
                            <li class="w-50 float-start"><a href="headlines.php" target="_blank" class="text-white text-small ">Headlines</a></li>
                            <li class="w-50 float-start"><a href="discover.php" target="_blank" class="text-white text-small ">Discover</a></li>
                        </ul>
                    </div>
                    <!-- end blog post -->
                    <!-- start blog post -->
                    <div class="col-lg-3 col-sm-6 widget md-margin-30px-bottom">
                        <div class="widget-title alt-font text-small text-white text-uppercase font-weight-600 text-center text-sm-start margin-15px-bottom">Follow Us</div>
                        <ul class="large-icon mb-0">
                            <li><a class="facebook text-white" href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                            <li><a class="twitter text-white" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="google text-white" href="https://plus.google.com" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a class="instagram text-white" href="https://instagram.com/" target="_blank"><i class="fab fa-instagram no-margin-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <!-- end blog post -->

                </div>
            </div>
        </div>
        <div class="container">
            <div class="footer-bottom border-top border-color-light padding-30px-top">
                <div class="row">
                    <!-- start copyright -->
                    <div class="col-lg-6 col-md-6 text-small text-md-start text-center text-white">Ternate</div>
                    <div class="col-lg-6 col-md-6 text-small text-md-end text-center text-white">Copyrighted © 2024 LONELY TEAM</a></div>
                    <!-- end copyright -->
                </div>
            </div>
        </div>
    </footer> 
        
    <!-- start scroll to top -->
    <a class="scroll-top-arrow" href="javascript:void(0);"><i class="ti-arrow-up"></i></a>
    <!-- end scroll to top  -->

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootsnav.js"></script>
    <script type="text/javascript" src="assets/js/jquery.nav.js"></script>
    <script type="text/javascript" src="assets/js/hamburger-menu.js"></script>
    <script type="text/javascript" src="assets/js/theme-vendors.min.js"></script>
    <!-- setting -->
     
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>

<script>
 document.addEventListener('DOMContentLoaded', function () {
    fetch('fetch_events.php')
        .then(response => response.json())
        .then(events => {
            let months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            let eventByMonth = {};

            // Mengelompokkan event berdasarkan bulan dan tahun
            events.forEach(event => {
                let eventDate = new Date(event.start);
                let monthYear = `${months[eventDate.getMonth()]} ${eventDate.getFullYear()}`;
                if (!eventByMonth[monthYear]) {
                    eventByMonth[monthYear] = [];
                }
                eventByMonth[monthYear].push({
                    day: eventDate.getDate(),
                    title: event.title,
                    url: `detailEvent.php?id=${event.id}` // Tambahkan URL halaman detail event
                });
            });

            // Mengisi kontainer slider dengan kartu bulan
            let container = document.getElementById('event-container');
            Object.keys(eventByMonth).forEach(monthYear => {
                let cardHtml = `
                    <div class="month-card">
                        <div class="card">
                            <div class="card-header">${monthYear}</div>
                            <ul class="list-group list-group-flush">`;

                if (eventByMonth[monthYear].length > 0) {
                    eventByMonth[monthYear].forEach(event => {
                        cardHtml += `
                            <li class="list-group-item">
                                <a href="${event.url}" class="event-link">
                                    <div class="event-icon">
                                        <span class="event-date">${event.day}</span>
                                    </div>
                                    <div class="event-details">
                                        <span class="event-title">${event.title}</span>
                                    </div>
                                </a>
                            </li>`;
                    });
                } else {
                    cardHtml += `
                        <li class="list-group-item">
                            <div class="event-details">
                                <span class="event-title">Tidak ada event di bulan ini</span>
                            </div>
                        </li>`;
                }

                cardHtml += `</ul></div></div>`;
                container.innerHTML += cardHtml;
            });

            // Inisialisasi Slick Slider
            $('.slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: false,
                dots: false,
                prevArrow: '.slick-prev',
                nextArrow: '.slick-next',
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
           

            });

        })
        .catch(error => console.error('Error fetching events:', error));
});

</script>

    </body>
</html>
<!-- Page generated by CouchCMS - Simple Open-Source Content Management -->
