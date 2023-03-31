@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">

                <div class="card border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            @foreach($paginator as $post)
                                <div class="col-md-12 align-items-center  flex-md-row">
                                    <div
                                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-static">
                                        <div class="col-md-4 d-none d-md-block">
                                            @if($post->image)
                                                <img src="http://laravella/image/{{ $post->image }}" alt=""
                                                     class="img-fluid"
                                                     style="object-fit: cover; width: 100%; height: 100%; max-height: 238px; min-height: 238px; max-width: 320px; min-width: 320px;">
                                            @endif
                                        </div>
                                        <div class="col-md-8 p-4">
                                            <strong class="d-inline-block mb-2 text-secondary">
                                                @foreach($post->categories->take(5) as $key => $category)
                                                    {{ $category->title }}
                                                    @if($key != count($post->categories)-1)
                                                        &#8226;
                                                    @endif
                                                @endforeach
                                                @if($post->categories->count() > 5)
                                                    ...
                                                @endif

                                            </strong>
                                            <h4 class="blog-post-title text-break  "><strong><a
                                                        class="text-body text-decoration-none"
                                                        href="{{ route('blog.view', $post->id) }}">{{ $post->title }}</a></strong>
                                            </h4>
                                            <div class="mb-1 text-muted"><p
                                                    class="blog-post-meta">{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.m.y H:i') : ''}}</p>
                                            </div>
                                            <p>{{ $post->excerpt }}</p>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
                @if($paginator->total() > $paginator->count())

                    <div class="card">
                        <div class="card-body">

                            {{ $paginator->appends([ 'category_sort' => $category_sort, 'page_size' => $pageSize])->links() }}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-3 ">
                <div class="flex-shrink-0 p-3 bg-white shadow-sm" style="margin-top: 16px">
                    <form method="get" action="{{ route('blog.main') }}">
                        <div class="form-group mb-3">
                            <label for="page_size">Количество статей на странице:</label>
                            <select class="form-control" id="page_size" name="page_size" onchange="this.form.submit()">
                                <option value="10" {{ $pageSize == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $pageSize == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $pageSize == 20 ? 'selected' : '' }}>20</option>
                                <option value="25" {{ $pageSize == 25 ? 'selected' : '' }}>25</option>
                            </select>
                        </div>


                    </form>
                    <h6 class="mb-3">Категории:</h6>

                    <ul class="nav nav-pills flex-column mb-auto">
                        <form method="get" action="{{ route('blog.main') }}">
                        @foreach($categoryList as $category)
                            <li class="border-top">

                                    <button type="submit" class="link-dark nav-link link-body-emphasis" name="category_sort" value="{{ $category->id }}">
                                        {{ $category->title }}
                                    </button>

                            </li>
                        @endforeach
                        </form>


                    </ul>

                </div>
            </div>
        </div>
    </div>

@endsection
