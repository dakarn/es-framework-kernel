<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:17
 */

namespace ES\Kernel\System\Auth\Authentication\Processes;

use ES\Kernel\Helper\RepositoryHelper\StorageRepository;
use ES\Kernel\Helper\Util;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\Models\User\User;
use ES\Kernel\System\Auth\ClientAppRepository;
use ES\Kernel\System\Auth\JWTokenManager;
use ES\Kernel\System\Auth\TokenRepository;
use ES\Kernel\System\Validators\AbstractValidator;
use ES\Kernel\System\Validators\Validators;

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
	 * @throws \ES\Kernel\Exception\FileException
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