<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/mesas')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('mesas.form');


</form>
