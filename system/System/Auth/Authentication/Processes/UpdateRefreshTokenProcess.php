<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:17
 */

namespace System\Auth\Authentication\Processes;

use Helper\RepositoryHelper\StorageRepository;
use Helper\Util;
use Http\Session\SessionRedis;
use Models\User\User;
use System\Auth\ClientAppRepository;
use System\Auth\JWTokenManager;
use System\Auth\TokenRepository;
use System\Validators\AbstractValidator;
use System\Validators\Validators;

class UpdateRefreshTokenProcess extends FillingPayload implements AuthenticationProcessInterface
{
	/**
	 * @var AbstractValidator
	 */
	private $validator;

	/**
	 * UpdateRefreshTokenProcess constructor.
	 * @param AbstractValidator $validator
	 */
	public function __construct(AbstractValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function execute(): bool
	{
		/** @var TokenRepository $tokenRepository */
		$tokenRepository   = StorageRepository::getRepository(TokenRepository::class);
		$tokenModel        = $tokenRepository->loadByRefreshToken($this->validator);

		/** @var ClientAppRepository $clientAppRepository */
		$clientAppRepository = StorageRepository::getRepository(ClientAppRepository::class);

		if (!$tokenRepository->isLoaded()) {
			$this->validator->setExtraErrorAPI('unknown-refresh', Validators::COMMON);
			return null;
		}

		$JWToken = JWTokenManager::create();

		$now = Util::now();
		$ttl = $clientAppRepository->getResult()->getAccessTTL();

		$user = User::loadByUserId($tokenModel->getUserId());

		$dataToSave = $this->fillPayload($clientAppRepository, $user, $now, $ttl);

		$JWToken
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$tokenRepository->updateRefreshToken($tokenModel);
		SessionRedis::create()->set($JWToken->getToken(), \json_encode($dataToSave, $ttl));

		return true;
	}
}