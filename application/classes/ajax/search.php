<?php

class Ajax_Search {

    public static function search_centerblock($data) {
        $functions = array('ct_search1', 'ct_search2');
        if (in_array($data, $functions)) {
            return Controller_Search::getSearchCenterblock(array_search($data, $functions)+1);
        }
        return null;
    }

    public static function search_fast($data) {
        $prep_data = array();
        $prep_data['is_woman'] = isset($data['cheks']['find_woman']) ? 1 : 0;
        $prep_data['photo'] = isset($data['cheks']['find_photo']) && $data['cheks']['find_photo'];
        $prep_data['online'] = isset($data['cheks']['find_online']) && $data['cheks']['find_online'];
        $data = $data['inputs'];
        $prep_data['country_id'] = isset($data['find_country_id']) && $data['find_country_id'] ? $data['find_country_id'] : NULL;
        $prep_data['region_id'] = isset($data['find_area_id']) && $data['find_area_id'] ? $data['find_area_id'] : NULL;
        $prep_data['city_id'] = isset($data['find_city_id']) && $data['find_city_id'] ? $data['find_city_id'] : NULL;
        $prep_data['age_from'] = isset($data['find_age_from']) && $data['find_age_from'] ? $data['find_age_from'] : NULL;
        $prep_data['age_to'] = isset($data['find_age_to']) && $data['find_age_to'] ? $data['find_age_to'] : NULL;

        $user_cards = Plussia_Finder::fastFind($prep_data);
        $cards = Plussia_Viewer::getVisitkas($user_cards, 'search');

        if(!$cards) {
            $nothingView = View::factory('nothing');
            $nothingView->text = XML_Base::factory('broad')->getAssoc();
            return $nothingView->render();
        }

        return $cards;
    }

    public static function search_full($data) {
        print_r($data);
    }

    public static function search_saveSputnikData($data) {
        print_r($data);
    }

}