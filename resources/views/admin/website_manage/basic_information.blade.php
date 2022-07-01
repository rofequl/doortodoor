@extends('admin.layout.app')
@section('title', 'Basic Information')
@section('content')
    <style>
        #previewImage {width: 100px;  height: 100px;
            border: 1px dotted gray;text-align: center;  cursor: pointer;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="x_panel">
                            <div class="x_content">
                                <form class="form-horizontal form-label-left" novalidate=""
                                      method="post" enctype="multipart/form-data">@csrf 
                                      <input type="hidden" name="id" value="{{basic_information()->id}}">
                                    <span class="section">Basic Information Update</span>
                                    <div class="field item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Website
                                            Title</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12"
                                                   data-validate-length-range="6" data-validate-words="2"
                                                   name="website_title"
                                                   value="{{basic_information()->website_title}}"
                                                   placeholder="Title Your Website" type="text">
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name2">Website
                                            Name</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name2" class="form-control col-md-7 col-xs-12"
                                                   data-validate-length-range="6" data-validate-words="2"
                                                   name="company_name"
                                                   value="{{basic_information()->company_name}}"
                                                   placeholder="Name your website, Facebook" type="text">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name2">Meet
                                            Time</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name2" class="form-control col-md-7 col-xs-12"
                                                   data-validate-length-range="6" data-validate-words="2"
                                                   name="meet_time"
                                                   value="{{basic_information()->meet_time}}"
                                                   placeholder="Office meet time" type="text">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name3">Phone
                                            Number One</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name3" class="form-control col-md-7 col-xs-12"
                                                   name="phone_number_one" placeholder="012345678987"
                                                   value="{{basic_information()->phone_number_one}}"
                                                   type="number">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name4">Phone
                                            Number Two</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="name4" class="form-control col-md-7 col-xs-12"
                                                   data-validate-minmax="10,100" name="phone_number_two"
                                                   value="{{basic_information()->phone_number_two}}"
                                                   placeholder="012345678987" type="number">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                               for="email">Email</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" id="email" name="email"
                                                   data-validate-minmax="10,100" placeholder="abc@gmail.com"
                                                   value="{{basic_information()->email}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website
                                            Link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="url" id="website" name="website_link"
                                                   placeholder="www.website.com"
                                                   value="{{basic_information()->website_link}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website2">Facebook
                                            Link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="url" id="website2" name="facebook_link"
                                                   placeholder="www.facebook.com"
                                                   value="{{basic_information()->facebook_link}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website3">Twiter
                                            Link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="url" id="website3" name="twiter_link"
                                                   placeholder="www.twiter.com"
                                                   value="{{basic_information()->twiter_link}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website3">Google
                                            Plus Link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="url" id="website3" name="google_plus_link"
                                                   placeholder="www.googleplus.com"
                                                   value="{{basic_information()->google_plus_link}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website3">Linkedin
                                            Link</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="url" id="website3" name="linkedin_link"
                                                   placeholder="www.linkedin.com"
                                                   value="{{basic_information()->linkedin_link}}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Footer
                                            Text</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="occupation" type="text" name="footer_text"
                                                   data-validate-length-range="6" data-validate-words="2"
                                                   value="{{basic_information()->footer_text}}"
                                                   placeholder=""
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                               for="textarea">Address</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea id="textarea" name="address"
                                                          class="form-control col-md-7 col-xs-12">{{basic_information()->address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Website
                                            Logo</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div onclick="chooseFile()" id="previewImage">
                                                <div class="mt-5">
                                                    <i class="fa fa-cloud-upload fa-3x"></i><br>
                                                    Add a Website Logo
                                                </div>
                                            </div>
                                            <input type="file" name="image" class="ImageUpload hidden">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="reset" class="btn btn-primary" data-toggle="collapse"
                                                    data-target=".multi-collapse"
                                                    aria-expanded="false"
                                                    aria-controls="multiCollapseExample1 multiCollapseExample2">
                                                Cancel
                                            </button>
                                            <button id="send" type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Basic Information</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a data-toggle="collapse" data-target=".multi-collapse"
                                       aria-expanded="false"
                                       aria-controls="multiCollapseExample1 multiCollapseExample2"><i
                                            class="fa fa-edit"></i> Edit</a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-bordered bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Website Title</th>
                                        <th class="column-title">Company Name</th>
                                        <th class="column-title">Website Url</th>
                                        <th class="column-title">Phone Number</th>
                                        <th class="column-title">Email</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>{{basic_information()->website_title}}</td>
                                        <td>{{basic_information()->company_name}}</td>
                                        <td>{{basic_information()->website_link}}</td>
                                        <td>{{basic_information()->phone_number_one}}</td>
                                        <td>{{basic_information()->email}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- validator -->
    <script src="{{asset('vendors/validator/validator.js')}}"></script>
    <script>
        function chooseFile() {
            $(".ImageUpload").click();
        }

        $(function () {
            $(".ImageUpload").change(function () {
                let file = this.files[0];
                let imagefile = file.type;
                let match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                    alert("only jpeg, jpg and png Images type allowed");
                    return false;
                } else {
                    $('#previewImage').html('<img src="" class="img-thumbnail h-100 mx-auto" id="previewLogo">');
                    let reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded(e) {
            $('#previewLogo').attr('src', e.target.result);
        }
    </script>
@endpush
