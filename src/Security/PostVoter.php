<?php

namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PostVoter extends Voter
{
    public const REMOVE = 'remove';
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const NEW = 'new';

    public function __construct(
        public Security $security
    ) {}

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Post && \in_array($attribute, [self::NEW, self::VIEW, self::EDIT, self::REMOVE], true);
    }

    protected function voteOnAttribute(string $attribute, $post, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $user === $post->getAuthor();
    }
}
