<!DOCTYPE html>
<html>
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bgimg {
  background-image: url('front/assets/images/forestbridge.jpg');
  height: 100%;
  background-position: center;
  background-size: cover;
  position: relative;
  color: white;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;
}

.topleft {
  position: absolute;
  top: 0;
  left: 16px;
}

.bottomleft {
  position: absolute;
  bottom: 0;
  left: 16px;
}

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.middle a{
  color: white;
}

hr {
  margin: auto;
  width: 40%;
}
</style>
<body>

<div class="bgimg">
  <div class="topleft">
    <p>@lang('header.rideshare')</p>
  </div>
  <div class="middle">
    <h1>@lang('header.coming_soon')</h1>
    <hr>
    <a href="{{ url('/') }}">@lang('header.go_to_home')...</a>
  </div>
  <div class="bottomleft">
    <p>@lang('header.sorry_to_late')....</p>
  </div>
</div>

</body>
</html>
