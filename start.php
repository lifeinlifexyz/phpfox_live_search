<?php

\Phpfox_Module::instance()
    ->addAliasNames('livesearch', 'CM_LiveSearch')
    ->addTemplateDirs([
        'livesearch' => PHPFOX_DIR_SITE_APPS . 'CM_LiveSearch' . PHPFOX_DS . 'views',
    ]);

event('app_settings', function ($settings){
    if (isset($settings['cm_live_search_enabled'])) {
        \Phpfox::getService('admincp.module.process')->updateActivity('livesearch', $settings['cm_live_search_enabled']);
    }
});

\Phpfox_Module::instance()->addComponentNames('block', [
    'livesearch.live-search'    => '\Apps\CM_LiveSearch\Block\Search',
]);

if (setting('cm_live_search_enabled')) {

    route('live-search', function(){

        $sQuery = request()->get('q');
        $aSearchResults = Phpfox::getService('search')->query($sQuery, 0, 5);
        if (is_array($aSearchResults) && !empty($aSearchResults)) {

            Core\Controller::$__view->env()->addFunction(new \Twig_SimpleFunction('avatar', function($user, $suffix, $maxWidth, $maxHeight){
                return Phpfox::getLib('phpfox.image.helper')->display([
                    'user' => $user,
                    'suffix' => $suffix,
                    'max_width' => $maxWidth,
                    'max_height' => $maxHeight,
                ]);
            }));

            echo  view('@CM_LiveSearch/live-search.html', [
                'aSearchResults' => $aSearchResults,
                'sQuery' => $sQuery,
                'sUrl' => Phpfox_Url::instance()->makeUrl('search', ['q' => urlencode($sQuery), 'encode' => '1']),
            ]);
        } else {
            echo  _p('No search results found.');
        }
        exit();
    });
}
