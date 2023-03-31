@extends('layouts.app')

@section('content')
    <div class="container">
    <form method="POST" action="{{ route('blog.admin.posts.update', $item->id) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

            @include('blog.admin.posts.includes.result_messages')



            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include('blog.admin.posts.includes.post_edit_main_col')
                </div>
                <div class="col-md-3">
                    @include('blog.admin.posts.includes.post_edit_add_col')
                </div>

            </div>
    </form>
    @role('admin')
    @if($item->exists)
        <br>
        <form method="POST" action="{{ route('blog.admin.posts.destroy', $item->id) }}">
            @method('DELETE')
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-block">
                        <div class="card-body ml-auto">
                            <button type="submit" class="btn btn-link">Удалить</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
    @endif
    @endrole
    </div>
    </div>
@endsection
