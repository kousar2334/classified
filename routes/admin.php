<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdsController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\MemberController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UtilityController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\UserAuthController;
use App\Http\Controllers\Backend\ConditionController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CustomFieldController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\ClassifiedSettingController;

Route::prefix('admin')->group(function () {
    //Admin Auth
    Route::get('/login', [UserAuthController::class, 'login'])->name('admin.auth.login')->middleware('guest');
    Route::post('/login', [UserAuthController::class, 'loginAttempt'])->name('admin.auth.login.attempt')->middleware('guest');

    Route::group(['middleware' => ['auth', 'admin']], function () {
        //Profile Management
        Route::get('/profile', [UserAuthController::class, 'profile'])->name('admin.auth.profile');
        Route::post('/profile-update', [UserAuthController::class, 'profileUpdate'])->name('admin.auth.profile.update');
        Route::post('/password-update', [UserAuthController::class, 'passwordUpdate'])->name('admin.auth.password.update');
        Route::get('/logout', [UserAuthController::class, 'logout'])->name('admin.auth.logout');

        //NOTIFICATION
        Route::get('/admin-notification-list', [NotificationController::class, 'adminNotifications'])->name('admin.notification.list');
        Route::post('/admin-notification-mark-as-read', [NotificationController::class, 'adminNotificationMarkAsRead'])->name('admin.notification.mark.as.read.single');
        Route::post('/admin-notification-mark-as-read-all', [NotificationController::class, 'adminAllNotificationMarkAsRead'])->name('admin.notification.mark.as.read.all');
        /**
         * DASHBOARD
         */
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware(['can:View Dashboard']);
        /**
         * PAGE MODULE
         */
        Route::prefix('pages')->group(function () {
            Route::get('/', [PageController::class, 'pageList'])->name('admin.page.list')->middleware('can:Manage Pages');
            Route::get('create-new-page', [PageController::class, 'createNewPage'])->name('admin.page.create')->middleware('can:Create New Page');
            Route::post('store-new-page', [PageController::class, 'storeNewPage'])->name('admin.page.new.store')->middleware(['can:Create New Page']);
            Route::get('edit/{page}', [PageController::class, 'editPage'])->name('admin.page.edit');
            Route::post('update-page', [PageController::class, 'updatePage'])->name('admin.page.update')->middleware(['can:Manage Pages']);
            Route::post('delete-page', [PageController::class, 'deletePage'])->name('admin.page.delete')->middleware(['can:Delete Page']);
        });

        /**
         * PAGE CONTENT MODULE
         */
        Route::prefix('page-content')->group(function () {
            Route::get('/home', [PageContentController::class, 'homePageContent'])->name('admin.page.content.home');
            Route::get('/about', [PageContentController::class, 'aboutPageContent'])->name('admin.page.content.about');
            Route::get('/contact', [PageContentController::class, 'contactPageContent'])->name('admin.page.content.contact');
            Route::post('update-page-content', [PageContentController::class, 'updatePageContent'])->name('admin.page.content.update');
        });

        /**
         * BLOGS MODULE
         */
        Route::prefix('blogs')->group(function () {
            // Blog categories
            Route::get('categories', [BlogController::class, 'categoriesList'])->name('admin.blogs.categories.list')->middleware('can:Manage Blog Category');
            Route::post('store-new-category', [BlogController::class, 'storeNewCategory'])->name('admin.blogs.categories.store')->middleware(['can:Manage Blog Category']);
            Route::get('edit-category/{id}', [BlogController::class, 'editCategory'])->name('admin.blogs.categories.edit');
            Route::post('delete-category', [BlogController::class, 'deleteCategory'])->name('admin.blogs.categories.delete')->middleware(['can:Delete Blog Category']);
            Route::post('category-update', [BlogController::class, 'updateCategory'])->name('admin.blogs.categories.update')->middleware(['can:Manage Blog Category']);
            Route::get('category-dropdown-options', [BlogController::class, 'categoryDropdownOptions'])->name('admin.blogs.categories.dropdown.options');

            //Blog Tag
            Route::get('tags-dropdown-options', [BlogController::class, 'tagsDropdownOptions'])->name('admin.blogs.tags.dropdown.options');
            //Blogs 
            Route::get('/', [BlogController::class, 'blogList'])->name('admin.blogs.list')->middleware(['can:Manage Blog']);
            Route::get('create-new-blog', [BlogController::class, 'createNewBlog'])->name('admin.blogs.create');
            Route::post('store-new-blog', [BlogController::class, 'storeNewBlog'])->name('admin.blogs.new.store')->middleware(['can:Create New Blog']);
            Route::get('edit/{blog}', [BlogController::class, 'editBlog'])->name('admin.blogs.edit');
            Route::post('update-blog', [BlogController::class, 'updateBlog'])->name('admin.blogs.update')->middleware(['can:Create New Blog']);
            Route::post('delete-blog', [BlogController::class, 'deleteBlog'])->name('admin.blogs.delete')->middleware(['can:Delete Blog']);

            //Comments
            Route::get('/comments', [BlogController::class, 'blogComments'])->name('admin.blogs.comment.list');
            Route::post('/comment-delete', [BlogController::class, 'blogCommentDelete'])->name('admin.blogs.comment.delete');
        });



        /**
         * CONTACT MESSAGE
         */
        Route::group(['middleware' => 'can:Manage Message'], function () {
            Route::get('messages', [ContactUsController::class, 'messages'])->name('admin.contact.us.message.list');
            Route::post('delete/message', [ContactUsController::class, 'deleteMessage'])->name('admin.contact.us.message.delete');
        });


        /**
         * USER MODULE 
         */
        //Permissions management
        Route::get('permissions', [UserController::class, 'permissions'])->name('admin.users.permission.list');

        //Roles management
        Route::get('roles', [UserController::class, 'roles'])->name('admin.users.role.list');
        Route::post('store-new-role', [UserController::class, 'storeNewRole'])->name('admin.users.role.store');
        Route::post('edit-role', [UserController::class, 'editRole'])->name('admin.users.role.edit');
        Route::post('delete-role', [UserController::class, 'deleteRole'])->name('admin.users.role.delete');
        Route::post('update-role', [UserController::class, 'updateRole'])->name('admin.users.role.update');

        //users Management
        Route::get('users', [UserController::class, 'users'])->name('admin.users.list');
        Route::post('store-new-user', [UserController::class, 'storeNewUser'])->name('admin.users.store');
        Route::post('edit-user', [UserController::class, 'editUser'])->name('admin.users.edit');
        Route::post('update-user', [UserController::class, 'updateUser'])->name('admin.users.update');
        Route::post('delete-user', [UserController::class, 'deleteUser'])->name('admin.users.delete')->middleware(['can:User Delete']);


        /**
         * SYSTEM MODULE
         */
        Route::prefix('system')->group(function () {
            //Environment setup
            Route::get('environment-setup', [SettingController::class, 'environmentSettings'])->name('admin.system.settings.environment');
            Route::post('environment-setup-update', [SettingController::class, 'environmentSettingsUpdate'])->name('admin.system.settings.environment.update')->middleware(['can:Update Environment']);

            //SMTP Setup
            Route::get('smtp-setup', [SettingController::class, 'smtpSettings'])->name('admin.system.settings.smtp');
            Route::post('smtp-setup-update', [SettingController::class, 'smtpSettingsUpdate'])->name('admin.system.settings.smtp.update')->middleware(['can:Update SMTP']);
            Route::post('send-test-mail', [SettingController::class, 'testMail'])->name('admin.system.settings.smtp.mail.test');

            /**
             * Language Module
             */
            Route::get('languages', [LanguageController::class, 'language'])->name('admin.system.settings.language.list');
            Route::post('store-language', [LanguageController::class, 'languageStore'])->name('admin.system.settings.language.store');
            Route::post('edit-language', [LanguageController::class, 'languageEdit'])->name('admin.system.settings.language.edit');
            Route::post('update-language', [LanguageController::class, 'languageUpdate'])->name('admin.system.settings.language.update');
            Route::post('delete-language', [LanguageController::class, 'languageDelete'])->name('admin.system.settings.language.delete');
            Route::get('translation/{id}', [LanguageController::class, 'LanguageKeys'])->name('admin.system.settings.language.translation');
            Route::post('translation-update', [LanguageController::class, 'translationUpdate'])->name('admin.system.settings.language.translation.update');
            Route::get('set-language/{code}', [LanguageController::class, 'setSessionLanguage'])->name('admin.system.settings.language.set');
        });


        /**
         * APPEARANCE MODULE
         */
        Route::prefix('appearance')->group(function () {
            //Mega Menu Management
            Route::get('/menus', [MenuController::class, 'menus'])->name('admin.appearance.menu.builder')->middleware(['can:Manage Menu']);
            Route::post('/menu-management', [MenuController::class, 'menuManagement'])->name('admin.appearance.menu.builder.menu.management');
            Route::post('/add-menu-items', [MenuController::class, 'addMenuItems'])->name('admin.appearance.menu.builder.add.menu.items');
            Route::post('/remove-menu-item', [MenuController::class, 'removeMenuItem'])->name('admin.appearance.menu.builder.remove.menu.item');
            Route::post('/update-menu-item', [MenuController::class, 'updateMenuItem'])->name('admin.appearance.menu.builder.update.menu.item');
            Route::post('/delete-menu', [MenuController::class, 'deleteMenu'])->name('admin.appearance.menu.builder.delete.menu')->middleware(['can:Delete Menu']);


            //Site Settings
            Route::get('/site-setting', [SiteSettingController::class, 'siteSetting'])->name('admin.appearance.site.setting');
            Route::post('/site-setting-update', [SiteSettingController::class, 'siteSettingUpdate'])->name('admin.appearance.site.setting.update')->middleware(['can:Manage Site Settings']);

            Route::get('/header-setting', [SiteSettingController::class, 'headerSetting'])->name('admin.appearance.site.setting.header');
            Route::post('/header-setting-update', [SiteSettingController::class, 'headerSettingUpdate'])->name('admin.appearance.site.setting.header.update')->middleware(['can:Manage Site Settings']);

            Route::get('/footer-setting', [SiteSettingController::class, 'footerSetting'])->name('admin.appearance.site.setting.footer');
            Route::post('/footer-setting-update', [SiteSettingController::class, 'footerSettingUpdate'])->name('admin.appearance.site.setting.footer.update')->middleware(['can:Manage Site Settings']);

            Route::get('/seo-setting', [SiteSettingController::class, 'seoSetting'])->name('admin.appearance.site.setting.seo');
            Route::post('/seo-setting-update', [SiteSettingController::class, 'seoSettingUpdate'])->name('admin.appearance.site.setting.seo.update')->middleware(['can:Manage Site Settings']);


            Route::get('/colors', [SiteSettingController::class, 'colorSetting'])->name('admin.appearance.site.setting.colors');
            Route::post('/colors-update', [SiteSettingController::class, 'colorSettingUpdate'])->name('admin.appearance.site.setting.colors.update')->middleware(['can:Manage Site Settings']);

            Route::get('/custom-css', [SiteSettingController::class, 'customCssSetting'])->name('admin.appearance.site.setting.custom.css');
            Route::post('/custom-css-update', [SiteSettingController::class, 'customCssSettingUpdate'])->name('admin.appearance.site.setting.custom.css.update')->middleware(['can:Manage Site Settings']);
        });
        /**
         * MEDIA MODULE
         */
        Route::get('media-manage', [MediaController::class, 'mediaManager'])->name('admin.media.list')->middleware('can:Manage Media');
        Route::post('delete/media', [MediaController::class, 'deleteMedia'])->name('admin.media.delete')->middleware(['can:Delete Media']);


        //Dashboard Routes
        Route::post('business-stats', [DashboardController::class, 'businessStats'])->name('business.stats');
        Route::post('ad--posting-stats', [DashboardController::class, 'adStats'])->name('reports.ad.chart');
        Route::post('member-registration-stats', [DashboardController::class, 'memberStats'])->name('reports.member.chart');
        /**
         * Member Module
         */
        Route::group(['prefix' => 'members'], function () {
            Route::get('/', [MemberController::class, 'memberList'])->name('admin.members.list');
            Route::post('delete', [MemberController::class, 'memberDelete'])->name('admin.members.delete');
            Route::post('reset/password', [MemberController::class, 'memberPasswordReset'])->name('admin.members.password.reset');
            Route::post('edit', [MemberController::class, 'memberEdit'])->name('admin.members.edit');
            Route::post('update', [MemberController::class, 'memberUpdate'])->name('admin.members.update');
            Route::post('store', [MemberController::class, 'memberStore'])->name('admin.members.store');
        });

        /**
         * Classified Settings module
         */
        Route::group(['prefix' => 'classified-settings'], function () {
            Route::get('general', [ClassifiedSettingController::class, 'generalSettings'])->name('classified.settings.general')->middleware('can:Manage General Settings');
            Route::get('currency', [ClassifiedSettingController::class, 'currencySettings'])->name('classified.settings.currency')->middleware(['can:Manage Currency Settings']);
            Route::get('member', [ClassifiedSettingController::class, 'memberSettings'])->name('classified.settings.member')->middleware('can:Manage Member Settings');
            Route::post('member/update', [ClassifiedSettingController::class, 'updateMemberSetting'])->name('classified.member.settings.update')->middleware(['can:Manage Member Settings', 'demo']);
            Route::get('ads', [ClassifiedSettingController::class, 'adsSettings'])->name('classified.settings.ads')->middleware('can:Manage Ads Settings');
            Route::get('map', [ClassifiedSettingController::class, 'mapSettings'])->name('classified.settings.map')->middleware(['can:Manage Map Settings']);
            //Safety tips
            Route::get('safety-tips', [ClassifiedSettingController::class, 'safetyTips'])->name('classified.settings.safety.tips.list')->middleware(['can:Manage Safety Tips']);
            Route::post('store-safety-tips', [ClassifiedSettingController::class, 'storeSafetyTips'])->name('classified.settings.safety.tips.store')->middleware(['can:Manage Safety Tips', 'demo']);
            Route::post('delete-safety-tips', [ClassifiedSettingController::class, 'deleteSafetyTips'])->name('classified.settings.safety.tips.delete')->middleware(['can:Manage Safety Tips', 'demo']);
            Route::get('edit-safety-tips/{id}', [ClassifiedSettingController::class, 'editSafetyTips'])->name('classified.settings.safety.tips.edit')->middleware(['can:Manage Safety Tips']);
            Route::post('update-safety-tips', [ClassifiedSettingController::class, 'updateSafetyTips'])->name('classified.settings.safety.tips.update')->middleware(['can:Manage Safety Tips', 'demo']);
            //Quick Sell Tips
            Route::get('quick-sell-tips', [ClassifiedSettingController::class, 'quickSellTips'])->name('classified.settings.quick.sell.tips.list')->middleware(['can:Manage Quick Sell Tips']);
            Route::post('store-quick-sell-tips', [ClassifiedSettingController::class, 'storeQuickSellTips'])->name('classified.settings.quick.sell.tips.store')->middleware(['can:Manage Quick Sell Tips', 'demo']);
            Route::post('delete-quick-sell-tips', [ClassifiedSettingController::class, 'deleteQuickSellTips'])->name('classified.settings.quick.sell.tips.delete')->middleware(['can:Manage Quick Sell Tips', 'demo']);
            Route::get('edit-quick-sell-tips/{id}', [ClassifiedSettingController::class, 'editQuickSellTips'])->name('classified.settings.quick.sell.tips.edit')->middleware(['can:Manage Quick Sell Tips']);
            Route::post('update-quick-sell-tips', [ClassifiedSettingController::class, 'updateQuickSellTips'])->name('classified.settings.quick.sell.tips.update')->middleware(['can:Manage Quick Sell Tips', 'demo']);
            //Share options
            Route::get('share-options', [ClassifiedSettingController::class, 'shareOptions'])->name('classified.settings.share.options.list')->middleware(['can:Manage Ad Share Options']);
            Route::post('share-option-update-status', [ClassifiedSettingController::class, 'shareOptionUpdateStatus'])->name('classified.settings.share.options.status.update')->middleware(['can:Manage Ad Share Options', 'demo']);

            Route::post('update', [ClassifiedSettingController::class, 'updateSetting'])->name('classified.settings.update')->middleware(['can:Manage Classified Settings', 'demo']);
        });
        /**
         * Classified Ads
         */
        Route::group(['prefix' => 'listing'], function () {
            Route::get('/', [AdsController::class, 'adListing'])->name('classified.ads.list');
            Route::get('/featured', [AdsController::class, 'featuredAdListing'])->name('classified.ads.list.featured');
            Route::get('/edit/{id}', [AdsController::class, 'editAd'])->name('classified.ads.edit');
            Route::post('/update', [AdsController::class, 'updateAd'])->name('classified.ads.update');
            Route::post('/delete', [AdsController::class, 'deleteAd'])->name('classified.ads.delete');

            //Category module
            Route::group(['prefix' => 'categories'], function () {
                Route::get('/', [CategoryController::class, 'categories'])->name('classified.ads.categories.list');
                Route::post('store', [CategoryController::class, 'categoryStore'])->name('classified.ads.categories.store');
                Route::post('delete', [CategoryController::class, 'categoryDelete'])->name('classified.ads.categories.delete');
                Route::post('edit', [CategoryController::class, 'categoryEdit'])->name('classified.ads.categories.edit');
                Route::post('update', [CategoryController::class, 'categoryUpdate'])->name('classified.ads.categories.update');
                Route::get('options', [CategoryController::class, 'CategoryOption'])->name('classified.ads.categories.options');
            });

            //Condition module
            Route::group(['prefix' => 'condition'], function () {
                Route::get('/', [ConditionController::class, 'conditions'])->name('classified.ads.condition.list');
                Route::post('store', [ConditionController::class, 'storeCondition'])->name('classified.ads.condition.store');
                Route::post('delete', [ConditionController::class, 'deleteCondition'])->name('classified.ads.condition.delete');
                Route::post('edit', [ConditionController::class, 'editCondition'])->name('classified.ads.condition.edit');
                Route::post('update', [ConditionController::class, 'updateCondition'])->name('classified.ads.condition.update');
            });

            //Tags module
            Route::group(['prefix' => 'tag'], function () {
                Route::get('/', [TagController::class, 'tags'])->name('classified.ads.tag.list');
                Route::post('store', [TagController::class, 'storeTag'])->name('classified.ads.tag.store');
                Route::post('delete', [TagController::class, 'deleteTag'])->name('classified.ads.tag.delete');
                Route::post('edit', [TagController::class, 'editTag'])->name('classified.ads.tag.edit');
                Route::post('update', [TagController::class, 'updateTag'])->name('classified.ads.tag.update');
                Route::post('bulk-action', [TagController::class, 'tagBulkAction'])->name('classified.ads.tag.bulk.action');
                Route::get('options', [TagController::class, 'tagOption'])->name('classified.ads.tag.options');
            });

            //Custom fields module
            Route::group(['prefix' => 'custom-field'], function () {
                Route::get('/', [CustomFieldController::class, 'customFields'])->name('classified.ads.custom.field.list');
                Route::post('store', [CustomFieldController::class, 'storeCustomField'])->name('classified.ads.custom.field.store');
                Route::post('delete', [CustomFieldController::class, 'deleteCustomField'])->name('classified.ads.custom.field.delete');
                Route::post('edit}', [CustomFieldController::class, 'editCustomField'])->name('classified.ads.custom.field.edit');
                Route::post('update', [CustomFieldController::class, 'updateCustomField'])->name('classified.ads.custom.field.update');
                Route::post('assign-category', [CustomFieldController::class, 'assignCategory'])->name('classified.ads.custom.field.assign.category');
                Route::post('bulk-action', [CustomFieldController::class, 'customFieldBulkAction'])->name('classified.ads.custom.field.bulk.action');

                Route::get('options/{id}', [CustomFieldController::class, 'customFieldOptions'])->name('classified.ads.custom.field.options');
                Route::post('options/store', [CustomFieldController::class, 'customFieldOptionStore'])->name('classified.ads.custom.field.options.store');
                Route::post('options/delete', [CustomFieldController::class, 'customFieldOptionDelete'])->name('classified.ads.custom.field.options.delete');
                Route::post('options/edit', [CustomFieldController::class, 'customFieldOptionEdit'])->name('classified.ads.custom.field.options.edit');
                Route::post('options/update', [CustomFieldController::class, 'customFieldOptionUpdate'])->name('classified.ads.custom.field.options.update');
                Route::post('options/bulk-action', [CustomFieldController::class, 'customFieldOptionBulkAction'])->name('classified.ads.custom.field.options.bulk.action');
            });
        });

        /**
         * Location Modules
         */
        Route::group(['middleware' => 'auth', 'prefix' => 'location'], function () {
            //Country
            Route::group(['prefix' => 'country'], function () {
                Route::get('', [LocationController::class, 'countries'])->name('classified.locations.country.list');
                Route::get('add/new', [LocationController::class, 'addNewCountry'])->name('classified.locations.country.add')->middleware(['can:Create Countries']);
                Route::post('store/new', [LocationController::class, 'storeNewCountry'])->name('classified.locations.country.store')->middleware(['can:Create Countries', 'demo']);
                Route::get('edit/{id}', [LocationController::class, 'editCountry'])->name('classified.locations.country.edit')->middleware(['can:Edit Countries']);
                Route::post('update', [LocationController::class, 'updateCountry'])->name('classified.locations.country.update')->middleware(['can:Edit Countries', 'demo']);
                Route::post('delete', [LocationController::class, 'deleteCountry'])->name('classified.locations.country.delete')->middleware(['can:Delete Countries', 'demo']);
                Route::post('bulk-action', [LocationController::class, 'countryBulkActions'])->name('classified.locations.country.bulk.action')->middleware(['can:Manage Countries', 'demo']);
                Route::post('status/update', [LocationController::class, 'countryStatusChange'])->name('classified.locations.country..status.update')->middleware(['can:Edit Countries', 'demo']);
            });
            //States
            Route::group(['prefix' => 'state'], function () {
                Route::get('', [LocationController::class, 'states'])->name('classified.locations.state.list')->middleware('can:Manage States');
                Route::get('add/new', [LocationController::class, 'addNewState'])->name('classified.locations.state.add')->middleware(['can:Create States']);
                Route::post('store/new', [LocationController::class, 'storeNewState'])->name('classified.locations.state.store')->middleware(['can:Create States', 'demo']);
                Route::get('edit/{id}', [LocationController::class, 'editState'])->name('classified.locations.state.edit')->middleware(['can:Edit States']);
                Route::post('update', [LocationController::class, 'updateState'])->name('classified.locations.state.update')->middleware(['can:Edit States', 'demo']);
                Route::post('delete', [LocationController::class, 'deleteState'])->name('classified.locations.state.delete')->middleware(['can:Delete States', 'demo']);
                Route::post('bulk-action', [LocationController::class, 'stateBulkActions'])->name('classified.locations.state.bulk.action')->middleware(['can:Manage States', 'demo']);
                Route::post('status/update', [LocationController::class, 'stateStatusChange'])->name('classified.locations.state.status.update')->middleware(['can:Edit States', 'demo']);
            });
            //Cities
            Route::group(['prefix' => 'city'], function () {
                Route::get('', [LocationController::class, 'cities'])->name('classified.locations.city.list')->middleware(['can:Manage Cities']);
                Route::get('add/new', [LocationController::class, 'addNewCity'])->name('classified.locations.city.add')->middleware(['can:Create Cities']);
                Route::post('store/new', [LocationController::class, 'storeNewCity'])->name('classified.locations.city.store')->middleware(['can:Create Cities', 'demo']);
                Route::get('edit/{id}', [LocationController::class, 'editCity'])->name('classified.locations.city.edit')->middleware(['can:Edit Cities']);
                Route::post('update', [LocationController::class, 'updateCity'])->name('classified.locations.city.update')->middleware(['can:Edit Cities', 'demo']);
                Route::post('delete', [LocationController::class, 'deleteCity'])->name('classified.locations.city.delete')->middleware(['can:Delete Cities', 'demo']);
                Route::post('bulk-action', [LocationController::class, 'cityBulkActions'])->name('classified.locations.city.bulk.action')->middleware(['can:Manage Cities', 'demo']);
                Route::post('status/update', [LocationController::class, 'cityStatusChange'])->name('classified.locations.city.status.update')->middleware(['can:Edit Cities', 'demo']);
            });
        });
    });
});

/**
 * Utility
 */
Route::post('/email-sending', [UtilityController::class, 'sendingEmail'])->name('utility.email.send');
Route::get('/admin/clear-system-cache', [UtilityController::class, 'clearCache'])->name('utility.clear.cache');
Route::post('/store-summer-note-image', [UtilityController::class, 'storeEditorImage'])->name('utility.store.editor.image');


/**
 * Media Management
 */
Route::post('/upload-media-file', [MediaController::class, 'uploadMediaFile'])->name('upload.media.file');
Route::post('/media-items-list', [MediaController::class, 'mediaList'])->name('media.file.list');
Route::post('/selected-media-details', [MediaController::class, 'selectedMediaDetails'])->name('media.selected.file.details');