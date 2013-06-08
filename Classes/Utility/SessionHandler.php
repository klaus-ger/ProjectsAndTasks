<?php
namespace T3developer\ProjectsAndTasks\Utility;


class SessionHandler implements t3lib_Singleton {
 
	/**
	 * Returns the object stored in the user´s PHP session
	 * @return Object the stored object
	 */
	public function restoreFromSession() {
		$sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_projectsandtasks_pi1');
		return unserialize($sessionData);
	}
 
	/**
	 * Writes an object into the PHP session
	 * @param	$object	any serializable object to store into the session
	 * @return	Tx_ProjectsAndTasks_Domain_Session_SessionHandler this
	 */
	public function writeToSession($object) {
		$sessionData = serialize($object);
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_projectsandtasks_pi1', $sessionData);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
		return $this;
	}
 
	/**
	 * Cleans up the session: removes the stored object from the PHP session
	 * @return	Tx_ProjectsAndTasks_Domain_Session_SessionHandler this
	 */
	public function cleanUpSession() {
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_projectsandtasks_pi1', NULL);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
		return $this;
	}
}
?>
