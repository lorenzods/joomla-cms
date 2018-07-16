<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$text = Text::_('JTOOLBAR_CANCEL');
?>
<button onclick="location.href='index.php?option=com_modules'" class="btn btn-sm btn-danger" title="<?php echo $text; ?>">
	<span class="icon-cancel" aria-hidden="true"></span> <?php echo $text; ?>
</button>
