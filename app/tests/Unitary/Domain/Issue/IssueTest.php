<?php

namespace App\Tests\Unitary\Domain\Issue;

use App\Domain\Issue\Issue;
use Codeception\Specify;
use PHPUnit\Framework\TestCase;


class IssueTest extends TestCase
{

    use Specify;
    private const PROJECT_NAME = "name";

    public function testConstructorInitializeAllVars(): void
    {
        $issue = IssueTestBuilder::getBuilder()
            ->projectId(IssueTestBuilder::DEFAULT_PROJECT_ID)
            ->title(IssueTestBuilder::DEFAULT_TITLE)
            ->type(IssueTestBuilder::DEFAULT_TYPE)
            ->parentId(IssueTestBuilder::DEFAULT_PARENT_ID)
            ->build();
        $this->assertNull($issue->getId());
        $this->assertEquals($issue->getProjectId(), IssueTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($issue->getType(), IssueTestBuilder::DEFAULT_TYPE);
        $this->assertEquals($issue->getTitle(), IssueTestBuilder::DEFAULT_TITLE);
        $this->assertEquals($issue->getTime(), IssueTestBuilder::DEFAULT_TIME);
        $this->assertEquals($issue->getTotalTime(), IssueTestBuilder::DEFAULT_TOTAL_TIME);
        $this->assertEquals($issue->getChilds(), IssueTestBuilder::DEFAULT_CHILDS);
    }

    public function testOnlyIssueTypeTopicCanHaveChild()
    {
        $issue = IssueTestBuilder::getDefaultNew();
        $issue->setChilds([IssueTestBuilder::getDefaultNew()]);
        $this->assertEquals($issue->getChilds(), []);
        $issue = IssueTestBuilder::getDefaultTypeTopic();
        $issue->setChilds([IssueTestBuilder::getDefaultNew()]);
        $this->assertEquals($issue->getChilds()[0], IssueTestBuilder::getDefaultNew());
    }

    public function testTimeOnlyCanBePositive()
    {
        $issue = IssueTestBuilder::getDefaultNew();
        $issue->setTime(-PHP_FLOAT_MAX);
        $this->assertEquals($issue->getTime(), 0.0);
    }

    public function testCorrectTimeManagement(): void
    {
        /**
         * Equivalence classes:
         *  time: 0,positive
         *  childs: have,not have
         */
        // 0,not have
        $issue = IssueTestBuilder::getDefaultTypeTopic();
        $issue->setTime(0);
        $this->assertEquals($issue->getTime(), 0);
        $this->assertEquals($issue->getTotalTime(), 0);
        // positive,not have
        $issue->setTime(PHP_FLOAT_MAX);
        $this->assertEquals($issue->getTime(), PHP_FLOAT_MAX);
        $this->assertEquals($issue->getTotalTime(), PHP_FLOAT_MAX);
        // 0,have
        $issue->setTime(0);
        $issue->setChilds([
            IssueTestBuilder::getDefaultNew()->setTime(-PHP_FLOAT_MAX),
            IssueTestBuilder::getDefaultNew()->setTime(PHP_FLOAT_MAX),
            IssueTestBuilder::getDefaultNew()->setTime(0),
        ]);
        $this->assertEquals(0, $issue->getTime());
        $this->assertEquals(PHP_FLOAT_MAX, $issue->getTotalTime());
        // positive,have
        $issue->setTime(PHP_FLOAT_MAX);
        $issue->setChilds([
            IssueTestBuilder::getDefaultNew()->setTime(PHP_FLOAT_MAX),
            IssueTestBuilder::getDefaultNew()->setTime(PHP_FLOAT_MAX),
            IssueTestBuilder::getDefaultNew()->setTime(0),
        ]);
        $this->assertEquals(PHP_FLOAT_MAX * 2, $issue->getTotalTime());
        $issue->setTime(1);
        $issue->setChilds([
            IssueTestBuilder::getDefaultNew()->setTime(2),
            IssueTestBuilder::getDefaultNew()->setTime(3),
            IssueTestBuilder::getDefaultNew()->setTime(0),
        ]);
        $this->assertEquals(6, $issue->getTotalTime());
    }
}