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

// Assume that all dependency is installed
$missingDependency = false;

if (strpos('installer + update + upgrade', $input->getCmd('view')) === false)
{
	if ( ! defined('JSN_MEDIASELECTOR_DEPENDENCY'))
	{
		// Load dependency from XML manifest file
		$xml	= simplexml_load_file(dirname(__FILE__) . '/' . substr($input->getCmd('option'), 4) . '.xml');
		$check	= $xml->xpath('subinstall/extension');
	}
	else
	{
		$check = json_decode(JSN_MEDIASELECTOR_DEPENDENCY);
	}

	// Backward compatible
	$checkUpdate = false;

	if (strpos($_SERVER['HTTP_REFERER'], '?option=' . $input->getCmd('option')) !== false
		AND (strpos($_SERVER['HTTP_REFERER'], '&view=update') !== false OR strpos($_SERVER['HTTP_REFERER'], '&view=upgrade') !== false))
	{
		// Checking for dependency is necessary
		$checkUpdate = true;
	}

	// Load installer model for checking dependency
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/installer.php';

	$model = new JSNMediaSelectorModelInstaller;

	if (($result = $model->check($check, $checkUpdate)) !== -1)
	{
		$missingDependency = true;
	}

	if ($missingDependency)
	{
		// Redirect to dependency installer view
		$app->redirect('index.php?option=' . $input->getCmd('option') . '&view=installer');
	}

	// Check compatibility between component and installed Joomla version
	if ( ! JSNVersion::isJoomlaCompatible(JSN_MEDIASELECTOR_REQUIRED_JOOMLA_VER))
	{
		try
		{
			$result = JSNUpdateHelper::check(JSN_MEDIASELECTOR_IDENTIFIED_NAME, JSN_MEDIASELECTOR_REQUIRED_JOOMLA_VER);

			if ($result[JSN_MEDIASELECTOR_IDENTIFIED_NAME])
			{
				$app->redirect('index.php?option=' . $input->getCmd('option') . '&view=update');
			}
			else
			{
				$app->enqueueMessage(JText::_('JSN_MEDIASELECTOR_NOT_COMPATIBLE_MSG'));
			}
		}
		catch (Exception $e)
		{
			$app->enqueueMessage(JText::_('JSN_MEDIASELECTOR_NOT_COMPATIBLE_MSG'));
		}
	}

	// Check compatibility between component and the installed version of JoomlaShine extension framework
	if ( ! JSNVersion::checkCompatibility(JSN_MEDIASELECTOR_IDENTIFIED_NAME, JSN_MEDIASELECTOR_VERSION))
	{
		$app->redirect('index.php?option=' . $input->getCmd('option') . '&view=update');
	}
}
