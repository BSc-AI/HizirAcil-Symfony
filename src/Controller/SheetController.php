<?php

namespace App\Controller;


use App\Entity\Sheet;
use App\Form\SheetType;
use App\Repository\SheetRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\GeoChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use Phpml\Association\Apriori;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Classification\NaiveBayes;
use Phpml\Classification\SVC;
use Phpml\Math\Distance\Minkowski;
use Phpml\SupportVectorMachine\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Service\DataService;

/**
 * @Route("/sheet")
 */

class SheetController extends AbstractController
{
    /**
     * @Route("/", name="sheet_index", methods={"GET"})
     */
    public function index(): Response
    {
        $limit=1000;
        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT ilce,tani FROM sheet';    //id,sokak idi ilce olarak değiştirdim haritada ilce üzerinden geliştirmeye devam edeceğim
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();

        //Red Zone
        $sqlRed = "SELECT count(tani) as redZone FROM sheet where id<".$limit."
        and (
         tani LIKE 'zehirlenmeler-%' or
         tani LIKE 'kvs-%' or
         tani LIKE 'travma-%')";
        $sRed = $em->getConnection()->prepare($sqlRed);
        $sRed->execute();
        $resultsRed = $sRed->fetchAll();
        //
        //Yellow Zone
        $sqlYel = "SELECT count(tani) as yelZone FROM sheet where id<".$limit."
        and (
         tani LIKE 'yenidogan-%' or 
         tani LIKE 'metabolik-%' or
         tani LIKE 'kadindogum-%' or 
         tani LIKE 'gis-%' or
         tani LIKE 'gus-%'
         )";
        $sYel = $em->getConnection()->prepare($sqlYel);
        $sYel->execute();
        $resultsYel = $sYel->fetchAll();
        //
        //Green Zone
        $sqlGr = "SELECT count(tani) as grZone FROM sheet where id<".$limit."
        and (
         tani LIKE 'diger-%' or 
         tani LIKE 'infeksiyonhstl-%' or
         tani LIKE 'psikiyatrik-%' or 
         tani LIKE 'norolojik-%' or
         tani LIKE '?'
         )";
        $sGr = $em->getConnection()->prepare($sqlGr);
        $sGr->execute();
        $resultsGr = $sGr->fetchAll();

        $objEkip = (object) array(
            'TB1' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0
            ),
            'TB2' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'TB3' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'TB4' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'TB5' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'TB6' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0
            ),
            'TB7' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP1' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP2' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP3' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP4' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP5' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP6' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
            'OP8' => array(
                'gorev' => 0,
                'toplam' => 0,
                'kmfark' => 0,
                'maxkm' => 0,
                'maxtop' => 0,
                'minkm' => 0,
                'mintop' => 0),
        );


        //Puan Ekip TB
        $sqlTb= "select ekipno as eNo ,id as eId,kendibolgesi as eBol, toplam as sums , kmfark as km  from sheet where id<".$limit." and (ekipno like 'TB-%')";
        $sTb = $em->getConnection()->prepare($sqlTb);
        $sTb->execute();
        $rTb = $sTb->fetchAll();
        //TBekip
        $objEkip->{'TB1'}{'mintop'} = $rTb[0]["sums"];
        $objEkip->{'TB1'}{'minkm'} = $rTb[0]["km"];
        $objEkip->{'TB2'}{'mintop'} = $rTb[1]["sums"];
        $objEkip->{'TB2'}{'minkm'} = $rTb[1]["km"];
        $objEkip->{'TB3'}{'mintop'} = $rTb[2]["sums"];
        $objEkip->{'TB3'}{'minkm'} = $rTb[2]["km"];
        $objEkip->{'TB4'}{'mintop'} = $rTb[3]["sums"];
        $objEkip->{'TB4'}{'minkm'} = $rTb[3]["km"];
        $objEkip->{'TB5'}{'mintop'} = $rTb[4]["sums"];
        $objEkip->{'TB5'}{'minkm'} = $rTb[4]["km"];
        $objEkip->{'TB6'}{'mintop'} = $rTb[5]["sums"];
        $objEkip->{'TB6'}{'minkm'} = $rTb[5]["km"];
        $objEkip->{'TB7'}{'mintop'} = $rTb[6]["sums"];
        $objEkip->{'TB7'}{'minkm'} = $rTb[6]["km"];
        //Puan Ekip TB
        $sqlOp= "select ekipno as eNo ,id as eId,kendibolgesi as eBol, toplam as sums , kmfark as km  from sheet where id<".$limit." and (ekipno like 'OP-%')";
        $sOp = $em->getConnection()->prepare($sqlOp);
        $sOp->execute();
        $rOp = $sOp->fetchAll();
        //OPekip
        $objEkip->{'OP1'}{'mintop'} = $rOp[0]["sums"];
        $objEkip->{'OP1'}{'minkm'} = $rOp[0]["km"];
        $objEkip->{'OP2'}{'mintop'} = $rOp[1]["sums"];
        $objEkip->{'OP2'}{'minkm'} = $rOp[1]["km"];
        $objEkip->{'OP3'}{'mintop'} = $rOp[2]["sums"];
        $objEkip->{'OP3'}{'minkm'} = $rOp[2]["km"];
        $objEkip->{'OP4'}{'mintop'} = $rOp[3]["sums"];
        $objEkip->{'OP4'}{'minkm'} = $rOp[3]["km"];
        $objEkip->{'OP5'}{'mintop'} = $rOp[4]["sums"];
        $objEkip->{'OP5'}{'minkm'} = $rOp[4]["km"];
        $objEkip->{'OP6'}{'mintop'} = $rOp[5]["sums"];
        $objEkip->{'OP6'}{'minkm'} = $rOp[5]["km"];
        $objEkip->{'OP8'}{'mintop'} = $rOp[6]["sums"];
        $objEkip->{'OP8'}{'minkm'} = $rOp[6]["km"];

        //print("<pre>".print_r($rTb[0]["sums"],true)."</pre>");


        //for($c =0 ; $c<sizeof($rTb); $c++)
        foreach ($rTb as $res){
            if($res["eNo"] == 'TB-1'){
                $objEkip->{'TB1'}{'gorev'}++;
                $objEkip->{'TB1'}{'toplam'} +=$res["sums"];
                $objEkip->{'TB1'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB1'}{'maxkm'} )$objEkip->{'TB1'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB1'}{'maxtop'} )$objEkip->{'TB1'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB1'}{'minkm'} )$objEkip->{'TB1'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB1'}{'mintop'} )$objEkip->{'TB1'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-2'){
                $objEkip->{'TB2'}{'gorev'}++;
                $objEkip->{'TB2'}{'toplam'} += $res["sums"];
                $objEkip->{'TB2'}{'kmfark'} += $res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB2'}{'maxkm'} )$objEkip->{'TB2'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB2'}{'maxtop'} )$objEkip->{'TB2'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                $objEkip->{'TB2'}{'minkm'} = $res["km"];
                if( $res["km"] < $objEkip->{'TB2'}{'minkm'} )$objEkip->{'TB2'}{'minkm'} = $res["km"];
                $objEkip->{'TB2'}{'mintop'} = $res["sums"];
                if( $res["sums"] < $objEkip->{'TB2'}{'mintop'} )$objEkip->{'TB2'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-3'){
                $objEkip->{'TB3'}{'gorev'}++;
                $objEkip->{'TB3'}{'toplam'} += $res["sums"];
                $objEkip->{'TB3'}{'kmfark'} += $res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB3'}{'maxkm'} )$objEkip->{'TB3'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB3'}{'maxtop'} )$objEkip->{'TB3'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB3'}{'minkm'} )$objEkip->{'TB3'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB3'}{'mintop'} )$objEkip->{'TB3'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-4'){
                $objEkip->{'TB4'}{'gorev'}++;
                $objEkip->{'TB4'}{'toplam'} +=$res["sums"];
                $objEkip->{'TB4'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB4'}{'maxkm'} )$objEkip->{'TB4'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB4'}{'maxtop'} )$objEkip->{'TB4'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB4'}{'minkm'} )$objEkip->{'TB4'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB4'}{'mintop'} )$objEkip->{'TB4'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-5'){
                $objEkip->{'TB5'}{'gorev'}++;
                $objEkip->{'TB5'}{'toplam'} +=$res["sums"];
                $objEkip->{'TB5'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB5'}{'maxkm'} )$objEkip->{'TB5'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB5'}{'maxtop'} )$objEkip->{'TB5'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB5'}{'minkm'} )$objEkip->{'TB5'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB5'}{'mintop'} )$objEkip->{'TB5'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-6'){
                $objEkip->{'TB6'}{'gorev'}++;
                $objEkip->{'TB6'}{'toplam'} += $res["sums"];
                $objEkip->{'TB6'}{'kmfark'} += $res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB6'}{'maxkm'} )$objEkip->{'TB6'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB6'}{'maxtop'} )$objEkip->{'TB6'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB6'}{'minkm'} )$objEkip->{'TB6'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB6'}{'mintop'} )$objEkip->{'TB6'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'TB-7'){
                $objEkip->{'TB7'}{'gorev'}++;
                $objEkip->{'TB7'}{'toplam'} +=$res["sums"];
                $objEkip->{'TB7'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'TB7'}{'maxkm'} )$objEkip->{'TB7'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'TB7'}{'maxtop'} )$objEkip->{'TB7'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'TB7'}{'minkm'} )$objEkip->{'TB7'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'TB7'}{'mintop'} )$objEkip->{'TB7'}{'mintop'} = $res["sums"];
                //end
            }

        }
        foreach ($rOp as $res){
            //OP
            if($res["eNo"] == 'OP-1'){
                $objEkip->{'OP1'}{'gorev'}++;
                $objEkip->{'OP1'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP1'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP1'}{'maxkm'} )$objEkip->{'OP1'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP1'}{'maxtop'} )$objEkip->{'OP1'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP1'}{'minkm'} )$objEkip->{'OP1'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP1'}{'mintop'} )$objEkip->{'OP1'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-2'){
                $objEkip->{'OP2'}{'gorev'}++;
                $objEkip->{'OP2'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP2'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP2'}{'maxkm'} )$objEkip->{'OP2'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP2'}{'maxtop'} )$objEkip->{'OP2'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP2'}{'minkm'} )$objEkip->{'OP2'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP2'}{'mintop'} )$objEkip->{'OP2'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-3'){
                $objEkip->{'OP3'}{'gorev'}++;
                $objEkip->{'OP3'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP3'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP3'}{'maxkm'} )$objEkip->{'OP3'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP3'}{'maxtop'} )$objEkip->{'OP3'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP3'}{'minkm'} )$objEkip->{'OP3'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP3'}{'mintop'} )$objEkip->{'OP3'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-4'){
                $objEkip->{'OP4'}{'gorev'}++;
                $objEkip->{'OP4'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP4'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP4'}{'maxkm'} )$objEkip->{'OP4'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP4'}{'maxtop'} )$objEkip->{'OP4'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP4'}{'minkm'} )$objEkip->{'OP4'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP4'}{'mintop'} )$objEkip->{'OP4'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-5'){
                $objEkip->{'OP5'}{'gorev'}++;
                $objEkip->{'OP5'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP5'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP5'}{'maxkm'} )$objEkip->{'OP5'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP5'}{'maxtop'} )$objEkip->{'OP5'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP5'}{'minkm'} )$objEkip->{'OP5'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP5'}{'mintop'} )$objEkip->{'OP5'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-6'){
                $objEkip->{'OP6'}{'gorev'}++;
                $objEkip->{'OP6'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP6'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP6'}{'maxkm'} )$objEkip->{'OP6'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP6'}{'maxtop'} )$objEkip->{'OP6'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP6'}{'minkm'} )$objEkip->{'OP6'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP6'}{'mintop'} )$objEkip->{'OP6'}{'mintop'} = $res["sums"];
                //end
            }
            if($res["eNo"] == 'OP-8'){
                $objEkip->{'OP8'}{'gorev'}++;
                $objEkip->{'OP8'}{'toplam'} +=$res["sums"];
                $objEkip->{'OP8'}{'kmfark'} +=$res["km"];
                //max Bulma
                if( $res["km"] > $objEkip->{'OP8'}{'maxkm'} )$objEkip->{'OP8'}{'maxkm'} = $res["km"];
                if( $res["sums"] > $objEkip->{'OP8'}{'maxtop'} )$objEkip->{'OP8'}{'maxtop'} = $res["sums"];
                //end
                //min bulma
                if( $res["km"] < $objEkip->{'OP8'}{'minkm'} )$objEkip->{'OP8'}{'minkm'} = $res["km"];
                if( $res["sums"] < $objEkip->{'OP8'}{'mintop'} )$objEkip->{'OP8'}{'mintop'} = $res["sums"];
                //end
            }
        }

        //print("<pre>".print_r($objEkip,true)."</pre>");

        return $this->render('sheet/index.html.twig', [
            'hastaSayi' =>  (int) ($resultsRed [0]["redZone"] + $resultsYel[0]["yelZone"] + $resultsGr[0]["grZone"]),
            'redZone' => (int) $resultsRed [0]["redZone"],
            'yellowZone' =>(int) $resultsYel[0]["yelZone"],
            'greenZone' =>(int) $resultsGr[0]["grZone"],
            'objEkip' => $objEkip,
            'sheets' => $statement,
        ]);
    }



    /**
     * @Route("/charts", name="sheet_charts", methods={"GET"})
     */
    public function charts(): Response
    {
        //PieChart Sonuc
        $em=$this->getDoctrine()->getManager();
        $sql="SELECT Sonuc, COUNT(*) AS sayı FROM `sheet` GROUP BY Sonuc";
        $statement=$em->getConnection()->prepare($sql);
        $statement->execute();
        $chart=$statement->fetchAll();

        $pieChart = new PieChart();
        $pieChart->getData($chart)->setArrayToDataTable(
            [['Task', 'Hours per Day'],


                ['Asılsız İhbar',  (int)  $chart[1]["sayı"]],
                ['Başka Araçla Nakil',  (int)  $chart[2]["sayı"]],
                ['Diğer',  (int)  $chart[3]["sayı"]],
                ['Diğer Ulaşılanlar',  (int)  $chart[4]["sayı"]],
                ['Eve Nakil',  (int)  $chart[5]["sayı"]],
                ['EX Morga Nakil',  (int)  $chart[6]["sayı"]],
                ['EX Yerinde Bırakıldı',  (int)  $chart[7]["sayı"]],
                ['Görev İptali',  (int)  $chart[8]["sayı"]],
                ['Hastaneler Arası Nakil',  (int)  $chart[9]["sayı"]],
                ['Hastaneye Nakil',  (int)  $chart[10]["sayı"]],
                ['Nakil Reddi',  (int)  $chart[11]["sayı"]],
                ['Olay Yerinde Bekleme',  (int)  $chart[12]["sayı"]],
                ['Tıbbi Teknik İçin Nakil',  (int)  $chart[13]["sayı"]],
                ['Yaralı Yok',  (int)  $chart[14]["sayı"]],
                ['Yerinde Müdahale',  (int)  $chart[15]["sayı"]]

            ]
        );


        $pieChart->getOptions()->setTitle('Sonuc');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        // PieChart End


        //PieChart İlce
        $em=$this->getDoctrine()->getManager();
        $sql="SELECT ilce, COUNT(*) AS toplam FROM `sheet` GROUP BY ilce";
        $statement=$em->getConnection()->prepare($sql);
        $statement->execute();
        $ilce=$statement->fetchAll();

        $pieChartI = new PieChart();
        $pieChartI->getData($chart)->setArrayToDataTable(
            [['Task', 'Hours per Day'],

                ['Afyon Yolu',  (int)  $ilce[2]["toplam"]],
                ['Alpu',  (int)  $ilce[3]["toplam"]],
                ['Ankara Yolu',  (int)  $ilce[4]["toplam"]],
                ['Beylik Ova',  (int)  $ilce[5]["toplam"]],
                ['Bursa Yolu',  (int)  $ilce[6]["toplam"]],
                ['Çifteler',  (int)  $ilce[7]["toplam"]],
                ['Günyüzü',  (int)  $ilce[8]["toplam"]],
                ['Han',  (int)  $ilce[9]["toplam"]],
                ['İnönü',  (int)  $ilce[10]["toplam"]],
                ['Kütahya Yolu',  (int)  $ilce[11]["toplam"]],
                ['Mahmudiye',  (int)  $ilce[12]["toplam"]],
                ['Mihalgazi',  (int)  $ilce[13]["toplam"]],
                ['Mihaliccik',  (int)  $ilce[14]["toplam"]],
                ['Odunpazarı',  (int)  $ilce[15]["toplam"]],
                ['Sarıcakaya',  (int)  $ilce[16]["toplam"]],
                ['Seyitgazi',  (int)  $ilce[17]["toplam"]],
                ['Sivrihisar',  (int)  $ilce[18]["toplam"]],
                ['Tepebaşı',  (int)  $ilce[19]["toplam"]],
            ]
        );


        $pieChartI->getOptions()->setTitle('İlce');
        $pieChartI->getOptions()->setHeight(500);
        $pieChartI->getOptions()->setWidth(500);
        $pieChartI->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChartI->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChartI->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChartI->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChartI->getOptions()->getTitleTextStyle()->setFontSize(20);

        // PieChart End



        //PieChart Tani

        $em=$this->getDoctrine()->getManager();
        $sqlDIGER="SELECT COUNT(tani) AS numara FROM sheet where tani like 'DIgER%'";
        $statement=$em->getConnection()->prepare($sqlDIGER);
        $statement->execute();
        $diger=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlYENIDOGAN="SELECT COUNT(tani) AS numara FROM sheet where tani like 'YENIDOgAN%'";
        $statement=$em->getConnection()->prepare($sqlYENIDOGAN);
        $statement->execute();
        $yeniDogan=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlGIS="SELECT COUNT(tani) AS numara FROM sheet where tani like 'GIS%'";
        $statement=$em->getConnection()->prepare($sqlGIS);
        $statement->execute();
        $gis=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlGuS="SELECT COUNT(tani) AS numara FROM sheet where tani like 'GuS%'";
        $statement=$em->getConnection()->prepare($sqlGuS);
        $statement->execute();
        $gus=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlKADiNDOgUM="SELECT COUNT(tani) AS numara FROM sheet where tani like 'KADiNDOgUM%'";
        $statement=$em->getConnection()->prepare($sqlKADiNDOgUM);
        $statement->execute();
        $kadinDogum=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlKVS="SELECT COUNT(tani) AS numara FROM sheet where tani like 'KVS%'";
        $statement=$em->getConnection()->prepare($sqlKVS);
        $statement->execute();
        $kvs=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlMETABOLIK="SELECT COUNT(tani) AS numara FROM sheet where tani like 'METABOLIK%'";
        $statement=$em->getConnection()->prepare($sqlMETABOLIK);
        $statement->execute();
        $metabolik=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlNoROLOJIK="SELECT COUNT(tani) AS numara FROM sheet where tani like 'NoROLOJIK%'";
        $statement=$em->getConnection()->prepare($sqlNoROLOJIK);
        $statement->execute();
        $norolojik=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlPSIKIYATRIK="SELECT COUNT(tani) AS numara FROM sheet where tani like 'PSIKIYATRIK%'";
        $statement=$em->getConnection()->prepare($sqlPSIKIYATRIK);
        $statement->execute();
        $psikiyatrik=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlSOLUNUMSISTEMI="SELECT COUNT(tani) AS numara FROM sheet where tani like 'SOLUNUMSISTEMI%'";
        $statement=$em->getConnection()->prepare($sqlSOLUNUMSISTEMI);
        $statement->execute();
        $solunumSistemi=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlTRAVMA="SELECT COUNT(tani) AS numara FROM sheet where tani like 'TRAVMA%'";
        $statement=$em->getConnection()->prepare($sqlTRAVMA);
        $statement->execute();
        $travma=$statement->fetchAll();

        $em=$this->getDoctrine()->getManager();
        $sqlZEHIRLENMELER="SELECT COUNT(tani) AS numara FROM sheet where tani like 'ZEHIRLENMELER%'";
        $statement=$em->getConnection()->prepare($sqlZEHIRLENMELER);
        $statement->execute();
        $zehirlenmeler=$statement->fetchAll();





        $pieChartTani = new PieChart();
        $pieChartTani->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Diğer',     (int) $diger[0]["numara"]],
                ['Yeni Doğan',      (int) $yeniDogan[0]["numara"]],
                ['GIS',  (int) $gis[0]["numara"]],
                ['GUS', (int) $gus[0]["numara"]],
                ['Kadın Doğum',    (int) $kadinDogum[0]["numara"]],
                ['KVS',    (int) $kvs[0]["numara"]],
                ['Metabolik',    (int) $metabolik[0]["numara"]],
                ['Nörolojik',    (int) $norolojik[0]["numara"]],
                ['Psikiyatrik',    (int) $psikiyatrik[0]["numara"]],
                ['Solunum Sistemi',    (int) $solunumSistemi[0]["numara"]],
                ['Travma',    (int) $travma[0]["numara"]],
                ['Zehirlenmeler',    (int) $zehirlenmeler[0]["numara"]]
            ]
        );
        $pieChartTani->getOptions()->setTitle('Tanı Genel');
        $pieChartTani->getOptions()->setHeight(500);
        $pieChartTani->getOptions()->setWidth(580);
        $pieChartTani->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChartTani->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChartTani->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChartTani->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChartTani->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('sheet/graphics.html.twig', [
            'piechart' => $pieChart,
            'chartilce' =>$pieChartI,
            'chartTani' =>$pieChartTani,
        ]);


    }




    /**
     * @Route("/ajax")
     */
    public function ajaxAction(Request $request) {

        return $this->render('sheet/ajax.html.twig');
    }

    /**
     * @Route("/api/ajax")
     */
    public function ApiajaxAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT ilce,tani FROM sheet WHERE id<100';
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();

        /*$statement = $this->getDoctrine()
            ->getRepository(Sheet::class)
            ->findAll();*/

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $jsonContent = $serializer->serialize($statement, 'json');
        echo $jsonContent;

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;

            foreach($statement as $student) {
                $temp = array(
                    'ilce' => $student->getIlce(),
                    'tani' => $student->getTani(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
            //dump($jsonData);
            //die();
        } else {
            return $this->render('sheet/ajax.html.twig',[
                'student' => $statement,
            ]);
        }
    }


    /**
     * @Route("/jsonparse", name="jsonparse", methods={"GET"})
     */
    public function jsonparse(): Response
    {
        $limit=1000;
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT sokak , ilce , tani ,mudahale ,Sonuc ,cagrinedeni ,yas FROM sheet WHERE id<'.$limit;
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $jsonContent = $serializer->serialize($statement, 'json');
        echo($jsonContent);
        return $this->render('sheet/jsonparse.html.twig', [
            'json' => $statement,
        ]);
    }




    /**
     * @Route("/data",name="datatable", methods={"GET","POST"})
     */
    public function listdataAction(Request $request,DataService $query){
        $data=$query->ReturnData($request);
        //dump($data);
        //die();
        return $this->render('sheet/tables-data.html.twig',[
            'data'=>$data,
        ]);
    }
    public function getCData($kolonName){

        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT DISTINCT ".$kolonName." FROM sheet ORDER BY ".$kolonName." ASC";
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();

    }

    /**
     * @Route("/new", name="sheet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sheet = new Sheet();
        $form = $this->createForm(SheetType::class, $sheet);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $dataForm = $request->request->all();
            //dump($dataForm['sheet']["cagriyapan"]);
            //die();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sheet);
            $entityManager->flush();
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT max(id) as id from sheet";
            $statement = $em->getConnection()->prepare($sql);
            $statement->execute();
            $id = $statement->fetchAll();

            $sqlmining = " select 
               cagriyapan,
               cagriyolu,
               cagrinedeni , 
               cinsiyet, 
               yas,
               sokak,
               mahalle,
               gitmeligitmemeli,
               polis, 
               ekhasta, 
               kentselkirsal,
               oncelik 
               from sheet where id <2000";
            $stmining = $entityManager->getConnection()->prepare($sqlmining);
            $stmining->execute();
            $dataDb = $stmining->fetchAll();

            $c = sizeof($dataDb);
            for ($i = 0; $i < $c; $i++) {
                $samples[$i][0] = $dataDb[$i]["cagriyapan"];
                $samples[$i][1] = $dataDb[$i]["cagriyolu"];
                $samples[$i][2] = $dataDb[$i]["cagrinedeni"];
                $samples[$i][3] = $dataDb[$i]["cinsiyet"];
                $samples[$i][4] = $dataDb[$i]["yas"];
                $samples[$i][5] = $dataDb[$i]["sokak"];

                $samples2[$i][0] = $dataDb[$i]["cagriyapan"];
                $samples2[$i][1] = $dataDb[$i]["cagriyolu"];
                $samples2[$i][2] = $dataDb[$i]["cagrinedeni"];

                $samples3[$i][0] = $dataDb[$i]["cagrinedeni"];
                $samples3[$i][1] = $dataDb[$i]["cagriyapan"];
                $samples3[$i][2] = $dataDb[$i]["ekhasta"];
                $samples3[$i][3] = $dataDb[$i]["kentselkirsal"];

                $samples4[$i][0] = $dataDb[$i]["cagrinedeni"];
                $samples4[$i][1] = $dataDb[$i]["cagriyapan"];
                $samples4[$i][2] = $dataDb[$i]["mahalle"];
                $samples4[$i][3] = $dataDb[$i]["yas"];
                $samples4[$i][4] = $dataDb[$i]["cinsiyet"];

               // $samples5[$i][0] = $dataDb[$i]["sokak"];
               // $samples5[$i][1] = $dataDb[$i]["mahalle"];
               // $samples5[$i][2] = $dataDb[$i]["ilce"];

                $labels[$i] = $dataDb[$i]["gitmeligitmemeli"];
                $labels2[$i] = $dataDb[$i]["polis"];
                $labels3[$i] = $dataDb[$i]["ekhasta"];
                $labels4[$i] = $dataDb[$i]["oncelik"];
                //$labels5[$i] = $dataDb[$i]["ekipno"];
                //dump($dataDb[$i]["gitmeligitmemeli"]);
            }


            $classifier = new NaiveBayes();
            $classifier->train($samples, $labels);
            //dump( $classifier->train($samples, $labels));
            $predict = $classifier->predict([
                $dataForm['sheet']["cagriyapan"],
                $dataForm['sheet']["cagriyolu"],
                $dataForm['sheet']["cagrinedeni"],
                $dataForm['sheet']["cinsiyet"],
                $dataForm['sheet']["yas"],
                $dataForm['sheet']["sokak"]
            ]);
            //sehir mahalle cinsiyet hastalık birliktelik
            $classifier2 = new KNearestNeighbors($k = 3, new Minkowski($lambda = 4));
            $classifier2->train($samples2, $labels2);
            $predict2 = $classifier2->predict([
                $dataForm['sheet']["cagriyapan"],
                $dataForm['sheet']["cagriyolu"],
                $dataForm['sheet']["cagrinedeni"],
            ]);

            $classifier3 = new SVC(Kernel::LINEAR, $cost = 1000);
            $classifier3->train($samples3, $labels3);
            $predict3 = $classifier3->predict([
                $dataForm['sheet']["cagrinedeni"],
                $dataForm['sheet']["cagriyapan"],
                $dataForm['sheet']["mahalle"],
                $dataForm['sheet']["kentselkirsal"],
            ]);

            $classifier4 = new SVC(Kernel::LINEAR, $cost = 1000);
            $classifier4->train($samples4, $labels4);
            $predict4 = $classifier4->predict([
                $dataForm['sheet']["cagrinedeni"],
                $dataForm['sheet']["cagriyapan"],
                $dataForm['sheet']["mahalle"],
                $dataForm['sheet']["kentselkirsal"],
                $dataForm['sheet']["yas"],
                $dataForm['sheet']["cinsiyet"],
            ]);
           // $classifier5 = new SVC(Kernel::LINEAR, $cost = 1000);
           // $classifier5->train($samples5, $labels5);
           // $predict5 = $classifier5->predict([
           //     $dataForm['sheet']["sokak"],
           //     $dataForm['sheet']["mahalle"],
           //     $dataForm['sheet']["ilce"],
           // ]);//

            //dump($predict5);
            //die();
            $associator = new Apriori($support = 0.5, $confidence = 0.5);
            $dataP4 = $associator->train($samples4, $labels4);

            return $this->render('phpml/index.html.twig', [
                'dataform' => $dataForm,
                'predict' => $predict,
                'predict2' => $predict2,
                'predict3' => $predict3,
                'predict4' => $predict4,
                'ekip' => $predict4,
                //'predict5' => $predict5,
                'id' => $id[0]["id"],
            ]);

        }

        return $this->render('sheet/newPatient.html.twig', [
            'sheet' => $sheet,
            'cagriyapan' => $this->getCData('cagriyapan'),
            'cagriyolu' => $this->getCData('cagriyolu'),
            'cagrinedeni' => $this->getCData('cagrinedeni'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sheet_show", methods={"GET"})
     */
    public function show(Sheet $sheet): Response
    {
        return $this->render('sheet/show.html.twig', [
            'sheet' => $sheet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sheet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sheet $sheet): Response
    {
        $form = $this->createForm(SheetType::class, $sheet);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            //dump($request);
            //die();
            return $this->redirectToRoute('sheet_index', [
                'id' => $sheet->getId(),
            ]);
        }

        return $this->render('sheet/_form.html.twig', [
            'sheet' => $sheet,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="sheet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sheet $sheet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sheet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sheet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sheet_index');
    }
}
