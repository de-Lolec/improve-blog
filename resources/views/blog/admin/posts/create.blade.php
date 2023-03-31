@extends('layouts.app')

@section('content')




    <form method="POST" action="{{ route('blog.admin.posts.store', $item->id) }}" enctype="multipart/form-data">

        @csrf
        <div class="container">
            <div class="row justify-content-center">
                @include('blog.admin.posts.includes.result_messages')
                <div class="col-md-8">

                    @include('blog.admin.posts.includes.post_edit_main_col')
                </div>
                <div class="col-md-3">
                    @include('blog.admin.posts.includes.post_edit_add_col')
                </div>

            </div>
        </div>
    </form>

@endsection
