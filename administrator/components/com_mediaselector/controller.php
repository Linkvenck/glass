<?php
/**
 * @version    $Id$
 * @package    JSN_MediaSelector
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General controller.
 *
 * @package  JSN_MediaSelector
 * @since    1.0.0
 */
class JSNMediaSelectorController extends JSNBaseController
{
	/**
	 * Method for display page.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  void
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Get input object
		$input = JFactory::getApplication()->input;

		// Set default view if not set
		$input->set('view', $input->getCmd('view', 'default'));

		// Call parent method
		parent::display($cachable, $urlparams);
	}

	/**
	 * Method for hiding a message
	 *
	 * @return	void
	 */
	function hideMsg()
	{
		jexit(JSNUtilsMessage::hideMessage(JFactory::getApplication()->input->getInt('msgId')));
	}
}
