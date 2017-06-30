<?php
namespace Drupal\pageable_node_list;
use Drupal\pageable_node_list\NodeListRepositoryInterface;
/**
 * This service gets the node list
 *
 * @author ndavis
 */
 

class NodeListRepository implements NodeListRepositoryInterface {
    public function getNodes($page, $pageSize, $sortField = 'title', $sortOrder = 'ASC'){
        $query = \Drupal::entityQuery('node')
                ->condition('type','page')
                ->sort($sortField,$sortOrder)
                ->range($page,$pageSize);
        $nids = $query->execute();
        $count = $query = \Drupal::entityQuery('node')
                ->condition('type','page')
                ->count()
                ->execute();
        $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
        $data = ['totalRecords' => $count];
        foreach($nodes as $node){
            $data['nodedata'][]['nid'] = $node->get('nid')->value;
            $data['nodedata'][]['title'] = $node->get('title')->value;
        }
        return $data;
    }
}