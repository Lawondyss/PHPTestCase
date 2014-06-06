<?php

/*
 *
 * @author RDPanek <rdpanek@developerhub.cz> { DeveloperHub
 */

namespace Tests;

class TestCase extends \PHPUnit_Framework_TestCase
{
	/** @var \RemoteWebDriver|null */
	public $driver;


	public function setUpSeleniumEnviroment()
	{
		$this->driver = \RemoteWebDriver::create();
	}



	public function tearDown()
	{
		if ($this->driver) {
			$this->driver->quit();
		}
		parent::tearDown();
	}

}
