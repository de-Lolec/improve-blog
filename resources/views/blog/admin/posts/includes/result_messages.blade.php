@if($errors->any())

        <div class="col-md-11">
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $errorsTxt)
                        <li>{{ $errorsTxt }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

@endif

