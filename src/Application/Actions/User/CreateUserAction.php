<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();

        $user = new User(
            givenName: $parsedBody['givenName'],
            familyName: $parsedBody['familyName'],
            email: $parsedBody['email'],
            birthDate: $parsedBody['birthDate'],
            password: $parsedBody['password'],
        );

        $lastInsertId = $this->userRepository->store($parsedBody);
        $data = $this->userRepository->get((int) $lastInsertId);
        
        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
