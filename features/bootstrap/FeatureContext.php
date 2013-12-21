<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Snippet\Context\SnippetsFriendlyInterface;

use Cjm\ShowGrabber\Console\Application;

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
     * @beforeScenario
     */
    public function configure()
    {
        $container = require_once __DIR__ . '/../../config/configure-services.php';
        $container->get('console.application')->setAutoExit(false);
        $this->applicationTester = $container->get('console.application.tester');
    }

    /**
     * @Given I have a configuration file with no shows
     */
    public function iHaveAnEmptyConfigurationFile()
    {
        // needs to change when config is implemented
    }

    /**
     * @When I run the :command command
     */
    public function iRunAParticularCommand($command)
    {
        $this->applicationTester->run(['command' => $command]);
    }

    /**
     * @Then The output should contain :snippet
     */
    public function theOutputShouldContain($snippet)
    {
        $output = $this->applicationTester->getDisplay();

        if (false === strpos($output, $snippet)) {
            throw new Exception(sprintf('Expected text "%s" not found in output "%s"', $snippet, $output));
        }
    }

}
