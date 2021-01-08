<?php

/**
 * Class to help making memory management decisions.
 */
class MemoryManagementHelper
{
		const SIZE_1PB = 1125899906842624; // 1024 * 1024 * 1024 * 1024 * 1024 = 1PB
		const SIZE_1TB = 1099511627776; // 1024 * 1024 * 1024 * 1024 = 1TB
		const SIZE_1GB = 1073741824; // 1024 * 1024 * 1024 = 1GB
		const SIZE_1MB = 1048576; // 1024 * 1024 = 1MB
		const SIZE_1KB = 1024; // 1024 = 1KB
		const MEMORY_SIZES = [
			'p' => self::SIZE_1PB,
			't' => self::SIZE_1TB,
			'g' => self::SIZE_1GB,
			'm' => self::SIZE_1MB,
			'k' => self::SIZE_1KB
		];

		/**
		 * Returns the memory used by the application as a percent of the limit.
		 *
		 * @param mixed $memoryLimit
		 * @returns int
		 */
		public static function getMemoryUsage($memoryLimit = null) {
			if (empty($memoryLimit)) {
				//Get the memory limit from PHP configs.
				$memoryLimit = ini_get("memory_limit");
			}
			$memoryLimit = self::getBytesFromSizeString($memoryLimit);
			if ($memoryLimit < 1) {
				return 1; // Memory has no limit. Return 1% which is the lowest allowed memory limit.
			}
			$memoryUsage = memory_get_usage(true);
			return ceil($memoryUsage / $memoryLimit * 100);
		}
		
		/**
		 * @param string $sizeString A size string like "3G"
		 * @return int
		 */
		public static function getBytesFromSizeString($sizeString) {
			// Get the last character to check if its a letter we support.
			$sizeSuffix = lcfirst(substr($sizeString, -1));
			// If its a number, its already in bytes so return it as an int.
			if (is_numeric($sizeSuffix)) {
				return (int) $sizeString;
			}
			// If its not an int already, we need to calculate its size.
			if ($sizeSuffix == 'b') {
				// Remove the 'b' for 'xb', eg convert 1mb to 1m.
				$sizeSuffix = lcfirst(substr($sizeString, -2, 1));
			}
			if (array_key_exists($sizeSuffix, self::MEMORY_SIZES)) {
				// Replace non numeric characters
				$sizeString = preg_replace("/[^0-9]/", "", $sizeString);
				$sizeString *= self::MEMORY_SIZES[$sizeSuffix];
			}
			return $sizeString;
		}
}
