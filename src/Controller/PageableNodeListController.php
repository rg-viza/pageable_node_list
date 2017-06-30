<?php
namespace Drupal\pageable_node_list\Controller;
use Drupal\pageable_node_list\NodeListRepository;
use Drupal\pageable_node_list\NodeListRepositoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
/**
 * Provides route responses for the Example module.
 */
class PageableNodeListController extends ControllerBase {
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   *   uri_paths = {
   *     "canonical" = "/pageable_node_list/{username}"
   *   }
   */
  protected $repoUserLocation;

  public function __construct(){
      $this->setRepoUserLocation(new NodeListRepository());
  }

  public function setRepoUserLocation(NodeListRepositoryInterface $repoNodeList){
      $this->repoNodeList = $repoNodeList;   
  }
  public function basic() {
    $element = array(
      '#markup' => 'Provide arguments to see nodes',
    );
    return $element;
  }
  public function showNodes($sortField, $sortOrder, $pageSize, $offset)
  {
    $nodes = $this->repoNodeList->getNodes($offset, $pageSize,$sortField = 'title', $sortOrder = 'ASC');
  $response = new Response();
$response->setContent(json_encode($nodes));
$response->headers->set('Content-Type', 'application/json');
return $response;
  }
}