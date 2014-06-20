<?php
/**
@author : Johan Barbier <johan.barbier@gmail.com>
@Version : 2006/10/09
*/

class noTimeOut {
	private $aProps = array (
		'TYPE' => null,
		'DB' => null,
		'HOST' => null,
		'LOGIN' => null,
		'PWD' => null,
		'QUERY' => null,
		'DBSERVER' => null,
		'FILE' => null,
		'START' => null,
		'LIMIT' => null,
		'STEP' => null
		);

	private $aDbServers = array (
		'MYSQL', 'MSSQL'
		);

	private $aTypes = array (
		'DEFAULT', 'FILE_OCTET', 'FILE_PATTERN', 'FILE_LINE', 'DB'
		);


	public function __construct () {
		// might be useful later
	}

	public function __set ($sType, $sVal) {
		try {
			if (!array_key_exists ($sType, $this -> aProps)) {
				throw new Exception ($sType.' is not a valid property');
			}
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
		try {
			switch ($sType) {
				case 'TYPE':
					if (!in_array ($sVal, $this -> aTypes)) {
						throw new Exception ($sVal.' is not a valid TYPE value');
					}
					break;
				case 'FILE':
					if (!file_exists ($sVal)) {
						throw new Exception ('File '.$sVal.' has not been found');
					}
					break;
				case 'DBSERVER':
					if (!in_array ($sVal, $this -> aDbServers)) {
						throw new Exception ('DB SERVER '.$sVal.' is not supported');
					}
					break;
				default :
					break;
			}
			$this -> aProps[$sType] = $sVal;
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
	}

	private static function isNull () {
		foreach (func_get_args() as $sArg) {
			if (is_null ($sArg)) {
				return false;
			}
		}
		return true;
	}

	public function flushMe ($aWork = null) {
		try {
			if (is_null ($this -> aProps['TYPE'])) {
				throw new Exception ('TYPE has not been defined');
			}
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
		try {
			switch ($this -> aProps['TYPE']) {
				case 'DB':
					if (false === self::isNull ($this -> aProps['DB'], $this -> aProps['HOST'], $this -> aProps['LOGIN'], $this -> aProps['PWD'], $this -> aProps['QUERY'], $this -> aProps['DBSERVER'], $this -> aProps['START'], $this -> aProps['STEP'])) {
						throw new Exception ('DB properties have not been fully defined');
					}
					$mTmp = $this -> getDB ();
					break;
				case 'FILE_OCTET':
					if (false === self::isNull ($this -> aProps['FILE'], $this -> aProps['START'], $this -> aProps['STEP'])) {
						throw new Exception ('FILE properties have not been fully defined');
					}
					$mTmp = $this -> getFileOctet ();
					break;
				case 'DEFAULT':
					if (false === self::isNull ($this -> aProps['START'], $this -> aProps['STEP'], $aWork)) {
						throw new Exception ('DEFAULT properties have not been fully defined');
					}
					$mTmp = $this -> getDefault ($aWork);
					break;
				case 'FILE_PATTERN':
					if (false === self::isNull ($this -> aProps['FILE'], $this -> aProps['START'], $this -> aProps['STEP'])) {
						throw new Exception ('FILE properties have not been fully defined');
					}
					$mTmp = $this -> getFilePat ();
					break;
				case 'FILE_LINE':
					if (false === self::isNull ($this -> aProps['FILE'], $this -> aProps['START'], $this -> aProps['STEP'])) {
						throw new Exception ('FILE properties have not been fully defined');
					}
					$mTmp = $this -> getFileLine ();
					break;
			}
			return $mTmp;
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
	}

	private function getFilePat () {
		$sTmp = '';
		try {
			if (false === ($fp = fopen ($this -> aProps['FILE'], 'r'))) {
				throw new Exception ('Failed to open file : '.$this -> aProps['FILE']);
			}
			if ( -1 === (fseek ($fp, $this -> aProps['START'], SEEK_SET))) {
				throw new Exception ('Failed to  modify cursor on : '.$this -> aProps['FILE']);
			}
			while (false === ($iEnd = strpos ($sTmp, $this -> aProps['STEP'])) && !feof ($fp)) {
				$sTmp .= @fgets ($fp, 1024);
			}
			$sTmp = substr ($sTmp, 0, $iEnd + strlen ($this -> aProps['STEP']));
			@fclose ($fp);
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
		return $sTmp;
	}

	private function getDefault ($aWork) {
		try {
			if (!is_array ($aWork)) {
				throw new Exception ('Parameter must be an array');
			}
			$aTmp = array ();
			for ($i = $this -> aProps['START']; $i < $this -> aProps['START'] + $this -> aProps['STEP']; $i ++) {
				if (isset ($aWork[$i])) {
					$aTmp[] = $aWork[$i];
				}
			}
			return $aTmp;
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
	}

	private function getFileOctet () {
		try {
			$sTmp = '';
			if (false === ($fp = fopen ($this -> aProps['FILE'], 'r'))) {
				throw new Exception ('Failed to open file : '.$this -> aProps['FILE']);
			}
			if ( -1 === (@fseek ($fp, $this -> aProps['START'], SEEK_SET))) {
				throw new Exception ('Failed to  modify cursor on : '.$this -> aProps['FILE']);
			}
			if (false === ($sTmp .= @fread ($fp, $this -> aProps['STEP']))) {
				throw new Exception ('Failed to  read file : '.$this -> aProps['FILE']);
			}
			@fclose ($fp);
			return $sTmp;
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
	}

	private function getFileLine () {
		$sTmp = '';
		try {
			if (false === ($fp = fopen ($this -> aProps['FILE'], 'r'))) {
				throw new Exception ('Failed to open file : '.$this -> aProps['FILE']);
			}
			if ( -1 === (fseek ($fp, $this -> aProps['START'], SEEK_SET))) {
				throw new Exception ('Failed to  modify cursor on : '.$this -> aProps['FILE']);
			}
			$iEnd = 0;
			while ($iEnd < $this -> aProps['STEP']) {
				$sTmp .= @fgets ($fp);
				$iEnd ++;
			}
			@fclose ($fp);
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
		return $sTmp;
	}

	private function getDB () {
		$sDb = strtolower ($this -> aProps['DBSERVER']);
		try {
			$rLink = @call_user_func ($sDb.'_connect', $this -> aProps['HOST'], $this -> aProps['LOGIN'], $this -> aProps['PWD']);
			if (false === $rLink) {
				throw new Exception ('Failed to connect to host : '.$this -> aProps['HOST']);
			}
			if (false === (@call_user_func ($sDb.'_select_db', $this -> aProps['DB'], $rLink))) {
				throw new Exception ('Failed to select database : '.$this -> aProps['DB']);
			}
			if (false === ($rRes = @call_user_func ($sDb.'_query', $this -> aProps['QUERY'], $rLink))) {
				throw new Exception ('Query failed : '.$this -> aProps['QUERY']);
			}
			if (false === (@call_user_func ($sDb.'_data_seek', $rRes, $this -> aProps['START']))) {
				throw new Exception ('Query failed : '.$this -> aProps['QUERY']);
			}
			$iCpt = 0;
			$aTmp = array ();
			while (($aRes = call_user_func ($sDb.'_fetch_assoc', $rRes)) && $iCpt < $this -> aProps['STEP']) {
				$aTmp[] = $aRes;
				$iCpt ++;
			}
			@call_user_func ($sDb.'_close', $rLink);
			return $aTmp;
		} catch (Exception $e) {
			echo $e -> getMessage ();
		}
	}
}
?>