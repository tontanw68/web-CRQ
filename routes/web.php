<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkareaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/signin', [AuthController::class, 'signin'])->name('auth.login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/timesheet', [TimesheetController::class, 'adddata'])->name('adddata');
//test  
Route::get('/timesheet', [TimesheetController::class, 'Edit'])->name('Edit');
//test edit
Route::get('/edit-data/{TS_id}', [TimesheetController::class, 'edit']);
//Route::put('/timesheet', [TimesheetController::class, 'update'])->name('update');
Route::get('/timesheet', [TimesheetController::class, 'destroy'])->name('destroy');
Route::put('/update/{TS_id}', [TimesheetController::class, 'update'])->name('update');
//Route::get('delete-data/{TS_id}', [TimesheetController::class, 'destroy']);
Route::delete('/service-delete/{TS_id}', [TimesheetController::class, 'delete']);
Route::get('/fetch-data', [TimesheetController::class, 'fetchdata']);
Route::put('/update-crq/{CRQ_id}', [WorkareaController::class, 'updatecrq']);
Route::get('/file', function(){
    return view ('files');
});
Route::post('/file', [UserController::class,'fileUpload']);


Route::middleware(['isAdmin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Workarea
    //worknow
    Route::get('/crq-data/{CRQ_id}', [WorkareaController::class, 'show']);
    Route::get('/crq-sendjob/{CRQ_id}', [WorkareaController::class, 'sendjob']);
    Route::get('/crq-editcrq/{CRQ_id}', [WorkareaController::class, 'editcrq']);
    //Route::put('comment', [WorkareaController::class, 'comment'])->name('comment');
    Route::put('/sjupdate/{CRQ_id}', [WorkareaController::class, 'sjupdate']);
    Route::put('/upclosejobnow/{CRQ_id}', [WorkareaController::class, 'upclosejobnow']);
    Route::put('/closeupdate/{CRQ_id}', [WorkareaController::class, 'closeupdate']);
    Route::get('/crq-closejob/{CRQ_id}', [WorkareaController::class, 'closejob']);
    Route::post('insert', [WorkareaController::class, 'addcrq'])->name('addcrq');
    Route::get('/editcrq-data/{CRQ_id}', [WorkareaController::class, 'edit']);
    Route::put('/update-crq/{CRQ_id}', [WorkareaController::class, 'updatecrq']);
    //Route::get('/fetch-crq', [WorkareaController::class, 'fetchcrq']);
    Route::get('/workall', [WorkareaController::class, 'index'])->name('workall');
    Route::get('/opencrq', [WorkareaController::class, 'opencrq'])->name('opencrq');
    Route::get('/worknow', [WorkareaController::class, 'worknow'])->name('worknow');
    Route::get('/workall', [WorkareaController::class, 'workall'])->name('workall');
    Route::get('/workwait', [WorkareaController::class, 'workwait'])->name('workwait');
    Route::get('/worksatis', [WorkareaController::class, 'worksatis'])->name('worksatis');
    Route::get('/masterDDL', [WorkareaController::class, 'masterDDL'])->name('masterDDL');
    // timesheet
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
   // workwait
    Route::post('addworkwait', [WorkareaController::class, 'addworkwait'])->name('addworkwait');
    Route::put('/crq-updatesendjob/{CRQ_id}', [WorkareaController::class, 'updatesendjob']);
    Route::put('/crq-update/{CRQ_id}', [WorkareaController::class, 'crq_update']);
    Route::get('upload/image', [WorkareaController::class,'ImageUpload'])->name('ImageUpload');
    Route::post('upload/image', [WorkareaController::class,'ImageUploadStore'])->name('ImageUploadStore');
    Route::delete('/crq-delete/{CRQ_id}', [WorkareaController::class, 'crq_delete']);

    // master DDL
    Route::get('/detail/{ID}', [WorkareaController::class, 'detailDDL']);
    Route::post('ddl-add', [WorkareaController::class, 'addddl'])->name('addddl');
    Route::get('/ddl-edit/{TS_id}', [WorkareaController::class, 'ddl_edit']);
    Route::put('/ddl-update/{TS_id}', [WorkareaController::class, 'ddl_update']);
    Route::delete('/ddl-delete/{TS_id}', [WorkareaController::class, 'ddl_delete']);
    // worksafis
    Route::get('/filterdate/', [WorkareaController::class, 'filterdate']);
    Route::put('/checkbox/{TS_id}', [WorkareaController::class, 'checkbox']);
    Route::post('addsatis', [WorkareaController::class, 'addsatis'])->name('addsatis');
    Route::get('/edit-satis/{CRQ_id}', [WorkareaController::class, 'editsatis']);
    Route::put('/update-satis/{CRQ_id}', [WorkareaController::class, 'updatesatis']);
    //test add
    //Route::get('/service-list', [TimesheetController::class, 'insert']);
    //Route::get('/Edit/{TS_id}', 'TimesheetController@Edit');
 


    Route::get('/dashboard-alternate', function () {
    return view('dashboard-alternate');
});
/*App*/
Route::get('/app-emailbox', function () {
    return view('app-emailbox');
});
Route::get('/app-emailread', function () {
    return view('app-emailread');
});
Route::get('/app-chat-box', function () {
    return view('app-chat-box');
});
Route::get('/app-file-manager', function () {
    return view('app-file-manager');
});
Route::get('/app-contact-list', function () {
    return view('app-contact-list');
});
Route::get('/app-to-do', function () {
    return view('app-to-do');
});
Route::get('/app-invoice', function () {
    return view('app-invoice');
});
Route::get('/app-fullcalender', function () {
    return view('app-fullcalender');
});
/*Charts*/
Route::get('/charts-apex-chart', function () {
    return view('charts-apex-chart');
});
Route::get('/charts-chartjs', function () {
    return view('charts-chartjs');
});
Route::get('/charts-highcharts', function () {
    return view('charts-highcharts');
});
/*ecommerce*/
Route::get('/ecommerce-products', function () {
    return view('ecommerce-products');
});
Route::get('/ecommerce-products-details', function () {
    return view('ecommerce-products-details');
});
Route::get('/ecommerce-add-new-products', function () {
    return view('ecommerce-add-new-products');
});
Route::get('/ecommerce-orders', function () {
    return view('ecommerce-orders');
});

/*Components*/
Route::get('/widgets', function () {
    return view('widgets');
});
Route::get('/component-alerts', function () {
    return view('component-alerts');
});
Route::get('/component-accordions', function () {
    return view('component-accordions');
});
Route::get('/component-badges', function () {
    return view('component-badges');
});
Route::get('/component-buttons', function () {
    return view('component-buttons');
});
Route::get('/component-cards', function () {
    return view('component-cards');
});
Route::get('/component-carousels', function () {
    return view('component-carousels');
});
Route::get('/component-list-groups', function () {
    return view('component-list-groups');
});
Route::get('/component-media-object', function () {
    return view('component-media-object');
});
Route::get('/component-modals', function () {
    return view('component-modals');
});
Route::get('/component-navs-tabs', function () {
    return view('component-navs-tabs');
});
Route::get('/component-navbar', function () {
    return view('component-navbar');
});
Route::get('/component-paginations', function () {
    return view('component-paginations');
});
Route::get('/component-popovers-tooltips', function () {
    return view('component-popovers-tooltips');
});
Route::get('/component-progress-bars', function () {
    return view('component-progress-bars');
});
Route::get('/component-spinners', function () {
    return view('component-spinners');
});
Route::get('/component-notifications', function () {
    return view('component-notifications');
});
Route::get('/component-avtars-chips', function () {
    return view('component-avtars-chips');
});
/*Content*/
Route::get('/content-grid-system', function () {
    return view('content-grid-system');
});
Route::get('/content-typography', function () {
    return view('content-typography');
});
Route::get('/content-text-utilities', function () {
    return view('content-text-utilities');
});
/*Icons*/
Route::get('/icons-line-icons', function () {
    return view('icons-line-icons');
});
Route::get('/icons-boxicons', function () {
    return view('icons-boxicons');
});
Route::get('/icons-feather-icons', function () {
    return view('icons-feather-icons');
});
/*Authentication*/
Route::get('/authentication-signin', function () {
    return view('authentication-signin');
});
Route::get('/authentication-signup', function () {
    return view('authentication-signup');
});
Route::get('/authentication-signin-with-header-footer', function () {
    return view('authentication-signin-with-header-footer');
});
Route::get('/authentication-signup-with-header-footer', function () {
    return view('authentication-signup-with-header-footer');
});
Route::get('/authentication-forgot-password', function () {
    return view('authentication-forgot-password');
});
Route::get('/authentication-reset-password', function () {
    return view('authentication-reset-password');
});
Route::get('/authentication-lock-screen', function () {
    return view('authentication-lock-screen');
});
/*Table*/
Route::get('/table-basic-table', function () {
    return view('table-basic-table');
});
Route::get('/table-datatable', function () {
    return view('table-datatable');
});
/*Pages*/
Route::get('/user-profile', function () {
    return view('user-profile');
});
Route::get('/timeline', function () {
    return view('timeline');
});
Route::get('/pricing-table', function () {
    return view('pricing-table');
});
Route::get('/errors-404-error', function () {
    return view('errors-404-error');
});
Route::get('/errors-500-error', function () {
    return view('errors-500-error');
});
Route::get('/errors-coming-soon', function () {
    return view('errors-coming-soon');
});
Route::get('/error-blank-page', function () {
    return view('error-blank-page');
});
Route::get('/faq', function () {
    return view('faq');
});
/*Forms*/
Route::get('/form-elements', function () {
    return view('form-elements');
});

Route::get('/form-input-group', function () {
    return view('form-input-group');
});
Route::get('/form-layouts', function () {
    return view('form-layouts');
});
Route::get('/form-validations', function () {
    return view('form-validations');
});
Route::get('/form-wizard', function () {
    return view('form-wizard');
});
Route::get('/form-text-editor', function () {
    return view('form-text-editor');
});
Route::get('/form-file-upload', function () {
    return view('form-file-upload');
});
Route::get('/form-date-time-pickes', function () {
    return view('form-date-time-pickes');
});
Route::get('/form-select2', function () {
    return view('form-select2');
});
/*Maps*/
Route::get('/map-google-maps', function () {
    return view('map-google-maps');
});
Route::get('/map-vector-maps', function () {
    return view('map-vector-maps');
});
/*Un-found*/
Route::get('/test/content-grid-system', function () {
    return view('test/content-grid-system');
});


});
// Route::get('/', function () {
//     return view('authentication-signin');

// });
// Route::get('/index', function () {
//     return view('index');
// });

// Route::get('/timesheet', function () {
//     return view('timesheet');
// });

// Route::get('/dashboard-alternate', function () {
//     return view('dashboard-alternate');
// });
// /*App*/
// Route::get('/app-emailbox', function () {
//     return view('app-emailbox');
// });
// Route::get('/app-emailread', function () {
//     return view('app-emailread');
// });
// Route::get('/app-chat-box', function () {
//     return view('app-chat-box');
// });
// Route::get('/app-file-manager', function () {
//     return view('app-file-manager');
// });
// Route::get('/app-contact-list', function () {
//     return view('app-contact-list');
// });
// Route::get('/app-to-do', function () {
//     return view('app-to-do');
// });
// Route::get('/app-invoice', function () {
//     return view('app-invoice');
// });
// Route::get('/app-fullcalender', function () {
//     return view('app-fullcalender');
// });
// /*Charts*/
// Route::get('/charts-apex-chart', function () {
//     return view('charts-apex-chart');
// });
// Route::get('/charts-chartjs', function () {
//     return view('charts-chartjs');
// });
// Route::get('/charts-highcharts', function () {
//     return view('charts-highcharts');
// });
// /*ecommerce*/
// Route::get('/ecommerce-products', function () {
//     return view('ecommerce-products');
// });
// Route::get('/ecommerce-products-details', function () {
//     return view('ecommerce-products-details');
// });
// Route::get('/ecommerce-add-new-products', function () {
//     return view('ecommerce-add-new-products');
// });
// Route::get('/ecommerce-orders', function () {
//     return view('ecommerce-orders');
// });

// /*Components*/
// Route::get('/widgets', function () {
//     return view('widgets');
// });
// Route::get('/component-alerts', function () {
//     return view('component-alerts');
// });
// Route::get('/component-accordions', function () {
//     return view('component-accordions');
// });
// Route::get('/component-badges', function () {
//     return view('component-badges');
// });
// Route::get('/component-buttons', function () {
//     return view('component-buttons');
// });
// Route::get('/component-cards', function () {
//     return view('component-cards');
// });
// Route::get('/component-carousels', function () {
//     return view('component-carousels');
// });
// Route::get('/component-list-groups', function () {
//     return view('component-list-groups');
// });
// Route::get('/component-media-object', function () {
//     return view('component-media-object');
// });
// Route::get('/component-modals', function () {
//     return view('component-modals');
// });
// Route::get('/component-navs-tabs', function () {
//     return view('component-navs-tabs');
// });
// Route::get('/component-navbar', function () {
//     return view('component-navbar');
// });
// Route::get('/component-paginations', function () {
//     return view('component-paginations');
// });
// Route::get('/component-popovers-tooltips', function () {
//     return view('component-popovers-tooltips');
// });
// Route::get('/component-progress-bars', function () {
//     return view('component-progress-bars');
// });
// Route::get('/component-spinners', function () {
//     return view('component-spinners');
// });
// Route::get('/component-notifications', function () {
//     return view('component-notifications');
// });
// Route::get('/component-avtars-chips', function () {
//     return view('component-avtars-chips');
// });
// /*Content*/
// Route::get('/content-grid-system', function () {
//     return view('content-grid-system');
// });
// Route::get('/content-typography', function () {
//     return view('content-typography');
// });
// Route::get('/content-text-utilities', function () {
//     return view('content-text-utilities');
// });
// /*Icons*/
// Route::get('/icons-line-icons', function () {
//     return view('icons-line-icons');
// });
// Route::get('/icons-boxicons', function () {
//     return view('icons-boxicons');
// });
// Route::get('/icons-feather-icons', function () {
//     return view('icons-feather-icons');
// });
// /*Authentication*/
// Route::get('/authentication-signin', function () {
//     return view('authentication-signin');
// });
// Route::get('/authentication-signup', function () {
//     return view('authentication-signup');
// });
// Route::get('/authentication-signin-with-header-footer', function () {
//     return view('authentication-signin-with-header-footer');
// });
// Route::get('/authentication-signup-with-header-footer', function () {
//     return view('authentication-signup-with-header-footer');
// });
// Route::get('/authentication-forgot-password', function () {
//     return view('authentication-forgot-password');
// });
// Route::get('/authentication-reset-password', function () {
//     return view('authentication-reset-password');
// });
// Route::get('/authentication-lock-screen', function () {
//     return view('authentication-lock-screen');
// });
// /*Table*/
// Route::get('/table-basic-table', function () {
//     return view('table-basic-table');
// });
// Route::get('/table-datatable', function () {
//     return view('table-datatable');
// });
// /*Pages*/
// Route::get('/user-profile', function () {
//     return view('user-profile');
// });
// Route::get('/timeline', function () {
//     return view('timeline');
// });
// Route::get('/pricing-table', function () {
//     return view('pricing-table');
// });
// Route::get('/errors-404-error', function () {
//     return view('errors-404-error');
// });
// Route::get('/errors-500-error', function () {
//     return view('errors-500-error');
// });
// Route::get('/errors-coming-soon', function () {
//     return view('errors-coming-soon');
// });
// Route::get('/error-blank-page', function () {
//     return view('error-blank-page');
// });
// Route::get('/faq', function () {
//     return view('faq');
// });
// /*Forms*/
// Route::get('/form-elements', function () {
//     return view('form-elements');
// });

// Route::get('/form-input-group', function () {
//     return view('form-input-group');
// });
// Route::get('/form-layouts', function () {
//     return view('form-layouts');
// });
// Route::get('/form-validations', function () {
//     return view('form-validations');
// });
// Route::get('/form-wizard', function () {
//     return view('form-wizard');
// });
// Route::get('/form-text-editor', function () {
//     return view('form-text-editor');
// });
// Route::get('/form-file-upload', function () {
//     return view('form-file-upload');
// });
// Route::get('/form-date-time-pickes', function () {
//     return view('form-date-time-pickes');
// });
// Route::get('/form-select2', function () {
//     return view('form-select2');
// });
// /*Maps*/
// Route::get('/map-google-maps', function () {
//     return view('map-google-maps');
// });
// Route::get('/map-vector-maps', function () {
//     return view('map-vector-maps');
// });
// /*Un-found*/
// Route::get('/test/content-grid-system', function () {
//     return view('test/content-grid-system');
// });
