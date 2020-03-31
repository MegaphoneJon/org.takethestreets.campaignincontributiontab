<?php

require_once 'campaignincontributiontab.civix.php';

/**
 * Add a whole mess of extra fields to the contribution tab.
 */
function campaignincontributiontab_civicrm_searchColumns($objectName, &$headers, &$values, &$selector) {
  if ($objectName == 'contribution' && !empty($values)) {
    // Remove the action links, we'll re-add them later.
    unset($headers[6]);
    $fieldArray = [
      [
        'name' => 'campaign_id',
        'label' => ts('Campaign'),
        'callback' => 'getCampaignName',
      ],
    ];
    $contributionIds = CRM_Utils_Array::collect('contribution_id', $values);
    // Add the additional contribution fields to the values array.
    $contributionFields = civicrm_api3('Contribution', 'get', [
      'id' => ['IN' => $contributionIds],
      'options' => ['limit' => 0],
    ])['values'];
    foreach ($values as $k => $value) {
      if (isset($contributionFields[$value['contribution_id']])) {
        $values[$k] = array_merge($contributionFields[$value['contribution_id']], $value);
      }
    }

    formatValues($values, $fieldArray);

    // Add the data.
    $headerId = 6;
    foreach ($fieldArray as $field) {
      $headers[$headerId]['field_name'] = $field['name'];
      $headers[$headerId]['name'] = $field['label'];
      $headers[$headerId]['weight'] = $headerId * 10;
      $headerId++;
    }

    // Re-add the action links.
    $headers[] = ['desc' => 'Actions', 'type' => 'actions', 'weight' => 99999];
  }
}

/**
 * We format the values - pseudoconstants are resolved, money fields are formatted as money, etc.
 * @param type $values
 * @param type $fieldArray
 */
function formatValues(&$values, $fieldArray) {
  foreach ($fieldArray as $field) {
    if (isset($field['callback'])) {
      foreach ($values as $k => $value) {
        if (isset($value[$field['name']])) {
          $values[$k][$field['name']] = call_user_func($field['callback'], $value[$field['name']], $field['name']);
        }
      }
    }
  }
}

function getCampaignName($data, $field) {
  if ($data) {
    return CRM_Contribute_BAO_Contribution::buildOptions('campaign_id')[$data];
  }
  return NULL;
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
