<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Behat\Snippet\Context\SnippetsFriendlyInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use org\bovigo\vfs\vfsStream;

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
     * @var string Temporary virtual folder
     */
    private $scratchSpace;

    /**
     * @var string Temporary config file
     */
    private $configFile;

    /**
     * @var string Temporary library folder
     */
    private $libraryLocation;

    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @var string $configYaml
     */
    private $configYaml;

    /**
     * Loads the service container
     *
     * @beforeScenario
     */
    public function configure()
    {
        $this->container = require __DIR__ . '/../../config/configure-services.php';
        $this->scratchSpace = vfsStream::setup('scratch')->url();
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
            $this->writeConfigFile();
            $this->container->compile();
            $this->applicationTester = $this->container->get('console.application.tester');
        }

        return $this->applicationTester;
    }

    /**
     * @Given I have a configuration file with no shows
     * @Given I do not have the show :show configured
     */
    public function iHaveNoShowsInTheConfigurationFile()
    {
        $this->configYaml = '';
    }

    /**
     * @Given I have a configuration file containing
     */
    public function iHaveAConfigurationFileContaining(PyStringNode $configString)
    {
        $this->configYaml = (string)$configString;
    }

    /**
     * Write a new config file in a temp location and inject the path into the container
     */
    private function writeConfigFile()
    {
        if (!$this->configFile) {
            $confDir = $this->scratchSpace . DIRECTORY_SEPARATOR . 'config';
            mkdir($confDir);
            $this->configFile = $confDir . DIRECTORY_SEPARATOR . 'config.yml';
        }
        file_put_contents($this->configFile, $this->configYaml);
        $this->container->setParameter('config.filename', $this->configFile);
    }

    /**
     * @When I list the shows
     */
    public function iListTheShows()
    {
        $this->runCommand(['command' => 'list-shows']);
    }

    /**
     * @When I list the episodes for the show :show
     */
    public function iListTheEpisodesForTheShow($show)
    {
        $this->runCommand([
            'command' => 'list-episodes',
            'show' => $show
        ]);
    }

    /**
     * @param $commandDefinition
     */
    private function runCommand($commandDefinition)
    {
        $this->getApplicationTester()->run($commandDefinition);
    }

    /**
     * @Given I have no files in the library
     * @Given I have the following files in the library
     */
    public function iHaveTheFollowingFilesInTheLibrary(TableNode $fileDescriptions = null)
    {
       $libraryLocation = $this->getLibraryLocation();

       if ($fileDescriptions) foreach ($fileDescriptions->getHash() as $fileDescription) {
           $this->createFileFromDescription($libraryLocation, $fileDescription);
       }
    }

    /**
     * @return string The path to the temporary library folder
     * @todo Inject into container
     */
    private function getLibraryLocation()
    {
        if (!$this->libraryLocation) {
            $this->libraryLocation = $this->scratchSpace . DIRECTORY_SEPARATOR . 'library';
            mkdir($this->libraryLocation);
            $this->configYaml .= PHP_EOL . 'library:' . PHP_EOL . '  path: ' . $this->libraryLocation;
        }
        return $this->libraryLocation;
    }

    /**
     * @param string $libraryLocation
     * @param array $fileDescription with folder and filename keys
     */
    private function createFileFromDescription($libraryLocation, $fileDescription)
    {
        $folderName = $libraryLocation . DIRECTORY_SEPARATOR . $fileDescription['folder'];
        if (!file_exists($folderName)) {
            mkdir($folderName);
        }
        $fileName = $folderName . DIRECTORY_SEPARATOR . $fileDescription['filename'];
        file_put_contents($fileName, 'XXX');
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
}
