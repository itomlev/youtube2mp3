<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './youtube2mp3/youtube2mp3.php';
//require('youtube-dl/youtube-dl.class.php');

$app = new \Slim\App;
$app->get('/', function (Request $request, Response $response) {
	$response->getBody()->write("Hello");

	return $response;
});
$app->get('/api/youtube2mp3', function (Request $request, Response $response) {
	$url = $request->getParam('url');

	$video = new youtube2mp3();
	$video->setUrl($url);

	try {
		$video->convert();
		return $response
			->withHeader('Content-Type', 'application/json')
			->withJSON(array('videoId'=>$video->videoId, 'downloadUrl'=>$video->videoDownloadUrl));

	} catch(Exception $e) {
		return $response
			->withStatus(400)
			->withHeader('Content-Type', 'application/json')
			->withJSON(array('error'=>$e->getMessage()));
	}

});
$app->run();