<form action="{{ 'https://deployrailway-production-3bd5.up.railway.app'.('/comunicados')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('comunicado.form');


</form>
