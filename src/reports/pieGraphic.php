<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 7/25/2018
 * Time: 12:35 AM
 */

include("../bibliotecas/pChart/pData.class");
include("../bibliotecas/pChart/pChart.class");
// Dataset definition
$DataSet = new pData;
$DataSet->AddPoint(array(10,2,3,5,3),"Serie1");
$DataSet->AddPoint(array("Jan","Feb","Mar","Apr","May"),"Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbsciseLabelSerie("Serie2");

// Initialise the graph
$Test = new pChart(380,200);
$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);
$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);

// Draw the pie chart
$Test->setFontProperties("../bibliotecas/Fonts/tahoma.ttf",8);
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);
$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

$Test->Render("pie.png");
?>