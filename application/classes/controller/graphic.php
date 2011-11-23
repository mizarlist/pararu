<?php

class Controller_Graphic extends Controller {

    public function action_index() {
        if (!Session::instance()->get('graphic_allowed') || !isset($_GET['u1']) || !isset($_GET['u2'])) {
            return;
        }
        if(!Plussia_Dispatcher::getUser()){
            return;
        }
        Session::instance()->delete('graphic_allowed');
        $user_id = Plussia_Dispatcher::getUserId();
        $sputnik_id = $_GET['u2'];
        if (!$user_id || $user_id != $_GET['u1']) {
            return;
        }
        $rows1 = Model_NicCard::getCharacterForUser($user_id);
        $rows2 = Model_NicCard::getCharacterForUser($sputnik_id);
        array_shift($rows1);
        array_shift($rows2);
        $max_value = ceil(max(array_merge($rows1, $rows2)));

        $h = 20;
        $num_h = ceil($max_value / $h);

        while ($num_h < 3) {
            $num_h *= 2;
            $h /= 2;
        }

        $file1 = Kohana::find_file('vendor', 'pchart/pChart/pData', 'class');
        $file2 = Kohana::find_file('vendor', 'pchart/pChart/pChart', 'class');
        require_once $file1;
        require_once $file2;
        // Dataset definition
        $DataSet = new pData;
        $sonic = XML_Texts::factory('sonic', '/')->getAssoc();
        $graphicText = XML_Texts::factory('graphic')->getAssoc();
        $DataSet->AddPoint(array_values($sonic['types']), "Label");

        $DataSet->AddPoint($rows1, "Serie1");
        $DataSet->AddPoint($rows2, "Serie2");
        $DataSet->AddSerie("Serie1");
        $DataSet->AddSerie("Serie2");

        $DataSet->SetAbsciseLabelSerie("Label");


        $DataSet->SetSerieName($graphicText['you'], "Serie1");
        $DataSet->SetSerieName($graphicText['you_sputnic'], "Serie2");

        // Initialise the graph
        $Test = new pChart(500, 365);
        $Test->setFontProperties("//fonts/tahoma.ttf", 10);
        $Test->setGraphArea(10, 10, 470, 335);

        $upalete = Plussia_Dispatcher::getUser()->getUserData()->is_woman ? 1 : 0;
        $Test->setColorPalette($upalete, 51, 204, 255);
        $Test->setColorPalette(1 - $upalete, 255, 102, 102);

        // Draw the radar graph
        $Test->drawRadarAxis($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE, 5, 100, 100, 100, 120, 120, 120, $num_h, $h);
        $Test->drawFilledRadar($DataSet->GetData(), $DataSet->GetDataDescription(), 30, 10, $max_value);
        //$Test->setLineStyle(2,10);
        // Finish the graph
        $Test->drawLegend(15, 15, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->Stroke();
    }

}