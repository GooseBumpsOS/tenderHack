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

        if (!count($ktruArray)) {

            array_push($ktruArray, [$okpd]);

        }

        return $this->json([

            $okpd, $ktruArray

        ]);
    }

    private function _getOkpd($cte)
    {

        $json = json_decode(file_get_contents('https://old.zakupki.mos.ru/api/Cssp/Sku/GetEntity?id=' . $cte), true);

        return $json['production']['okpds'][0]['okpd']['code'];

    }

    private function _getKtru($okpd2)
    {


        $crawler = new Crawler(file_get_contents('https://zakupki.gov.ru/epz/ktru/search/results.html?searchString=' . $okpd2 . '&morphology=on'));
        $ktru2Array = [];

        for ($i = 0; $i < $crawler->filter('.registry-entry__header-mid__number')->count(); $i++) {

            array_push($ktru2Array, [$crawler->filter('.registry-entry__header-mid__number > a')->eq($i)->text(), $crawler->filter('.w-space-inherit')->eq($i)->text()]);


        }

        return $ktru2Array;

    }

    /**
     * @Route("/mail", name="mail_api")
     */
    public function mainApi(Request $request)
    {
        $to = "nikita@vetoshkin.info";

        $subject = "Birthday Reminders for August";

        $subject = '=?koi8-r?B?' . base64_encode(convert_cyr_string($subject, "w", "k")) . '?=';

        $message = '
<html>

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta name="x-apple-disable-message-reformatting">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="telephone=no" name="format-detection">
<title></title>
<!--[if (mso 16)]>
<style type="text/css">
a {text-decoration: none;}
</style>
<![endif]-->
<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
</head>

<body>
<div class="es-wrapper-color">
<!--[if gte mso 9]>
<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
<v:fill type="tile" color="#f6f6f6"></v:fill>
</v:background>
<![endif]-->
<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-email-paddings" valign="top">
<table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center">
<tbody>
<tr>
<td class="esd-stripe" align="center">
<table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr>
<td class="esd-structure es-p20t es-p20r es-p20l" align="left">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td width="560" class="esd-container-frame" align="center" valign="top">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-image"><a target="_blank"><img class="adapt-img" src="https://fumibg.stripocdn.email/content/guids/CABINET_4eae1262.." alt style="display: block;" width="560"></a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p20t es-p20r es-p20l" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="es-m-p0r es-m-p20b esd-container-frame" width="560" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="left" class="esd-block-text">
<p>Уважаемый организатор совместной закупки!</p>
<p> С Вами хотят участвовать в&nbsp;совместной закупке № 3244.</p>
<p>СТЕ: <br></p>
<p>КТРУ:</p>
<p>Заказчик: МУНИЦИПАЛЬНОЕ БЮДЖЕТНОЕ ОБЩЕОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ СРЕДНЯЯ ОБЩЕОБРАЗОВАТЕЛЬНАЯ ШКОЛА № 1 ИМЕНИ А.И.ГЕРЦЕНА МУНИЦИПАЛЬНОГО ОБРАЗОВАНИЯ ТИМАШЕВСКИЙ РАЙОН<br></p>
<p>ИНН: 2353014442</p>
<p>КПП: 235301001</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
<!--[if mso]><table width="560" cellpadding="0"
cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
<table cellpadding="0" cellspacing="0" class="es-left" align="left">
<tbody>
<tr>
<td width="270" class="es-m-p20b esd-container-frame" align="left">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-button es-p10"><span class="es-button-border" style="border-width: 0px; border-color: rgb(44, 181, 67); background: rgb(49, 203, 75);"><a href class="es-button" target="_blank">Принять заявку</a></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
<table cellpadding="0" cellspacing="0" class="es-right" align="right">
<tbody>
<tr>
<td width="270" align="left" class="esd-container-frame">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-button es-p10" bgcolor="transparent"><span class="es-button-border" style="border-width: 0px; border-color: rgb(44, 181, 67); background: rgb(204, 0, 0);"><a href class="es-button" target="_blank" style="background: rgb(204, 0, 0); border-color: rgb(204, 0, 0);">Отклонить заявку</a></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if mso]></td></tr></table><![endif]-->
</td>
 
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</body>

</html>

';
        $boundary = uniqid('np');

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: Foo no-reply@myfinlab.ru\r\n";
        $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

        $message = "This is a MIME encoded message.";

        $message .= "\r\n\r\n--" . $boundary . "\r\n";
        $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
        $message .= "This is the text/plain version.";

        $message .= "\r\n\r\n--" . $boundary . "\r\n";
        $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
        $message .=
            '<html>

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta name="x-apple-disable-message-reformatting">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="telephone=no" name="format-detection">
<title></title>
<!--[if (mso 16)]>
<style type="text/css">
a {text-decoration: none;}
</style>
<![endif]-->
<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
</head>

<body>
<div class="es-wrapper-color">
<!--[if gte mso 9]>
<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
<v:fill type="tile" color="#f6f6f6"></v:fill>
</v:background>
<![endif]-->
<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="esd-email-paddings" valign="top">
<table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center">
<tbody>
<tr>
<td class="esd-stripe" align="center">
<table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr>
<td class="esd-structure es-p20t es-p20r es-p20l" align="left">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td width="560" class="esd-container-frame" align="center" valign="top">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-image"><a target="_blank"><img class="adapt-img" src="https://biont.ru/upload/iblock/81e/81e471a6e7df55e4b93c7031021c4a8b.png" alt style="display: block;" width="560"></a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p20t es-p20r es-p20l" align="left">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="es-m-p0r es-m-p20b esd-container-frame" width="560" valign="top" align="center">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="left" class="esd-block-text">
<p>Уважаемый организатор совместной закупки!</p>
<p> С Вами хотят участвовать в&nbsp;совместной закупке № 3244.</p>
<p>СТЕ: ' . $request->query->get('cte') . '<br></p>
<p>КТРУ:' . $request->query->get('ktru') . '</p>
<p>Заказчик: МУНИЦИПАЛЬНОЕ БЮДЖЕТНОЕ ОБЩЕОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ СРЕДНЯЯ ОБЩЕОБРАЗОВАТЕЛЬНАЯ ШКОЛА № 1 ИМЕНИ А.И.ГЕРЦЕНА МУНИЦИПАЛЬНОГО ОБРАЗОВАНИЯ ТИМАШЕВСКИЙ РАЙОН<br></p>
<p>ИНН: 2353014442</p>
<p>КПП: 235301001</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
<!--[if mso]><table width="560" cellpadding="0"
cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
<table cellpadding="0" cellspacing="0" class="es-left" align="left">
<tbody>
<tr>
<td width="270" class="es-m-p20b esd-container-frame" align="left">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-button es-p10"><span class="es-button-border" style="border-width: 0px; border-color: rgb(44, 181, 67); background: rgb(49, 203, 75);"><a href class="es-button" target="_blank">Принять заявку</a></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
<table cellpadding="0" cellspacing="0" class="es-right" align="right">
<tbody>
<tr>
<td width="270" align="left" class="esd-container-frame">
<table cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" class="esd-block-button es-p10" bgcolor="transparent"><span class="es-button-border" style="border-width: 0px; border-color: rgb(44, 181, 67); background: rgb(204, 0, 0);"><a href class="es-button" target="_blank" style="background: rgb(204, 0, 0); border-color: rgb(204, 0, 0);">Отклонить заявку</a></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if mso]></td></tr></table><![endif]-->
</td>
 
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</body>

</html>';

        $message .= "\r\n\r\n--" . $boundary . "--";

        mail($to, $subject, $message, $headers);


        return $this->json([

            'ok'

        ]);


    }

}
