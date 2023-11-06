<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/frente/'. $frente->id )}}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
@include('frente.form');

</form>
