<?php

namespace mageekguy\atoum\scripts;

require_once __DIR__ . '/../../constants.php';

use
	mageekguy\atoum,
	mageekguy\atoum\cli,
	mageekguy\atoum\php,
	mageekguy\atoum\writers,
	mageekguy\atoum\exceptions
;

class runner extends atoum\script\configurable
{
	const defaultConfigFile = '.atoum.php';
	const defaultBootstrapFile = '.bootstrap.atoum.php';

	protected $runner = null;
	protected $configuratorFactory = null;
	protected $defaultReportFactory = null;
	protected $scoreFile = null;
	protected $arguments = array();
	protected $defaultArguments = array();
	protected $namespaces = array();
	protected $tags = array();
	protected $methods = array();
	protected $loop = false;

	protected static $autorunner = true;
	protected static $runnerFile = null;

	public function __construct($name, atoum\adapter $adapter = null)
	{
		parent::__construct($name, $adapter);

		$this
			->setRunner()
			->setConfiguratorFactory()
			->setDefaultReportFactory()
		;
	}

	public function setInfoWriter(atoum\writer $writer = null)
	{
		if ($writer === null)
		{
			$writer = new writers\std\out();
			$writer->addDecorator(new cli\colorizer('0;32'));
		}

		parent::setInfoWriter($writer);

		return $this;
	}

	public function setWarningWriter(atoum\writer $writer = null)
	{
		if ($writer === null)
		{
			$writer = new writers\std\err();

			$colorizer = new cli\colorizer('0;33');
			$colorizer->setPattern('/^([^:]+:)/');

			$writer->addDecorator($colorizer);
		}

		parent::setWarningWriter($writer);

		return $this;
	}

	public function setErrorWriter(atoum\writer $writer = null)
	{
		if ($writer === null)
		{
			$writer = new writers\std\err();

			$colorizer = new cli\colorizer('0;31');
			$colorizer->setPattern('/^([^:]+:)/');

			$writer->addDecorator($colorizer);
		}

		parent::setErrorWriter($writer);

		return $this;
	}

	public function getResourcesDirectory()
	{
		return atoum\directory . '/resources';
	}

	public function setRunner(atoum\runner $runner = null)
	{
		$this->runner = $runner ?: new atoum\runner();

		return $this->setArgumentHandlers();
	}

	public function getRunner()
	{
		return $this->runner;
	}

	public function setConfiguratorFactory(\closure $factory = null)
	{
		$this->configuratorFactory = $factory ?: function($test) { return new atoum\configurator($test); };

		return $this;
	}

	public function getConfiguratorFactory()
	{
		return $this->configuratorFactory;
	}

	public function setDefaultReportFactory(\closure $factory = null)
	{
		$this->defaultReportFactory = $factory ?: function($script) {
			$report = new atoum\reports\realtime\cli();
			$report->addWriter($script->getOutputWriter());

			return $report;
		};

		return $this;
	}

	public function getDefaultReportFactory()
	{
		return $this->defaultReportFactory;
	}

	public function autorun()
	{
		return (isset($_SERVER['argv']) === false || isset($_SERVER['argv'][0]) === false || $this->adapter->realpath($_SERVER['argv'][0]) !== $this->getName());
	}

	public function setScoreFile($path)
	{
		$this->scoreFile = (string) $path;

		return $this;
	}

	public function getScoreFile()
	{
		return $this->scoreFile;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function setArguments(array $arguments)
	{
		$this->arguments = $arguments;

		return $this;
	}

	public function addDefaultArguments($argument)
	{
		$this->defaultArguments = array_merge($this->defaultArguments, func_get_args());

		return $this;
	}

	public function hasDefaultArguments()
	{
		return (sizeof($this->defaultArguments) > 0);
	}

	public function getDefaultArguments()
	{
		return $this->defaultArguments;
	}

	public function addTestAllDirectory($directory)
	{
		$this->writeError('--test-all argument is deprecated, please replace call to ' . __METHOD__ . '(\'path/to/default/tests/directory\') by $runner->addTestsFromDirectory(\'path/to/default/tests/directory\') in your configuration files and use atoum without any argument instead');

		return $this;
	}

	public function run(array $arguments = array())
	{
		# Default bootstrap file MUST be included here because some arguments on the command line can include some tests which depends of this file.
		# So, this file must be included BEFORE argument parsing which is done in script::run().
		# Default bootstrap file can be overrided in a default config file included in script\configurable::run() which extends script::run().
		# So, if a bootstrap file is defined in a default config file, it will be available when arguments on CLI will be parsed
		$this->setDefaultBootstrapFiles();

		if ($this->autorun() === true && sizeof($this->runner->getDeclaredTestClasses()) > 0)
		{
			$this->runner->canNotAddTest();
		}

		try
		{
			parent::run($arguments ?: $this->getArguments());
		}
		catch (atoum\exception $exception)
		{
			$this->writeError($exception->getMessage());

			exit(2);
		}

		return $this;
	}

	public function version()
	{
		$this
			->writeMessage(sprintf($this->locale->_('atoum version %s by %s (%s)'), atoum\version, atoum\author, atoum\directory) . PHP_EOL)
			->stopRun()
		;

		return $this;
	}

	public function useConfigFile($path)
	{
		$script = call_user_func($this->configuratorFactory, $this);
		$runner = $this->runner;

		return $this->includeConfigFile($path, function($path) use ($script, $runner) { include_once($path); });
	}

	public function testIt()
	{
		$this->runner->addTestsFromDirectory(atoum\directory . '/tests/units/classes');

		return $this;
	}

	public function enableLoopMode()
	{
		if ($this->loop !== null)
		{
			$this->loop = true;
		}

		return $this;
	}

	public function disableLoopMode()
	{
		$this->loop = null;

		return $this;
	}

	public function testNamespaces(array $namespaces)
	{
		foreach ($namespaces as $namespace)
		{
			$this->namespaces[] = trim($namespace, '\\');
		}

		return $this;
	}

	public function getTestedNamespaces()
	{
		return $this->namespaces;
	}

	public function testTags(array $tags)
	{
		$this->tags = $tags;

		return $this;
	}

	public function testMethod($class, $method)
	{
		$this->methods[$class][] = $method;

		return $this;
	}

	public function addDefaultReport()
	{
		$report = call_user_func($this->defaultReportFactory, $this);

		$this->addReport($report);

		return $report;
	}

	public function addReport(atoum\report $report)
	{
		$this->runner->addReport($report);

		return $this;
	}

	public function setReport(atoum\report $report)
	{
		$this->runner->setReport($report);

		return $this;
	}

	public function getReports()
	{
		return $this->runner->getReports();
	}

	public function init()
	{
		$resourceDirectory = static::getResourcesDirectory();
		$currentDirectory = rtrim($this->adapter->getcwd(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		$defaultConfigFile = $currentDirectory . static::defaultConfigFile;

		if ($this->adapter->file_exists($defaultConfigFile) === false || $this->prompt($this->locale->_('Default configuration file \'' . static::defaultConfigFile . '\' already exists in the current directory, type \'Y\' to overwrite it...')) === 'Y')
		{
			$this
				->copy($resourceDirectory . '/configurations/runner/atoum.php.dist', $defaultConfigFile)
				->writeMessage($this->locale->_('Default configuration file \'' . static::defaultConfigFile . '\' was successfully created in the current directory'))
			;
		}

		$bootstrapFile = $currentDirectory . static::defaultBootstrapFile;

		if ($this->adapter->file_exists($bootstrapFile) == false || $this->prompt($this->locale->_('Default bootstrap file \'' . static::defaultBootstrapFile . '\' already exists in the current directory, type \'Y\' to overwrite it...')) === 'Y')
		{
			$this
				->copy($resourceDirectory . '/configurations/runner/bootstrap.php.dist', $bootstrapFile)
				->writeMessage($this->locale->_('Default bootstrap file \'' . static::defaultBootstrapFile . '\' was successfully created in the current directory'))
			;
		}

		return $this->stopRun();
	}

	public function setDefaultBootstrapFiles($startDirectory = null)
	{
		foreach (self::getSubDirectoryPath($startDirectory ?: $this->getDirectory()) as $directory)
		{
			$defaultBootstrapFile = $directory . static::defaultBootstrapFile;

			if ($this->adapter->is_file($defaultBootstrapFile) === true)
			{
				$this->runner->setBootstrapFile($defaultBootstrapFile);

				break;
			}
		}

		return $this;
	}

	public static function autorunMustBeEnabled()
	{
		return (static::$autorunner === true);
	}

	public static function enableAutorun($name)
	{
		static $autorunIsRegistered = false;

		if (static::$autorunner instanceof static)
		{
			throw new exceptions\runtime('Unable to autorun \'' . $name . '\' because \'' . static::$autorunner->getName() . '\' is already set as autorunner');
		}

		if ($autorunIsRegistered === false)
		{
			$autorunner = & static::$autorunner;
			$calledClass = get_called_class();

			register_shutdown_function(function() use (& $autorunner, $calledClass) {
					if ($autorunner instanceof $calledClass)
					{
						$score = $autorunner->run()->getRunner()->getScore();

						exit($score->getFailNumber() <= 0 && $score->getErrorNumber() <= 0 && $score->getExceptionNumber() <= 0 ? 0 : 1);
					}
				}
			);

			$autorunIsRegistered = true;
		}

		static::$autorunner = new static($name);

		return static::$autorunner;
	}

	public static function disableAutorun()
	{
		static::$autorunner = false;
	}

	protected function setArgumentHandlers()
	{
		parent::setArgumentHandlers()
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) !== 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->version();
					},
					array('-v', '--version'),
					null,
					$this->locale->_('Display version')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) !== 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->resetVerbosityLevel();

						$verbosityLevel = substr_count($argument, '+');

						while ($verbosityLevel--)
						{
							$script->increaseVerbosityLevel();
						}
					},
					array('+verbose', '++verbose'),
					null,
					$this->locale->_('Enable verbose mode')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) !== 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->init();
					},
					array('--init'),
					null,
					$this->locale->_('Create configuration and bootstrap files in the current directory')
				)
			->addArgumentHandler(
					function($script, $argument, $path) {
						if (sizeof($path) != 1)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->setPhpPath(current($path));
					},
					array('-p', '--php'),
					'<path/to/php/binary>',
					$this->locale->_('Path to PHP binary which must be used to run tests')
				)
			->addArgumentHandler(
					function($script, $argument, $defaultReportTitle) {
						if (sizeof($defaultReportTitle) != 1)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->setDefaultReportTitle(current($defaultReportTitle));
					},
					array('-drt', '--default-report-title'),
					'<string>',
					$this->locale->_('Define default report title with <string>')
				)
			->addArgumentHandler(
					function($script, $argument, $file) {
						if (sizeof($file) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->setScoreFile(current($file));
					},
					array('-sf', '--score-file'),
					'<file>',
					$this->locale->_('Save score in file <file>')
				)
			->addArgumentHandler(
					function($script, $argument, $maxChildrenNumber) {
						if (sizeof($maxChildrenNumber) != 1)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->setMaxChildrenNumber(current($maxChildrenNumber));
					},
					array('-mcn', '--max-children-number'),
					'<integer>',
					$this->locale->_('Maximum number of sub-processus which will be run simultaneously')
				)
			->addArgumentHandler(
					function($script, $argument, $empty) {
						if ($empty)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->disableCodeCoverage();
					},
					array('-ncc', '--no-code-coverage'),
					null,
					$this->locale->_('Disable code coverage')
				)
			->addArgumentHandler(
					function($script, $argument, $directories) {
						if (sizeof($directories) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$coverage = $script->getRunner()->getCoverage();

						foreach ($directories as $directory)
						{
							$coverage->excludeDirectory($directory);
						}
					},
					array('-nccid', '--no-code-coverage-in-directories'),
					'<directory>...',
					$this->locale->_('Disable code coverage in directories <directory>')
				)
			->addArgumentHandler(
					function($script, $argument, $namespaces) {
						if (sizeof($namespaces) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						foreach ($namespaces as $namespace)
						{
							$script->getRunner()->getCoverage()->excludeNamespace($namespace);
						}
					},
					array('-nccfns', '--no-code-coverage-for-namespaces'),
					'<namespace>...',
					$this->locale->_('Disable code coverage for namespaces <namespace>')
				)
			->addArgumentHandler(
					function($script, $argument, $classes) {
						if (sizeof($classes) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						foreach ($classes as $class)
						{
							$script->getRunner()->getCoverage()->excludeClass($class);
						}
					},
					array('-nccfc', '--no-code-coverage-for-classes'),
					'<class>...',
					$this->locale->_('Disable code coverage for classes <class>')
				)
			->addArgumentHandler(
					function($script, $argument, $files) {
						if (sizeof($files) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$runner = $script->getRunner();

						foreach ($files as $path)
						{
							$runner->addTest($path);
						}
					},
					array('-f', '--files'),
					'<file>...',
					$this->locale->_('Execute all unit test files <file>')
				)
			->addArgumentHandler(
					function($script, $argument, $directories) {
						if (sizeof($directories) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$runner = $script->getRunner();

						foreach ($directories as $directory)
						{
							$runner->addTestsFromDirectory($directory);
						}
					},
					array('-d', '--directories'),
					'<directory>...',
					$this->locale->_('Execute unit test files in all <directory>')
				)
			->addArgumentHandler(
					function($script, $argument, $extensions) {
						if (sizeof($extensions) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->getTestDirectoryIterator()->acceptExtensions($extensions);
					},
					array('-tfe', '--test-file-extensions'),
					'<extension>...',
					$this->locale->_('Execute unit test files with one of extensions <extension>')
				)
			->addArgumentHandler(
					function($script, $argument, $patterns) {
						if (sizeof($patterns) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$runner = $script->getRunner();

						foreach ($patterns as $pattern)
						{
							$runner->addTestsFromPattern($pattern);
						}
					},
					array('-g', '--glob'),
					'<pattern>...',
					$this->locale->_('Execute unit test files which match <pattern>')
				)
			->addArgumentHandler(
					function($script, $argument, $tags) {
						if (sizeof($tags) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->testTags($tags);
					},
					array('-t', '--tags'),
					'<tag>...',
					$this->locale->_('Execute only unit test with tags <tag>')
				)
			->addArgumentHandler(
					function($script, $argument, $methods) {
						if (sizeof($methods) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						foreach ($methods as $method)
						{
							$method = explode('::', $method);

							if (sizeof($method) != 2)
							{
								throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
							}

							$script->testMethod($method[0], $method[1]);
						}
					},
					array('-m', '--methods'),
					'<class::method>...',
					$this->locale->_('Execute all <class::method>, * may be used as wildcard for class name or method name')
				)
			->addArgumentHandler(
					function($script, $argument, $namespaces) {
						if (sizeof($namespaces) <= 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->testNamespaces($namespaces);
					},
					array('-ns', '--namespaces'),
					'<namespace>...',
					$this->locale->_('Execute all classes in all namespaces <namespace>')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if ($values)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->enableLoopMode();
					},
					array('-l', '--loop'),
					null,
					$this->locale->_('Execute tests in an infinite loop')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) !== 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->disableLoopMode();
					},
					array('--disable-loop-mode'),
					null,
					null,
					3
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) !== 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->testIt();
					},
					array('--test-it'),
					null,
					$this->locale->_('Execute atoum unit tests')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						$script->writeError('--test-all argument is deprecated, please do $runner->addTestsFromDirectory(\'path/to/default/tests/directory\') in a configuration file and use atoum without any argument instead');
					},
					array('--test-all'),
					null,
					$this->locale->_('DEPRECATED, please do $runner->addTestsFromDirectory(\'path/to/default/tests/directory\') in a configuration file and use atoum without any argument instead')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if ($values)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						\mageekguy\atoum\cli::forceTerminal();
					},
					array('-ft', '--force-terminal'),
					null,
					$this->locale->_('Force output as in terminal')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) != 1)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->setBootstrapFile($values[0]);
					},
					array('-bf', '--bootstrap-file'),
					'<file>',
					$this->locale->_('Include <file> before executing each test method'),
					2
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) != 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$lightReport = new atoum\reports\realtime\cli\light();
						$lightReport->addWriter($script->getOutputWriter());

						$script->setReport($lightReport);
					},
					array('-ulr', '--use-light-report'),
					null,
					$this->locale->_('Use "light" CLI report')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) != 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$tapReport = new atoum\reports\realtime\tap();
						$tapReport->addWriter($script->getOutputWriter());

						$script->setReport($tapReport);
					},
					array('-utr', '--use-tap-report'),
					null,
					$this->locale->_('Use TAP report')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) != 0)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->enableDebugMode();
					},
					array('--debug'),
					null,
					$this->locale->_('Enable debug mode')
				)
			->addArgumentHandler(
					function($script, $argument, $values) {
						if (sizeof($values) != 1)
						{
							throw new exceptions\logic\invalidArgument(sprintf($script->getLocale()->_('Bad usage of %s, do php %s --help for more informations'), $argument, $script->getName()));
						}

						$script->getRunner()->setXdebugConfig($values[0]);
					},
					array('-xc', '--xdebug-config'),
					null,
					$this->locale->_('Set XDEBUG_CONFIG variable')
				)
		;

		$this->setDefaultArgumentHandler(function($script, $argument) {
				try
				{
					$script->getRunner()->addTest($argument);
				}
				catch (\exception $exception)
				{
					return false;
				}

				return true;
			}
		);

		return $this;
	}

	protected function doRun()
	{
		parent::doRun();

		if ($this->argumentsParser->hasFoundArguments() === false)
		{
			$this->argumentsParser->parse($this, $this->defaultArguments);
		}

		if (sizeof($this->runner->getTestPaths()) <= 0 && sizeof($this->runner->getDeclaredTestClasses()) <= 0)
		{
			$this->writeError($this->locale->_('No test found'))->help();
		}
		else
		{
			$arguments = $this->argumentsParser->getValues();

			if (sizeof($arguments) <= 0)
			{
				$this->verbose(sprintf($this->locale->_('Using no CLI argument…')));
			}
			else
			{
				$this->verbose(sprintf($this->locale->__('Using %s CLI argument…', 'Using %s arguments…', sizeof($arguments)), $this->argumentsParser));
			}

			if (sizeof($this->configFiles) > 0)
			{
				foreach ($this->configFiles as $configFile)
				{
					$this->verbose(sprintf($this->locale->_('Using \'%s\' configuration file…'), $configFile));
				}
			}

			$bootstrapFile = $this->runner->getBootstrapFile();

			if ($bootstrapFile !== null)
			{
				$this->verbose(sprintf($this->locale->_('Using \'%s\' bootstrap file…'), $bootstrapFile));
			}

			foreach (atoum\autoloader::getRegisteredAutoloaders() as $autoloader)
			{
				$this->verbose(sprintf($this->locale->_('Using \'%s\' autoloader cache file…'), $autoloader->getCacheFileForInstance()));
			}

			foreach ($this->runner->getTestPaths() as $testPath)
			{
				$this->verbose(sprintf($this->locale->_('Using \'%s\' test file…'), $testPath), 2);
			}

			if ($this->loop === true)
			{
				$this->loop();
			}
			else
			{
				if ($this->runner->hasReports() === false)
				{
					$this->addDefaultReport();
				}

				$methods = $this->methods;
				$oldFailMethods = array();

				if ($this->scoreFile !== null && ($scoreFileContents = @file_get_contents($this->scoreFile)) !== false && ($oldScore = @unserialize($scoreFileContents)) instanceof atoum\score)
				{
					$oldFailMethods = self::getFailMethods($oldScore);

					if ($oldFailMethods)
					{
						$methods = $oldFailMethods;
					}
				}

				$newScore = $this->runner->run($this->namespaces, $this->tags, $this->getClassesOf($methods), $methods);

				$this->saveScore($newScore);

				if ($oldFailMethods && sizeof(self::getFailMethods($newScore)) <= 0)
				{
					$testMethods = $this->runner->getTestMethods($this->namespaces, $this->tags, $this->methods);

					if (sizeof($testMethods) > 1 || sizeof(current($testMethods)) > 1)
					{
						$this->saveScore($this->runner->run($this->namespaces, $this->tags, $this->getClassesOf($this->methods), $this->methods));
					}
				}
			}
		}

		return $this;
	}

	protected function runAgain()
	{
		return ($this->prompt($this->locale->_('Press <Enter> to reexecute, press any other key and <Enter> to stop...')) == '');
	}

	protected function loop()
	{
		$php = new php();
		$php
			->addOption('-f', $_SERVER['argv'][0])
			->addArgument('--disable-loop-mode')
		;

		if ($this->cli->isTerminal() === true)
		{
			$php->addArgument('--force-terminal');
		}

		$addScoreFile = false;

		foreach ($this->argumentsParser->getValues() as $argument => $values)
		{
			switch ($argument)
			{
				case '-l':
				case '--loop':
				case '--disable-loop-mode':
					break;

				case '-sf':
				case '--score-file':
					$addScoreFile = true;
					break;

				default:
					if ($this->argumentsParser->argumentHasHandler($argument) === false)
					{
						$php->addArgument('-f', $argument);
					}
					else
					{
						$php->addArgument($argument, join(' ', $values));
					}
			}
		}

		if ($this->scoreFile === null)
		{
			$this->scoreFile = sys_get_temp_dir() . '/atoum.score';

			@unlink($this->scoreFile);

			$addScoreFile = true;
		}

		if ($addScoreFile === true)
		{
			$php->addArgument('--score-file', $this->scoreFile);
		}

		while ($this->canRun() === true)
		{
			passthru((string) $php);

			if ($this->loop === false || $this->runAgain() === false)
			{
				$this->stopRun();
			}
		}

		return $this;
	}

	protected function saveScore(atoum\score $score)
	{
		if ($this->scoreFile !== null && $this->adapter->file_put_contents($this->scoreFile, serialize($score), \LOCK_EX) === false)
		{
			throw new exceptions\runtime('Unable to save score in \'' . $this->scoreFile . '\'');
		}

		return $this;
	}

	protected function writeHelpUsage()
	{
		$this->writeHelp(sprintf($this->locale->_('Usage: %s [path/to/test/file] [options]'), $this->getName()) . PHP_EOL);

		return $this;
	}

	protected function parseArguments(array $arguments)
	{
		$configTestPaths = $this->runner->getTestPaths();

		$this->runner->resetTestPaths();

		parent::parseArguments($arguments);

		$this->runner->setTestPaths($this->runner->getTestPaths() ?: $configTestPaths);

		return $this;
	}

	private function getClassesOf($methods)
	{
		return sizeof($methods) <= 0 || isset($methods['*']) === true ? array() : array_keys($methods);
	}

	private function copy($from, $to)
	{
		if (@$this->adapter->copy($from, $to) === false)
		{
			throw new exceptions\runtime($this->locale->_('Unable to write \'' . $from . '\' to \'' . $to . '\''));
		}

		return $this;
	}

	private static function getFailMethods(atoum\score $score)
	{
		return self::mergeMethods(self::mergeMethods(self::mergeMethods($score->getMethodsWithFail(), $score->getMethodsWithError()), $score->getMethodsWithException()), $score->getMethodsNotCompleted());
	}

	private static function mergeMethods(array $methods, array $newMethods)
	{
		foreach ($newMethods as $class => $classMethods)
		{
			if (isset($methods[$class]) === false)
			{
				$methods[$class] = $classMethods;
			}
			else
			{
				$methods[$class] = array_unique(array_merge($methods[$class], $classMethods));
			}
		}

		return $methods;
	}
}
