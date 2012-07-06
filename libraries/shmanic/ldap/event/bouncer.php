<?php
/**
 * PHP Version 5.3
 *
 * @package     Shmanic.Libraries
 * @subpackage  Ldap.Event
 * @author      Shaun Maunder <shaun@shmanic.com>
 *
 * @copyright   Copyright (C) 2011-2012 Shaun Maunder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

/**
 * This class observes the global JDispatcher. On Joomla event calls, it evaluates whether
 * the event should be passed onto the corresponding Ldap event by checking the event's context.
 *
 * @package     Shmanic.Libraries
 * @subpackage  Ldap.Event
 * @since       2.0
 */
class SHLdapEventBouncer extends JEvent
{
	/**
	 * Holds if the current user/session is Ldap based.
	 *
	 * @var    boolean
	 * @since  2.0
	 */
	protected $isLdap = false;

	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The JDispatcher object to observe.
	 *
	 * @since  2.0
	 */
	public function __construct(&$subject)
	{
		// Check if the current user is Ldap authenticated
		$this->isLdap = SHLdapHelper::isUserLdap();

		parent::__construct($subject);
	}

	/**
	 * Method is called after initialise.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onAfterInitialise()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onAfterInitialise');
		}
	}

	/**
	 * Method is called after route.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onAfterRoute()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onAfterRoute');
		}
	}

	/**
	 * Method is called after dispatch.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onAfterDispatch()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onAfterDispatch');
		}
	}

	/**
	 * Method is called before render.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onBeforeRender()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onBeforeRender');
		}
	}

	/**
	 * Method is called after render.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onAfterRender()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onAfterRender');
		}
	}

	/**
	 * Method is called before compile head.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onBeforeCompileHead()
	{
		if ($this->isLdap)
		{
			SHLdapHelper::triggerEvent('onBeforeCompileHead');
		}
	}

	/**
	 * Method prepares the data on a form.
	 * Note: there is no Ldap session validation!
	 *
	 * @param   string  $context  Context / namespace of the form (i.e. form name).
	 * @param   object  $data     The associated data for the form.
	 *
	 * @return  boolean  True on success or False on error.
	 *
	 * @since   2.0
	 */
	public function onContentPrepareData($context, $data)
	{
		return SHLdapHelper::triggerEvent('onContentPrepareData', array($context, $data));
	}

	/**
	 * Method prepares a form in the way of fields.
	 * Note: there is no Ldap session validation!
	 *
	 * @param   JForm   $form  The form to be alterted.
	 * @param   object  $data  The associated data for the form.
	 *
	 * @return  boolean  True on success or False on error.
	 *
	 * @since   2.0
	 */
	public function onContentPrepareForm($form, $data)
	{
		return SHLdapHelper::triggerEvent('onContentPrepareForm', array($form, $data));
	}

	/**
	 * Method is called before user data is deleted from the database.
	 *
	 * @param   array  $user  Holds the user data.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onUserBeforeDelete($user)
	{
		if ($params = JArrayHelper::getValue($user, 'params', false, 'string'))
		{
			if (self::_checkParameter($params))
			{
				SHLdapHelper::triggerEvent('onUserBeforeDelete', array($user));
			}
		}
	}

	/**
	 *  Method is called after user data is deleted from the database.
	 *
	 * @param   array    $user     Holds the user data.
	 * @param   boolean  $success  True if user was successfully deleted from the database.
	 * @param   string   $msg      An error message.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		if ($params = JArrayHelper::getValue($user, 'params', false, 'string'))
		{
			if (self::_checkParameter($params))
			{
				SHLdapHelper::triggerEvent('onUserAfterDelete', array($user, $success, $msg));
			}
		}
	}

	/**
	 * Method is called before user data is stored in the database.
	 *
	 * @param   array    $user   Holds the old user data.
	 * @param   boolean  $isNew  True if a new user is stored.
	 * @param   array    $new    Holds the new user data.
	 *
	 * @return  boolean  Cancels the save if False.
	 *
	 * @since   2.0
	 */
	public function onUserBeforeSave($user, $isNew, $new)
	{
		if ($params = JArrayHelper::getValue($new, 'params', false, 'string'))
		{
			if (self::_checkParameter($params))
			{
				return SHLdapHelper::triggerEvent('onUserBeforeSave', array($user, $isNew, $new));
			}
		}
	}

	/**
	 * Method is called after user data is stored in the database.
	 *
	 * @param   array    $user     Holds the new user data.
	 * @param   boolean  $isNew    True if a new user has been stored.
	 * @param   boolean  $success  True if user was successfully stored in the database.
	 * @param   string   $msg      An error message.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onUserAfterSave($user, $isNew, $success, $msg)
	{
		if ($params = JArrayHelper::getValue($user, 'params', false, 'string'))
		{
			if (self::_checkParameter($params))
			{
				SHLdapHelper::triggerEvent('onUserAfterSave', array($user, $isNew, $success, $msg));
			}
		}
	}

	/**
	 * Method handles login logic and report back to the subject.
	 *
	 * @param   array  $user     Holds the user data.
	 * @param   array  $options  Extra options such as autoregister.
	 *
	 * @return  boolean  Cancels login on False.
	 *
	 * @since   2.0
	 */
	public function onUserLogin($user, $options = array())
	{
		// We can only process LDAP authentications
		if (JArrayHelper::getValue($user, 'type') != 'LDAP')
		{
			return;
		}

		$config = SHFactory::getConfig();
		$autoRegister = (int) $config->get('user.autoregister', 1);

		if ($autoRegister === 0 || $autoRegister === 1)
		{
			// Inherited Auto-registration
			$options['autoregister'] = isset($options['autoregister']) ? $options['autoregister'] : $autoRegister;
		}
		else
		{
			// Override Auto-registration
			$options['autoregister'] = ($autoRegister === 2) ? 1 : 0;
		}

		/* Before firing the onLdapLogin method, we must make sure
		 * the user has the attributes element. If not then it can
		 * be assumed that the JMapMyLDAP authentication wasn't used.
		 */
		if (!isset($user[SHLdapHelper::ATTRIBUTE_KEY]))
		{
			// TODO: fix this!!
			return false;
		}

		$instance = SHUserHelper::getUser($user, $options);

		if ($instance === false)
		{
			// Failed to get the user either due to save error or autoregister
			return false;
		}

		// Fire the ldap specific on login events
		$result = SHLdapHelper::triggerEvent('onUserLogin', array(&$instance, $user, $options));

		if ($result)
		{
			$instance->save();
		}

		// Allow Ldap events to be called
		$this->isLdap = true;

		return $result;
	}

	/**
	 * Method handles logout logic and reports back to the subject.
	 *
	 * @param   array  $user     Holds the user data.
	 * @param   array  $options  Array holding options such as client.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.0
	 */
	public function onUserLogout($user, $options = array())
	{
		if ($this->isLdap)
		{
			return SHLdapHelper::triggerEvent('onUserLogout', array($user, $options));
		}
	}

	/**
	 * Method is called on user login failure.
	 *
	 * @param   array  $response  The authentication response.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function onUserLoginFailure($response)
	{
		// Check if the attempted login was an Ldap user, if so then fire the event
		if ($username = JArrayHelper::getValue($response, 'username', false, 'string'))
		{
			// Check if the user exists in the J! database
			if ($id = JUserHelper::getUserId($username))
			{
				$user = JUser::getInstance($id);

				if ($user->getParam('authtype') == 'LDAP')
				{
					SHLdapHelper::triggerEvent('onUserLoginFailure', array($response));
				}
			}
		}
	}

	/**
	 * Checks whether the specified user parameters contain the LDAP
	 * authtype parameter.
	 *
	 * @param   string  $parameters  User parameters.
	 *
	 * @return  boolean  True if user is LDAP.
	 *
	 * @since   2.0
	 */
	private static function _checkParameter($parameters)
	{
		// Load the user parameters into a registry object for inspection
		$reg = new JRegistry;
		$reg->loadString($parameters);

		/**
		 * Check whether this saved user was an LDAP user, and if so then
		 * fire the LDAP event for it.
		 */
		if ($reg->get('authtype') == 'LDAP')
		{
			return true;
		}

		return false;
	}
}
