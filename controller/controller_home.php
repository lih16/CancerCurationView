<?php
//namespace Controller;
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Controller
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  Sema4
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */

/**
 * This is a "Docblock Comment," also known as a "docblock."  The class'
 * docblock, below, contains a complete description of how to write these.
 */
use Lib\model_base;

use Lib\Controller_base;

class controller_home extends Controller_base
{
  /**
   * Create the Controller model
   *  @param  $model Designate a place to hold class dependencies
   */
    public $model;

    public function __construct()
    {
      /**
       * Accept a $model instance in the constructor, so the  dependencies can be injected from the outside
       * Set the dependency in a class property, so it's easily accessible for later use of class methods.
       * @param $this means "this instance of class A"
        * $this->model means "this instance of class Login_Model $model property
       */
        $this->model = new Login_Model();
    }

    public function action_browse()
    {
      /**
      * Set views directories
      */

        include VIEW_PATH . 'header.php';
        include VIEW_PATH . 'select.php';
        include VIEW_PATH . 'narrative.php';
        include VIEW_PATH . 'modaldialog.php';
    }

    public function action_gettumor()
    {
      /**
        * Set the dependency in a class property, so it's easily accessible for later use of class methods.
        * @param $this means "this instance of class A"
        * $this->model means "this instance of class Tumor_Model $model property
        * @param $result gets this instance of getTumor
        * @param $this->send_plaintext  converts result to plaintext
      **/
        $this->model = new Tumor_Model();
        $result = $this->model->getTumor();
        $this->send_plaintext($result);
    }

    public function action_getgenes()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $result gets this instance of getGenes
      * @param $this->send_plaintext  converts result to plaintext
    **/
        $this->model = new Tumor_Model();
        $result = $this->model->getGenes();
        $this->send_plaintext($result);
    }

    public function action_getgenemutations()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $result gets this instance of getGeneMutations
      * @param $this->send_plaintext converts result to plaintext
    **/
        $this->model = new Tumor_Model();
        $result = $this->model->getGeneMutations();
        $this->send_plaintext($result);
    }

    public function action_getnarrative()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $result gets this instance of getNarrative
      * @param $this->send_plaintext converts result to plaintext
    **/
        $this->model = new Tumor_Model();
        $result = $this->model->getNarrative();
        $this->send_plaintext($result);
    }

    public function action_savecomment()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $result gets this instance of saveComment
      * @param $this->send_plaintext converts result to plaintext
    **/
        $this->model = new Tumor_Model();
        $result = $this->model->saveComment();
        $this->send_plaintext($result);
    }

    public function action_getcomment()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $result gets this instance of getComment
      * @param $this->send_plaintext converts result to plaintext
    **/
        $this->model = new Tumor_Model();
        $result = $this->model->getComment();
        $this->send_json($result);
    }

    public function action_getnarrativeList()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $this->model gets this instance of getNarrativeList
    **/
        $this->model = new Tumor_Model();
        $this->model->getNarrativeList();
        //$this->send_json($result);
    }

    public function action_saveNarrative()
    {
      /**
      * Set the dependency in a class property, so it's easily accessible for later use of class methods.
      * @param $this means "this instance of class A"
      * $this->model means "this instance of class Tumor_Model $model property
      * @param $this->model gets this instance of saveNarrative
    **/
        $this->model = new Tumor_Model();
        $this->model->saveNarrative();
        //$this->send_json($result);
    }
}
