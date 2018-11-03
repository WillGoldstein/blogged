@extends('blogged::layout')

@section('content')
    <div class="main-content">
        <!-- Navbar -->
        @include('blogged::partials.navbar')

        <!-- Header -->
        <div class="header bg-primary py-8"></div>

        <!-- Page content -->
        <section class="section">
            <div class="container" style="margin-top: -100px; margin-bottom: 100px">
                <div class="card shadow no-border pb-2">
                    <img class="card-img-top" src="{{ $article->image }}" alt="Card image cap">

                    <div class="bg-secondary px-5 py-2">
                        <b>Published on:</b> <span class="description">{{ $article->publish_date->toFormattedDateString() }}</span>
                        <button type="button" class="btn btn-outline-danger btn-sm pull-right">Education</button>
                    </div>

                    <div class="card-body px-5">
                        <h1 class="display-1">{{ $article->title }}</h1>
                        <article class="pt-2 is-{{ config('blogged.ui.code') }}">
                            {!! $article->parsedBody !!}
                        </article>
                    </div>
                </div>
            </div>
        </section>

        @include('blogged::partials.share', ['url' => $article->path()])
    </div>

    @include('blogged::partials.footer')
@endsection