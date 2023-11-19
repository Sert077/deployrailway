<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/documentaciones/'. $documentacion->id )}}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH') }}
    @include('documentacion.form');

</form>
