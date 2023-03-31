@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h1>Панель управления</h1>
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>Последние публикации</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Автор</th>
                                <th>Категория</th>
                                <th>Заголовок</th>
                                <th>Дата публикации</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr @if(!$post->is_published) style="background-color: #ccc;" @endif>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>   @foreach($post->categories->take(5) as $key => $category)
                                            {{ $category->title }}
                                            @if($key != count($post->categories)-1)
                                                |
                                            @endif
                                        @endforeach
                                        @if($post->categories->count() > 2)
                                            ...
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blog.admin.posts.edit', $post->id) }}">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.m.y H:i') : ''}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a class="btn btn-primary" href="{{ route('blog.admin.posts.index') }}">Список всех статей</a>
                        @role('admin')
                        <a class="btn btn-primary ml-auto" href="{{ route('blog.admin.posts.create') }}">Добавить
                            новую</a>
                        @endrole
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px;">
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>Черновики</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Автор</th>
                                <th>Категория</th>
                                <th>Заголовок</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($drafts as $draft)
                                <tr style="background-color: #ccc;">
                                    <td>{{ $draft->id }}</td>
                                    <td>{{ $draft->user->name }}</td>
                                    <td>   @foreach($draft->categories->take(5) as $key => $category)
                                            {{ $category->title }}
                                            @if($key != count($draft->categories)-1)
                                                |
                                            @endif
                                        @endforeach
                                        @if($draft->categories->count() > 2)
                                            ...
                                        @endif</td>
                                    <td>
                                        <a href="{{ route('blog.admin.posts.edit', $draft->id) }}">
                                            {{ $draft->title }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-primary" href="{{ route('draft') }}">Список</a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>Категории</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Категория</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $item)
                                @php /** @var/App/Models/BlogPost $item */ @endphp
                                <tr>
                                    <td> {{ $item->id }}</td>
                                    <td>
                                        <a href="{{ route('blog.admin.categories.edit', $item->id) }}">
                                            {{ $item->title }}
                                        </a>
                                    </td>
                                    <td @if(in_array($item->parent_id, [0, 1])) style="color:#ccc" @endif>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-primary " href="{{ route('blog.admin.categories.index') }}">Список</a>
                        @role('admin')
                        <a class="btn btn-primary ml-auto"
                           href="{{ route('blog.admin.categories.create') }}">Добавить</a>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
