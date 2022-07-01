@extends('layouts.app')

@section('content')
    <article>
        <!-- Breadcrumb -->
        <section class="theme-breadcrumb pad-50">
            <div class="theme-container container ">
                <div class="row">
                    <div class="col-sm-8 pull-left">
                        <div class="title-wrap">
                            <h2 class="section-title no-margin"> Blogs  </h2>
                            <p class="fs-16 no-margin"> Get answers or know fo your questions </p>
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
                            <h4 class="title-1">Search your blogs</h4>
                            <form action="/blog-search" method="get">@csrf
                                <div class="form-group">
                                    <input type="text" title="search" name="search" class="form-control" placeholder="Type and hit enter...">
                                    <input type="submit" hidden="hidden">
                                </div>
                            </form>
                        </div>
                        <div class="widget-wrap pb-50 categories">
                            <h4 class="title-1">Categories</h4>
                            <ul>
                                @foreach($categories as $category)
                                <li><a href="/blog-cetegory/{{$category->id}}">{{$category->name}} <small>{{$category->blogs->count()}}</small></a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget-wrap pb-50 flickr-feed">
                            <h4 class="title-1">Flickr Feed</h4>
                            <ul>@foreach($featuresPhotos as $row)
                                <li style="width:33%;overflow:hidden;"><a href="#"><img src="/{{$row->photo}}"></a></li> @endforeach
                            </ul>
                        </div>
                    </aside>

                    <div class="visible-xs pad-30"></div>

                    <section class="col-md-9 col-sm-8 pb-50">
                        @foreach($blogs as $blog)
                        <article class="post-wrap pb-50">
                            <div class="post-img pb-10">
                                <a href="#"> <img alt="" src="/{{$blog->photo}}"> </a>
                            </div>
                            <div class="post-content">
                                <h6 class="title-2 fs-10">{{$blog->blog_category->name}}</h6>
                                <a class="title-1" href="#">{{$blog->title}}</a>
                                <div class="pad-10">
                                    <span class="black-clr">
                                        Posted on
                                        <span>{{date('l',strtotime($blog->created_at))}}</span>,
                                        <span>{{date('F d, y',strtotime($blog->created_at))}}</span>
                                    </span>
                                    <span class="pull-right">
                                        <a href="#"> <i class="fa fa-comment"></i> 0</a>
                                    </span>
                                </div>
                                <p>
                                    @if(strlen($blog->description) > 250)                     
                                        {{ mb_substr(strip_tags($blog->description), 0 , 250) }} ....
                                    @else {{$blog->description}} @endif 
                                </p>
                            </div>
                            @if(strlen($blog->description) > 250)  
                            <div class="post-footer">
                                <span class="post-readmore">
                                    <a class="font2-title1 fs-12" href="single-blog.html">Read more <span class="arrow_right fs-20"></span> </a>
                                </span>
                            </div> @endif
                        </article> @endforeach

                        <div class="pagination-wrap font-2">
                            <ul class="pagintn">
                                <li>{{$blogs->links()}}</li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- /.Blog -->

    </article>
@endsection
