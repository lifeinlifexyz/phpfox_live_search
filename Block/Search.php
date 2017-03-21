<?php


namespace Apps\CM_LiveSearch\Block;


class Search extends \Phpfox_Component
{
    public function process()
    {
        if (!\Phpfox::getUserParam('search.can_use_global_search')) {
            return false;
        }
        return 'block';
    }
}