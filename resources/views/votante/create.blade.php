<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/votante')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('votante.form');

</form>
