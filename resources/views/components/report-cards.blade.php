@props(['url'=> '', 'name' => '', 'color' => 'card-secondary'])

<div class="col-md-4">
    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-title="Reports" data-bs-url="form_create/{{$url}}" data-bs-size="">
        <div class="card {{$color}}">
            <div class="card-body skew-shadow">
                <h1>{{$name}}</h1>
                <h5 class="op-8">{{$name}} Report</h5>
            </div>
        </div>
    </a>
</div>
