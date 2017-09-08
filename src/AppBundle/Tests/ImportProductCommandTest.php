<?php
// tests/AppBundle/Command/CreateUserCommandTest.php
namespace AppBundle\Tests\Command;

use AppBundle\Command\ImportProductsCommand;
use AppBundle\Service\Import\ImportProducts;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
class ImportProductCommandTest extends KernelTestCase
{
    /** @var $_command Command */
    private $_command;

    /** @var $_commandTester CommandTester */
    private $_commandTester;
    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new ImportProductsCommand());

        $this->_command = $application->find('import-csv');
        $this->_commandTester = new CommandTester($this->_command);

    }

    /**
     *
     */
    public function testExecuteWrongMode()
    {
        $this->expectException(ConsoleInvalidArgumentException::class);
        $this->expectExceptionMessage('Choose please correct import mode');
        $this->_executeCommandWithArguments('stock.csv', '1'.ImportProducts::MODE_TEST);

    }

    /**
     *
     */
    public function testExecuteWrongPath()
    {
        $this->expectException(ConsoleInvalidArgumentException::class);
        $this->expectExceptionMessage('Path is incorrect: file does not exists');
        $this->_executeCommandWithArguments('stock_test_not_exists.csv', ImportProducts::MODE_TEST);
    }

    /**
     *
     */
    public function testExecuteWrongExtension()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('There are no parser for extension ');
        $this->_executeCommandWithArguments('stock_test.csv1', ImportProducts::MODE_TEST);
    }

    /**
     * Return string representation
     *
     * @param string $fileName
     * @param string $mode
     * @return string
     */
    private function _executeCommandWithArguments($fileName = '', $mode = '') : string {
        $arguments = [];
        $arguments['filename'] = $fileName;
        $arguments['mode'] = $mode;
        $this->_commandTester->execute(array_replace([
            'command'  => $this->_command->getName()
        ], $arguments));
        return $this->_commandTester->getDisplay();
    }
}