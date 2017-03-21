<?php


namespace Apps\CM_LiveSearch\Block;


class Search extends \Phpfox_Component
{
    public function process()
    {
        if (!\Phpfox::getUserParam('search.can_use_global_search') || !setting('cm_live_search_enabled')) {
            return false;
        }
        return 'block';
    }
}