<?php

require_once 'campaignincontributiontab.civix.php';

function campaignincontributiontab_civicrm_searchColumns($objectName, &$headers, &$values, &$selector) {
  if ($objectName == 'contribution') {
    foreach ($headers as $k => $header) {
      if (isset($header['name']) && $header['name'] == 'Premium') {
        $headers[$k]['name'] = 'Campaign';
        unset($headers[$k]['sort']);
      }
    }
    // Get the contact id of the contact we're viewing.
    $contact_id = $values[0]['contact_id'];
    // Select a list of contributions that have soft credits from this contact,
    // plus the name of the creditees.  This is better than doing a separate SQL
    // query for each contribution.
    if ($contact_id) {
      $sql = "SELECT cc.id, camp.title FROM civicrm_contribution cc JOIN civicrm_campaign camp ON cc.campaign_id = camp.id WHERE cc.contact_id = %1";
      $dao = CRM_Core_DAO::executeQuery($sql, array(1 => array($contact_id, 'Integer')));
      while ($dao->fetch()) {
        $campaignName[$dao->id] = $dao->title;
      }

      // Insert the soft creditee name as "product_name" so we don't have to
      // change the templates.
      foreach ($values as $k => $value) {
        if (array_key_exists($value['contribution_id'], $campaignName)) {
          $values[$k]['product_name'] = $campaignName[$value['contribution_id']];
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function campaignincontributiontab_civicrm_config(&$config) {
  _campaignincontributiontab_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function campaignincontributiontab_civicrm_xmlMenu(&$files) {
  _campaignincontributiontab_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function campaignincontributiontab_civicrm_install() {
  _campaignincontributiontab_civix_civicrm_install();
}

/**
* Implements hook_civicrm_postInstall().
*
* @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
*/
function campaignincontributiontab_civicrm_postInstall() {
  _campaignincontributiontab_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function campaignincontributiontab_civicrm_uninstall() {
  _campaignincontributiontab_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function campaignincontributiontab_civicrm_enable() {
  _campaignincontributiontab_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function campaignincontributiontab_civicrm_disable() {
  _campaignincontributiontab_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function campaignincontributiontab_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _campaignincontributiontab_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function campaignincontributiontab_civicrm_managed(&$entities) {
  _campaignincontributiontab_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaignincontributiontab_civicrm_caseTypes(&$caseTypes) {
  _campaignincontributiontab_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaignincontributiontab_civicrm_angularModules(&$angularModules) {
_campaignincontributiontab_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function campaignincontributiontab_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _campaignincontributiontab_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function campaignincontributiontab_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function campaignincontributiontab_civicrm_navigationMenu(&$menu) {
  _campaignincontributiontab_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'org.takethestreets.campaignincontributiontab')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _campaignincontributiontab_civix_navigationMenu($menu);
} // */
