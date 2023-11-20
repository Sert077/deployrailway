<?php

namespace App\Http\Controllers;
use Illuminate\Support\Optional;
use Illuminate\Validation\Rule;
//use Illuminate\Support\Facades\DB;

use App\Models\Eleccion;
use App\Models\Frente;
use App\Models\Votante;
use App\Models\Jurado;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mesascreadas = Mesa::orderBy('id_de_eleccion', 'asc')->paginate(100);
        return view('mesas.index', compact('mesascreadas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $elecciones = Eleccion::where('estado', 1)->get();
    $editar = false; // Establecer a false para modo de creación
    return view('mesas.create', compact('elecciones', 'editar'));
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idDeEleccion = $request->input('id_de_eleccion');

        // Encuentra el número total de votantes registrados para esta elección
        $votantes = Votante::where('ideleccion', $idDeEleccion)->orderBy('apellidoPaterno')->get();
        $totalVotantes = $votantes->count();
    
        // Validar si hay votantes registrados
        if ($totalVotantes == 0) {
            // No hay votantes, redirigir con un mensaje personalizado
            return redirect('/mesas')->with('error', 'No hay votantes registrados en esta elección. Seleccione otra elección que tenga votantes.');
        }
        
        // Validación
        $request->validate([
            'id_de_eleccion' => [
                'required',
                Rule::unique('mesas')->where(function ($query) use ($request) {
                    return $query->where('id_de_eleccion', $request->input('id_de_eleccion'));
                }),
            ],
        ]);
    
        $idDeEleccion = $request->input('id_de_eleccion');
    
        // Encuentra el tipo de votantes de la elección
        $eleccion = Eleccion::find($idDeEleccion);
        $tipoVotantes = strtolower($eleccion->tipodevotantes); // Convertir a minúsculas
    
        // Encuentra el número total de votantes registrados para esta elección
        $votantes = Votante::where('ideleccion', $idDeEleccion)->orderBy('apellidoPaterno')->get();
        $totalVotantes = $votantes->count();
    
        // Calcula la cantidad de votantes por mesa
        $cantidadMesas = ceil($totalVotantes / 100); // 100 votantes por mesa
        $votantesPorMesa = ceil($totalVotantes / $cantidadMesas);
    
        // Lógica de asignación de mesas
        if ($totalVotantes <= 99) {
            // Caso: Menos o igual a 99 votantes, crea una sola mesa
            $datosMesas = request()->except('_token');
            $datosMesas['numeromesa'] = 1; // Número de mesa
            $datosMesas['numerodevotantes'] = $totalVotantes; // Asigna todos los votantes
            $datosMesas['id_de_eleccion'] = $idDeEleccion; // Asigna el id de la elección
    
            // Asignar el apellido del primer y último votante a la columna votantesenmesa
            $primerVotante = $votantes->first();
            $ultimoVotante = $votantes->last();
    
            if ($primerVotante && $ultimoVotante) {
                $datosMesas['votantesenmesa'] = "De {$primerVotante->apellidoPaterno} Hasta {$ultimoVotante->apellidoPaterno}";
            }
    
            // Asignar el tipo de votantes a la columna votantemesa
            $datosMesas['votantemesa'] = $primerVotante->tipoVotante;
    
            Mesa::insert($datosMesas);
        } else {
            // Caso: Más de 99 votantes, asigna mesas equitativamente
    
            // Lógica específica para el tipo "General"
            if ($tipoVotantes == 'general') {
                $votantesEstudiantes = $votantes->where('tipoVotante', 'estudiante');
                $votantesDocentes = $votantes->where('tipoVotante', 'docente');
                $votantesAdministrativos = $votantes->where('tipoVotante', 'administrativo');
    
                $mesaActual = 1;
    
                // Asignar mesas para estudiantes
                $mesaActual = $this->asignarMesasPorTipo($mesaActual, $votantesEstudiantes, $votantesPorMesa, $idDeEleccion, 'estudiante');
    
                // Asignar mesas para docentes
                $mesaActual = $this->asignarMesasPorTipo($mesaActual, $votantesDocentes, $votantesPorMesa, $idDeEleccion, 'docente');
    
                // Asignar mesas para administrativos
                $this->asignarMesasPorTipo($mesaActual, $votantesAdministrativos, $votantesPorMesa, $idDeEleccion, 'administrativo');
            } else {
                // Caso: Otros tipos de votantes, asigna mesas según la lógica actual
                $mesaActual = 1;
    
                $this->asignarMesasPorTipo($mesaActual, $votantes, $votantesPorMesa, $idDeEleccion, '');
            }
        }
    
        return redirect('/mesas')->with('success', 'Las mesas se han guardado con éxito.');
    }
    
    // Función actualizada para asignar mesas por tipo
    private function asignarMesasPorTipo($mesaActual, $votantes, $votantesPorMesa, $idDeEleccion, $tipoVotante)
    {
        $votantesTipo = $votantes->where('tipoVotante', $tipoVotante);
    
        $cantidadMesas = ceil($votantesTipo->count() / $votantesPorMesa);
    
        for ($i = 0; $i < $cantidadMesas; $i++) {
            $datosMesas = request()->except('_token');
            $datosMesas['numeromesa'] = $mesaActual;
            $datosMesas['id_de_eleccion'] = $idDeEleccion; // Asigna el id de la elección
            $datosMesas['votantemesa'] = $tipoVotante; // Asigna el tipo de votante
    
            // Asignar el apellido del primer votante a la columna votantesenmesa
            $primerVotante = $votantesTipo->slice($i * $votantesPorMesa)->first();
    
            // Asignar el apellido del último votante a la columna votantesenmesa
            $ultimoVotante = $votantesTipo->slice($i * $votantesPorMesa, $votantesPorMesa)->last();
    
            if ($primerVotante && $ultimoVotante) {
                $datosMesas['votantesenmesa'] = "De {$primerVotante->apellidoPaterno} Hasta {$ultimoVotante->apellidoPaterno}";
            }
    
            // Asigna la cantidad correcta de votantes a la mesa
            $votantesAsignados = min($votantesPorMesa, $votantesTipo->count() - ($i * $votantesPorMesa));
            $datosMesas['numerodevotantes'] = $votantesAsignados;
    
            Mesa::insert($datosMesas);
    
            $mesaActual++;
        }
    
        return $mesaActual;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $mesas = Mesa::findOrFail($id);
    $elecciones = Eleccion::where('estado', 1)->get();
    $editar = true; // Indica que estamos en modo de edición

    return view('mesas.edit', compact('mesas', 'elecciones', 'editar'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       
        $datosMesas = request()->except(['_token', '_method']);
    
        Mesa::where('id', $id)->update($datosMesas);
    
        return redirect('/mesas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Mesa::destroy($id);
        return redirect('mesas');
    }

    public function generateJurados($id)
{
    $mesa = Mesa::find($id);

    if (!$mesa) {
        return redirect('/mesas')->with('error', 'Mesa no encontrada');
    }

    // Obtén la cantidad de jurados que deseas generar
    $cantidadSuplentes = 1;
    $cantidadTitulares = 2;
    $cantidadPresidente = 2;

    // Obtén la elección asociada a la mesa
    $eleccion = Eleccion::find($mesa->id_de_eleccion);

    if (!$eleccion) {
        return redirect('/mesas')->with('error', 'No se encontró la elección asociada a esta mesa.');
    }

    // Verificar si el tipo de votantes es "General"
    if (strtolower($eleccion->tipodevotantes) === 'general') {
        // Generar jurados de tipo 'Docente'
        $this->generateJuradosByType($mesa->numeromesa, $eleccion->id, 'docente', $cantidadSuplentes, $cantidadTitulares, $cantidadPresidente);

        // Generar jurados de tipo 'Estudiante'
        $this->generateJuradosByType($mesa->numeromesa, $eleccion->id, 'estudiante', 1, 1, 0);
    } else {
        // Generar jurados sin tener en cuenta el tipo de votante
        $this->generateJuradosByType($mesa->numeromesa, $eleccion->id, null, $cantidadSuplentes, $cantidadTitulares, $cantidadPresidente);
    }

    return redirect('/mesas/' . $id . '/lista-jurados')->with('success', 'Se han generado los jurados con éxito.');
}

// Función para generar jurados por tipo
private function generateJuradosByType($idMesa, $idEleccion, $tipoVotante, $cantidadSuplentes, $cantidadTitulares, $cantidadPresidente)
{
    // Verificar la cantidad actual de jurados asignados a la mesa y elección
    $juradosAsignados = Jurado::where('idmesa', $idMesa)
        ->where('iddeeleccion', $idEleccion)
        ->count();

    // Calcular la cantidad máxima de jurados que se pueden asignar
    $cantidadMaxima = 5 - $juradosAsignados;

    // Si no hay espacio para más jurados, no hacer más asignaciones
    if ($cantidadMaxima <= 0) {
        return;
    }

    $votantesQuery = Votante::where('ideleccion', $idEleccion);

    // Si se especifica un tipoVotante, agregar la condición
    if ($tipoVotante !== null) {
        $votantesQuery->whereRaw('LOWER(tipoVotante) = ?', [$tipoVotante]);
    }

    $votantes = $votantesQuery
        ->whereNotIn('codSis', function ($query) use ($idEleccion) {
            $query->select('codSis')
                ->from('jurados')
                ->where('iddeeleccion', $idEleccion);
        })
        ->whereNotIn('CI', function ($query) use ($idEleccion) {
            $query->select('CI')
                ->from('jurados')
                ->where('iddeeleccion', $idEleccion);
        })
        ->inRandomOrder()
        ->limit(min($cantidadMaxima, $cantidadSuplentes + $cantidadTitulares + $cantidadPresidente))
        ->get();

    $votantes = $votantes->shuffle();
    
    $tiposJurado = ['Suplente', 'Titular', 'Presidente'];

    $i = 0;

    foreach ($votantes as $votante) {
        // Obtener el tipo de jurado de manera segura
        $tipoJurado = isset($tiposJurado[$i]) ? $tiposJurado[$i] : null;
    
        // Ajuste para el nombre del presidente
        if ($tipoJurado === 'Presidente') {
            $nombreJurado = $tipoJurado;
        } else {
            $nombreJurado = $tipoJurado === null ? 'Jurado' : $tipoJurado . ' ' . ucfirst($tipoVotante);
        }
    
        Jurado::create([
            'iddeeleccion' => $votante->ideleccion,
            'idmesa' => $idMesa,
            'nombres' => $votante->nombres,
            'apellidoPaterno' => $votante->apellidoPaterno,
            'apellidoMaterno' => $votante->apellidoMaterno,
            'codSis' => $votante->codSis,
            'CI' => $votante->CI,
            'tipoJurado' => $nombreJurado,
        ]);
    
        $i++;
    
        if ($i >= count($tiposJurado) || $i >= ($cantidadSuplentes + $cantidadTitulares + $cantidadPresidente)) {
            break;
        }
    }
}
    
    

public function listaJurados($id)
{
    $mesa = Mesa::find($id);

    if (!$mesa) {
        return redirect('/mesas')->with('error', 'Mesa no encontrada');
    }

    // Obtén los jurados de esta mesa ordenados por tipo
    $jurados = Jurado::where('iddeeleccion', $mesa->id_de_eleccion)
        ->where('idmesa', $mesa->numeromesa)
        ->orderBy('tipojurado', 'asc')
        ->get();

    // Obtén el nombre de la elección
    $eleccion = Eleccion::find($mesa->id_de_eleccion);

    return view('mesas.lista-jurados', compact('jurados', 'eleccion'));
}

public function visualizaracta($id)
    {
        
        $mesa = Mesa::find($id);

        if (!$mesa) {
            return response()->json(['error' => 'Mesa no encontrada'], 404);
        }

        // Obtener elección relacionada
        $eleccion = Eleccion::find($mesa->id_de_eleccion);

        // Obtener los frentes relacionados con la elección
        
        
        $frentes = Frente::where('ideleccionfrente', $mesa->id_de_eleccion)->get();
        $jurados = Jurado::where('iddeeleccion', $mesa->id_de_eleccion)
        ->where('idmesa', $mesa->numeromesa)
        ->orderBy('tipojurado', 'asc')
        ->get();

        return view('mesas.acta', compact('mesa', 'eleccion', 'frentes', 'jurados'));
    }
    public function pdf($id)
    {
        
        $mesa = Mesa::find($id);

        if (!$mesa) {
            return response()->json(['error' => 'Mesa no encontrada'], 404);
        }

        // Obtener elección relacionada
        $eleccion = Eleccion::find($mesa->id_de_eleccion);

        // Obtener los frentes relacionados con la elección
        $frentes = Frente::where('ideleccionfrente', $mesa->id_de_eleccion)->get();
        $jurados = Jurado::where('iddeeleccion', $mesa->id_de_eleccion)
        ->where('idmesa', $mesa->numeromesa)
        ->orderBy('tipojurado', 'asc')
        ->get();
        $pdf = PDF::loadView('mesas.actapdf', compact('mesa', 'eleccion', 'frentes', 'jurados'));
        return $pdf->stream();
    }

}
