<?php

namespace App\Dto\User;

use App\Dto\BasicDto;
use App\Dto\Organization\OrganizationDto;
use App\Dto\User\Page\PageDto;
use App\Dto\User\RoleGroup\RoleGroupDto;
use DateTimeImmutable;
use libphonenumber\PhoneNumber;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as PhoneNumberAssert;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Dto\User\UserManager\UserManagerDto;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDto extends BasicDto
{
    public function __construct(
        public readonly ?string            $name = null,
    )
    {
    }
}
