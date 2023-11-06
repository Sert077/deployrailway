formulario de edicion de elecciones

<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/elecciones/'.$elecciones->id )}}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
@include('elecciones.form');

</form>
