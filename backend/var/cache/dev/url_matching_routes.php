<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/admin/client-configuration' => [
            [['_route' => 'app_client_configuration_findall', '_controller' => 'App\\Controller\\Admin\\ClientConfigurationController::getAllClient'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_configuration_post', '_controller' => 'App\\Controller\\Admin\\ClientConfigurationController::saveOneClient'], null, ['POST' => 0], null, false, false, null],
        ],
        '/sectionall' => [[['_route' => 'app_section_getall', '_controller' => 'App\\Controller\\Admin\\SectionController::allSection'], null, ['GET' => 0], null, false, false, null]],
        '/section' => [[['_route' => 'app_section_add', '_controller' => 'App\\Controller\\Admin\\SectionController::addNewSection'], null, ['POST' => 0], null, false, false, null]],
        '/admin/sectiontype' => [
            [['_route' => 'app_admin_sectiontype_index', '_controller' => 'App\\Controller\\Admin\\SectionTypeController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_admin_sectiontype_addwebsiteconfigtype', '_controller' => 'App\\Controller\\Admin\\SectionTypeController::addWebsiteConfigType'], null, ['POST' => 0], null, false, false, null],
        ],
        '/admin' => [[['_route' => 'app_admin', '_controller' => 'App\\Controller\\AdminController::index'], null, null, null, false, false, null]],
        '/api' => [[['_route' => 'app_api', '_controller' => 'App\\Controller\\ApiController::index'], null, null, null, false, false, null]],
        '/api/login_check' => [[['_route' => 'app_auth_authentification_index', '_controller' => 'App\\Controller\\Auth\\AuthentificationController::index'], null, ['POST' => 0], null, false, false, null]],
        '/auth' => [[['_route' => 'app_auth', '_controller' => 'App\\Controller\\AuthController::index'], null, null, null, false, false, null]],
        '/api/client/category' => [
            [['_route' => 'app_client_categoryproduct_getallcategory', '_controller' => 'App\\Controller\\Client\\CategoryProductController::getAllCategory'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_categoryproduct_addcategoryproduct', '_controller' => 'App\\Controller\\Client\\CategoryProductController::addCategoryProduct'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/client/category/remove' => [[['_route' => 'app_client_categoryproduct_removecategory', '_controller' => 'App\\Controller\\Client\\CategoryProductController::removeCategory'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/category/update' => [[['_route' => 'app_client_categoryproduct_updatecategoryproduct', '_controller' => 'App\\Controller\\Client\\CategoryProductController::updateCategoryProduct'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/galerie' => [
            [['_route' => 'app_client_galerie_getallgalerie', '_controller' => 'App\\Controller\\Client\\GalerieController::getAllGalerie'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_galerie_addmediagalerie', '_controller' => 'App\\Controller\\Client\\GalerieController::addMediaGalerie'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/client/galerie/remove' => [[['_route' => 'app_client_galerie_removemedia', '_controller' => 'App\\Controller\\Client\\GalerieController::removeMedia'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/page/website/config/custom' => [[['_route' => 'app_page_website_config_custom', '_controller' => 'App\\Controller\\Client\\PageWebsiteConfigCustomController::index'], null, null, null, false, false, null]],
        '/api/client/clientmodules' => [[['_route' => 'list_clientmodules', '_controller' => 'App\\Controller\\Client\\PageWebsiteConfigDefaultController::index'], null, null, null, false, false, null]],
        '/api/client/clientdefaultsectiontype' => [[['_route' => 'list_clientdefaultsectiontype', '_controller' => 'App\\Controller\\Client\\PageWebsiteConfigDefaultController::getAllDefaultSectionType'], null, null, null, false, false, null]],
        '/api/client/product' => [
            [['_route' => 'app_client_product_listproduct', '_controller' => 'App\\Controller\\Client\\ProductController::listProduct'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_product_addproduct', '_controller' => 'App\\Controller\\Client\\ProductController::addProduct'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/client/product/remove' => [[['_route' => 'app_client_product_removeproduct', '_controller' => 'App\\Controller\\Client\\ProductController::removeProduct'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/user' => [[['_route' => 'app_user_information_detail', '_controller' => 'App\\Controller\\Client\\UserInformationController::index'], null, null, null, false, false, null]],
        '/api/client/variation-product' => [
            [['_route' => 'app_client_variationproduct_getconfig', '_controller' => 'App\\Controller\\Client\\VariationProductController::getConfig'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_variationproduct_addnewvariation', '_controller' => 'App\\Controller\\Client\\VariationProductController::addnewVariation'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/client/variation-product/detail' => [[['_route' => 'app_client_variationproduct_getdetailonevariation', '_controller' => 'App\\Controller\\Client\\VariationProductController::getDetailOneVariation'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/variation-product/update' => [[['_route' => 'app_client_variationproduct_updateonevariationproduct', '_controller' => 'App\\Controller\\Client\\VariationProductController::updateOneVariationProduct'], null, ['POST' => 0], null, false, false, null]],
        '/api/client/variation-product/remove' => [[['_route' => 'app_client_variationproduct_removeonevariationproduct', '_controller' => 'App\\Controller\\Client\\VariationProductController::removeOneVariationProduct'], null, ['POST' => 0], null, false, false, null]],
        '/client' => [
            [['_route' => 'app_client_get', '_controller' => 'App\\Controller\\ClientController::allClient'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_client_add', '_controller' => 'App\\Controller\\ClientController::addNewClient'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:98)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:134)'
                                .'|router(*:148)'
                                .'|exception(?'
                                    .'|(*:168)'
                                    .'|\\.css(*:181)'
                                .')'
                            .')'
                            .'|(*:191)'
                        .')'
                    .')'
                .')'
                .'|/a(?'
                    .'|dmin/client\\-configuration/([^/]++)(*:242)'
                    .'|pi/(?'
                        .'|admin/client/([^/]++)/assign\\-(?'
                            .'|domain(*:295)'
                            .'|sections/([^/]++)(*:320)'
                        .')'
                        .'|client/(?'
                            .'|c(?'
                                .'|ategory/detail/([^/]++)(*:366)'
                                .'|lientdefaultsectiontypedetail/([^/]++)(*:412)'
                            .')'
                            .'|product/(?'
                                .'|detail/([^/]++)(*:447)'
                                .'|edit/([^/]++)(*:468)'
                            .')'
                            .'|souscategory/(?'
                                .'|([^/]++)(*:501)'
                                .'|add(*:512)'
                                .'|detail/([^/]++)/([^/]++)(*:544)'
                                .'|remove(*:558)'
                                .'|update(*:572)'
                            .')'
                        .')'
                    .')'
                .')'
                .'|/s(?'
                    .'|ection/(?'
                        .'|type/([^/]++)(*:612)'
                        .'|detail/([^/]++)(*:635)'
                        .'|client/([^/]++)(*:658)'
                    .')'
                    .'|ite/([^/]++)(*:679)'
                .')'
                .'|/client/([^/]++)(*:704)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        98 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        134 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        148 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        168 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        181 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        191 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        242 => [[['_route' => 'app_client_configuration_detail', '_controller' => 'App\\Controller\\Admin\\ClientConfigurationController::getInfosOneClient'], ['id'], ['GET' => 0], null, false, true, null]],
        295 => [[['_route' => 'app_admin_assign-domain', '_controller' => 'App\\Controller\\AdminController::assignDomain'], ['id'], ['POST' => 0], null, false, false, null]],
        320 => [[['_route' => 'app_admin_assign-sections', '_controller' => 'App\\Controller\\AdminController::assignSections'], ['id', 'sectionIds'], ['GET' => 0], null, false, true, null]],
        366 => [[['_route' => 'app_client_categoryproduct_getonecategory', '_controller' => 'App\\Controller\\Client\\CategoryProductController::getOneCategory'], ['id'], ['GET' => 0], null, false, true, null]],
        412 => [[['_route' => 'list_clientdefaultsectiontypedetail', '_controller' => 'App\\Controller\\Client\\PageWebsiteConfigDefaultController::getAllDefaultSectionTypeDetail'], ['id'], null, null, false, true, null]],
        447 => [[['_route' => 'app_client_product_detailproduct', '_controller' => 'App\\Controller\\Client\\ProductController::detailProduct'], ['id'], ['GET' => 0], null, false, true, null]],
        468 => [[['_route' => 'app_client_product_editproduct', '_controller' => 'App\\Controller\\Client\\ProductController::editProduct'], ['id'], ['POST' => 0], null, false, true, null]],
        501 => [[['_route' => 'app_client_souscategoryproduct_getallsouscategory', '_controller' => 'App\\Controller\\Client\\SousCategoryProductController::getAllSousCategory'], ['id'], ['GET' => 0], null, false, true, null]],
        512 => [[['_route' => 'app_client_souscategoryproduct_addcategoryproduct', '_controller' => 'App\\Controller\\Client\\SousCategoryProductController::addCategoryProduct'], [], ['POST' => 0], null, false, false, null]],
        544 => [[['_route' => 'app_client_souscategoryproduct_getonecategory', '_controller' => 'App\\Controller\\Client\\SousCategoryProductController::getOneCategory'], ['cat', 'id'], ['GET' => 0], null, false, true, null]],
        558 => [[['_route' => 'app_client_souscategoryproduct_removecategory', '_controller' => 'App\\Controller\\Client\\SousCategoryProductController::removeCategory'], [], ['POST' => 0], null, false, false, null]],
        572 => [[['_route' => 'app_client_souscategoryproduct_updatecategoryproduct', '_controller' => 'App\\Controller\\Client\\SousCategoryProductController::updateCategoryProduct'], [], ['POST' => 0], null, false, false, null]],
        612 => [[['_route' => 'app_section_get', '_controller' => 'App\\Controller\\Admin\\SectionController::allSectionWhereType'], ['id'], ['GET' => 0], null, false, true, null]],
        635 => [[['_route' => 'app_section_detail', '_controller' => 'App\\Controller\\Admin\\SectionController::detailSection'], ['id'], ['GET' => 0], null, false, true, null]],
        658 => [[['_route' => 'app_section_assign_client_list', '_controller' => 'App\\Controller\\Admin\\SectionController::clientSectionAsigned'], ['id'], ['GET' => 0], null, false, true, null]],
        679 => [[['_route' => 'app_site', '_controller' => 'App\\Controller\\SiteController::index'], ['domain'], ['GET' => 0], null, false, true, null]],
        704 => [
            [['_route' => 'app_client_detail', '_controller' => 'App\\Controller\\ClientController::detailCLient'], ['id'], ['GET' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
