<?php

namespace App\Tests\Unitary\Domain\Project;


use Codeception\Specify;
use PHPUnit\Framework\TestCase;


class ProjectTest extends TestCase
{

    use Specify;
    private const PROJECT_NAME = "name";

    private function getProjectBuilder()
    {
        return ProjectTestBuilder::getProjectTest();
    }

    public function testProjectConstructor(): void
    {
        $this->describe("Project constructor consistencia",
            function () {
                $this->should("id = null, name != null",
                    function () {
                        $project = $this->getProjectBuilder()->name(self::PROJECT_NAME)->build();
                        $this->assertNull($project->getId());
                        $this->assertEquals($project->getName(), self::PROJECT_NAME);
                        $this->assertEquals($project->getIssueCount(), 0);
                    });
            });
    }
}