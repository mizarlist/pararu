<?php

class Controller_Graph extends Controller {

    public function action_index() {
        if (!Session::instance()->get('graph_allowed')) {
            return;
        }
        if (!Plussia_Dispatcher::getUser()) {
            return;
        }
        $user_id = Plussia_Dispatcher::getUserId();
        Session::instance()->delete('graph_allowed');
        $rows1 = Model_NicCard::getCharacterForUser($user_id);
        array_shift($rows1);
        $max_value = ceil(max($rows1));

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
        $DataSet->AddSerie("Serie1");
        $DataSet->SetAbsciseLabelSerie("Label");
        $DataSet->SetSerieName($graphicText['you_character'], "Serie1");

        // Initialise the graph
        $Test = new pChart(500, 365);
        $Test->setFontProperties("//fonts/tahoma.ttf", 10);
        $Test->setGraphArea(10, 10, 470, 335);

        $upalete = Plussia_Dispatcher::getUser()->getUserData()->is_woman ? 1 : 0;
        if (!$upalete) {
            $Test->setColorPalette($upalete, 51, 204, 255);
        } else {
            $Test->setColorPalette(1 - $upalete, 255, 102, 102);
        }

        // Draw the radar graph
        $Test->drawRadarAxis($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE, 5, 100, 100, 100, 120, 120, 120, $num_h, $h);
        $Test->drawFilledRadar($DataSet->GetData(), $DataSet->GetDataDescription(), 30, 10, $max_value);
        //$Test->setLineStyle(2,10);
        // Finish the graph
        $Test->drawLegend(15, 15, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->Stroke();
    }

}