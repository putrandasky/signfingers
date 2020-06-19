      <div class="media">
        <span class="fa-stack fa-3x fa-sm-2x">
          {{$icon}}
          <i class="fa fa-ban fa-stack-2x " style="color:Tomato">
          </i>
        </span>
        <div class="media-body ml-3">

          <h3 class="text-warning">
              {{$title}}
          </h3>
          <p class="text-white">
            {{$slot}}
          </p>
        </div>
      </div>
