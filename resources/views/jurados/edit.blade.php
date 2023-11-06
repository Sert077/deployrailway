

<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/jurados/'. $jurados->id )}}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
@include('jurados.form');

</form>
