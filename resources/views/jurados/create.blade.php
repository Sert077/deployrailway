<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/jurados')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('jurados.form');


</form>
