<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Helper\DocBlock;

use ObjectCalisthenics\Helper\DocBlock\MemberComment;
use ObjectCalisthenics\Tests\FileFactory;
use PHPUnit\Framework\TestCase;

final class MemberCommentTest extends TestCase
{
    /**
     * @var FileFactory
     */
    private $fileFactory;

    protected function setUp(): void
    {
        $this->fileFactory = new FileFactory();
    }

    public function test(): void
    {
        $file = $this->fileFactory->createFile(__DIR__ . '/MemberCommentSource/SomeFile.php.inc');
        $memberComment = MemberComment::getMemberComment($file, 20);

        $this->assertSame('argument', $memberComment);
    }
}
