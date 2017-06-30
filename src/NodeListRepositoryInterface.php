<?php
namespace Drupal\pageable_node_list;
/**
 *
 * @author ndavis
 */
interface NodeListRepositoryInterface {
    public function getNodes($offset, $pageSize,$sortField = 'title', $sortOrder = 'ASC');
}
