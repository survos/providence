<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AppController extends AbstractController
{

	/**
	 * @Route("/index{oldRoute}", name="app_legacy_index", requirements={"oldRoute"=".+"})
	 */
	public function legacyIndex(Request $request, $oldRoute): Response
	{
		dd($oldRoute);
	}
    /**
     * @Route("/system/Error", name="app_error")
     */
    public function systemError(Request $request): Response
    {
		dd($request);
        return $this->render('models.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

	/**
	 * @Route("/new", name="app_index")
	 */
	public function index(Request $request): Response
	{
		return $this->render("models.html.twig");
	}

	/**
	 * @Route("/models", name="app_models")
	 */
	public function models(Request $request): Response
	{
		foreach (\BaseModel::$s_ca_models_definitions as $ca_models_definition=>$info) {
//			dd($ca_models_definition, $info);
		}
//		$baseObject = (new \BaseModel());
//		dd($baseObject, $GLOBALS, array_filter(get_declared_classes(), fn ($className) => preg_match('/base|ca_/i', $className)) );
//		foreach (glob(__DIR__ . '/../../app/models/*.php') as $modelName) {
//			try {
//
//			} catch (\Exception $exception) {
//
//			}
//		}
//		$model = new \ca_item_tags();
//		dd($model);
//		dd('models', __CA_APP_TYPE__);
		return $this->render("app/models.html.twig", [
			'models' => \BaseModel::$s_ca_models_definitions
		]);
	}

}

