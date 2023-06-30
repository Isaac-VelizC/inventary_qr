@extends('layouts.app')

@section('content')

<section class="section">
    <div class="col-12">
        <div class="card top-selling">
            <div class="card-body pb-0">
                <h5 class="card-title">Vista de <span>| {{$user->name}}</span></h5>
                Show
            </div>
        </div>
    </div>
</section>

@endsection