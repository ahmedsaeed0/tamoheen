<style>

    *{
        list-style:none;
        text-decoration: none;
    }
    .footer-block {
      background-color: #f8f8f8;
      padding: 20px 0;
    }
    
    .custom-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }
    
    .topfooter {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    
    .left, .right {
      flex: 1;
      min-width: 300px;
    }
    
    .subscribe-block h4 {
      font-size: 18px;
      margin-bottom: 10px;
    }
    
    .subscribe-block .bl-typo {
      font-size: 14px;
      margin-bottom: 10px;
    }
    
    .newsletter-new {
      display: flex;
      align-items: center;
    }
    
    .newsletter-new .content {
      width: 100%;
    }
    
    .newsletter-new .form {
      display: flex;
    }
    
    .newsletter-new .field.newsletter {
      /*flex: 1;*/
    }
    
    .newsletter-new .field.newsletter .control input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .newsletter-new .actions {
      margin-left: 10px;
    }
    
    .newsletter-new .actions .fill-btn {
      background-color: #833AB4;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .newsletter-new .actions .fill-btn:hover {
      background-color: #6a3a8a;
    }
    
    .rght .imgsec-top {
      margin-bottom: 10px;
    }
    
    .rght .imgsec-top .one a {
      color: #6a3a8a;
      text-decoration: none;
    }
    
    .rght .social-sec ul {
      display: flex;
      list-style: none;
      padding: 0;
    }
    
    .rght .social-sec ul li {
      margin-right: 10px;
    }
    
    .rght .social-sec ul li a {
      color: #6a3a8a;
      text-decoration: none;
    }
    
    .site-details {
      margin-bottom: 20px;
    }
    
    .link-list a {
      display: inline-block;
      margin-right: 15px;
      color: #833AB4;
      text-decoration: none;
    }
    
    .lower-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      border-top: 1px solid #ccc;
      padding-top: 10px;
    }
    
    .copyright {
      flex: 1;
    }
    
    .secondft, .thirdft {
      margin-right: 10px;
    }
    
    .payment .card-img {
      display: inline-block;
      width: 30px;
      height: 25px;
      background-size: cover;
      margin-left: 10px;
    }
    
    .payment .card-img.visa {
      background-image: url('path_to_visa_image');
    }
    
    .payment .card-img.master {
      background-image: url('path_to_mastercard_image');
    }
    
    .payment .card-img.american {
      background-image: url('path_to_american_express_image');
    }
    .social-sec i{
        font-size: 30px;
        padding-right: 20px;
        color: #6a3a8a;
    }
    a img{
        width: 100px;
       padding: 10px;
    }
    .colors{
        background-color: ghostwhite;
    }
    
    </style>
    <head>  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    
    <div class="footer-block">
      <div class="custom-container">
        <div class="topfooter">
          <div class="left">
            <div class="subscribe-block">
              <h4>@lang('footer.need_my_travel_help')</h4>
             
              <div class="newsletter-new">
                <div class="content">
                  <form class="form subscribe" novalidate="novalidate" action="" method="post" id="newsletter-validate-detail" data-gtm-form-interact-id="0">
                    <div class="field newsletter">
                      <div class="control">
                        <label for="newsletter">
                          <input name="email" type="email" id="newsletter" placeholder="@lang('footer.your_email')" data-validate="{required:true, 'validate-email':true}" data-gtm-form-interact-field-id="0">
                        </label>
                      </div>
                    </div>
                    <div class="actions">
                      <button class="fill-btn" title="اشتراك" type="submit" aria-label="Subscribe">
                        <span>@lang('footer.send')</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="right">
            <div class="imgsec-top">
              <div class="one">
                
               <a href="https://www.tga.gov.sa/" aria-label="tga" target="_blank">
                <img src="{{ asset('front/TGA.png') }}" alt="TGA">
                </a>
                <a href="https://www.vision2030.gov.sa/">
                <img src="{{ asset('front/ksa2030.png') }}" class="colors" alt="Vision 2030">
                 </a>

              </div>
            </div>
            <div class="social-sec">
              <ul>
                
                <i class="fa-brands fa-facebook"><a href=""> </a></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-twitter"></i>
            </div>
          </div>
        </div>
        <div class="site-details">
          <div class="link-list">
            <a aria-label="عنا" href="" class="bm-typo"></a>
            <a aria-label="تواصل معنا" href="https://www.tamoheen.com/ar/ambitious-success-partners" class="bm-typo">@lang('footer.SuccessـPartners')</a>
            <a aria-label=""  href= "https://www.tamoheen.com/ar/about-us" class="bm-typo">@lang('footer.about_us') </a>
            <a aria-label="قانوني" href="https://www.tamoheen.com/ar/terms-conditions" class="bm-typo">@lang('footer.tos')</a>
          </div>
        </div>
        <div class="lower-footer">
          <div class="copyright">
            <p class="bs-typo">@lang('footer.oo')</p>
          </div>
          <div class="secondft">@lang('footer.Commercial')</div>
          <div class="thirdft">@lang('footer.tax')</div>
          <div class="payment">
            <span class="card-img visa"></span>
            <span class="card-img master"></span>
            <span class="card-img american"></span>
          </div>
        </div>
      </div>
    </div>
    
    