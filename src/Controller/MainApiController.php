<?php

namespace App\Controller;

use App\Service\ParserApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainApiController extends AbstractController
{
    /**
     * @Route("/{slug}", name="main_api")
     */
    public function index($slug)
    {

//        $this->getDoctrine()->getManager(


        $html = file_get_contents('https://edu.upt24.ru/sku/view/1387181');

        echo str_replace('<base href="/"/>', '<base href="https://old.zakupki.mos.ru"/>', $html);

        return $this->json([

        ]);
    }

    public function hello(){
        echo "Hello";
    }
}
