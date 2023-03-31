@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                @role('admin|moderator')
                <p class="text-end mb-0 text-decoration-none"><a class="text-decoration-none"
                                                                 href="{{ route('blog.admin.posts.edit', $item->id) }}">&#9998;
                        Редактировать</a></p>
                @endrole
                <h1 class="display-8 text-start mb-2">{{ $item->title }}</h1>

                <p class="blog-post-meta text-muted text-start mb-3">{{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d.m.Y') : '' }}

                <div class="d-flex justify-content-center mb-3">
                    <img src="http://laravella/image/{{ $item->image }}" alt="" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;
                    max-height: 700px; min-height: 400px; max-width: 700px; min-width: 400px;">
                </div>
                <p class="lead mb-5 word-wrap">{{ $item->content_raw }}</p>
                <hr>   <h5>
                <strong class="d-inline-block mb-2 text-muted">
                    @foreach($item->categories->take(5) as $key => $category)
                       {{ $category->title }}
                        @if($key != count($item->categories)-1)
                            &#8226;
                        @endif
                    @endforeach
                </strong>
                </h5>
            </div>
        </div>
    </main>

@endsection


