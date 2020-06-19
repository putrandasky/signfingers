<div id="intro" class="intro-homepage">
  <div class="jumbotron d-flex justify-content-center align-items-center text-center" style="background-image:linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),url({{ asset('images/bg_hero.jpg') }})">
    <div>
      <h1 id="hero-title" class="text-warning  font-weight-bold">{{$title}}</h1>
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
