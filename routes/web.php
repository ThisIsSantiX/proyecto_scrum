<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriosAceptacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SprintBacklogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\RoleUser;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiembrosEquipoController;
use App\Http\Controllers\ProductBacklogController;
use App\Http\Controllers\DailyScrumController;
use App\Http\Controllers\GithubController;
use App\Models\CriteriosAceptacion;
use App\Models\SprintBacklogMiembro;


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
        Log::error('Google OAuth Error: ' . $e->getMessage());
        return redirect('/auth/login')
            ->withErrors(['google_login' => 'Error al iniciar sesión con Google']);
    }

    // --- Procesar datos del usuario de Google ---
    $fullName    = $googleUser->getName() ?? 'Usuario';
    $givenName   = $googleUser->user['given_name'] ?? '';  // nombre
    $familyName  = $googleUser->user['family_name'] ?? ''; // apellido

    // Username base sin espacios
    $baseUsername = preg_replace('/\s+/', '', $fullName);

    // Foto de perfil
    $foto = $googleUser->getAvatar()
        ? $googleUser->getAvatar()
        : "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=random&color=fff";

    // --- Buscar usuario existente por correo ---
    $user = User::where('email', $googleUser->getEmail())->first();

    if ($user) {
        // Si ya existe, actualizar datos de Google (sin cambiar username)
        $user->update([
            'google_id' => $googleUser->getId(),
            'foto_url'  => $foto,
            'estado'    => 1,
            'nombre'    => $givenName ?: $user->nombre,
            'apellido'  => $familyName ?: $user->apellido,
        ]);
    } else {
        // Si es nuevo, crear username único
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $user = User::create([
            'username'  => $username,
            'nombre'    => $givenName,
            'apellido'  => $familyName,
            'email'     => $googleUser->getEmail(),
            'telefono'  => null, // lo completas después si es obligatorio
            'google_id' => $googleUser->getId(),
            'foto_url'  => $foto,
            'uid'       => (string) Str::uuid(),
            'estado'    => 1,
            'password'  => bcrypt(Str::random(16)), // contraseña aleatoria
        ]);

        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => 4,
            'estado'  => 1,
            'uid'     => Str::uuid(),
        ]);
    }

    // Iniciar sesión
    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/auth/github', [GithubController::class, 'redirectToProvider']);
Route::get('/auth/github/callback', [GithubController::class, 'handleProviderCallback']);

//-----------------------------------------------------------------------

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// perfil ---------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/perfil/configuracion', [UserController::class, 'configuracion'])->name('configuracion');

Route::get('/perfil/{username}', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('user.profile');

Route::put('/perfil/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::get('/perfil/configuracion', [UserController::class, 'configuracion'])->name('configuracion');



// Rutas para gestión de usuarios
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/showUsuarios', [UserController::class, 'show'])->name('showUsuarios');
    Route::get('/usuarios/edit/{uid}', [UserController::class, 'edit'])->name('editUsuario');
    Route::put('/usuarios/update/{uid}', [UserController::class, 'update'])->name('updateUsuario');
    Route::delete('/usuarios/eliminar/{uid}', [UserController::class, 'destroy'])->name('deleteUsuario');
    Route::get('/showRoles', [UserController::class, 'showRoles'])->name('showRoles');
    Route::delete('/usuarios/{uid}/foto', [UserController::class, 'deleteFotoPerfil'])->name('deleteFotoUsuario');

});

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
Route::get('/proyectos/recientes', [ProyectoController::class, 'proyectosRecientes'])->middleware('auth')->name('proyectos.recientes');
Route::post('/proyectos/{uid}/registrar-acceso', [ProyectoController::class, 'registrarAcceso'])
    ->name('proyectos.registrar-acceso');
    

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
Route::post('/marcar-tour-completado', [UserController::class, 'marcarTour'])->name('usuario.marcarTour');

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
Route::post('/onboarding/completado', [DashboardController::class, 'marcarOnboardingCompletado'])
->middleware('auth')
->name('onboarding.completado');


    // Authentication Routes

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

        Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
        Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
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
Route::get('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}', 
    [SprintController::class, 'getItem']
)->name('sprint.item.get');

Route::post('/proyectos/{proyectoUID}/sprints/{sprintUID}/items', 
    [SprintController::class, 'createItem'])->name('items.create');

Route::get('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}', 
    [SprintController::class, 'getItem']);

Route::put('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}', 
    [SprintController::class, 'updateItem']);

Route::patch('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}/titulo', 
    [SprintController::class, 'updateItemTitulo']);

Route::post('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}/progreso', 
    [SprintController::class, 'updateItemProgreso']);

Route::delete('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}', 
    [SprintController::class, 'deleteItem']);

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

// RUTAS PARA DAILY SCRUM
Route::get('/reuniones', [DailyScrumController::class, 'index'])->name('dailyScrum.index');
Route::get('/proyectos/backlog/{uid}/reuniones/show', [DailyScrumController::class, 'show'])->name('showDailyScrum');
Route::post('/proyectos/backlog/{uid}/reuniones/store', [DailyScrumController::class, 'store'])->name('storeDailyScrum');
Route::put('/proyectos/backlog/{uid}/reuniones/update', [DailyScrumController::class, 'update'])->name('updateDailyScrum');
Route::post('/proyectos/backlog/{uid}/reuniones/destroy', [DailyScrumController::class, 'destroy'])->name('destroyDailyScrum');
//_____________________________________


//RUTAS PARA PODER ASIGNAR USUARIOS DESDE EL TABLERO
Route::get('/proyectos/{proyectoUID}/miembros',[SprintController::class, 'miembrosProyecto']);
Route::post('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}/asignar-miembros', [SprintController::class, 'asignarMiembrosASprintItem'])->name('sprint.item.asignarMiembros');
Route::get('/proyectos/{proyectoUID}/sprints/{sprintUID}/items/{itemUID}/miembros', [SprintController::class, 'getMiembrosAsignados']);
//______________________________
