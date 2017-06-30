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
        $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
        foreach($nodes as $node){
            $data[]['nid'] = $node->get('nid')->value;
            $data[]['title'] = $node->get('title')->value;
        }
        return $data;
    }
}