<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Repository\UserRepositoryInterface;
use App\Service\UserService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserServiceTest extends TestCase
{
    private readonly MockObject|ValidatorInterface $validator;
    private readonly MockObject|UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        $this->validator = $this
            ->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userRepository = $this
            ->getMockBuilder(UserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCreate(): void
    {
        $this->validator->expects(self::once())
            ->method('validate')
            ->willReturn(new ConstraintViolationList());

        $this->userRepository->expects(self::once())
            ->method('save');

        (new UserService($this->userRepository, $this->validator))->create('Johny Bravo');
    }

    public function testCreateInvalid(): void
    {
        $this->validator->expects(self::once())
            ->method('validate')
            ->willReturn(new ConstraintViolationList([
                new ConstraintViolation('', '', [], null, '', null),
            ]));

        $this->userRepository->expects(self::never())
            ->method('save');

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid User object provided.');

        (new UserService($this->userRepository, $this->validator))->create('');
    }

    public function testFind(): void
    {
        $this->userRepository->expects(self::once())
            ->method('find')
        ->willReturn(['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', 'name' => 'Rafael Nadal']);

        $user = (new UserService($this->userRepository, $this->validator))->find('test_id');

        self::assertSame('Rafael Nadal', $user->getName());
        self::assertSame('60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', $user->getId());
    }
}
