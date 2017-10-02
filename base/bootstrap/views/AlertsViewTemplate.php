@if (Session::has('success'))
<div class="container-fluid">
    <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    \{{ Session::get('success') }}
                </div>
            </div>
    </div>
</div>
@endif

@if($errors->any())
<div class="container-fluid">
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="col-md-6 col-sm-12">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    \{{$error}}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif