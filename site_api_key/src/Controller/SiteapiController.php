<?php

namespace Drupal\site_api_key\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class SiteapiController extends ControllerBase {

  public function get_content($api_key, $nid) {
    $response_array = [];
    $config = \Drupal::config('siteapikey.settings');
    $api_value = $config->get('siteapikey');
    $node = Node::load($nid);
    if (isset($node) && $api_value==$api_key) {
       if ($node->bundle() == 'page') {
          $response_array[$node->get('title')->value] = [
           'title' => $node->get('title')->value,
           'nid' => $node->get('nid')->value,
           'body' => $node->get('body')->value,
         ];
          return new JsonResponse( $response_array );
       }
       else {
         return new JsonResponse("Access Denied") ;
       }
    } else {
        return new JsonResponse("Access Denied") ;
    }
  }
}
