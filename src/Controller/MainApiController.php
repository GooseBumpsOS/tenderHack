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
     * @Route("/ktru", name="main_api")
     */
    public function index(Request $request)
    {

        $okpdArray = $this->_getRawHtml($request->query->get('okpd2'));

        return $this->json([

            $okpdArray

        ]);
    }

    private function _getRawHtml($okpd2){


        $crawler = new Crawler(file_get_contents('https://zakupki.gov.ru/epz/ktru/search/results.html?searchString='. $okpd2 .'.121&morphology=on&search-filter=%D0%94%D0%B0%D1%82%D0%B5+%D1%80%D0%B0%D0%B7%D0%BC%D0%B5%D1%89%D0%B5%D0%BD%D0%B8%D1%8F&activeESCKLP=on&clGroupHiddenId=0&ktruCharselectedTemplateItem=0&sortBy=ITEM_CODE&pageNumber=1&sortDirection=true&recordsPerPage=_10&showLotsInfoHidden=false&rubricatorIdSelected=-1'));
        $okpd2Array = [];

        for ($i = 0; $i < $crawler->filter('.registry-entry__header-mid__number')->count(); $i++)
        {

            array_push($okpd2Array, [$crawler->filter('.registry-entry__header-mid__number > a')->eq($i)->text(), $crawler->filter('.w-space-inherit')->eq($i)->text()]);


        }

        return $okpd2Array;

    }
}
