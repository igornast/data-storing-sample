<?php

declare(strict_types=1);

namespace Tests\Repository\Mysql;

use App\Entity\User;
use App\Exception\DataNotFoundException;
use App\Repository\Mysql\UserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UserRepositoryTest extends TestCase
{
    private readonly MockObject|Connection $connection;

    protected function setUp(): void
    {
        $this->connection = $this
            ->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testSave()
    {
        $this->connection->expects(self::once())->method('executeStatement');

        $user = new User('test_id', 'test_name');

        (new UserRepository($this->connection))->save($user);
    }

    public function testFind()
    {
        $resultMock = $this
            ->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();
        $resultMock->expects(self::once())
            ->method('fetchAssociative')
            ->willReturn([
                'id' => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
                'name' => 'Johny Bravo',
            ]);

        $this->connection
            ->expects(self::once())
            ->method('executeQuery')
            ->willReturn($resultMock);

        $result = (new UserRepository($this->connection))->find('test_id');

        self::assertSame('Johny Bravo', $result['name']);
        self::assertSame('68c68470-f25f-4ce4-bbf4-05f50bd82fc4', $result['id']);
    }

    public function testFindNoResult()
    {
        $resultMock = $this
            ->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();
        $resultMock->expects(self::once())
            ->method('fetchAssociative')
            ->willReturn(false);

        $this->connection
            ->expects(self::once())
            ->method('executeQuery')
            ->willReturn($resultMock);

        self::expectException(DataNotFoundException::class);
        self::expectExceptionMessage('The data is not found for: "App\Entity\User #test_id"');

        (new UserRepository($this->connection))->find('test_id');
    }
}
