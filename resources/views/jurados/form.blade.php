<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear/Editar Jurados</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        /* Estilos del encabezado */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Uni Sans", sans-serif;
}

.company-logo {
    border-radius: 8%;

    max-width: 15%;
    /* Ajusta el ancho máximo de la imagen al 100% del contenedor */
    height: auto;
    /* Permite que la altura se ajuste automáticamente para mantener la proporción */
    /* Alinea verticalmente la imagen en el medio del texto */
    float: left;
    margin-right: 40px;
}

nav {
    display: flex;
    align-items: center;
    justify-content: space-around;
    height: 70px;
    background-image: linear-gradient(to right, #003770, #f80211);
    border-bottom: 2px solid #fff;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 999;
}

nav .logo a {
    font-size: 25px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}

nav .logo a:hover {
    color: #003770;
    transition: 0.5s;
}

nav ul {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2.5rem;
}

nav ul li {
    list-style: none;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
}

nav ul li a:hover {
    color: #003770;
    transition: 0.5s;
}

.menu-icon {
    display: none;
    width: 25px;
    height: 3px;
    background: #fff;
    transform: translateY(-50%);
    transition: 0.5s;
    border-radius: 5px;
    cursor: pointer;
}

.menu-icon::before,
.menu-icon::after {
    content: "";
    position: absolute;
    width: 25px;
    height: 3px;
    background: #fff;
    transition: 0.5s;
    border-radius: 5px;
}

.menu-icon::before {
    top: -8px;
}

.menu-icon::after {
    top: -8px;
}

.menu-icon.active {
    background: rgba(0, 0, 0, 0);
}

.menu-icon.active::before {
    top: 0;
    transform: rotate(45deg);
}

.menu-icon.active::after {
    top: 0;
    transform: rotate(135deg);
}

@media screen and (max-width:992px) {
    nav ul {
        position: fixed;
        top: 0px;
        right: 100%;
        width: 100%;
        height: 90vh;
        background: #004a92;
        flex-direction: column;
        transition: 0.5s ease-in;
    }

    nav ul li a {
        font-size: 24px;
    }

    ul.active {
        right: 0;
        transition: 0.5s ease-in;
    }

    .menu-icon {
        display: block;
    }
}

/* Estilos del contenido */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.header {
    background-color: white;
    color: white;
    text-align: center;
    padding: 20px 0;
}

.container {
    max-width: 1300px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

    
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

.form-title {
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

input[type="text"],
input[type="number"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

input[type="file"] {
    margin-top: 5px;
}

input[type="submit"] {
    background-color: #04243C;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

input[type="reset"] {
    background-color: #A70606;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

input[type="submit"]:hover,
input[type="reset"]:hover {
    background-color: #0056b3;
}

/* Estilos para las columnas */
.columns {
    display: flex;
    justify-content: space-between;
}

.column {
    flex: 1;
    padding: 10px;
}

.footer {
    background-color: #003770;
    color: white;
    padding: 15px;
    position: fixed;
    bottom: 0;
    right: 0;
    left: 0;
    font-size: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-izq {
    flex: 1;

    text-align: left;
    margin-left: 70px;
    /* Ajusta el valor de margen según cuánto espacio desees agregar */


}

.footer-medio {
    text-align: center;
    display: flex;
    align-items: center;
    white-space: nowrap;
    /* Evita el retorno de línea */
    overflow: hidden;
    /* Oculta el desbordamiento si el contenido es demasiado largo */
    text-overflow: ellipsis;
    /* Agrega puntos suspensivos (...) si el contenido es demasiado largo */
    display: flex;
    align-items: center;
    white-space: nowrap;
    /* Evita el retorno de línea */
    overflow: hidden;
    /* Oculta el desbordamiento si el contenido es demasiado largo */
    text-overflow: ellipsis;
    /* Agrega puntos suspensivos (...) si el contenido es demasiado largo */
    font-size: 18px;

}

.footer-der {
    flex: 1;
    text-align: center;
}

.footer-der a {
    color: white;
    /* Establece el color del texto en blanco por defecto */
    text-decoration: none;
    /* Elimina el subrayado predeterminado de los enlaces */
    transition: color 0.3s;
    /* Agrega una transición suave para el cambio de color */
    font-size: 18px;
    /* Ajusta el tamaño de fuente según tus preferencias */

}

.footer-der a:hover {
    color: red;
    /* Cambia el color del texto a rojo al pasar el ratón sobre el enlace */
    font-size: 20px;
    /* Tamaño de fuente al pasar el ratón sobre el enlace, puedes ajustarlo según tus preferencias */

}

    </style>


    <script>
        function confirmarCancelacion() {
            var confirmacion = confirm("¿Seguro que deseas cancelar? Los cambios no se guardarán.");
            if (confirmacion) {

                window.location.href = "/jurados/jurados";
            }
        }

        function confirmarConfirmacion() {
            var confirmacion = confirm("Los datos han sido registrados con éxito");
            if (confirmacion) {

                window.location.href = "/jurados/jurados";
            }
        }
    </script>

</head>

<body>
    <nav>
        <div class="logo">
            <a href="#" class="logo2">
                <img src="/images/Logo_TE.png" alt="Logo de Enrique" class="company-logo">
                
            </a>
            <div><a href="{{ url('/') }}">TRIBUNAL ELECTORAL</a></div>
            
            <div><a href="{{ url('/') }}">UNIVERSITARIO</a></div>
        </div>
        <ul>
            <li></li><li></li>
            <li></li><li></li>
            <li></li><li></li>
            <li></li><li></li>

        <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="{{ url('/elecciones') }}">Elecciones</a></li>
            <li><a href="#">Documentación</a></li>
            {{-- <li><a href="#">Acerca de</a></li>
            <li><a href="#">Contacto</a></li> --}}
            <li><a href="#">Ingreso</a></li>
            <img src="/images/img.png"  class="company-logo">

        </ul>
        <div class="menu-icon"></div>
    </nav>
    <header></header>
    <div class="header">
    <label for=""></label><br><br>
    </div>
    <div class="container">
        <form action="{{ isset($jurados) ? url('/jurados/' . $jurados->id) : url('/jurados') }}"
            method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($jurados))
                {{ method_field('PATCH') }}
            @endif
            <h2 class="form-title">Editar jurado</h2>
            <br>
                <div class="column">

                    <label for="iddeeleccion">Id Eleccion:</label>
                    <input type="number"  name="iddeeleccion"
                        placeholder="Escribe el nombre del miembro aquí..."
                        value="{{ isset($jurados) ? $jurados->iddeeleccion : '' }}" id="iddeeleccion" required>

                    <label for="idmesa">Id Mesa:</label>
                    <input type="number" 
                        name="idmesa" placeholder="Escribe el apellido paterno aquí..."
                        value="{{ isset($jurados) ? $jurados->idmesa : '' }}" id="idmesa"
                        required>

                        <label for="nombres">Nombres:</label>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z,.]+/g, '')" maxlength="30"
                        name="nombres" placeholder="Escribe el apellido materno aquí..."
                        value="{{ isset($jurados) ? $jurados->nombres : '' }}" id="nombres"
                        required>

                        <label for="apellidoPaterno">Apellido Materno:</label>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z,.]+/g, '')" maxlength="30"
                        name="apellidoPaterno" placeholder="Escribe el apellido materno aquí..."
                        value="{{ isset($jurados) ? $jurados->apellidoPaterno : '' }}" id="apellidoPaterno"
                        required>

                        <label for="apellidoMaterno">Apellido Materno:</label>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z,.]+/g, '')" maxlength="30"
                        name="apellidoMaterno" placeholder="Escribe el apellido materno aquí..."
                        value="{{ isset($comite) ? $comite->apellidoMaterno : '' }}" id="apellidoMaterno"
                        required>

                        <label for="codSis">Cod-SiS:</label>
                    <input type="number" 
                        name="codSis" placeholder="Escribe el codSis"
                        value="{{ isset($jurados) ? $jurados->codSis : '' }}" id="codSis" maxlength="10"
                        required>

                        <label for="CI">CI:</label>
                    <input type="text" 
                        name="CI" placeholder="Escribe el carnet de identidad"
                        value="{{ isset($jurados) ? $jurados->CI : '' }}" id="CI" maxlength="10"
                        required>

                        <label for="tipojurado">Tipo Jurado:</label>
                    <input type="text" 
                        name="tipojurado" placeholder="Escribe el tipo de jurado" oninput="this.value = this.value.replace(/[^A-Za-z,.]+/g, '')" maxlength="30"
                        value="{{ isset($jurados) ? $jurados->tipojurado : '' }}" id="tipojurado"
                        required>

                   

                </div>
            <input type="submit" value="{{ isset($jurados) ? 'Actualizar' : 'Registrar' }}"
                onclick="confirmarConfirmacion()">
            <input type="reset" value="Cancelar" onclick="confirmarCancelación()">
            
            <label for=""></label><br><br>
        </form>
        
    </div>
    <br><br>
    <br><br>
    <br><br>
    <div class="footer">

            <div class="footer-izq">
                Av. Oquendo y calle Jordán asd
                <br>
                Mail: Tribunal_electoral@umss.edu
                <br>
                www.umss.edu.bo Cochabamba - Bolivia
                <br>
                Design: DevGenius

            </div>
            <div class="footer-medio">

                Copyright © 2023 Tribunal Electoral Universitario Todos los derechos Reservados

            </div>
            <div class="footer-der">
                <a href="{{ url('/') }}">Acerca de</a>
                <span>&nbsp;|&nbsp;</span> <!-- Para agregar un separador -->
                <a href="{{ url('/') }}">Contactos</a>

            </div>

        </div>


</body>

</html>