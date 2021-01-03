<?php

namespace App\Controller;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsApiController extends AbstractController {
	/**
	 * @Route("/api/products/recommended/{city}", name="getRecommendations", methods={"GET"})
	 */
	public function getRecommendations(Request $request, $city): JsonResponse
	{
		$client = new CurlHttpClient();
		$response = $client->request('GET', 'https://api.meteo.lt/v1/places/'.$city.'/forecasts/long-term');
		$recommendations = [];
		$dayWeathers = [];

		// go through all timestamps and get 2  product recommendations for each day.
		foreach ($response->toArray()['forecastTimestamps'] as $forecast) {
			$forecastDate = substr($forecast['forecastTimeUtc'], 0, 10);
			//if not enough products are selected and this condition hasnt been already selected for this day
			if ((empty($recommendations[$forecastDate]) || sizeof($recommendations[$forecastDate]['products']) < 2) &&
				(empty($dayWeathers[$forecastDate]) || !in_array($forecast['conditionCode'], $dayWeathers[$forecastDate]))) {
				if (empty($recommendations[$forecastDate]['products'])) {
					$recommendations[$forecastDate]['products'] = [];
				}
				$recommendations[$forecastDate]['weather_forecast'] = $forecast['conditionCode'];
				$recommendations[$forecastDate]['date'] = $forecastDate;
				$recommendations[$forecastDate]['products'] = $this->getProductsByWeather($forecast['conditionCode'], $recommendations[$forecastDate]['products']);
				$dayWeathers[$forecastDate][] = $forecast['conditionCode'];
			}
		}
		$response = new JsonResponse(['city' => $city, 'recommendations' => array_values($recommendations), 'data_source' => 'LHMT'], Response::HTTP_OK);
		$response->setMaxAge(300);
		$response->setPublic();
		return $response;
	}

	/**
	 * @param $weather array string of weather type
	 * @param $existingProducts array list of products that will be already recommended for current day.
	 * @return array
	 */
	protected function getProductsByWeather($weather, &$existingProducts) : array {
		$products = $this->getDoctrine()->getRepository(Product::class)->findByArrayValue($weather);
		if (empty($products)) {
			return $existingProducts;
		}
		foreach ($products as $product) {
			$productsArr['name'] = $product->getName();
			$productsArr['sku'] = $product->getSku();
			$productsArr['price'] = $product->getPrice();
			if (!in_array($productsArr, $existingProducts) && sizeof($existingProducts) < 2) {
				$existingProducts[] = $productsArr;
			}
		}
		return $existingProducts;
	}
}