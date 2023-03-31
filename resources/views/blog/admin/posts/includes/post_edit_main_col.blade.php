@php
    /*@var \App\Models\BlogCategory $category */
@endphp
<div class="row justify-content-center" xmlns="http://www.w3.org/1999/html">
    @if($item->is_published)
        <a href="http://laravella/admin/blog/posts" style="margin-bottom: 12px; text-decoration: none;">&#8592; Список статей </a>
    @else
        <a href="http://laravella/admin/draft" style="margin-bottom: 12px; text-decoration: none;">&#8592; Список черновиков</a>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($item->is_published)
                    Опубликовано
                @else
                    Черновик
                @endif
            </div>
            <div class="card-body">
                <div class="card-title"></div>
                <div class="card-subtitle mb-2 text-muted"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                           type="button" role="tab" aria-controls="nav-home" aria-selected="true">Основные данные</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                           type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Доп. данные</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input name="title" value="{{ $item->title }}"
                                   id="title"
                                   type="text"
                                   class="form-control"
                                   minlength="3"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="slug">Статья</label>
                            <textarea name="content_raw"
                                      id="content_raw"
                                      class="form-control"
                                      rows="20">{{ old('content_raw', $item->content_raw) }}</textarea>
                        </div>
                        <hr>
                        <div class="form-group col-4">
                            <label>Загрузить превью</label>
                            <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
                        </div>

                        @isset($item->image)
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="remove" id="remove">
                                <label class="form-check-label" for="remove">
                                    Удалить загруженное изображение
                                </label>
                            </div>
                        @endisset
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="form-group">
                            <label for="parent_id">Категория:</label>

                            @foreach($categoryList as $categoryId => $categoryTitle)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]"
                                           id="{{ $categoryId }}" value="{{ $categoryId }}"
                                           @if(in_array($categoryId, $categoryIds)) checked @endif>
                                    <label class="form-check-label" for="{{ $categoryId }}">
                                        {{ $categoryTitle }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                        <div class="form-group">
                            <label for="slug">Идентификатор</label>
                            <input name="slug" value="{{ $item->slug }}"
                                   id="slug"
                                   type="text"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Выдержка</label>
                            <textarea name="excerpt"
                                      id="excerpt"
                                      class="form-control"
                                      rows="3"> {{ old('expert', $item->excerpt) }}</textarea>
                        </div>
                        <div class="form-check">
                            <input name="is_published"
                                   type="hidden"
                                   value="0">
                            <input name="is_published"
                                   type="checkbox"
                                   class="form-check-input"
                                   value="1"
                                   @if($item->is_published)
                                       checked="checked"
                                @endif
                            >
                            <label class="form-check-label" for="is_published">Опубликовано</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

