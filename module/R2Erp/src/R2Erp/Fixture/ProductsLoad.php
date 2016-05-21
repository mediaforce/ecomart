<?php

namespace R2Base\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ProductsLoad extends AbstractFixture implements OrderedFixtureInterface {

	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager) {
		$str = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/videos.json');
		$json = json_decode($str, true);
		$produtosVideos = $json['produtos'];

		$csvData = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/produtos.csv');
		$csvData = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/produtos.csv');

		$lines = explode(PHP_EOL, $csvData);
		$array = array();

		foreach ($lines as $line) {
			$array[] = str_getcsv($line, ';');
		}

		unset($array[0]);


		$arrProdutos = [];
		$count = 0;
		foreach ($array as $produto) {
			if (isset($produto[9])) {
				$idManufacturer = 0;
				switch ($produto[1]) {
				    case 'ECOVACS':
				        $idManufacturer = 1;
				        break;
				    case 'PAINT ZOOM':
				        $idManufacturer = 2;
				        break;
				    case 'YODA':
				        $idManufacturer = 3;
				        break;
				    case 'HOMEUP':
				        $idManufacturer = 4;
				        break;
				    case 'WORX':
				        $idManufacturer = 5;
				        break;
				}

				$idDepartment = 0;
				switch ($produto[3]) {
				    case 'PEÇAS DE REPOSIÇÃO':
				        $idDepartment = 1;
				        break;
				    case 'ROBÔS DE LIMPEZA':
				        $idDepartment = 2;
				        break;
				    case 'ELETRODOMÉSTICOS':
				        $idDepartment = 3;
				        break;
				    case 'FERRAMENTAS':
				        $idDepartment = 4;
				        break;
				}

				// peso = 4, comprimento = 5, altura = 6, largura = 7,
				// preço anterior = 8, preço atual = 9

				$arrProduto = [
					'reference' => $produto[0],
					'manufacturer' => (int) $idManufacturer,
					'title' => $produto[2],
					'department' => (int) $idDepartment,
					'weight' => (float) $produto[4],
					'dimensionLength' => (float) $produto[5],
					'dimensionHeight' => (float) $produto[6],
					'dimensionWidth' => (float) $produto[7],
					'unitPrice' => (float) str_replace(",",".",$produto[8]),
					'unitDiscountPrice' => (float) str_replace(",",".",$produto[9]),
				];

				if ($count < 5) {
					$arrProduto['isHighlighted'] = true;
				} else if ($count < 10) {
					$arrProduto['isLaunch'] = true;
				}

				$count++;

				array_push($arrProdutos, $arrProduto);
			}
		}

		foreach($arrProdutos as $produto) {
			$produto['manufacturer'] = $manager->getReference('R2Erp\Entity\Manufacturer\Manufacturer', $produto['manufacturer']);
			$produto['department'] = $manager->getReference('R2Erp\Entity\Product\ProductDepartment', $produto['department']);

			$video = $this->findVideo($produtosVideos, $produto['reference']);

			if ($video) {
			 	$videos = new ArrayCollection();
			 	$videoEntity = new \R2Base\Entity\VideoLink( array('title' => $produto['title'], 'address' => $video) );
				$videos->add($videoEntity);
				$produto['videos'] = $videos;
			}



			$dir = new \DirectoryIterator("C:/DESENVOLVIMENTO/sites/ecomart/public/img/uploads/products/");

			foreach ($dir as $fileinfo) {
			    if (!$fileinfo->isDot()) {

			    	if ($fileinfo->isDir()) {
			    		$dir2 = new \DirectoryIterator("C:/DESENVOLVIMENTO/sites/ecomart/public/img/uploads/products/" . $fileinfo->getFilename());

			    		if ($fileinfo->getFilename() == $produto['reference']) {

			    			$images = new ArrayCollection();
				    		foreach($dir2 as $fileinfo2) {
					        	if (!$fileinfo2->isDot()) {

					        		if ($fileinfo2->isFile()) {
					        			$imageEntity = new \R2Base\Entity\Image();

					        			$fileArr = explode('_', pathinfo($fileinfo2->getFilename(), PATHINFO_FILENAME));

					        			$imageEntity->setPath('/img/uploads/products/' . $produto['reference'] . '/' . $fileinfo2->getFilename());
					        			if (isset($fileArr[1]) && $fileArr[1] == "true") {
					        				$imageEntity->setIsCover(true);
					        			}

					        			$manager->persist($imageEntity);

										$images->add($imageEntity);

					        		}
					        	}
					        }
					        $produto['images'] = $images;
		    			}
			    	}
			    }
			}

			$entity = new \R2Erp\Entity\Product\Product($produto);
			$manager->persist($entity);


			$store = new \R2Erp\Entity\Order\Store\Store(array(
				'product' => $entity, 
				'toSell' => true,
				'sellNoShipping' => false,
				'quantity' => 10,
				'unitPrice' => (float) $produto['unitPrice'],
				'unitDiscountPrice' => (float) $produto['unitDiscountPrice'],
				'sellDiscountPrice' => true,
			));

			$manager->persist($store);
		}

		$manager->flush();

	}

	private function findVideo($produtos, $reference) {
		foreach($produtos as $produto) {
			if ($produto['reference'] == $reference) return $produto['video'];
		}
		return false;
	}

	public function getOrder() {
		return 3;
	}
}