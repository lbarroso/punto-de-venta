@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Imagen de perfil  </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Perfil</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">  
              
            <div class="card-header"> <i class="fas fa-user"></i> {{ ucwords(Auth::user()->name) }} </div>
            
            <div class="card-body">    

                <div class="container">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="profile_image">Imagen de perfil:</label>
                            <input type="file" class="form-control" name="profile_image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar  Perfil</button>
                    </form>
                </div>

</div>
<!-- /.card-body -->
<div class="card-footer">
  &nbsp;
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
</div>
</div>
</div>
</section>

@endsection