<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriosAceptacionController;
use App\Http\Controllers\ProductBacklogController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SprintBacklogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiembrosEquipoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect('/auth/login')->withErrors(['google_login' => 'Error al iniciar sesión con Google: ' . $e->getMessage()]);
    }

    $nombre   = explode(' ', $googleUser->getName())[0] ?? '';
    $apellido = explode(' ', $googleUser->getName())[1] ?? '';

    $user = User::where('email', $googleUser->getEmail())->first();
    $uid = $user ? $user->uid : (string) Str::uuid();

    $foto = null;

    // 🔹 Intentar descargar la foto de Google con headers
    if ($googleUser->getAvatar()) {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept'     => 'image/webp,image/apng,image/*,*/*;q=0.8',
            ])->get($googleUser->getAvatar());

            if ($response->successful()) {
                $extension = "jpg";
                $fileName = "usuarios/" . $uid . "." . $extension;

                Storage::disk('public')->put($fileName, $response->body());

                $foto = "storage/" . $fileName;
            }
        } catch (\Exception $e) {
            // Si falla, se deja null y pasa al fallback
        }
    }

    // 🔹 Fallback a ui-avatars si no se descargó nada
    if (!$foto) {
        $foto = "https://ui-avatars.com/api/?name=" . urlencode("{$nombre} {$apellido}") . "&background=random&color=fff";
    }

    // 🔹 Guardar usuario
    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'email'    => $googleUser->getEmail(),
            'google_id'=> $googleUser->getId(),
            'foto_url' => $foto,
            'uid'      => $uid,
            'estado'   => 1,
            'password' => bcrypt(Str::random(16)),
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});

//-----------------------------------------------------------------------

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// usuarios ---------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/storeCuenta', [AuthController::class, 'store'])->name('storeCuenta');

// Rutas para gestión de usuarios
Route::get('/usuarios', [UserController::class, 'index'])
    ->name('usuarios.index')
    ->middleware('auth');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/showUsuarios', [UserController::class, 'show'])->name('showUsuarios');
Route::get('/usuarios/edit/{uid}', [UserController::class, 'edit'])->name('editUsuario');
Route::put('/usuarios/update/{uid}', [UserController::class, 'update'])->name('updateUsuario');
Route::delete('/usuarios/eliminar/{uid}', [UserController::class, 'destroy'])->name('deleteUsuario');
Route::get('/showRoles', [UserController::class, 'showRoles'])->name('showRoles');
Route::delete('/usuarios/{uid}/foto', [UserController::class, 'deleteFotoPerfil'])->name('deleteFotoUsuario');

//  Rutas para la gestion de proyectos ---------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/proyectos', [ProyectoController::class, 'index'])
    ->middleware('auth')
    ->name('proyectos.index');
Route::get('/showProyectos',[ProyectoController::class, 'show'])->name('showProyectos');
Route::post('/proyectos/store', [ProyectoController::class, 'store'])->name('storeProyecto');
Route::get('/proyecto/{uid}', [ProyectoController::class, 'detailsProyecto'])->name('detailsProyecto');
Route::get('/proyectos/edit/{uid}', [ProyectoController::class, 'edit'])->name('editProyecto');
Route::put('/proyectos/update', [ProyectoController::class, 'update'])->name('updateProyecto');
Route::delete('/proyectos/delete/{uid}', [ProyectoController::class, 'destroy'])->name('deleteProyecto');

// Rutas para la gestion del backlog
Route::get('/proyectos/backlog/{uid}', [ProductBacklogController::class, 'index'])
    ->middleware('auth')
    ->name('showProyectoBacklog');
Route::get('proyectos/backlog/{uid}/show', [ProductBacklogController::class, 'show'])->name('showProductBacklog');
Route::post('/proyectos/backlog/{uid}/store', [ProductBacklogController::class, 'store'])->name('storeProductBacklog');
Route::put('/proyectos/backlog/{uid}/update/{historiaUid}', [ProductBacklogController::class, 'update'])->name('updateProductBacklog');
Route::delete('/proyectos/backlog/{uid}/delete', [ProductBacklogController::class, 'destroy'])->name('deleteProductBacklog');

// Rutas para la gestion de los criterios de aceptacion
Route::post('/criterios/{historiaUid}/store', [CriteriosAceptacionController::class, 'store'])->name('storeCriterios');
Route::put('/criterios/{uid}/update',[CriteriosAceptacionController::class,'update'])->name('updateCriterios');
Route::delete('/criterio/{uid}/delete',[CriteriosAceptacionController::class,'destroy'])->name('deleteCriterios');

//Roles---------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles.store');
Route::get('/roles/show',[RolesController::class, 'show'])->name('roles.show');
Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
Route::delete('/roles/{uid}', [RolesController::class, 'destroy'])->name('deleteRoles');
Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
Route::get('/roles/{id}/delete', [RolesController::class, 'destroy'])->name('roles.delete');

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth')
        ->name('dashboard');

    Route::get('/dashboard/proyectos', [DashboardController::class, 'getProyectos'])->name('getProyectos');


    // Authentication Routes
    Auth::routes(['reset' => true]);

    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::redirect('/', '/auth/login');
    Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/register', [AuthController::class, 'authRegister'])->name('auth.register');
    Route::post('/auth/login', [AuthController::class, 'authLogin'])->name('authLogin');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware(['web'])->group(function () {
    Route::get('/auth/recovery', [AuthController::class, 'showRecoveryForm'])->name('recoverypw');
    Route::post('/auth/recovery', [AuthController::class, 'sendRecoveryEmail'])->name('recoverypw.send');
    Route::get('/auth/mail-sent', [AuthController::class, 'showMailSent'])->name('mail.sent');
    });


// Sprint Routes
Route::get('/proyectos/backlog/{uid}/sprints/show', [SprintController::class, 'show'])->name('showSprint');
Route::post('/proyectos/backlog/{uid}/sprints/store', [SprintController::class, 'store'])->name('storeSprint');
Route::post('/proyectos/backlog/{uid}/sprints/update', [SprintController::class, 'update'])->name('updateSprint');
Route::post('/proyectos/backlog/{uid}/sprints/destroy', [SprintController::class, 'destroy'])->name('destroySprint');
Route::get('/proyectos/backlog/{uid}/sprints/items', [SprintController::class, 'showItems'])->name('showItems');
Route::post('/proyectos/backlog/{uid}/sprints/{sprintUid}/items/start', [SprintController::class, 'startSprint'])->name('startSprint');
Route::get('/proyectos/{uid}/board', [ProyectoController::class, 'board'])->name('board');
Route::get('/proyectos/{proyectoUID}/sprints/activo', [SprintController::class, 'getSprintActivo']);
Route::get('/proyectos/backlog/{uid}/sprints/all', [SprintController::class, 'showAll'])->name('sprints.all');



// Sprint Backlog Routes
Route::get('/proyectos/backlog/{uid}/sprints/{sprintId}/sprbacklog/show', [SprintBacklogController::class, 'show'])->name('showSprintBacklog ');
Route::post('/proyectos/backlog/{uid}/sprints/{sprintId}/sprbacklog/store',[SprintBacklogController::class, 'store'])->name('storeSprintBacklog');


// Tablero Routes
Route::get('/proyectos/{proyectoUID}/sprints/{sprintUID}/board/view', [SprintController::class, 'boardView'])
    ->middleware('auth')
    ->name('boardView');
Route::get('/proyectos/{proyectoUID}/sprints/{sprintUID}/board/items', [SprintController::class, 'getSprintBacklog']);
Route::post('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}/progreso', [SprintController::class, 'updateItemProgreso']);

//ruta para las invitaciones a proyectos
Route::post('/proyectos/{proyecto}/enviar-invitacion',[ProyectoController::class,'enviarInvitacion'])->name('proyectos.enviarInvitacion');
Route::get('/mis-invitaciones',[ProyectoController::class,'misInvitaciones'])->name('proyectos.misInvitaciones');
Route::post('/invitaciones/{uid}/responder',[ProyectoController::class,'responderInvitacion'])->name('proyectos.responderInvitacion');

//------

//RUTAS PARA MOSTRAR LOS MIEMBROS DE UN EQUIPO
Route::get('/miembros-equipo/{uidProyecto}',[MiembrosEquipoController::class,'show'])->name('miembros');
//-----------------------

//RUTA PARA PODER DEVOLVER UN PRODUCT_BACKLOG DEL SPRINT
Route::delete('/proyectos/backlog/{uid}/sprints/items/{uidHistoria}/devolver',[SprintBacklogController::class,'devolverHistoria'])->name('devolverProduct');
//_____________________________________

