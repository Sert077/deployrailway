<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/elecciones')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('elecciones.form');


</form>
