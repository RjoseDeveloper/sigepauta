<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao;


/**
 * Provide methods to handle a website root page.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class PageRoot extends \Frontend
{

	/**
	 * Redirect to the first active regular page
	 *
	 * @param integer $pageId
	 * @param boolean $blnReturn
	 * @param boolean $blnPreferAlias
	 *
	 * @return integer
	 */
	public function generate($pageId, $blnReturn=false, $blnPreferAlias=false)
	{
		$objNextPage = \PageModel::findFirstPublishedByPid($pageId);

		// No published pages yet
		if (null === $objNextPage)
		{
			header('HTTP/1.1 404 Not Found');
			$this->log('No active page found under root page "' . $pageId . '"', __METHOD__, TL_ERROR);
			die_nicely('be_no_active', 'No active pages found');
		}

		if (!$blnReturn)
		{
			$this->redirect($objNextPage->getFrontendUrl());
		}

		if ($blnPreferAlias && $objNextPage->alias != '')
		{
			return $objNextPage->alias;
		}

		return $objNextPage->id;
	}
}
