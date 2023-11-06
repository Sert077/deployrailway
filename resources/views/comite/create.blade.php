<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/comite')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('comite.form');


</form>
