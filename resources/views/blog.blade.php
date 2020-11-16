@extends('layouts.app')

@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> lorem quis  </h2>
                            <p class="fs-16 no-margin"> Track your product & see the current condition </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb-menubar list-inline">
                            <li><a href="#" class="gray-clr">Home</a></li>
                            <li class="active">Blog Posts</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Breadcrumb -->

        <!-- Blog -->
        <div class="theme-container container">
            <div class="row">
                <div class="blog-wrap pad-80 clearfix">
                    <aside class="sidebar col-sm-4 col-md-3">
                        <div class="widget-wrap pb-50">
                            <h4 class="title-1">Join The Newsletter</h4>
                            <form action="#" method="post">
                                <div class="form-group">
                                    <input type="text" title="search" name="search" class="form-control" placeholder="Type and hit enter...">
                                    <input type="submit" hidden="hidden">
                                </div>
                            </form>
                        </div>
                        <div class="widget-wrap pb-50 categories">
                            <h4 class="title-1">Categories</h4>
                            <ul>
                                <li><a href="#">Design <small>14</small></a></li>
                                <li><a href="#">Art Direction <small>21</small></a></li>
                                <li class="active"><a href="#">HTML and CSS <small>12</small></a></li>
                                <li><a href="#">Themes <small>19</small></a></li>
                                <li><a href="#">Wordpress <small>36</small></a></li>
                            </ul>
                        </div>
                        <div class="widget-wrap pb-50 flickr-feed">
                            <h4 class="title-1">Flickr Feed</h4>
                            <ul>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                                <li><a href="#"><img alt="" src="assets/img/flickr/flickr-feed.jpg"></a></li>
                            </ul>
                        </div>
                        <div class="widget-wrap pb-50 tag-cloud">
                            <h4 class="title-1">Tags</h4>
                            <ul>
                                <li><a href="#">Creative</a></li>
                                <li><a href="#">Design</a></li>
                                <li><a href="#">Art</a></li>
                                <li><a href="#">Autpor Name</a></li>
                                <li><a href="#">Coorperate</a></li>
                                <li><a href="#">Wordpress</a></li>
                                <li><a href="#">3D Animations</a></li>
                            </ul>
                        </div>
                    </aside>

                    <div class="visible-xs pad-30"></div>

                    <section class="col-md-9 col-sm-8 pb-50">
                        <article class="post-wrap pb-50">
                            <div class="post-img pb-10">
                                <a href="#"> <img alt="" src="assets/img/background/banner-1.jpg"> </a>
                            </div>
                            <div class="post-content">
                                <h6 class="title-2 fs-10">Photography</h6>
                                <a class="title-1" href="#">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat.</a>
                                <div class="pad-10">
                                            <span class="black-clr">
                                                Posted on
                                                <span>17th</span>
                                                <span>May</span>
                                                <span>2014</span>
                                            </span>
                                    <span class="pull-right">
                                                <a href="#"> <i class="fa fa-comment"></i> 12</a>
                                            </span>
                                </div>
                                <p>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat
                                    consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra.</p>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor.</p>
                            </div>
                            <div class="post-footer">
                                        <span class="post-readmore">
                                            <a class="font2-title1 fs-12" href="single-blog.html">Read more <span class="arrow_right fs-20"></span> </a>
                                        </span>
                            </div>
                        </article>

                        <article class="post-wrap pb-50">
                            <div class="post-img pb-10">
                                <a href="#"> <img alt="" src="assets/img/background/banner-2.jpg"> </a>
                            </div>
                            <div class="post-content">
                                <h6 class="title-2 fs-10">Photography</h6>
                                <a class="title-1" href="#">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat.</a>
                                <div class="pad-10">
                                            <span class="black-clr">
                                                Posted on
                                                <span>17th</span>
                                                <span>May</span>
                                                <span>2014</span>
                                            </span>
                                    <span class="pull-right">
                                                <a href="#"> <i class="fa fa-comment"></i> 12</a>
                                            </span>
                                </div>
                                <p>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat
                                    consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra.</p>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor.</p>
                            </div>
                            <div class="post-footer">
                                        <span class="post-readmore">
                                            <a class="font2-title1 fs-12" href="single-blog.html">Read more <span class="arrow_right fs-20"></span> </a>
                                        </span>
                            </div>
                        </article>

                        <div class="pagination-wrap font-2">
                            <ul class="pagintn">
                                <li><a href="#" class="arrow_left fs-20"></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#" class="arrow_right fs-20"></a></li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- /.Blog -->

    </article>
@endsection
