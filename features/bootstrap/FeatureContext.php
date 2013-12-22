<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Behat\Snippet\Context\SnippetsFriendlyInterface;
use Behat\Gherkin\Node\PyStringNode;

use Symfony\Component\Console\Tester\ApplicationTester;

/**
 * Context class for all features
 */
class FeatureContext implements ContextInterface, SnippetsFriendlyInterface
{

    /**
     * @var ApplicationTester
     */
    private $applicationTester;

    /**
     * @var string Temporary config file
     */
    private $configFile;

    /**
     * @var string Path to the config file before we overwrote
     */
    private $defaultConfigPath;

    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * Loads the service container
     *
     * @beforeScenario
     */
    public function configure()
    {
        $this->container = require __DIR__ . '/../../config/configure-services.php';
    }

    /**
     * Loads the application tester from the container
     *
     * Note - any container changes done after this is invoked may not effect the Application as boostrapped
     *
     * @return Application
     */
    private function getApplicationTester()
    {
        if (!$this->applicationTester) {
            $this->container->get('console.application')->setAutoExit(false);
            $this->applicationTester = $this->container->get('console.application.tester');
        }

        return $this->applicationTester;
    }

    /**
     * @Given I have a configuration file with no shows
     */
    public function iHaveAnEmptyConfigurationFile()
    {
        $this->writeConfigFile('');
    }

    /**
     * @Given I have a configuration file containing
     */
    public function iHaveAConfigurationFileContaining(PyStringNode $configString)
    {
        $this->writeConfigFile((string)$configString);

    }

    /**
     * Write a new config file in a temp location and inject the path into the container
     *
     * @param string $configString
     */
    private function writeConfigFile($configString)
    {
        $this->configFile = tempnam(sys_get_temp_dir(), 'showgrabber');
        file_put_contents($this->configFile, $configString);
        $this->container->setParameter('config.filename', $this->configFile);
    }

    /**
     * @When I run the :command command
     */
    public function iRunAParticularCommand($command)
    {
        $this->getApplicationTester()->run(['command' => $command]);
    }

    /**
     * @Then The output should contain :snippet
     */
    public function theOutputShouldContain($snippet)
    {
        $output = $this->getApplicationTester()->getDisplay();

        if (false === strpos($output, $snippet)) {
            throw new Exception(sprintf('Expected text "%s" not found in output "%s"', $snippet, $output));
        }
    }

    /**
     * @afterScenario
     */
    public function cleanUpFiles()
    {
        if ($this->configFile && file_exists($this->configFile)) {
            unlink($this->configFile);
        }
    }

}
