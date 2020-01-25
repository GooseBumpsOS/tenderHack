<?php

namespace App\Controller;

use App\Service\ParserApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainApiController extends AbstractController
{
    /**
     * @Route("/api", name="main_api")
     */
    public function index(Request $request)
    {

        $okpd = $this->_getOkpd($request->query->get('CTE'));
        $ktruArray = $this->_getKtru($okpd);

        return $this->json([

            $okpd, $ktruArray

        ]);
    }

    private function _getOkpd($cte){

       $json = json_decode(file_get_contents('https://old.zakupki.mos.ru/api/Cssp/Sku/GetEntity?id=' . $cte), true);

       return $json['production']['okpds'][0]['okpd']['code'];

    }

    private function _getKtru($okpd2){



        $crawler = new Crawler(file_get_contents('https://zakupki.gov.ru/epz/ktru/search/results.html?searchString='. $okpd2 .'&morphology=on'));
        $ktru2Array = [];

        for ($i = 0; $i < $crawler->filter('.registry-entry__header-mid__number')->count(); $i++)
        {

            array_push($ktru2Array, [$crawler->filter('.registry-entry__header-mid__number > a')->eq($i)->text(), $crawler->filter('.w-space-inherit')->eq($i)->text()]);


        }

        return $ktru2Array;

    }
}
