<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/frente')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('frente.form');


</form>
