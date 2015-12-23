<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace bestophe\VideoCollectionBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

class ControllerListener {

//    protected $templating;
//
//    // private $movieGenre;
//
//    public function __construct($template) {
//
//        $this->templating = $template;
//    }
//
//    public function onKernelView(GetResponseForControllerResultEvent $event) {
//        //result returned by the controller
//        $data = $event->getControllerResult();
//
//        /* @var $request  \Symfony\Component\HttpFoundation\Request */
//        $request = $event->getRequest();
//        $template = $request->get('_template');
//        $route = $request->get('_route');
//
//        // bestophe_VideoCollection_movieSectionAlphaView
//        dump($request);
//        dump($data);
//        dump($template);
//        dump($route);
//        
//
//        if (substr($route, 37, 9) == 'AlphaView') {
//           // $newTemplate = str_replace('html.twig', 'movieAlphaView.html.twig', $template);
//            $newTemplate= 'bestopheVideoCollectionBundle:MovieSection:MovieList/movieAlphaView.html.twig';
//            //Overwrite original template with the mobile one
//            $response = $this->templating->renderResponse($newTemplate, $data);
//            $event->setResponse($response);
//        }
//    }

}
