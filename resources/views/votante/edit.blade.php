<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/votante/'. $votante->id )}}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
@include('votante.form');

</form>
