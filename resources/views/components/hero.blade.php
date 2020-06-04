<div id="intro" class="intro-homepage">
  <div class="jumbotron d-flex justify-content-center align-items-center text-center" style="background-image:linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)),url({{ asset('images/bg_hero.jpg') }})">
    <div>
      <h2 class="text-warning display-4 font-weight-bold">{{$title}}</h2>
      <p class="text-white mx-md-5 px-md-5">{{$slot}}
      </p>
      <a  href='{{url("sign-file")}}' class="btn btn-warning mt-5">
        <strong>
          {{$button}}
        </strong>
      </a>
    </div>
  </div>
</div>
