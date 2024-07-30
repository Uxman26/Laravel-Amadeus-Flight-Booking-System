<!-- Bootstrap modal popup -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title poptitle" id="dataModalLabel"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dataModalBody">
        <div class="container">
            <div class="row">
                <div class="col-md-12 promo">
                    <form action="{{ url('slider/savepopinfo')}}" method="POST" class="pb-4">
                        <input type="hidden" name="title" class="title">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="news_body">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="news_body">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="news_body">Message</label>
                            <textarea class="form-control" name="message"></textarea>
                        </div>
                    </div>
                    <div class="row pt-2">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-large form-control">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<section class="footer-area padding-top-100px padding-bottom-30px justify-content-center">
    <div class="container justify-content-center">
        <div class="row justify-content-center text-center">
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <div class="footer-logo padding-bottom-10px">
                        <a href="/" class="foot__logo"><img style="max-width: 200px;background:transparent" src="{{ asset('assets/logo/'.getLogo()) }}" alt="logo"></a>
                    </div>
                    <ul class="list-items pt-3">
                        <li><strong> {{ option('phone') }} </strong></li>
                        <li><strong><a href="mailto:{{ option('email') }}">{{ option('email') }}</a></strong></li>
                        <li><a href="#"><strong>Contact Us</strong></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9 responsive-column">
                <ul class="foot_menu w-100">
                    <li class="footm">
                        <a href="company">Company <i class="la la-angle-down"></i></a>
                        <ul class="dropdown-menu-item">
                            <li><a href="{{ route('footer.aboutus') }}">About Us</a>
                            </li>
                            <li><a href="/terms-of-use">Terms of Use</a>
                            </li>
                            <li><a href="/cookies-policy">Cookies policy</a>
                            </li>
                            <li><a href="{{ route('footer.privacy') }}">Privacy Policy</a>
                            </li>
                        </ul>
                    </li>
                    <li class="footm">
                        <a href="supprt">Support <i class="la la-angle-down"></i></a>
                        <ul class="dropdown-menu-item">
                            <li><a href="{{ route('register') }}">Become Supplier</a>
                            </li>
                            <li><a href="">FAQs</a>
                            </li>
                            <li><a href="{{ route('register') }}">Booking Tips</a>
                            </li>
                            <li><a id="howto" class="pop" href="javascript:void(0);">How to Book</a>
                            </li>
                        </ul>
                    </li>
                    <li class="footm">
                        <a href="services">Services <i class="la la-angle-down"></i></a>
                        <ul class="dropdown-menu-item">
                            <li><a id="claim" class="pop" href="javascript:void(0);">File a claim</a>
                            </li>
                            <li><a href="/offers">Last minute deals</a>
                            </li>
                            <li><a href="{{ route('register') }}">Add your business</a>
                            </li>
                            <li><a id="careers" class="pop" href="javascript:void(0);">Careers and Jobs</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="term-box footer-item">
                    <ul class="list-items list--items d-flex align-items-center">
                        All Rights Reserved by All Rights Reserved by {{ env('APP_NAME') }} </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="footer-social-box text-right">
                    <ul class="social-profile">
                        <li><a href="@if(isset($settings) && !empty($settings)){!! $settings->facebook !!}@endif" target="_blank"><i class="lab la-facebook"></i></a></li>
                        <li><a href="@if(isset($settings) && !empty($settings)){!! $settings->twitter !!}@endif" target="_blank"><i class="lab la-twitter"></i></a></li>
                        <li><a href="@if(isset($settings) && !empty($settings)){!! $settings->whatsapp !!}@endif" target="_blank"><i class="lab la-whatsapp"></i></a></li>
                        <li><a href="@if(isset($settings) && !empty($settings)){!! $settings->instagram !!}@endif" target="_blank"><i class="lab la-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="section-block mt-4"></div>
</section>

<script>
// jQuery function to handle div click event
$(document).ready(function() {
  $(".promo_div").click(function() {
    var id = $(this).data("id");
	var urllink = $(this).data("url");

    $.ajax({
      url: urllink,
      method: "GET",
      data: { id: id },
      success: function(data) {
        $('.promotext').text(data.promos.promotext);
        $('.promoimg').attr("src", "/assets/slider/"+data.promos.image);
        $('.promo_id').val(data.promos.id);
        $('#promoform').attr('action', 'slider/promotion/'+data.promos.slug+'/save');

        $("#dataModal").modal("show");
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
      }
    });
  });
});

$(document).ready(function() {
  $(".pop").click(function() {
    var title;
    if (this.id == 'howto') {
        title = 'How to Book';
    }else if (this.id == 'claim') {
        title = 'File a Claim';
    }else if (this.id == 'careers') {
        title = 'Careers and Jobs';
    }
    $('.poptitle').text(title);
    $('.title').val(title);
    $("#Modal").modal("show");
  });
});
</script>