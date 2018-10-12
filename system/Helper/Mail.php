<?php
/**
 * @version   1.0
 * @package   projmet
 * @filename  Mail.php
 * @author    khomenko
 * @created   20.12.13 15:58
 */
namespace App;

use Helper\Util;
use Helper\Mime;

class Mail
{

    const CRLF = "\r\n";

    /**
     * @var string
     */
    protected $_mailer = "WebPetroMailer / 1.0";

    /**
     * @var string
     */
    protected $_domain;

    /**
     * @var string
     */
    protected $_mimeVersion = '1.0';

    /**
     * @var string
     */
    protected $_mime        = Mime::TEXT;

    /**
     * @var string
     */
    protected $_multiMime   = Mime::MULTI_MIX;

    /**
     * @var string
     */
    protected $_encoding    = 'utf-8';

    /**
     * @var array
     */
    protected $_sender;

    /**
     * @var array
     */
    protected $_from = [];

    /**
     * @var array
     */
    protected $_to = [];

    /**
     * @var array
     */
    protected $_replyTo = [];

    /**
     * @var array
     */
    protected $_cc = [];

    /**
     * @var array
     */
    protected $_bcc = [];

    /**
     * @var string
     */
    protected $_subject;

    /**
     * @var string
     */
    protected $_message;

    /**
     * @var array
     */
    protected $_cid = [];

    /**
     * @var array
     */
    protected $_attaches = [];

    /**
     * @var bool
     */
    protected $_isMultipart = false;

    /**
     * @var array of strings multipart boundary
     */
    protected $_boundary = [];

    /**
     * @var bool
     */
    protected $_wasSent = false;

    /**
     * @var bool
     */
    protected $_withWardenBCC = true;

	/**
	 * @var array
	 */
	protected $_headers = [];

	/**
	 * Constructor
	 * @param $domain
	 */
	protected function __construct($domain = null)
	{
		if (empty($domain)) {
			$this->_domain = Config::getDomainName();
		} else {
			$this->_domain = $domain;
		}
	}

	/**
	 * @param string $domain
	 * @return Mail
	 */
	public static function create($domain = null)
	{
		return new static($domain);
	}

	/**
	 * @return $this
	 */
	public function noWarden()
	{
		$this->_withWardenBCC = false;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function asHtml()
	{
		$this->_mime = Mime::HTML;

		return $this;
	}

	/**
	 * @return $this
	 * @throws \Exception
	 */
	public function asMultipart()
	{
		$this->_isMultipart = true;
		$this->_multiMime = 'multipart/mixed';
		$this->getBoundary(0);

		return $this;
	}

	/**
	 * @param int $id
	 * @return mixed
	 * @throws \Exception
	 */
	public function getBoundary($id = 0)
	{
		if (empty($this->_boundary[$id])) {
			$this->_boundary[$id] = Util::generateRandom(30);
		}

		return $this->_boundary[$id];
	}

	/**
	 * @param string $mime
	 * @return $this
	 */
	public function setMime($mime)
	{
		$this->_mime = $mime;
		return $this;
	}

	/**
	 * @param string $from
	 * @return $this
	 */
	public function setFrom($from)
	{
		if ($from = self::_validEmails($from)) {
			$this->_from = $from;
		}

		return $this;
	}

	/**
	 * @param string|array $to
	 * @return $this
	 */
	public function setTo($to)
	{
		if ($to = self::_validEmails($to)) {
			$this->_to = $to;
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isTestMail(): bool
	{
		return false;
	}

	/**
	 * Override recipient address.
	 */
	public function overrideRealTo(): Mail
	{
		$this->_subject .= " ::TO::" . self::_prepareEmail($this->_to) . " " . self::_prepareEmail($this->_bcc);
		$this->_to = [Config::getDefaultEmail()];

		return $this;
	}

	/**
	 * @param string $reply
	 * @return $this
	 */
	public function setReplyTo($reply)
	{
		if ($reply = self::_validEmails($reply)) {
			$this->_replyTo = $reply;
		}

		return $this;
	}

	/**
	 * @param string|array $cc
	 * @return $this
	 */
	public function setCC($cc)
	{
		if ($cc = self::_validEmails($cc)) {
			$this->_cc = $cc;
		}

		return $this;
	}

	/**
	 * @param string|array $bcc
	 * @return $this
	 */
	public function setBCC($bcc)
	{
		if ($bcc = self::_validEmails($bcc)) {
			$this->_bcc = $bcc;
		}

		return $this;
	}

	/**
	 * @param $bcc
	 * @return $this
	 */
	public function addBCC($bcc)
	{
		if ($bcc = self::_validEmails($bcc)) {
			$this->_bcc = \array_merge($this->_bcc, $bcc);
		}

		return $this;
	}

	/**
	 * @param $subject
	 * @return $this
	 */
	public function setSubject($subject)
	{
		$this->_subject = $subject;

		return $this;
	}

	/**
	 * @param $message
	 * @return $this
	 */
	public function setMessage($message)
	{
		$this->_message = $message;

		return $this;
	}

	/**
	 * @param $template
	 * @param array $data
	 * @return $this
	 */
	public function setTemplate($template, array $data = [])
	{
		return $this;
	}

	/**
	 * @param null $postKey
	 * @return $this
	 * @throws \Exception
	 */
	public function setPostedAttaches($postKey = null)
	{
		if (empty($postKey) || !Request::hasFiles()) {
			return $this;
		}

		if (Request::isMultiFile($postKey)) {
			$files = Request::takeFiles($postKey);

			if (empty($files)) {
				return $this;
			}
		} else {
			$file = Request::takeFile($postKey);

			if (empty($file)) {
				return $this;
			}

			$files = [$file];
		}

		$this->asMultipart();

		$i = 0;

		foreach ($files as $file) {
			$cid = $this->_cid(++$i, $file['name'], $postKey . $i);
			$this->_attaches[$cid] = Attach::createFromPost($cid, $file);
		}

		return $this;
	}

	/**
	 * @param $file
	 * @param null $cidName
	 * @return $this
	 * @throws \Exception
	 */
	public function attachOne($file, $cidName = null)
	{
		if (empty($file)) {
			return $this;
		}

		$this->asMultipart();

		$cid = $this->_cid(\count($this->_attaches), $file, $cidName);
		$this->_attaches[$cid] = Attach::createFromFile($cid, $file);

		return $this;
	}

	/**
	 * @param $data
	 * @param $mime
	 * @param $name
	 * @return $this
	 * @throws \Exception
	 */
	public function attachData($data, $mime, $name)
	{
		if (empty($data)) {
			return $this;
		}

		$this->asMultipart();

		$cid = $this->_cid(\count($this->_attaches), $name);
		$this->_attaches[$cid] = Attach::createFromData($cid, $data, $mime, $name);

		return $this;
	}

	/**
	 * @param array|null $files
	 * @return $this
	 * @throws \Exception
	 */
	public function setAttaches(array $files = null)
	{
		if (empty($files)) {
			return $this;
		}

		$this->asMultipart();

		$i = 0;

		foreach ($files as $cidName => $file) {
			$cid = $this->_cid(++$i, $file, $cidName);
			$this->_attaches[$cid] = Attach::createFromFile($cid, $file);
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function send()
	{
		return $this->_sendMessage();
	}

	/**
	 * @return void
	 */
	protected function _prepareGeneralHeaders()
	{
		$this->_headers[] = "MIME-Version: $this->_mimeVersion";
		$this->_headers[] = "X-Mailer:  {$this->_mailer}";

		$reply = $from = $cc = $bcc = false;

		if ($this->isTestMail()) {
			$this->overrideRealTo();
		} else {
			$cc = self::_prepareEmail($this->_cc);
			$bcc = self::_prepareEmail($this->_bcc);
		}

		if ($this->_from) {
			$from = self::_prepareEmail($this->_from);
		} else {
			$from = \defaultNoReplyEmail();
		}

		if ($this->_replyTo) {
			$reply = self::_prepareEmail($this->_replyTo);
		}

		if ($from) {
			$this->_headers[] = "From:  {$from}";
		}

		if ($reply) {
			$this->_headers[] = "Reply-To: {$reply}";
		}

		if ($cc) {
			$this->_headers[] = "CC: {$cc}";
		}

		if ($bcc) {
			$this->_headers[] = "BCC: {$bcc}";
		}
	}

	/**
	 * @return bool
	 */
	protected function _sendMessage()
	{
		if (empty($this->_to)) {
			return false;
		}

		try {
			if ($this->_withWardenBCC) {
				$this->addBCC(\getEmail('warden'));
			}

			$this->_prepareGeneralHeaders();
			$to = self::_prepareEmail($this->_to);
			$subject = Util::base64Encode($this->_subject);

			return $this->_wasSent = \mail($to, $subject, $this->_prepareContent(), \implode(self::CRLF, $this->_headers));
		} catch (\Throwable $e) {

		}

		return false;
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	protected function _prepareContent()
	{
		if ($this->_isMultipart) {
			$bound = $this->getBoundary();
			$this->_headers[] = "Content-Type: {$this->_multiMime}; boundary={$bound}";

			return $this->_prepareMultipartContent($bound);
		} else {
			$this->_headers[] = "Content-Type: {$this->_mime}; charset={$this->_encoding}";

			return $this->_message;
		}
	}

	/**
	 * @param $mainBound
	 * @return string
	 */
	protected function _prepareMultipartContent($mainBound)
	{
		$message[] = '--' . $mainBound;
		$message[] = "Content-Type: {$this->_mime}; charset={$this->_encoding}";
		$message[] = '';
		$message[] = $this->_message;

		if ($this->_attaches) {

			foreach ($this->_attaches as $attach) {
				if ($attach instanceof Attach) {
					$message[] = '--' . $mainBound;
					$message[] = $attach->getContentString();
				}
			}
		}

		$message[] = '--' . $mainBound . '--';

		return \implode(self::CRLF, $message);
	}

	/**
	 * @param $email
	 * @return bool|array
	 */
	private static function _validEmails($email)
	{
		if (empty($email)) {
			return false;
		}

		if (\is_array($email)) {
			$valid = [];

			foreach ($email as $name => $toEmail) {
				if (\filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
					$valid[$name] = $toEmail;
				}
			}

			if (empty($valid)) {
				return false;
			}

			return $valid;
		} else if ($email = \trim($email) && \filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return [$email];
		} else {
			return false;
		}
	}

	/**
	 * @param array $email
	 * @return null|string
	 */
	private static function _prepareEmail(array $email)
	{
		if ($email) {
			return '<' . \implode('>, <', $email) . '>';
		}

		return null;
	}

	/**
	 * @param $i
	 * @param string $file
	 * @param null $cidName
	 * @return string
	 * @throws \Exception
	 */
	private function _cid($i, $file = '', $cidName = null)
	{
		$cid = Util::generateRandom(10) . Util::getTimeFormatted('%s') . '.' . $i . '@' . $this->_domain . $file;

		if (\is_string($cidName) && $cidName) {
			$this->_cid[$cidName] = $cid;
		}

		return $cid;
	}

}

class Attach
{

	private $_cid;
	private $_mime;
	private $_name;
	private $_enctype = 'base64';
	private $_rawName;
	private $_path;
	private $_error;
	private $_size;
	private $_isRemote = false;
	private $_rawData = null;

	/**
	 * Private constructor
	 */
	private function __construct()
	{
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->_rawName;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->_path;
	}

	/**
	 * @return string
	 */
	public function getMime()
	{
		return $this->_mime;
	}

	/**
	 * @return string
	 */
	public function getEncoding()
	{
		return $this->_enctype;
	}

	/**
	 * @return string
	 */
	public function getContentString()
	{
		$fileName = Util::base64Encode($this->getName(), Util::B64_RFC2183);

		$message[] = "Content-Type: {$this->_mime}";
		$message[] = "Content-Transfer-Encoding: {$this->_enctype}";
		$message[] = "Content-Disposition: attachment; filename=\"$fileName\"";
		$message[] = "Content-ID: <{$this->_cid}>";
		$message[] = '';
		$message[] = Util::base64Encode($this->_rawData ?? File::content($this->_path), Util::B64_CHUNKED);

		return \implode(Mail::CRLF, $message);
	}

	/**
	 * @param string $contentId
	 * @param array $filePost
	 * @return Attach
	 */
	public static function createFromPost($contentId, array $filePost)
	{
		$obj = new self;

		$obj->_mime    = $filePost['type'];
		$obj->_name    = $filePost['name'];
		$obj->_rawName = $filePost['real_name'];
		$obj->_path    = $filePost['tmp_name'];
		$obj->_error   = $filePost['error'];
		$obj->_size    = $filePost['size'];
		$obj->_cid     = $contentId;

		return $obj;
	}

	/**
	 * @param string $contentId
	 * @param string $filePath
	 * @return Attach
	 */
	public static function createFromFile($contentId, $filePath)
	{
		$obj = new self;

		if (\file_exists($filePath)) {
			$name = \pathinfo($filePath, \PATHINFO_BASENAME);
			$mime = Mime::resolve($filePath);
		} else {
			$info = \pathinfo($filePath, \PATHINFO_FILENAME | \PATHINFO_BASENAME | \PATHINFO_EXTENSION | \PATHINFO_DIRNAME);;
			$name = $info['basename'] ?? '';
			$ext  = $info['extension'] ?? '';
			$mime = Mime::resolveByExt($ext);

			$obj->_isRemote = true;

		}

		$obj->_mime    = $mime;
		$obj->_name    = Util::translit($name);
		$obj->_rawName = $name;
		$obj->_path    = $filePath;
		$obj->_error   = 0;
		$obj->_size    = \filesize($filePath);
		$obj->_cid     = $contentId;

		return $obj;
	}

	/**
	 * @param string $data
	 * @return Attach
	 */
	public static function createFromData($contentId, $data, $mime, $name)
	{
		$obj = new self;

		$obj->_mime    = $mime;
		$obj->_rawName = $name;
		$obj->_path    = null;
		$obj->_cid     = $contentId;
		$obj->_rawData = $data;

		return $obj;
	}

}
