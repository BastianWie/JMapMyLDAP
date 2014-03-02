<?php
/**
 * PHP Version 5.3
 *
 * @package     Shmanic.Libraries
 * @subpackage  Adapter
 * @author      Shaun Maunder <shaun@shmanic.com>
 *
 * @copyright   Copyright (C) 2011-2013 Shaun Maunder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

/**
 * Abstract generic adapter base class.
 *
 * @package     Shmanic.Libraries
 * @subpackage  Adapter
 * @since       2.1
 */
abstract class SHAdapter
{
	/**
	 * Name of adapter.
	 * This should be overridden by the implementation adapter.
	 *
	 * @var    string
	 * @since  2.1
	 */
	const NAME = 'generic';

	/**
	 * Type of adapter.
	 * This should be overridden by the implementation adapter.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const TYPE = self::TYPE_GENERIC;

	/**
	 * Generic adapter type.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const TYPE_GENERIC = 0;

	/**
	 * User adapter type.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const TYPE_USER = 1;

	/**
	 * Group adapter type.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const TYPE_GROUP = 2;

	/**
	 * State of adapter is unknown (default).
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const STATE_UNKNOWN = 0;

	/**
	 * Object already exists in driver.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const STATE_EXISTS = 1;

	/**
	 * Object does not exist in driver.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const STATE_NEW = 2;

	/**
	 * Object was created in driver.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const STATE_CREATED = 3;

	/**
	 * Object creation failed in driver.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	const STATE_FAILED = 4;

	/**
	 * Holds the current state of this adapter.
	 *
	 * @var    integer
	 * @since  2.1
	 */
	protected $state = self::STATE_UNKNOWN;

	/**
	 * Method to get certain otherwise inaccessible properties from the global adapter object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   2.1
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'name':
				return static::NAME;
				break;

			case 'state':
				return $this->state;
				break;
		}

		return null;
	}

	/**
	 * Returns the name of this adapter.
	 *
	 * @param   string  $name  An optional string to compare against the adapter name.
	 *
	 * @return  string|false  Adapter name or False on non-matching parameter.
	 *
	 * @since   2.1
	 */
	public static function getName($name = null)
	{
		if (is_null($name) || strtoupper($name) === static::NAME)
		{
			return static::NAME;
		}

		return false;
	}

	/**
	 * Returns the domain or the configuration ID used for this specific user.
	 *
	 * @return  string  Domain or Configuration ID.
	 *
	 * @since   2.1
	 */
	abstract public function getDomain();

	/**
	 * Returns all available domains for this adapter type.
	 *
	 * @return  array  An array of domain names.
	 *
	 * @since   2.1
	 */
	abstract public static function getDomains();
}
