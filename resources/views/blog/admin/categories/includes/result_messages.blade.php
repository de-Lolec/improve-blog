@if($errors->any())

    <div class="col-md-8">
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach($errors->all() as $errorsTxt)

                    <li>{{ $errorsTxt }}</li>
                @endforeach
            </ul>
        </div>

    </div>
@endif
