<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'('/comunicados/'. $comunicado->id )}}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH') }}
    @include('comunicado.form');

</form>
