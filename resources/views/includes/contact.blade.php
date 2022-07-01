<section class="contact-wrap pad-120">
            <span class="bg-text wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"> Contact </span>
            <div class="theme-container container">
                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        <div class="title-wrap">
                            <h2 class="section-title wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s">
                                contact us</h2>
                            <p class="wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s">Get in touch with
                                us easiky</p>
                        </div>
                        <ul class="contact-detail title-2 pt-50">
                           
                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".40s"> <span>  Cell Numbers:</span> <p class="gray-clr"> {{basic_information()->phone_number_one}}<br>{{basic_information()->phone_number_two}}  </p> </li>

                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".50s"> <span>Email address:</span> <p class="gray-clr"> {{basic_information()->email}} </p> </li>

                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".60s"> <span>Meeting time:</span> <p class="gray-clr"> {{basic_information()->meet_time}}</p> </li>
                            
                        </ul>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="title-wrap">
                            <h2 class="section-title wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"></h2>
                            <p class="wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"><br></p>
                        </div>
                        <ul class="contact-detail title-2 pt-50">
                           
                           <li><img src='/images/{{basic_information()->company_logo}}' style="max-height: 100px"></li>
                            <li class="wow fadeInUp" data-wow-offset="50" data-wow-delay=".60s"> <span>Address:</span> <p class="gray-clr"> {{basic_information()->address}}</p> </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </section>