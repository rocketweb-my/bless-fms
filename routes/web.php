<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\CustomScriptController;
use App\Http\Controllers\KnowledgebaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ReplyTicketController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BanEmailController;
use App\Http\Controllers\BanIPController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportV2Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThankYouMessageController;
use App\Http\Controllers\BotController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\LookUpKumpulanPenggunaController;
use App\Http\Controllers\LookUpKementerianController;
use App\Http\Controllers\LookUpAgensiController;
use App\Http\Controllers\LookUpSubAgensiController;
use App\Http\Controllers\LookUpStatusLogController;
use App\Http\Controllers\LookUpKaedahMelaporController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\App;



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

//    Route::get('/', function () {
//        return redirect()->route('dashboard.index');
//    });

    Route::get('login',  [LoginController::class, 'login'])->name('login');
    Route::get('logout',  [LoginController::class, 'logout'])->name('logout');
    Route::get('password/reset',  [ForgotPasswordController::class, 'index'])->name('forgot_password');
    Route::post('password/reset',  [ResetPasswordController::class, 'reset_password'])->name('reset_password');
//    Route::view('password/reset', 'auth.passwords.email');

    Route::post('login', [LoginController::class, 'authenticate']);

    Route::middleware(['user.session'])->group(function() {

        //Ticket Controller
        Route::get('/ticket', [TicketController::class, 'index'])->name('ticket.index');
        Route::get('/ticket/export', [TicketController::class, 'export'])->name('ticket.export');
        Route::post('/ticket/export', [TicketController::class, 'export_ticket'])->name('ticket.export_ticket');
        Route::post('/ticket/export_2', [TicketController::class, 'export_ticket_2'])->name('ticket.export_ticket_2');
        Route::post('/ticket/export_pdf', [TicketController::class, 'export_ticket_pdf'])->name('ticket.export_ticket_pdf');
        Route::post('/ticket/export_excel', [TicketController::class, 'export_ticket_excel'])->name('ticket.export_ticket_excel');
        Route::get('/admin/choose_category', [TicketController::class, 'admin_create_ticket_category'])->name('admin_choose_category');


        Route::post('/create_ticket', [TicketController::class, 'store'])->name('ticket.store');
        Route::post('/bulk_assign', [TicketController::class, 'bulk_assign'])->name('bulk_assign');
        Route::post('/bulk_priority_update', [TicketController::class, 'bulk_priority_update'])->name('bulk_priority_update');
        Route::post('/store_filter', [TicketController::class, 'store_filter'])->name('store_filter');
        Route::post('/admin/create_ticket', [TicketController::class, 'admin_create_ticket'])->name('admin_create_ticket');
        Route::post('/admin/create_ticket/store', [TicketController::class, 'admin_create_ticket_store'])->name('admin_create_ticket.store');

        //Reply Ticket Controller
        Route::get('/ticket/{trackid}', [ReplyTicketController::class, 'index'])->name('ticket.reply');

        Route::post('/ticket/note', [ReplyTicketController::class, 'note'])->name('ticket.note');
        Route::get('/ticket/note/download/{id}', [ReplyTicketController::class, 'download_note_attachment'])->name('ticket.note.download');
        Route::post('/ticket/note/edit', [ReplyTicketController::class, 'edit_note'])->name('ticket.note.edit');
        Route::post('/ticket/note/delete', [ReplyTicketController::class, 'delete_note'])->name('ticket.note.delete');
        Route::post('/ticket/reply', [ReplyTicketController::class, 'reply'])->name('ticket.reply.store');
        Route::post('/ticket/reply/delete', [ReplyTicketController::class, 'delete_ticket'])->name('ticket.reply.delete');
        Route::post('/ticket/reply/save_to_draft', [ReplyTicketController::class, 'save_to_draft'])->name('ticket.reply.save_to_draft');
        Route::post('/ticket/reply/change_category', [ReplyTicketController::class, 'change_category'])->name('ticket.reply.change_category');
        Route::post('/ticket/reply/change_status', [ReplyTicketController::class, 'change_status'])->name('ticket.reply.change_status');
        Route::post('/ticket/reply/change_priority', [ReplyTicketController::class, 'change_priority'])->name('ticket.reply.change_priority');
        Route::post('/ticket/reply/change_owner', [ReplyTicketController::class, 'change_owner'])->name('ticket.reply.change_owner');
        Route::post('/ticket/reply/add_cc_email', [ReplyTicketController::class, 'add_cc_email'])->name('ticket.reply.add_cc_email');
        Route::post('/ticket/reply/export_pdf', [ReplyTicketController::class, 'export_pdf'])->name('ticket.reply.export_pdf');
        Route::post('/ticket/reply/export_with_notes_pdf', [ReplyTicketController::class, 'export_with_notes_pdf'])->name('ticket.reply.export_with_notes_pdf');

        //Category Controller
        Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/add_category', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/get_to_edit', [CategoryController::class, 'get_to_edit'])->name('category.get_to_edit');
        Route::post('/categories/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/categories/delete', [CategoryController::class, 'delete'])->name('category.delete');

        //Sub Category Controller
        Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-category.index');
        Route::post('/add_sub_category', [SubCategoryController::class, 'store'])->name('sub-category.store');
        Route::post('/get_sub_to_edit', [SubCategoryController::class, 'get_to_edit'])->name('sub-category.get_to_edit');
        Route::post('/sub-categories/edit', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
        Route::post('/sub-categories/delete', [SubCategoryController::class, 'delete'])->name('sub-category.delete');

        //Team Controller
        Route::get('/teams', [TeamController::class, 'index'])->name('team.index');
        Route::post('/teams/status', [TeamController::class, 'change_status'])->name('team.status');
        Route::post('/add_team', [TeamController::class, 'store'])->name('team.store');
        Route::get('/teams/profile/{id}', [TeamController::class, 'profile'])->name('team.profile');
        Route::post('/teams/profile/update', [TeamController::class, 'update_profile'])->name('team.profile.update');
        Route::post('/teams/change_password', [TeamController::class, 'change_password_team'])->name('team.change_password');
        Route::post('/teams/remove', [TeamController::class, 'remove_team'])->name('team.remove');

        Route::get('/test', [TestController::class, 'index'])->name('test.index');

        //Template Controller
        Route::get('/template/ticket', [TemplateController::class, 'ticket'])->name('template.ticket');
        Route::post('/template/ticket', [TemplateController::class, 'store_ticket'])->name('template.ticket.store');
        Route::post('/template/ticket/edit', [TemplateController::class, 'edit_ticket'])->name('template.ticket.edit');
        Route::post('/template/ticket/delete', [TemplateController::class, 'delete_ticket'])->name('template.ticket.delete');

        Route::get('/template/canned', [TemplateController::class, 'canned'])->name('template.canned');
        Route::post('/template/canned', [TemplateController::class, 'store_canned'])->name('template.canned.store');
        Route::post('/template/canned/edit', [TemplateController::class, 'edit_canned'])->name('template.canned.edit');
        Route::post('/template/canned/delete', [TemplateController::class, 'delete_canned'])->name('template.canned.delete');

        //Dashboard Controller
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');

        // Ban IP Controller
        Route::get('/banned/ips',[BanIPController::class, 'index'])->name('ban.ip');
        Route::post('/banned/ips/store',[BanIPController::class, 'store'])->name('ban.ip.store');
        Route::post('/banned/ips/delete',[BanIPController::class, 'delete'])->name('ban.ip.delete');
        Route::post('/banned/ips/store_reply_page',[BanIPController::class, 'store_from_reply_page'])->name('ban.ip.store_reply_page');

        // Ban Email Controller
        Route::get('/banned/emails',[BanEmailController::class, 'index'])->name('ban.email');
        Route::post('/banned/emails/store',[BanEmailController::class, 'store'])->name('ban.email.store');
        Route::post('/banned/emails/delete',[BanEmailController::class, 'delete'])->name('ban.email.delete');
        Route::post('/banned/emails/store_reply_page',[BanEmailController::class, 'store_from_reply_page'])->name('ban.email.store_reply_page');

        //Custom Field
        Route::get('/custom_fields',[CustomFieldController::class, 'index'])->name('custom_field.index');
        Route::post('/custom_fields/store',[CustomFieldController::class, 'store'])->name('custom_field.store');
        Route::post('/custom_fields/get_data',[CustomFieldController::class, 'get_data'])->name('custom_field.get_data');
        Route::post('/custom_fields/update',[CustomFieldController::class, 'update'])->name('custom_field.update');
        Route::post('/custom_fields/delete',[CustomFieldController::class, 'delete'])->name('custom_field.delete');

        //Custom Script
        Route::get('/custom_scripts',[CustomScriptController::class, 'index'])->name('custom_script.index');
        Route::post('/custom_scripts/store',[CustomScriptController::class, 'store'])->name('custom_script.store');
        Route::post('/custom_scripts/get_data',[CustomScriptController::class, 'get_data'])->name('custom_script.get_data');
        Route::post('/custom_scripts/update',[CustomScriptController::class, 'update'])->name('custom_script.update');
        Route::post('/custom_scripts/delete',[CustomScriptController::class, 'delete'])->name('custom_script.delete');

        //Lookup Kumpulan Pengguna
        Route::get('/lookup/kumpulan-pengguna',[LookUpKumpulanPenggunaController::class, 'index'])->name('lookup.kumpulan-pengguna.index');
        Route::post('/lookup/kumpulan-pengguna',[LookUpKumpulanPenggunaController::class, 'store'])->name('lookup.kumpulan-pengguna.store');
        Route::get('/lookup/kumpulan-pengguna/{id}/edit',[LookUpKumpulanPenggunaController::class, 'edit'])->name('lookup.kumpulan-pengguna.edit');
        Route::put('/lookup/kumpulan-pengguna/{id}',[LookUpKumpulanPenggunaController::class, 'update'])->name('lookup.kumpulan-pengguna.update');
        Route::post('/lookup/kumpulan-pengguna/toggle-status',[LookUpKumpulanPenggunaController::class, 'toggleStatus'])->name('lookup.kumpulan-pengguna.toggle-status');

        //Lookup Kementerian
        Route::get('/lookup/kementerian',[LookUpKementerianController::class, 'index'])->name('lookup.kementerian.index');
        Route::post('/lookup/kementerian',[LookUpKementerianController::class, 'store'])->name('lookup.kementerian.store');
        Route::get('/lookup/kementerian/{id}/edit',[LookUpKementerianController::class, 'edit'])->name('lookup.kementerian.edit');
        Route::put('/lookup/kementerian/{id}',[LookUpKementerianController::class, 'update'])->name('lookup.kementerian.update');
        Route::post('/lookup/kementerian/toggle-status',[LookUpKementerianController::class, 'toggleStatus'])->name('lookup.kementerian.toggle-status');

        //Lookup Agensi
        Route::get('/lookup/agensi',[LookUpAgensiController::class, 'index'])->name('lookup.agensi.index');
        Route::post('/lookup/agensi',[LookUpAgensiController::class, 'store'])->name('lookup.agensi.store');
        Route::get('/lookup/agensi/{id}/edit',[LookUpAgensiController::class, 'edit'])->name('lookup.agensi.edit');
        Route::put('/lookup/agensi/{id}',[LookUpAgensiController::class, 'update'])->name('lookup.agensi.update');
        Route::post('/lookup/agensi/toggle-status',[LookUpAgensiController::class, 'toggleStatus'])->name('lookup.agensi.toggle-status');

        //Lookup Sub Agensi
        Route::get('/lookup/sub-agensi',[LookUpSubAgensiController::class, 'index'])->name('lookup.sub-agensi.index');
        Route::post('/lookup/sub-agensi',[LookUpSubAgensiController::class, 'store'])->name('lookup.sub-agensi.store');
        Route::get('/lookup/sub-agensi/{id}/edit',[LookUpSubAgensiController::class, 'edit'])->name('lookup.sub-agensi.edit');
        Route::put('/lookup/sub-agensi/{id}',[LookUpSubAgensiController::class, 'update'])->name('lookup.sub-agensi.update');
        Route::post('/lookup/sub-agensi/toggle-status',[LookUpSubAgensiController::class, 'toggleStatus'])->name('lookup.sub-agensi.toggle-status');

        //Lookup Status Log
        Route::get('/lookup/status-log',[LookUpStatusLogController::class, 'index'])->name('lookup.status-log.index');
        Route::post('/lookup/status-log',[LookUpStatusLogController::class, 'store'])->name('lookup.status-log.store');
        Route::get('/lookup/status-log/{id}/edit',[LookUpStatusLogController::class, 'edit'])->name('lookup.status-log.edit');
        Route::put('/lookup/status-log/{id}',[LookUpStatusLogController::class, 'update'])->name('lookup.status-log.update');
        Route::post('/lookup/status-log/toggle-status',[LookUpStatusLogController::class, 'toggleStatus'])->name('lookup.status-log.toggle-status');

        //Lookup Kaedah Melapor
        Route::get('/lookup/kaedah-melapor',[LookUpKaedahMelaporController::class, 'index'])->name('lookup.kaedah-melapor.index');
        Route::post('/lookup/kaedah-melapor',[LookUpKaedahMelaporController::class, 'store'])->name('lookup.kaedah-melapor.store');
        Route::get('/lookup/kaedah-melapor/{id}/edit',[LookUpKaedahMelaporController::class, 'edit'])->name('lookup.kaedah-melapor.edit');
        Route::put('/lookup/kaedah-melapor/{id}',[LookUpKaedahMelaporController::class, 'update'])->name('lookup.kaedah-melapor.update');
        Route::post('/lookup/kaedah-melapor/toggle-status',[LookUpKaedahMelaporController::class, 'toggleStatus'])->name('lookup.kaedah-melapor.toggle-status');

        //Report
        Route::get('/report/main',[ReportController::class, 'main'])->name('report.main');
        Route::get('/report/getdata',[ReportController::class, 'getData'])->name('report.getData');

        Route::get('/report/process_duration_chart',[ReportController::class, 'process_duration_chart_get_data'])->name('report.process_duration_chart.get_data');

        Route::post('/report/add_chart',[ReportController::class, 'add_chart'])->name('report.add_chart');
        Route::post('/report/delete_chart',[ReportController::class, 'delete_chart'])->name('report.delete_chart');

        //Advanced Reporting System
        Route::get('/advance-report', [ReportV2Controller::class, 'index'])->name('advance-report.index');
        Route::get('/advance-report/generate', [ReportV2Controller::class, 'generate'])->name('advance-report.generate');
        Route::get('/advance-report/ticket-details/{trackid}', [ReportV2Controller::class, 'getTicketDetails'])->name('advance-report.ticket-details');
        Route::post('/advance-report/preview', [ReportV2Controller::class, 'preview'])->name('advance-report.preview');
        Route::post('/advance-report/export', [ReportV2Controller::class, 'export'])->name('advance-report.export');

        //User
        Route::get('/profile',[UserController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
        Route::post('/profile/change_password', [UserController::class, 'change_password'])->name('profile.change_password');
        Route::post('/profile/picture', [UserController::class, 'profile_picture'])->name('profile.picture');


        //Knowledgebase
        Route::get('/knowledgebase',[KnowledgebaseController::class, 'index'])->name('knowledgebase');
        Route::get('/knowledgebase/article',[KnowledgebaseController::class, 'article'])->name('knowledgebase.article');
        Route::get('/knowledgebase/category',[KnowledgebaseController::class, 'category'])->name('knowledgebase.category');
        Route::get('/knowledgebase/article/{id}',[KnowledgebaseController::class, 'view_article'])->name('knowledgebase.article.view');
        Route::post('/knowledgebase/article/edit',[KnowledgebaseController::class, 'edit_article'])->name('knowledgebase.article.edit');
        Route::post('/knowledgebase/article/edit/save',[KnowledgebaseController::class, 'save_edit_article'])->name('knowledgebase.article.edit.save');
        Route::post('/knowledgebase/add_article',[KnowledgebaseController::class, 'add_article'])->name('knowledgebase.article.store');
        Route::post('/knowledgebase/add_category',[KnowledgebaseController::class, 'add_category'])->name('knowledgebase.category.store');
        Route::post('/knowledgebase/edit_category',[KnowledgebaseController::class, 'edit_category'])->name('knowledgebase.category.edit');
        Route::post('/knowledgebase/delete_category',[KnowledgebaseController::class, 'delete_category'])->name('knowledgebase.category.delete');
        Route::post('/knowledgebase/delete_article',[KnowledgebaseController::class, 'delete_article'])->name('knowledgebase.article.delete');

        //Setting
        Route::get('/setting/general',[SettingController::class, 'general'])->name('setting.general');
        Route::post('/setting/general/store',[SettingController::class, 'general_store'])->name('setting.general.store');
        Route::post('/setting/priority/store',[SettingController::class, 'priority_store'])->name('setting.priority.store');
        Route::get('/setting/email',[SettingController::class, 'email'])->name('setting.email');
        Route::post('/setting/email/store',[SettingController::class, 'email_store'])->name('setting.email.store');
        Route::post('/setting/email/test',[SettingController::class, 'email_test'])->name('setting.email.test');



        //Slider
        Route::get('/slider',[SliderController::class, 'index'])->name('slider.index');
        Route::post('/slider/upload',[SliderController::class, 'upload'])->name('slider.upload');

        //Thank You Message
        Route::get('/thank_you_message',[ThankYouMessageController::class, 'index'])->name('thank.index');
        Route::post('/thank_you_message/store',[ThankYouMessageController::class, 'store'])->name('thank.store');






    });

//Route::get('login',  [TestController::class, 'login'])->name('login');
Route::get('chart',  [TestController::class, 'chart'])->name('chart');

// Public Controller

Route::get('/public/submission',[PublicController::class, 'submission_category'])->name('public.submission_cat');
Route::get('/public/reply',[PublicController::class, 'search_ticket'])->name('public.search');
Route::get('/att/{id}', [PublicController::class, 'download'])->name('public.download');
Route::get('/',[PublicController::class, 'index'])->name('public.index');
Route::get('/public/knowledgebase/category',[PublicController::class, 'knowledgebase_category'])->name('public.knowledgebase_category');
Route::get('/public/knowledgebase/category/{id}',[PublicController::class, 'knowledgebase'])->name('public.knowledgeabase');
Route::get('/public/knowledgebase/category/{cat_id}/article/{id}',[PublicController::class, 'knowledgebase_view'])->name('public.knowledgeabase.view');
Route::get('/public/submission/success',[PublicController::class, 'submission_success'])->name('public.submission.success');
Route::get('/kb_att/{id}', [PublicController::class, 'knowledgebase_download'])->name('public.knowledgebase_download');

// Language switching
Route::post('/set-language', [PublicController::class, 'setLanguage'])->name('set.language');

Route::post('/public/reply',[PublicController::class, 'reply_ticket'])->name('public.reply');
Route::post('/public/submission',[PublicController::class, 'submission'])->name('public.submission');
Route::post('/public/submission_form',[PublicController::class, 'submission_form'])->name('public.submission_form');
Route::post('/public/reply_form',[PublicController::class, 'reply_form'])->name('public.reply_form');
Route::post('/public/close_ticket',[PublicController::class, 'close_ticket'])->name('public.close_ticket');
Route::post('/public/forgot_tracking',[PublicController::class, 'forgot_tracking'])->name('public.forgot_tracking');

Route::get('/webhook',[BotController::class,'index'])->name('webhook');
Route::post('/chatbot_submission',[ChatBotController::class,'submit_ticket'])->name('chatbot_submission');
Route::post('/chatbot_check_ticket',[ChatBotController::class,'check_ticket'])->name('chatbot_check_ticket');


Route::get('chart',[TestController::class, 'newChart']);
Route::view('/texting','pages.public.empty');

// Bot
// Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);

Route::get('/lang/{locale}', function ($locale) {

    App::setLocale($locale);
    dump(App::getLocale());
    dd(__('ban_Ip.Ban IPs'));
    //
});


Route::get('/otp-request', [\App\Http\Controllers\OtpController::class, 'requestForOtp'])->name('opt_request');
Route::get('/test/otp-validate', [\App\Http\Controllers\OtpController::class, 'validateOtp'])->name('opt_verify');
Route::get('/test/otp-resend', [\App\Http\Controllers\OtpController::class, 'resendOtp']);


URL::forceScheme('https');
