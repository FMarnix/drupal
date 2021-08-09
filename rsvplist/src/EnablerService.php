<?php
/**
 * @file
 * Contains \Drupal\rsvplist\EnablerService
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

/**
 * Defines a service for managing RSVP list enabled for nodes.
 */
class EnableService {
  /**
    * Constructor
    */
    public function __construct(); 
      
  /**
   * sets a individual node to be RSVP enabled.
   * 
   * @param \Drupal\node\Entity\Node $node 
   */ 
  public function setEnabled(Node $node) {
    if (!$this->isEnabled($node)) {
      $insert = Database::getConnection()->inser('rsvplist_enabled');
      $insert->fields(array('nid'), array($node->id()));
      $insert->execute();
    }
  }

  /**
   * Checks if an individual node is RSVP enabled.
   * 
   * @param \Drupal\node\Entity\Node $node 
   * 
   * @return bool
   * Wether the node is enabled for the RSVP functionality.
   */
  public function isEnabled(Node $node) {
    if ($node->isNew()) {
      return FALSE;
    }
    $select = Database::getConnection()->select('rsvplist-enabled', 're');
    $select->fields('re', array('nid'));
    $select->condition('nid', $node->id());
    $results = $select->execute();
    return !empty($results->fetchCol());
  }

  /**
   * Deletes enabled settings for an individual node.
   * 
   * @param \Drupal\node\Entity\Node\ $node
   */
  public function delEnabled(node $node)   {
      $delete = Database::getConnection()->delete('rsvplist_enabled');
      $delete->condition('nid', $node->id());
      $delete->execute();
  }
}
?>