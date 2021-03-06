<?php
namespace Drupal\pageable_node_list\Controller;
use Drupal\pageable_node_list\NodeListRepositoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
   *     "canonical" = "/pageable_node_list/{sortField}/{sortOrder}/{recordsPerPage}/{startingRecord}"
   *   }
   */
  protected $repoNodeList;

  public function __construct(NodeListRepositoryInterface $repoNodeList){
      $this->repoNodeList = $repoNodeList;
  }
  /**
   * {@inheritdoc}
   * inject dependencies...
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('node_list_repository')
    );
  }

  public function basic() {
    $element = array(
      '#markup' => 'Provide arguments to see nodes. See README',
    );
    return $element;
  }
  public function showNodes($sortField, $sortOrder, $pageSize, $offset)
  {
    $nodes = $this->repoNodeList->getNodes($offset, $pageSize, $sortField, $sortOrder);
    $response = new Response();
    $response->setContent(json_encode($nodes));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }
}