<?php


namespace App\Controller;

use App\Entity\Assiduite;
use App\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;

class chartController extends AbstractController
{
    /**
     * @return Response
     * @Route("/chart",name="chart")
     */
    public  function chart(ChartBuilderInterface $chartBuilder):Response{
        $data=[];
        $label=[];
        $matiere=$this->getDoctrine()->getRepository(Matiere::class)->findAll();

        foreach ($matiere as $matier){

            $assiduite=$this->getDoctrine()->getRepository(Assiduite::class)->
            findBy(['id'=>$matier,'valeur'=>'p']);
            $count=count($assiduite);
            array_push($data,$count);
            $mat=$matier->getNomMatiere();
            array_push($label,$mat);


        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $label,
            'datasets' => [
                [
                    'label' => 'Assiduite',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

        return $this->render('enseignant/chart/index.html.twig', [
            'chart' => $chart,
        ]);



    }

}