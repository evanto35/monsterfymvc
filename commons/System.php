<?php

class System {
	protected function selfStore() {
		$_SESSION[BaseController::IDX_SYSTEM] = serialize($this);
	}

	public static function get($forceRefresh = false) {
		if (!$forceRefresh && isset($_SESSION[BaseController::IDX_SYSTEM]))
			return unserialize($_SESSION[BaseController::IDX_SYSTEM]);
		else
			return new System();
	}
}