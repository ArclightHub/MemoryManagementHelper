<?php

require_once('../src/MemoryBundle/Helper/MemoryManagementHelper.php');

class MemoryTests
{
	/** @var array */
	private $testStatus = ["\n"];

	/**
	 * Unit Tests
	 */
	public function runUnitTests()
	{
		// Make sure the platform we are running on works correctly.
		$this->assertLeftGreaterThanRight(memory_get_usage(true), 0);
		$this->testStatus[] = "Platform tests end.";

		// Test the helper constants
		$this->testStatus[] = "\nHelper constants tests";
		$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage(), 0); // Test using config defined memory limit
		$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage(MemoryManagementHelper::SIZE_1MB*32), 0); // Test using a limit of 32MB
		$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage(MemoryManagementHelper::SIZE_1GB), 0); // Test using a limit of 1GB
		$this->assertDoesNotEqual(MemoryManagementHelper::getMemoryUsage(MemoryManagementHelper::SIZE_1MB), 1); // Test using a limit of 1MB
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('1g'), MemoryManagementHelper::SIZE_1GB, "Test that the string '1g' is converted to 1073741824 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('12g'), MemoryManagementHelper::SIZE_1GB*12, "Test that the string '12g' is converted to 12884901888 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('1k'), MemoryManagementHelper::SIZE_1KB, "Test that the string '1k' is converted to 1024 bytes"); // Test 1kb as a short string.
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('1kb'), MemoryManagementHelper::SIZE_1KB, "Test that the string '1kb' is converted to 1024 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('13mb'), MemoryManagementHelper::SIZE_1MB*13, "Test that the string '13mb' is converted to 13631488 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('13MB'), MemoryManagementHelper::SIZE_1MB*13, "Test that the string '13MB' is converted to 13631488 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('13M'), MemoryManagementHelper::SIZE_1MB*13, "Test that the string '13M' is converted to 13631488 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('13m'), MemoryManagementHelper::SIZE_1MB*13, "Test that the string '13m' is converted to 13631488 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('73gb'), MemoryManagementHelper::SIZE_1GB*73, "Test that the string '73gb' is converted to 78383153152 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('73g'), MemoryManagementHelper::SIZE_1GB*73, "Test that the string '73g' is converted to 78383153152 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('142tb'), MemoryManagementHelper::SIZE_1TB*142, "Test that the string '142tb' is converted to 156130651144192 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('142t'), MemoryManagementHelper::SIZE_1TB*142, "Test that the string '142t' is converted to 156130651144192 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('733pb'), MemoryManagementHelper::SIZE_1PB*733, "Test that the string '733pb' is converted to 825284631715643392 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('733p'), MemoryManagementHelper::SIZE_1PB*733, "Test that the string '733p' is converted to 825284631715643392 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString('1024'), MemoryManagementHelper::SIZE_1KB, "Test that the string '1024' is converted to 1024 bytes");
		$this->assertEquals(MemoryManagementHelper::getBytesFromSizeString(1024), MemoryManagementHelper::SIZE_1KB, "Test that the integer 1024 is evaluated as 1024 bytes");

		// Test the helper strings
		$this->testStatus[] = "\nHelper constants tests";
		$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage('1g'), 0);
		$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage('1k'), 0);

		// Print the test output.
		$this->testStatus[] = ""; // New line for clean output
		return implode("\n", $this->testStatus);
	}
	
	/**
	 * Integration Tests
	 *
	 * Requires 1gb of memory
	 */
	public function runIntegrationTests()
	{
		$this->testStatus = ["\n"];
		$this->testStatus[] = "\nIntegration Tests";
		$this->testStatus[] = "TODO";
		//$this->assertLeftGreaterThanRight(MemoryManagementHelper::getMemoryUsage(MemoryManagementHelper::SIZE_1MB*32), 0); // Test using a limit of 32MB

		// Print the test output.
		$this->testStatus[] = ""; // New line for clean output
		return implode("\n", $this->testStatus);
	}
	
	private function setMemoryUsage()
	{
		// TODO Set the memory used to approx the given number of bytes.
	}

	/**
	 * Assert that the left is greater than the right.
	 */
	private function assertLeftGreaterThanRight($left, $right, $testName = null) {
		$message = sprintf(
			"Successfully asserted that %s was greater than %s",
			$left,
			$right
		);
		if ($left <= $right) {
			$message = sprintf(
				"Failed asserting that %s was greater than %s",
				$left,
				$right
			);
		}
		if (!empty($testName)) {
			$message .= " | Explanation: '$testName'";
		}
		$this->testStatus[] = $message;
	}
	
	private function assertDoesNotEqual($a, $b, $testName = null) {
		$message = sprintf(
			"Successfully asserted that %s was not equal to %s",
			$a,
			$b
		);
		if ($a == $b) {
			$message = sprintf(
				"Failed asserting that %s was not equal to %s",
				$a,
				$b
			);
		}
		if (!empty($testName)) {
			$message .= " | Explanation: '$testName'";
		}
		$this->testStatus[] = $message;
	}
	
	private function assertEquals($a, $b, $testName = null) {
		$message = sprintf(
			"Successfully asserted that %s equals %s",
			$a,
			$b
		);
		if ($a !== $b) {
			$message = sprintf(
				"Failed asserting that %s equals %s",
				$a,
				$b
			);
		}
		if (!empty($testName)) {
			$message .= " | Explanation: '$testName'";
		}
		$this->testStatus[] = $message;
	}
}
try {
	$tests = new MemoryTests();
	echo $tests->runUnitTests();
	echo $tests->runIntegrationTests();
} catch (\Fatal $e) {
	var_export($e);
}
