<?php

namespace App\Controller;

use Phpml\Classification\NaiveBayes;
use Phpml\Clustering\KMeans;
use Phpml\Dataset\ArrayDataset;
use Phpml\Dataset\CsvDataset;
use Phpml\Exception\FileException;
use Phpml\ModelManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Phpml\Classification\KNearestNeighbors;

class PhpmlController extends AbstractController
{
    /**
     * @Route("sheet/phpml", name="phpml")
     */
    public function index()
    {
        try {

            $the_big_array = [];
            if (($h = fopen("part22.csv", "r")) !== FALSE)
            {
                // Convert each line into the local $data variable
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE)
                {
                    $the_big_array[] = $data;// Read the data from a single line
                }

                // Close the file
                fclose($h);
            }

            $labels=array_column($the_big_array,5);
            for ($i = 0 ; $i<count($the_big_array);$i++){
                $the_big_array[$i][0] = 0;
                unset($the_big_array[$i][5]);
            }
            $samples = $the_big_array;
            
            // KNearestNeighbors
            $classifier = new KNearestNeighbors();
            $classifier->train($samples, $labels);
            
            // NaiveBayes
            $classnaive = new NaiveBayes();
            $classnaive -> train($samples,$labels);

            // predict
            $predict = $classifier->predict(['2','2','3','1','74']);

            
            return $this->render('phpml/index.html.twig', [
                'predict' => $predict,
                //'naive' => $predictnaive,
            ]);

        } catch (FileException $e) {
            echo "404 ERROR";
        }
    }
}
